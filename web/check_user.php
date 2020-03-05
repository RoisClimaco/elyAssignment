<?php 
include '../lib/database.class.php';
include '../lib/admin_users.class.php';
$objAdminUser = new AdminUser();
$strString = $_GET['user'];
//$strString = "egcristoria";
$objAdminUser -> voidSetUsername($strString);
$blnIsExisting = $objAdminUser -> blnValidateAdminUsername();

if (!$blnIsExisting) {
    print "<div  style='color: red;'><b>Username already Exist! Select another Username</b></div>";
}

?>