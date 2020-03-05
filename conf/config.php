<?php
session_start();
//error_reporting(E_ERROR | E_PARSE | E_WARNING);
//ini_set(error_reporting,E_ALL);
require_once '../../Kernel.php';
/* Constants */
define('AD_DB_HASH_KEY', 'WIS');
define('AD_CLIENT_TITLE', 'Welcome Institute of Studies');

//constant information about the database
define('AD_DB_HOST', "localhost");
define('AD_DB_NAME', "dbSoft806");
define('AD_DB_USER', "root");
define('AD_DB_PASSWD', "");

/* Libraries */
require_once('../../lib/general.class.php');
require_once('../../lib/database.class.php');
require_once('../../lib/session.class.php');
require_once('../../lib/data_list.class.php');
require_once('../../lib/filters.class.php'); 
require_once('../../lib/admin_users.class.php'); 
require_once('../../lib/students.class.php'); 

//$iOldErrorReportingLevel = error_reporting(error_reporting() & !E_STRICT); 
//error_reporting($iOldErrorReportingLevel);

/* database connection */
$objDbConn  = new MysqlDb();
$objDbConn  -> voidInitialize(AD_DB_HOST, AD_DB_USER, AD_DB_PASSWD, AD_DB_NAME);
$objDbConn  -> voidConnect();

/* Session */ 
$objSession = new Session();
$arrSessionLoginVars = array('intAdminUserId', 'strUsername', 'strFirstName', 'strLastName', 'intUserLevel');
//print $_SERVER['PHP_SELF'];
if ($_SERVER['PHP_SELF'] == '/soft806/web/login/index.php')
{
	if ($objSession -> blnIsVariableSet($arrSessionLoginVars))
	{
		if ($objSession -> blnIsSessionKeyRegistered(AD_DB_HASH_KEY, $_SESSION['intAdminUserId']))
		{
			General::voidRedirectUrl('../main-form/index.php'); 
		}
	}
}

else
{
	if ($objSession -> blnIsVariableSet($arrSessionLoginVars))
	{
		if (!$objSession -> blnIsSessionKeyRegistered(AD_DB_HASH_KEY, $_SESSION['intAdminUserId']))
		{
			General::voidRedirectUrl('../main-form/index.php');
		}
	}
	else
	{
		General::voidRedirectUrl('../login/index.php');
	}
}



?>
