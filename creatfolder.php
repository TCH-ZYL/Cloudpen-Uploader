
<html><head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>
创建文件夹
</title></head>
<body>
</body>
</html>

<?php
/**
 * 创建一个文件夹 (new_folder_<timestamp>)
 * 
 * 
 * $kp = new Kuaipan('consumer_key', 'consumer_secret');
 */
session_start ();
require_once('conn.php');
$nowfolder=$_SESSION['nf'];

if(!empty($_GET['foldername'])){
	$root_path = 'app_folder'.UrlEncode($nowfolder); //应用拥有整个快盘的权限，否则可以使用ap_folder
    $ret1 = $kp->api ( 'metadata', $root_path, $params );
     for($i=0;$i<sizeof($ret1['files']) ;$i++)
       if($ret1['files'][$i]['name']==$_GET['foldername']  &&  $ret1['files'][$i]['type']=="folder"){
		   Print  '<Script language="Javascript">
                    alert("文件夹名已经存在");
                     location.replace("./metadata.php");
                  </Script>';
		   }	
	
   $params = array (
        'root' => 'app_folder',
        'path' => $nowfolder.'/'.$_GET['foldername'] 
);
$ret = $kp->api ( 'fileops/create_folder', '', $params );
if (false == $ret) {
    $ret = $kp->getError ();
}else{
 Print  '<Script language="Javascript">
                    alert("创建成功");
                     location.replace("./metadata.php");
                  </Script>';
//header("Location: upload.php"); 
}
//print_r ($ret);
}
?>
