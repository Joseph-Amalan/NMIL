<?php
$WEB_URL = "nmil.knsclients.com";
$WEB_ROOT = '/home/knsclients/nmil/';
$SITE_URL = $WEB_URL; 
$SITEROOT = $WEB_ROOT;
$PARENT_URL = str_replace("http://","",$SITE_URL);
$DBHOST = "localhost";
$DBNAME = "nmil_service";
$DBUSER="nmil_root";
$DBPASSWORD="Nmil_r00t_888";

if(isset($_GET) && is_array($_GET))
{
	foreach($_GET as $k=>$v)
	{
		$temp = "g_".$k;
		$$temp = $v;
	}
}
if(isset($_POST) && is_array($_POST))
{
	foreach($_POST as $k=>$v)
	{
		$temp = "p_".$k;
		$$temp = $v;
	}
}
if(isset($_REQUEST) && is_array($_REQUEST))
{
	foreach($_REQUEST as $k=>$v)
	{
		$temp = "r_".$k;
		$$temp = $v;
	}
	//print_r($_REQUEST);
}


include($WEB_ROOT."/includes/database.php");

function set_datetime($datetime) {
    $arr = explode(" ", $datetime);
    if (isset($arr[0]) && isset($arr[1]))
        return $arr[0] . "T" . $arr[1] . "Z";
}

?>