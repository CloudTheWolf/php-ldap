# php-ldap

# Requirements
- IIS or Apache base web server
- PHP 7
- php_ldap module enabled in the php.ini file

# Setup

1 - Uplaod the files to the desired location on your server

2 - Open inc/hader.inc.php

3 - Replace {{LDAP_HOST_NAME}} with the IP or URL of your LDAP Server. If needed also change the port number
4 - Replace {{LDAP_USER}} with your username. (Eg. cn=Username,ou=MyDir,dc=mysite,dc=com)

5 - Replace {{LDAP_PASSWORD}} with your password

6 - Replace {{LDAP_TREE}} with your LDAP Base Search Query (Eg. ou=treeName,ou=MyDir,dc=mysite,dc=com)

7 - (Optional) Replace the F Data / Lables and nonumber values as required

