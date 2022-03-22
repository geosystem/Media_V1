<?php
/**
 * Created by GeoSystem.
 * User: Andreas
 * Date: 05/01/2015
 * Time: 8:17
 */


$hostname_web = "localhost";
$database_web = "sahabat";
$username_web = "root";
$password_web = "[arint0k0]";
$sahabat      = mysql_pconnect($hostname_web, $username_web, $password_web) or die(mysql_error());
mysql_select_db($database_web, $sahabat);
?>