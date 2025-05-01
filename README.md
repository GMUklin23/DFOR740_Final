# User Agent Spoofing Identification
This github project was proof of concept of identifying User Agent spoofing within browsers as part of a class final project. It takes advantage of the fact that not all user agent spoofing plugins will properly modify the Navigator object's user agent property of the javascript engine. It also has additional components on the PHP side which demonstrate the WhatIsMyBrowser api as a second layer of spoofing detection if the given a suspicious/non-standard user agent string.

## Languages
- PHP
- HTML
- JavaScript (and jQuery)

## Requirements
- XAMPP Stack
- PHP Curl utility
- WhatIsMyBrowser API Key

## Installation
This project requires an XAMPP (Or LAMP) stack in order to run, so APACHE, MySQL, and PHP will have to be installed on the target platform. It also requires the PHP Curl utility which can be installed using "sudo apt install php-curl" for most debian platforms. Then, the project can be extracted into the webroot folder which is usually "/var/www/html" for Linux instances.

## Usage
Upon installation, the project can be explored as a normal web server to understand the proof of concept method for detecting user agent spoofing. It can be also used to test different plugins to determine which plugins properly spoof user agents correctly by both overriding the Window.Navigator.UserAgent javascript property **AND** the browser's network condition user agent.

## Warning
As you can probably already tell, there is no consistent way to detect user agent spoofing. Unless the user agent was badly spoofed and malformed in a way that would get flagged by the API, is it impossible to detect spoofing **solely based** on the provided user agent of a client.
