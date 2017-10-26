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
 
 /********************
 * Expert Settings **
 ********************/
set_time_limit(30);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL & ~E_DEPRECATED);
ini_set('display_errors',0); // Set to 1 to display errors.
 
// Load External Config
require_once ('./inc/header.inc.php');

// connect 
$ldapconn = ldap_connect(LDAP_SERVER_NAME) or die("Could not connect to LDAP server.");

if($ldapconn) {
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, SYS_LDAP_PROTOCOL_VERSION);
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldapuser, $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn)." ".LDAP_SERVER_NAME." on Protocol Version: " .SYS_LDAP_PROTOCOL_VERSION);
	
	// Add some HTML to make it look cleaner 

	// verify binding
    if ($ldapbind) {
  		echo("<html>");
		echo("<head>");
		echo("<title>Phone Direcrtory</title>");

		echo('<link rel="stylesheet" href="./styles.css" />');
		echo('<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>');
		echo('<link href="./css/bootstrap.min.css" rel="stylesheet">');
		echo("</head>");
		echo("<body>");
		echo('<script> function sName() { var url="index.php?n=" + document.getElementById("n").value; location.href=url; return false; } </script>');
		echo('<form name="SearchN"  onSubmit="return sName();">');
		
		if (!isset($_GET['n'])) {
			echo('<center>Search By Name: <input type="text" name="n" id="n" placeholder="Search By Name">&nbsp;<input class="btn btn-success" type="submit" value="Search"></center>');
			} else { 
			echo("<center>Search By Name: <input type='text' name='n' id='n' value=".$_GET['n'].">&nbsp;<input class='btn btn-success' type='submit' value='Search'>&nbsp;<a class='btn btn-danger' href='index.php' role='button'>Reset Filter</a></center>");
			
			}
		        // print number of entries found

			echo('');
			if (!isset($_GET['n'])) {
			$result = ldap_search($ldapconn,$ldaptree, "(cn=*)") or die ("Error in search query: ".ldap_error($ldapconn));
			ldap_sort($ldapconn, $result, 'cn');
			$data = ldap_get_entries($ldapconn, $result);
			} else {
			$result = ldap_search($ldapconn,$ldaptree, "(cn=*".$_GET['n']."*)") or die ("Error in search query: ".ldap_error($ldapconn));
			ldap_sort($ldapconn, $result, 'cn');
			$data = ldap_get_entries($ldapconn, $result);
			}
		
        echo "<center>Found: " . ldap_count_entries($ldapconn, $result)." Results for ".$_GET['n']."</center>" ;
		} else {
			echo "<center>LDAP bind failed...</center>";
		}
		// iterate over array and print data for each entry
		
			echo('<table class="table table-hover" style="font-size: 13px; border-collapse: collapse">');
			for ($i=0; $i<$data["count"]; $i++) {

			$coName = $result[$i]["cn"][0];
			$cname["$i"]= $coName;

			if ($data[$i]["telephonenumber"][0] == '00000000' ) {
					echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_1_LABEL.": </strong>".SYS_NO_NUMBER."</td></tr>";
				} else {
					echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_1_LABEL.": </strong> ". $data[$i][WEB_FIELD_1_DATA][0] ." </th> ";
				}
            
            
            if(isset($data[$i]["telephonenumber"][0])) {
			     if ($data[$i]["telephonenumber"][0] == '00000000' ) {
					echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_2_LABEL.": </strong>".SYS_NO_NUMBER."</td></tr>";
				} else {
					echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_2_LABEL.": </strong> ". $data[$i][WEB_FIELD_2_DATA][0] ." </td> ";
				}
            } else {
                echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_2_LABEL.": </strong>".SYS_NO_NUMBER."</td>";
            }

            if(isset($data[$i]["mobile"][0])) {
                if ($data[$i]["mobile"][0] == '00000000' ) {
					echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_3_LABEL.": </strong>".SYS_NO_NUMBER."</td></tr>";
				} else {
					echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_3_LABEL.":</strong> ". $data[$i][WEB_FIELD_3_DATA][0] ."</td></tr>";
				}
           	} else {
                echo "<td style='border-right: solid 1px #C0C0C0; border-left: solid 1px #C0C0C0;'><strong>".WEB_FIELD_3_LABEL.": </strong>".SYS_NO_NUMBER."</td></tr>";
            }
			

        }
		echo('</table>');
		// Now lets close the html
		echo("</body>");
		echo("</html>");
}

//Before we finish, let's clsose the connection down.
ldap_close($ldapconn);
?>