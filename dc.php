<?php
session_destroy();
unlink ("./sdk/cache");
copy("./cache","./sdk/cache");
header("Location: index.html");
?> 
