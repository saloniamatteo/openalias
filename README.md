# openalias-api
A simple API for OpenAlias resolution

# Requirements

Not a whole lot, really.

You need to be running on a Unix environment that allows use of the `host` command (for checking RRSIG keys) and if you want to allow caching, you'll need to have access to a Redis database.

# Installation

Installation is simple and quick.

Just download the zip and place it wherever you want it to run.

After that, you'll just need to modify `config.ini` for your Redis host and port. By default it's set to `localhost` and port `6379`.

In `index.php` you can make a couple changes.

If you want to cache with Redis, make sure you have `line 35` uncommented. Then, in the instantiation of `Routes`, add your object as the second parameter. An example of all this is already in the code, so it's easy to see how it works.

Once you do that, you're all setup and ready to go. The rest manages itself. All this will take you about 49 seconds.


# Usage

If it was easy to install, it's even easier to use. Once you've set it up on your web server, just hit it in your browser.

So, let's say you're on `localhost`. Just go to `http://localhost/OpenAlias-api/` and you'll see a nice little web form.

![web form](http://i.imgur.com/VjcGz8Vm.png?1)

In that form you can place a domain to check it's OpenAlias records. After you submit, a JSON string will be returned with all the data. If no OpenAlias data has been found, then you'll get a 400 error code along with an error description in the JSON string.

If you want to bypass the web form completely (and we recommend you do, as it's primarily just for testing) you can create your url thusly: `http://localhost/OpenAlias-api/domain.com`.

See? Simple. Just add your domain to the end of the URL and it'll automatically pull all the data for you. If you take a look at the URL the form sends you to, it's exactly the same format.
