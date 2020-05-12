<?php
session_start();
require 'common.php';

$uname=$_POST['uname'];
$pwd=$_POST['pwd'];

if($uname=="" || $pwd=="")
{
    echo "Username/Password cannot be empty";
}
else
{
if($uname=="admin")
{

        if($pwd=="admin")
        {
            echo "success";
            
            $_SESSION['uname']='admin';
            
           
        }

        else
        {
            echo "Incorrect password";
        }
}
else
{
    echo "Incorrect Username";
}

}
?>
