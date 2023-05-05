<?php
function check_login()
{
if(strlen($_SESSION['admin_login'])==0)
	{
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="../home.php";
		$_SESSION["admin_login"]="";
		header("Location: http://$host$uri/$extra");
	}
}
?>
