eBay Platform Notifications Listener
Written in PHP 5 using ext/soap

by Adam Trachtenberg

Sample code to process eBay Platform Notifications using the PHP 5
ext/soap extension.

listener.php
Receives the notifications from eBay, validates the message signature,
and allows you to act on them.

generator.php
Sends notifications on demand to your listener. Allows you to test
your listener code without going to eBay and triggering them manually.

SetNotificationPreferences.php
Tell eBay where it should send notifications. Also use it to
subscribe to specific notification types on behalf of a member.

GetNotificationPreferences.php
Check your eBay notification settings.

eBaySOAP.php
Helper files to make eBay Trading Service API calls and a base class
shared across the Platform Notification listener and generator.

ebay.ini
Configuration file for keys and tokens.

notifications/*.xml
Sample notifications used by generator.php

platform-notifications.txt
Explains whys and hows of using notifications. Unfinished.
