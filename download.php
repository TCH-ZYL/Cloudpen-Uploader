<head>
<title>下载页面</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script>
  window.onbeforeunload=function()  
  { window.location="./del.php";  
    alert ("提示：退出页面时，您寄存在服务器上的中转文件将会删除。感谢使用！");  
  }

</script>
</head>
</html>
<?php
session_start ();
require_once('function.php');
downloadfile();
?>

