<?php
# http://www.php.net/manual/en/security.php
# http://shiflett.org/

Security

----

Normally, when a PHP file is requested, the sequence of procedures are: read - parse – compile – execute.  Code Acceleration works by saving the PHP code, once it is called for the first , into the server’s memory (RAM; configurable).  Then, each subsequent time the code is called, the saved, pre-compiled version is used instead of the original script

Note: Acceleration is not the same thing as Caching

Acceleration saves the actual compiled script in the server’s memory, while Caching saves the output of that script.

From a development view, it is recommended that this feature be set to Off during development, then to On for deployment, with the developer selectively excluding (“blacklist”, user_blacklist_filename) those files that should not be cached. Common reasons not to cache a page are: files that have high memory consumption.


----

In your home, you have locks on your doors or windows… in the Internet world, you have similar measures though more abstract in concept

Not a single thing you can do… multiple steps… look at both input and output
Most people don’t think about output to user as a vulnerability, but it is!

Developers need to be aware of embedding security measures throughout the application development lifecycle

In essence, Security is all about data safety

Must be OBSESSIVE about logging information on your site… get most information about attack vector and limit as much as possible the amount of info attacker receives about you

Major areas they need to address are:
inherent safety in code
filtering of I/O
handling of errors – internally and to the public
data encryption


----

Defense in Depth is a strategy... putting more and more layers of security into the applications makes it harder for a vector attack to succeed, and may dissuade some from attacking

Ultimate goal is not to have a ‘hacker-proof’ web site… probably not possible… Even if the site is completely secure there are still humans accessing the site who can be fooled
Just don’t want to be the MOST vulnerable

----

Data from outside can come from anywhere… user forms, get, post… BUT must think about other forms, like HTTP headers
HTTP Protocol: Browser send pieces of information to web server; that info is almost directly ported right into a variable available within PHP - e.g., superglobal, httphost

GET vs. POST
CGI: POST passes data via standard input; GET adds data to URL, so data potentially can be displayed (security issue)
Don’t be lulled into thinking that POST is immune to security risks
HTTP: GET designed for web access which only displays information; POST requests are designed for requests with other actions tied to them – if Get is used, browsers, caches and proxies may behave incorrectly

Cookies
Only pass an identifier in a cookie, not sensitive data
Subject to Sniffing, where an attacker obtains access to computer, then observes cookie being passed between site and user – steals information

Server Variables such as REQUEST_URL contain user provided data

 Cookies: (can be set only for the domain and sub-domains the user is on… Parent to child only direction… )
Any information sent out should be considered known to the user and potentially to other agents - so it should be restricted to minimum and verified on input, not trusted (e.g., cookie saying "logged in" is bad idea);

Cookies and Check Host: will certainly not work for groups of computers hidden behind a single IP address (i.e. NAT). Since most corporate networks access this internet this way, this form of check is of limited value

Error Logging: Probably most under-rated and under-utilized strategy step for security
In order for malicious users to take advantage of your programs, they must first probe your application to find possible attack vectors, so they often probe web applications to gather as much information as possible about them, esp. by trying to cause errors.

Example: 
It tells us that
There is a variable key called passwd
Often, variable names are mapped onto database column names, so we know that there’s a likelihood that there’s a column called passwd
It tells us that there’s a file called user.inc in the directory /includes.  Since the web server may not see .inc files as PHP files we could probably download that file
It also tells us that the program is running Linux and Zend Core/Apache2… if there were security vulnerabilities in these (no known in Core), then could exploit
If that’s possible we could also look at require and include functions in that file and download other important files

register_globals: “poster boy” for making something so simple it becomes dangerous
At one time, was default as ‘ON’, but not any more.

“What do you do if you have to have this on?” some companies have this built in, depending on when applications were built
Not dead in the water, but have to be especially careful
Every variable HAS TO BE INITIALIZED!
Use tools; Zend Studio, e.g., has Code Analyzer to identify when you are using variables before they have been initialized
could use isset() to ensure that all variables are defined, especially useful if dealing with data of uncertain quality

Least Privileges:
older versions of OS, like Windows, used to require too many people to be an Admin… not any more
Limit permissions to minimum necessary - running as an Admin supercedes all other security measures, so any breach now extends over entire system, not just individual user
e.g., no sending world-writtable ‘777’ file directories
Take the time to make sure groups, directories, and related permissions are established correctly

http://www.onlamp.com/pub/a/php/2003/07/31/php_foundations.html
part 1 -
part 2 - system attacks
part 3 - logging and security

Common Style mistakes can compromise security
http://www.onlamp.com/pub/a/php/2003/05/29/php_foundations.html
http://www.onlamp.com/pub/a/php/2003/07/31/php_foundations.html

http://shiflett.org/
http://en.wikipedia.org/wiki/Csrf (cross site request forgery)
http://en.wikipedia.org/wiki/Cross-site_scripting
PHP Architect's Guide to PHP Security
Pro PHP Security

Other Books
Scalable Internet Architectures
Practices of an Agile Developer
Web APIs with PHP
Pro PHP XML and Web Services
