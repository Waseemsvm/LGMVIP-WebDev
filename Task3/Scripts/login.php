<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
   if(!empty($_POST['userid']) && !empty($_POST['password']) && !empty($_POST['role'])){
    
      session_start();
      $_SESSION['userid'] = $_POST['userid'];
      $_SESSION['password'] = $_POST['password'];
      $_SESSION['role'] = $_POST['role'];
      

      switch($_SESSION['role']){
         case "admin":
               header("Location: ./Admin.php");
            break;
         case "teacher":
               header("Location: ./Teacher.php");
            break;
         case "student":
               header("Location: ./Student.php");
            break;

      }
   }else{
      header('Location: ../index.php');
      echo "error";
   }

?>