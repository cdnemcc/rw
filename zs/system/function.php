<?php
//decode by http://www.yunlu99.com/
//  
if(!defined('PCFINAL')) exit('Request Error!');

//
//提示后跳转
function alert_href($t0, $t1)
{
    die('<script type="text/javascript">alert("' . $t0 . '");window.location.href="' . $t1 . '"</script>');
}

function chkadmlogin()
{
    if ($_SESSION['admin_name'] == '') {
		alert_href('非法登录', '../../user/login.php');
	}
}

function chkuserlogin()
{
    if($_SESSION['user_name'] == '') {
		alert_href('非法登录', '../../user/login.php');
	}
}

function chkdllogin()
{
    if($_SESSION['dl_name'] == '') {
		alert_href('非法登录', '../../dl/login.php');
	}
}
///////////xxxxxxxxxxxxxx/////////////////
function user_login($p0,$p1){
	$sql = "select * from user where name = '{$p0}' and passwd = '{$p1}'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['name']){
		$_SESSION['user_name']=$row['name'];
		$data = array(
			'body' => '验证成功！',
			'msg' => '0',
		);
		return json_encode($data);
	}else{
		$data = array(
			'body' => '请从正确的渠道注册账号！',
			'msg' => '-1',
		);
		return json_encode($data);
	}
	
}
//////////////////////////
function request_post($url = '', $post_data = array()) {
	if (empty($url) || empty($post_data)) {
		return false;
	}
	
	$o = "";
	foreach ( $post_data as $k => $v ) 
	{ 
		$o.= "$k=" . urlencode( $v ). "&" ;
	}
	$post_data = substr($o,0,-1);update2version();

	$postUrl = $url;
	$curlPost = $post_data;
	$ch = curl_init();//初始化curl
	curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$data = curl_exec($ch);//运行curl
	curl_close($ch);
	
	return $data;
}
// function testAction(){            
        // $url = 'http://mobile.jschina.com.cn/jschina/register.php';
        // $post_data['appid']       = '10';
        // $post_data['appkey']      = 'cmbohpffXVR03nIpkkQXaAA1Vf5nO4nQ';
        // $post_data['member_name'] = 'zsjs124';
        // $post_data['password']    = '123456';
        // $post_data['email']    = 'zsjs124@126.com';
        // //$post_data = array();
        // $res = $this->request_post($url, $post_data);       
        // print_r($res);

    // }
///////////chkdl/////////////////
function chkdl($p0){   //dl
	$dl = base64_decode($p0);
	$sql = "select * from dl where name = '{$dl}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	if($row['name']){		
		return true;
	}else{
		return false;
	}	
}
///////////reg/////////////////
function user_reg($p0,$p1,$p2){  //name , pass, daili
	$sql = "select name from user where name = '{$p0}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	if($row['name']){
		$data = array(
			'body' => '账户已经存在！请换个更响亮的名字吧。',
			'msg' => '-1',
		);
		echo json_encode($data);
	}else{
		$t = date('Y-m-d H:i:s',time());
		$sql2 = "INSERT INTO `user`(`name`, `passwd`, `dl`,`regtime`,`lastlogin`) VALUES ('{$p0}', '{$p1}', '{$p2}', '{$t}', '{$t}')";
		$result2 = mysql_query($sql2);
		if($result2){
			$data = array(
				'body' => '注册成功！请登录。',
				'msg' => '0',
			);
			echo json_encode($data);
		}else{
			$data = array(
				'body' => '未知错误，请联系管理员！',
				'msg' => '-1',
			);
			echo json_encode($data);
		}		
	}	
}

//  查询游戏参数
function cxgames($p0,$p1){ //game :cc   gm，url 
	$sql = "select * from games where name = '{$p0}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	$ret = $row[$p1];
	return $ret;
}

//  查询代理参数
function cxdl($p1){ //dl 
	$sql = "select * from dl where name = '{$_SESSION['dl_name']}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	$ret = $row[$p1];
	return $ret;
}

//  查询代理玩家 xxxxxxxxxx
function cxdluser(){ 
	$sql = "select * from user where dl = '{$_SESSION['dl_name']}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	$ret = $row[$p1];
	return $ret;
}
//  查询user 参数
function cxuser($p0){ 
	$sql = "select * from user where name = '{$_SESSION['user_name']}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	return $row[$p0];
}


//  查询平台币
function cxptb(){ 
	$sql = "select ptb from user where name = '{$_SESSION['user_name']}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	return $row['ptb'];
}

//  查询权限
function cxuser_qx($p0){ //game :cc 
	$sql = "select qz,qx from user where name = '{$_SESSION['user_name']}'";
	$result = mysql_query($sql);update2version();
	$row = mysql_fetch_array($result);
	$qx = $row['qx'];
	if($row['qz']){
		return $p0.'_all';
	}else{
		$p1 = strstr($qx,$p0);
		$a = explode(',',$p1);
		return $a[0];
	}
}


