=== KC Admin area Monitor ===
Contributors: krumch
Donate link: http://krumch.com/2016/07/02/kc-admin-area-monitor/
Stable tag: 2016.06.02
Tested up to: 5.2.4
Requires at least: 3.0
Requires: WordPress® 3.0+, PHP 5.2+
Tags: security, security check, security camera, admin security, dashboard security, log, security log, admin connections log, security prevention, risk prevention, self protection, activity log, security tool, log tool, check tool

Monitors WEB connections to your admin area. The "security camera" in your Admin dashboard.


== Description ==

<p>This plugin is for at least "middle techy" developers or site owners, as works with "too raw" info.</p>
<p>This plugin is a "security camera" only, passive registering tool, not a "guard", active protection tool. Whitelisting blocks only messages to you, not the work of your site, theme and plugins.</p>
<p>When anybody sends a request to your WordPress dashboard, you will get a mail. There in mail will be all the info about this request: call stack, _REQUEST and _SERVER arrays, and a message from the plugin. Messages will be only two: "KCAM options saving" or "Alert".</p>
<p>Note, it sends emails on EVERY request, include your activity in the admin area and saving his own options. That is because plugin can not recognise "you". To not be flooded with emails, you must set the whitelist. Means, copy some unique string (in "Usage" section you will find examples) from the email you got from it, put in whitelist and you will not get emails that have this string inside.</p>
<p>In the screenshot I set (row by row) my IP, a marker from another tool of mine, my mobile user agent (as it can have lot of IPs, can not set them all), "action" from the logging plugin, several actions from intruders, all they mimic plugins I don't run, so they are not menace for me, and finally, my server's IP, sometimes wp_cron uses it.</p>
<p>Now I get only alerts about some plugins, that allow cracking, or when some intruders try some URLs, without to know the structure of my site. With that info I can do something to protect my site. I ban IPs of "most motivated" intruders, change plugins, even consult others what plugins to avoid and find viruses in other people computers just because they saw some pages on my site and viruses run scanning on the site right away, without their knowing.</p>


== Installation ==

Nothing special, just a generic installation. You must set it in admin area, please find a new row "KC Admin Monitor" in "Settings" menu. Fill the "whitelist". See detailed description about that in next chapter.

== Usage ==

The plugin sends emails like this:
<pre>_________REQUEST__________
!reauth! -> !1!<br>
!redirect_to! -> !http://krumch.com/blog/wp-admin/!<br>

_________Environment Variables__________
!DOCUMENT_ROOT! -> !/var/www/vhosts/krumch.com/httpdocs!<br>
!FCGI_ROLE! -> !RESPONDER!<br>
!GATEWAY_INTERFACE! -> !CGI/1.1!<br>
!HTTP_ACCEPT! -> !*/*!<br>
!HTTP_ACCEPT_CHARSET! -> !ISO-8859-1,utf-8;q=0.7,*;q=0.7!<br>
!HTTP_ACCEPT_ENCODING! -> !gzip,deflate,identity!<br>
!HTTP_ACCEPT_LANGUAGE! -> !en-us,en;q=0.5!<br>
!HTTP_CACHE_CONTROL! -> !max-age=0!<br>
!HTTP_CONNECTION! -> !close!<br>
!HTTP_COOKIE! -> !PHPSESSID=4adii70f2r25e5s6ai1bh7m2b0!<br>
!HTTP_HOST! -> !krumch.com!<br>
!HTTP_USER_AGENT! -> !Mechanize/2.7.3 Ruby/1.9.3p551 (http://github.com/sparklemotion/mechanize/)!<br>
!PATH! -> !/sbin:/usr/sbin:/bin:/usr/bin!<br>
!PHP_SELF! -> !/blog/wp-login.php!<br>
!PP_CUSTOM_PHP_INI! -> !/var/www/vhosts/krumch.com/etc/php.ini!<br>
!QUERY_STRING! -> !redirect_to=http%3A%2F%2Fkrumch.com%2Fblog%2Fwp-admin%2F&amp;reauth=1!<br>
!REMOTE_ADDR! -> !23.88.121.52!<br>
!REMOTE_PORT! -> !44030!<br>
!REQUEST_METHOD! -> !GET!<br>
!REQUEST_TIME! -> !1476619690!<br>
!REQUEST_URI! -> !/blog/wp-login.php?redirect_to=http%3A%2F%2Fkrumch.com%2Fblog%2Fwp-admin%2F&amp;reauth=1!<br>
!SCRIPT_FILENAME! -> !/var/www/vhosts/krumch.com/httpdocs/blog/wp-login.php!<br>
!SCRIPT_NAME! -> !/blog/wp-login.php!<br>
!SERVER_ADDR! -> !50.62.142.159!<br>
!SERVER_ADMIN! -> !server.elmarmaurer@yahoo.com!<br>
!SERVER_NAME! -> !krumch.com!<br>
!SERVER_PORT! -> !80!<br>
!SERVER_PROTOCOL! -> !HTTP/1.1!<br>
!SERVER_SIGNATURE! -> !<address>Apache Server at krumch.com Port 80</address>
!<br>
!SERVER_SOFTWARE! -> !Apache!<br>

_________MESSAGE__________
!<pre>Alert</pre>!

</pre>

Looks scary? Nope, that is only the info of a HTTP request. Someone scans my site for some old bug... This is the full list of data, what the server knows about the request.

If you want to avoid emails like this, created by your activity on the site, you must set your IP in the whitelist. That is easy: copy the row:
<pre>!REMOTE_ADDR! -> !23.88.121.52!</pre>
Check if this is your IP (I use <a href="http://www.infosniper.net/">Infosniper</a> or <a href="https://www.whatismyip.com/">WhatIsMyIP</a>). Then put in whitelist and you will not get email alerts for your activity. Do same for other admins in your site, if any.

If you want to stop alerts for the request, what have "reauth" parameter equal to "1", grab this row:
<pre>!reauth! -> !1!</pre>
and put it in the whitelist. Note that there can be lot of requests with this parameter, and this will hide all of them.

This way you create your whitelist (each string/rule alone on a row). Set unique strings for each action you want to skip the alert, to be sure you will mute the exactly action you know that is not a problem for your site. Avoid HTML tags - they will be deleted. Please check my own settings at "Screenshot" tab bellow.

If you do a mistake, save wrong row or so, you won't do any harm on your site. All the requests will be executed, not suspended, in any case. This plugin is a "security camera" only, passive registering tool, not a "guard", active protection tool. You block only messages to you, not the work of your site, theme and plugins. It will work well with any plugin, include your security plugins. Actually, you can check how well works your security plugins, using this tool.

== Frequently Asked Questions ==

No questions, so far. Ask me, I will answer.

== Screenshots ==

1. Admin area

In the screenshot I set (row by row) my IP, a marker from another tool of mine, my mobile user agent (as it can have lot of IPs, can not set them all) on 3 rows, "action" from the logging plugin, several actions from intruders, all they mimic plugins I don't run, so they are not menace for me, and finally, my server's IP, sometimes wp_cron uses it.

== Changelog ==

= 2016.06.02 =
* Released as the very first version

