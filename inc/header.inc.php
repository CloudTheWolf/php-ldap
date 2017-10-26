<?php

/***********************************
 * Name: PHP LDAP Directory
 * Version: 1.1
 * Developed by Michael Howard
 ***********************************
 * Change Notes
 ***********************************
 * Version 1
 * - Initial Release
 * 
 * Version 1.1
 * - Results not sorting by name using the CN field
 * - If the mobile field is blank or is set to 00000000 it will now show as SYS_NO_NUMBER (Set Below)
 *
 *************************************/
/*******************
 * Basic Settings **
 *******************/
$ldapserver = 'ldap://{{LDAP_HOST_NAME}}:389'; //LDAP Serevr Host/IP
$ldapuser   = '{{LDAP_USER}}'; //LDAP Username
$ldappass   = '{{LDAP_PASSWORD}}'; //LDAP Password
$ldaptree   = '{{LDAP_TREE}}'; //LDAP Search Query

$noNumber = 'NONE'; // What to show if value = 00000000 or is blank
$f1Label = 'Name'; //Label for Field 1
$f1Data = 'cn'; //LDAP Field for Field 1
$f2Label = 'Extension Number'; //Label for Field 2
$f2Data = 'telephonenumber'; //LDAP Field for Field 2
$f3Label = 'Phone Number'; //Label for Field 3
$f3Data = 'mobile'; //LDAP Field for Field 3

/***********************
 * System Controllers **
 ***********************/
define ('LDAP_SERVER_NAME', $ldapserver);
define ('SYS_LDAP_PROTOCOL_VERSION',3);

define ('SYS_NO_NUMBER', $noNumber);
define ('WEB_FIELD_1_LABEL', $f1Label);
define ('WEB_FIELD_1_DATA', $f1Data);
define ('WEB_FIELD_2_LABEL', $f2Label);
define ('WEB_FIELD_2_DATA', $f2Data);
define ('WEB_FIELD_3_LABEL', $f3Label);
define ('WEB_FIELD_3_DATA', $f3Data);