<?php

include("dbconfig.php");
  //Checking if we are into the OpenShift App
  if (isset($_ENV['OPENSHIFT_APP_NAME'])) {
    $db_user=$_ENV['OPENSHIFT_MYSQL_DB_USERNAME']; //Openshift db name OPENSHIFT_MYSQL_DB_USERNAME
    $db_host=$_ENV['OPENSHIFT_MYSQL_DB_HOST']; //Openshift db host OPENSHIFT_MYSQL_DB_HOST
    $db_password=$_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']; //Openshift db password OPENSHIFT_MYSQL_DB_PASSWORD
    $db_name=$database; //Openshift db name
  } else {
    
    $db_user=$user; //my db user
    $db_host=$host; //my db host
    $db_password=$password; //my db password
    $db_name=$database; //my db name
  }

//CREATING THE CONNECTION
//CAMBIAR $mysqli en todas las paginas y usar ESTA: $connection
    $connection = new mysqli($db_host,$db_user,$db_password,$db_name);
    $connection->set_charset("utf8");
//TESTING IF THE CONNECTION WAS RIGHT
    if ($connection->connect_errno) {
        echo $connection->connect_error;
        exit();
    }
?>
