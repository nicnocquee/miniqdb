﻿﻿#summary Documentation for the Supybot-Miniqdb plugin.
#labels Section-Supybot-Miniqdb,Featured

With the Miniqdb plugin for Supybot, you can access a few parts of your miniqdb instance with a Supybot.

For more information on supybot, visit [www.supybot.com](http://www.supybot.com/).

# Commands #
  * **quote** _id_ -- returns quote _id_. If the quote is longer than the configuration variable _**maxLines**_, only a link and how many lines that quote contains is returned.
  * **stats** -- returns the number of quotes in the database.
  * **random** -- returns a single, random quote from the database.

# Configuration variables #
  * _**miniqdbRoot**_ -- enter the root of your miniqdb instance here, without the trailing slash. For example, `http://www.example.com/stuff/miniqdb`
  * _**maxLines**_ (default: 3) -- the maximum number of lines to submit to the channel.
  * _**auth**_
    * _**auth.username**_ -- enter the username for HTTP Basic authentication. don't worry about this if your server doesn't require authorization.
    * _**auth.password**_ -- enter the password for HTTP Basic authentication. don't worry about this if your server doesn't require authorization.

# Bugs and RFEs #
If you come across a bug, or would like an additional feature, file an issue with the label Section-Supybot-Miniqdb.