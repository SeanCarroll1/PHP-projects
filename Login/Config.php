<?php
   define('DB_SERVER', 'localhost:8889');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'root');
   define('DB_DATABASE', 'students');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   if (!mysqli_ping($db)) {
    echo 'Lost connection, exiting after query #1';
    exit;
}else
{
	echo "success";
}

?>