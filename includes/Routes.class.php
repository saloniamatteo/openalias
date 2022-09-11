<?php
/**
 * Class Routes
 * Creates a route and handles it. Simple and easy.
 */
class Routes extends \Slim\Slim
{
    /**
     * To be used for the slim app
     */
    private $app;

    /**
     * To be used for handling redis calls
     */
    private $redis = false;

    private $m;

    /**
     * @param array $app
     * Setup the slim app, please.
     */
    public function __construct($app, $redis = false)
    {
        //setup $app so we can use it later on
        $this->app = $app;

        if ($redis !== false) {
            $this->redis = $redis;
        }

        $this->m = $m = new Mustache_Engine(
            array(
                'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../views', array(
                    'extension' => '.mustache'
                )),
            )
        );
    }

    /**
     * echos out the form if no domain is set
     */
    public function index()
    {
        echo $this->m->render('form');
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     * Returns true if $haystack ends with $needle
     */
    private function my_str_ends_with($haystack, $needle) {
	    $length = strlen($needle);
	    return $length > 0 ? substr($haystack, -$length) === $needle : true;
    }

    /**
     * @param $domain
     * @return string
     * Route for /:domain
     * ex: localhost/$domain
     */
    public function domainCheck($domain)
    {
        //create a blank response to fill in later
        $response = array();

	// check if we have to pretty print response
	if ($this->my_str_ends_with($domain, "view=full")) {
		$pretty = true;
		// strip domain
		$domain = substr($domain, 0, strlen($domain) - strlen("view=full"));
	} else
		$pretty = false;

        //checks to see if $domain is, in fact, a domain.
        if (preg_match('^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\\.)+[A-Za-z]{2,6}$^', $domain)) {

            //if redis is enabled
            if ($this->redis) {
                $redis_response = $this->redis->get($domain);

                //if the response already exists in redis
		if ($redis_response) {
			$response = json_decode($redis_response, true);

			if ($pretty) {
			    $this->app->response->headers->set('Content-Type', 'text/html');
			    echo $this->m->render('pretty_response', array('results' => json_encode($response)));
			} else {
			    $this->app->response->headers->set('Content-Type', 'application/json');
			    //encode and return the response
			    echo json_encode($response);
			}

			return json_encode($response);
                }
            }

            //get TXT records
            $records = dns_get_record($domain, DNS_TXT);

            //create this to fill in later
            $response['records'] = array();

            //accepted record names
            $accepted_records = array(
                'recipient_address',
                'recipient_name',
                'crc-32',
                'dnssec_verified'
            );

            //look for oa1 records
            foreach ($records as $record) {

                if (substr($record['txt'], 0, 3) == 'oa1') {
                    $this_record = array(
                        'oa1' => substr($record['txt'], 4, 3),
                    );

                    //create a trimmed array of all the record pieces
                    $record['txt'] = array_map('trim', explode(';', substr($record['txt'], 8)));

                    foreach ($record['txt'] as $item) {

                        $this_item = explode('=', $item);

                        //if the item isn't empty
                        if (count($this_item) > 1) {

                            $this_record[$this_item[0]] = $this_item[1];
                        }
                    }

                    //push the records into the response array
                    array_push($response['records'], $this_record);
                }
            }

            if (count($response['records']) == 0) {
                $this->app->response->setStatus(400);
                $response = array(
                    'error' => true,
                    'response' => 'No OA1 records found'
                );
            } else {
                $response['records_returned'] = count($response['records']);

                $response['error'] = false;

                //check for dnssec
                exec('host -t RRSIG ' . $domain, $output);

                if (!strstr($output[0], 'not found')) {
                    $response['dnssec_verified'] = true;
                } else {
                    $response['dnssec_verified'] = false;
                }

                //write to redis if it's enabled
                if ($this->redis != false) {
                    $this->redis->write($domain, json_encode($response));
                }
            }

        } else {
            //uh oh, not a valid domain. send out an error response
            $this->app->response->setStatus(400);
            $response = array(
                'error' => true,
                'response' => 'Not a valid domain'
            );
        }

        if ($pretty) {
            $this->app->response->headers->set('Content-Type', 'text/html');
            echo $this->m->render('pretty_response', array('results' => json_encode($response)));
        } else {
            $this->app->response->headers->set('Content-Type', 'application/json');
            //encode and return the response
            echo json_encode($response);
        }
    }
}
