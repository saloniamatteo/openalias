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