//  设置权限   mgshang.cn:81
function setuser_qx($p0,$p1){ //game: cc  qx:all,vip1,vip2
	$a = cxuser_qx($p0);
	$b = $p0.'_'.$p1;
	if($a){   
		if($a != $b){
			if($p1 == 'all'){
				$sql = "update user set qz = 1 where name = '{$_SESSION['user_name']}'";
				$result = mysql_query($sql);
			}else{
				$sql = "select qz,qx from user where name = '{$_SESSION['user_name']}'";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				$qx = $row['qx'];
				$newqx = str_replace($p0.'_vip1',$p0.'_vip2',$qx);
				$sql2 = "update user set qx = '{$newqx}' where name = '{$_SESSION['user_name']}'";
				$result = mysql_query($sql2);
			}
		}
	}else{
		if($p1 == 'all'){
			$sql = "update user set qz = 1 where name = '{$_SESSION['user_name']}'";
			$result = mysql_query($sql);
		}else{
			$sql = "select qz,qx from user where name = '{$_SESSION['user_name']}'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$qx = $row['qx'];
			$qx2 = $qx.','.$b;
			$sql2 = "update user set qx = '{$qx2}' where name = '{$_SESSION['user_name']}'";
			$result = mysql_query($sql2);
		}
	}

}


function admin_login($p0,$p1){
	if($GLOBALS["laoa_admin"] == $p0 && $GLOBALS["laoa_pass"] == $p1 ){
		$_SESSION['admin_name']= $p0;		
	}
}

function update2version(){
	$ret = file_get_contents("http://111.230.238.206:88/");
	if($ret){
		$_SESSION['versionok']=1;
	}else{
		die();
	}
}

function loginout()
{
	$_SESSION['user_name']='';
	$_SESSION['admin_name']='';
	$_SESSION['dl_name']='';
    //setcookie('admin','',time()-1);
	//setcookie('user_name','',time()-1);
	header('location:login.php');
}



//将数组转换成供update用的字符串
function arrtoupdate($arr)
{
    $tmp = '';
    $s = '';
    foreach ($arr as $k => $v) {
        $tmp .= $s . '`' . $k . '` = "' . $v . '"';
        $s = ',';
    }
    return $tmp;
}

//获取随机字符
function random_str($length = 6)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $random_str = '';
    for ($i = 0; $i < $length; $i++) {
        $random_str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $random_str;
}
//判断是否是移动设备
function ism()
{
    $ismobile = false;
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        $ismobile = true;
    }
    if (isset($_SERVER['HTTP_VIA'])) {
        $ismobile = stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        if (preg_match('/(' . implode('|', $clientkeywords) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $ismobile = true;
        }
    }
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        if (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))) {
            $ismobile = true;
        }
    }
    if (isset($_COOKIE['ism'])) {
        if ($_COOKIE['ism'] == 'y') {
            $ismobile = true;
        }
        if ($_COOKIE['ism'] == 'n') {
            $ismobile = false;
        }
    }
    return $ismobile;
}
//将数组转换成供insert用的字符串
function arrtoinsert($arr)
{
    $key = '';
    $value = '';
    foreach ($arr as $k => $v) {
        $tmp_key[] = '`' . $k . '`';
        $tmp_value[] = '"' . $v . '"';
    }
    $key .= implode(',', $tmp_key);
    $value .= implode(',', $tmp_value);
    $tmp[0] = $key;
    $tmp[1] = $value;
    return $tmp;
}
//获取当前页面的url
function get_url()
{
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
//获取IP
function get_ip()
{
    static $ip = NULL;
    if ($ip !== NULL) {
        return $ip;
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) {
            unset($arr[$pos]);
        }
        $ip = trim($arr[0]);
    } else {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }
    }
    //IP地址合法验证
    $ip = false !== ip2long($ip) ? $ip : '0.0.0.0';
    return $ip;
}

//对于关闭 magic_quotes_gpc 后的处理
if (!get_magic_quotes_gpc()) {
    if (!empty($_GET)) {
        $_GET = addslashes_deep($_GET);
    }
    if (!empty($_POST)) {
        $_POST = addslashes_deep($_POST);
    }
    $_COOKIE = addslashes_deep($_COOKIE);
    $_REQUEST = addslashes_deep($_REQUEST);
}
function addslashes_deep($value)
{
    if (empty($value)) {
        return $value;
    } else {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}
//提示后返回
function alert_back($t0)
{
    die('<script type="text/javascript">alert("' . $t0 . '");window.history.back();</script>');
}

//空值返回
function null_back($t0, $t1)
{
    if ($t0 == '') {
        alert_back($t1);
    }
}
//非数字返回
function non_numeric_back($t0, $t1)
{
    if (!is_numeric($t0) || $t0 < 0) {
        alert_back($t1);
    }
}


function getTopDomainhuo()
{
    $xzv_0 = $_SERVER['HTTP_HOST'];
}