<?php
if(!empty($_GET['spasswd'])){
	setPasswd($_GET['spasswd']);
	 header ( 'Location:metadata.php' );
	}
if(!empty($_POST['kdpasswd'])){
	kedui($_POST['kdpasswd']);
	header ( 'Location:metadata.php' );
	}

function uploadfile(){
	session_start ();
    require_once('conn.php');
	$upload = $kp->api ( 'fileops/upload_locate' );
    
    if (false !== $upload) {
        $params = array (
            'root' => 'app_folder',
            'overwrite' => 'true',
            'path' => $_SESSION['nf'].'/'.$_FILES['uploadfile']['name'] 
    );
    $filename = dirname ( __FILE__ ) . "/upload/".$_FILES['uploadfile']['name'];
    echo dirname ( __FILE__ ) . "/upload/".$_FILES['uploadfile']['name'];
    $ret = $kp->api ( sprintf ( '%s/1/fileops/upload_file', rtrim ( $upload ['url'], '/' ) ), '', $params, 'POST', $filename );
    if (false === $ret) {
        $ret = $kp->getError ();
        }
    unlink( $filename);
    } else {
    $ret = $kp->getError ();
     print_r($ret);}
	}
	
function downloadfile(){
	session_start ();
    require_once('conn.php');
    $fn=$_GET["fn"];
    $type=strstr($fn,".");
    $type=strtolower($type);
    if($type=='.txt'|| $type=='.doc' || $type=='.xls'  || $type=='.ppt' || $type=='.rar'  || $type=='.zip'  || $type=='.jpg' || $type=='.gif' || $type=='.png')
    {
      $params = array (
        'root' => 'app_folder',
        'path' => $_SESSION['nf'].'/'.$fn
         );

     $fn1=time().$fn;

     $filename = dirname ( __FILE__ ) . '/download/' . $fn1 ;
     $ret = $kp->api ( 'fileops/download_file', '', $params, 'GET', $filename );

   if (false === $ret) {
       $ret = $kp->getError ();
       } else {
       $ret = array (
            'saved_path' => $filename 
        );
      }
    $_SESSION['fn']=$filename;
    echo "您好，文件已经中转到安全区域，请<a href=./download/".rawurlencode($fn1)." target='_blank'>点击</a>下载你所需要的文件";
    }else{
	echo "为顾及服务器安全，该类型文件不能下载，谢谢使用！您可下载的文件类型有rar,zip,xls,doc,ppt,txt,png";
      }
	}
	
	function setPasswd($getps){
		session_start ();
        require_once('conn.php');
        $file="./sdk/cache";
        $handle=fopen($file,'r');  
        $token=unserialize(fread($handle,filesize($file))); 
        $userfile="./passwd/".$token['user_id'];
        file_exists($userfile) or touch($userfile);
        $filename=$_SESSION['nf'];
         $passwd=$getps;
         $cline=0;
         $countmulu=substr_count($filename,"/");
        if($countmulu>1){
      
        $fp=fopen($userfile,"a+r");
        while(false!==($line=fgets($fp))){
			         $cline++;
					  $ret=explode("|",$line);
					  if($ret[0]==$filename)
					     { fclose($fp);
                          del_str_line($userfile,$cline);
                          $fp=fopen($userfile,"a+r");
                          }
                       }
        
        $str=$filename."|".$passwd."|\n";
        $do=fwrite($fp,$str);
        fclose($fp);
        
        //$content=file_get_contents($userfile);
		//$content=trim($content);
		//$content=preg_replace('/\s(?=\s)/', '', $content);
		//$fp=fopen($userfile,"w");
		//fwrite($fp,$content);
        }
        
		
}
	
	function yanzheng(){
		 session_start ();
         require_once('conn.php');
         $file="./sdk/cache";
		 $handle=fopen($file,'r');  
         $token=unserialize(fread($handle,filesize($file))); 
         $userfile="./passwd/".$token['user_id'];
         if(file_exists($userfile)==false){
			 $_SESSION['yespass']=0;
			 return true;			  
			 }
		 if(file_exists($userfile)){
			 $filename=$_SESSION['nf'];
             $fp=fopen($userfile,"r");
                while(false!==($line=fgets($fp))){
					  $ret=explode("|",$line);
		                  if($filename==$ret[0] && $ret[0]!==''&& $_SESSION['access']!==1){
							  $_SESSION['yespass']="no";
							  echo "<form  action='function.php' method='post'><input type='password' name='kdpasswd'><input type='submit' value='验证'></form>";
							  return false;
							  }
					  }
			   $_SESSION['yespass']=0;
			   return true;
			 }
		}
		  
		
	function kedui($sendpass){
	session_start ();
    require_once('conn.php');
    $file="./sdk/cache";
    $handle=fopen($file,'r');  
    $token=unserialize(fread($handle,filesize($file))); 
    $userfile="./passwd/".$token['user_id'];
    $filename=$_SESSION['nf'];
    $fp=fopen($userfile,"r");
 	   while(false!==($line=fgets($fp))){
		$ret=explode("|",$line);
		if($filename==$ret[0]  &&  $sendpass==$ret[1] )
		{ $_SESSION['access']=1;
		break;
	  }
			      else{
			      $_SESSION['access']=0;
			    }
		}
		   
	  
		}
		
		function yanzheng1(){
		 session_start ();
         require_once('conn.php');
         $file="./sdk/cache";
		 $handle=fopen($file,'r');  
         $token=unserialize(fread($handle,filesize($file))); 
         $userfile="./passwd/".$token['user_id'];
         if(file_exists($userfile)==false){
			 $_SESSION['yespass']=0;
			 return true;			  
			 }
		 if(file_exists($userfile)){
			 $filename=$_SESSION['nf'];
             $fp=fopen($userfile,"r");
                while(false!==($line=fgets($fp))){
					  $ret=explode("|",$line);
		                  if($filename==$ret[0] && $ret[0]!==''&& $_SESSION['access']!==1){
							  $_SESSION['yespass']="no";
							  
							  return false;
							  }
					  }
			   $_SESSION['yespass']=0;
			   return true;
			 }
		}
		


function del_str_line($filename,$line){
$str='';
$handle = @fopen($filename, "rb+");//以读写方式打开，
//为移植性考虑，强烈建议在用 fopen() 打开文件时总是使用 'b' 标记。
if ($handle) {
for($i=0;$i<$line;$i++){
$str=fgets($handle);//读取指定的行
}
//关闭文件，因为当前的文件指针已经指向了下一行
//如果不关闭，直接执行下面的重写代码，PHP会在$line+1删除指定个数的字符
rewind($handle);//重置文件指针到开头
$len=strlen($str);//计算指定行的长度
for($i=0;$i<$line-1;$i++){
fgets($handle);//将文件指针定位到指定行的上一行
}
for($n=1;$n<=$len-1;$n++){//循环重写文件，这时候文件指针移动到指定行
fwrite($handle,' ');//将指定行每个位置的字符用空格代替，实现删除
}
}
}


?>
