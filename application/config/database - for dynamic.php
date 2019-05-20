<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

//Required by CI
$active_group = "school_default";
$active_record = TRUE;

//Customized Variables to Early DB Connection
$servername = "localhost";
$username = "compatl8_root";
$password = "@Compassion123"; 
$dbname = $active_group;

//Early DB Connection Include
include "early_connection.php";

//An array of DB groups
$db_groups = array('school_default','schoolapp1','schoolapp2');

foreach($db_groups as $db_group){
	// The following values will probably need to be changed.
	$db[$db_group]['dsn'] = 'mysql:host=localhost;dbname='.$db_group;
	$db[$db_group]['hostname'] = $servername;
	$db[$db_group]['username'] = $username;
	$db[$db_group]['password'] = $password;
	$db[$db_group]['database'] = $db_group;
	
	
	// The following values can probably stay the same.
	$db[$db_group]['dbdriver'] = "pdo";
	$db[$db_group]['dbprefix'] = "";
	$db[$db_group]['pconnect'] = FALSE;
	$db[$db_group]['db_debug'] = FALSE;
	$db[$db_group]['cache_on'] = FALSE;
	$db[$db_group]['cachedir'] = "";
	$db[$db_group]['char_set'] = "utf8";
	$db[$db_group]['dbcollat'] = "utf8_general_ci";
	
}


/* End of file database.php */
/* Location: ./application/config/database.php */