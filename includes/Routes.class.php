<?php
// Copyright (c) 2014, The Monero Project
//
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without modification, are
// permitted provided that the following conditions are met:
//
// 1. Redistributions of source code must retain the above copyright notice, this list of
//    conditions and the following disclaimer.
//
// 2. Redistributions in binary form must reproduce the above copyright notice, this list
//    of conditions and the following disclaimer in the documentation and/or other
//    materials provided with the distribution.
//
// 3. Neither the name of the copyright holder nor the names of its contributors may be
//    used to endorse or promote products derived from this software without specific
//    prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
// EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL
// THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
// PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
// INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
// STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
// THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

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
     * @param $domain
     * @return string
     * Route for /:domain
     * ex: localhost/$domain
     */
    public function domainCheck($domain)
    {
        //create a blank response to fill in later
        $response = array();

        //checks to see if $domain is, in fact, a domain.
        if (preg_match('^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\\.)+[A-Za-z]{2,6}$^', $domain)) {

            //if redis is enabled
            if ($this->redis) {
                $redis_response = $this->redis->get($domain);

                //if the response already exists in redis
                if ($redis_response) {
                    $response = json_decode($redis_response, true);
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

        $req = $this->app->request();

        if ($req->get('view') == 'full') {
            $this->app->response->headers->set('Content-Type', 'text/html');

            echo $this->m->render('pretty_response', array('results' => json_encode($response)));
        } else {
            $this->app->response->headers->set('Content-Type', 'application/json');

            //encode and return the response
            echo json_encode($response);
        }

    }
}