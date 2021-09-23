<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <style>
        .content{
            color: red;
            font-weight: 1000;
            background-color: yellow;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .returnHome{
            font-size: 1.5em;
        }

        nav{
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;  
            padding: 10px;           
        }
        nav>div{
            height: 100%;
        }

        .container{
            margin-top: 20px;
        }

        .buttonDiv{
            display: flex;
            justify-content: space-between;
        }
        .buttonDiv button{
            margin-right: 10px;
        }

        .buttonDiv button a{
            color: #000;
            font-size: 1.2em;
        }

        body{
            
            background-color: #021636;
        }

        td > a {
            color: white;
        }
    </style>
</head>
<body>
<?php

    session_start();
    // print_r($_SESSION);

    $username = "root";
    $password = "";
    $dbname = "test";
    $servername = "localhost";
    
    try{
         // connect to the database
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //  echo "Connected Successfully !";
        
        if(isset($_SESSION['userid'])){
            //if connection is successful then check if the user exists in the students table
            $userid = $_SESSION['userid'];
            $password = $_SESSION['password'];
            $sql = "select * from teacher where  tid = :userid and password= :password";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":userid", $userid);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

        }else{

            ?>
            <div class="content">
            
            <h1 class="display-1">User Authentication Failed!</h1>
            <p>(Login as a Teacher)</p>
            <a href="../index.php" class="returnHome">Return to Home Page</a>
            </div>
<?php

            exit;
        }

         
 
    }
    catch (PDOException $e) {
        echo "Connection Failed ! ". $e->getmessage();
    }

?>

<?php   
       
        // if the student exists then fetch the details
    if($stmt->rowCount() > 0){
?>
   
   
<?php
        $sql = "select distinct tname from teacher where tid=:userid and password=:password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $row = $stmt->fetch();
            
?>
    <!-- This is shown when the user is authenticated -->
        <nav>
        <h1> Hello <?=$row['tname']?> ! </h1>
        <div class="buttonDiv">    
        <button class="btn btn-light"> <a href="updateMarks.php">Update the marks</a> </button>
        <button class="btn btn-light"> <a href="logout.php"> Logout</a></button><br><br>
        </div>
        </nav>
        

<?php


        $sql = "select distinct id, name from student";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();

?>
    <div class="container">
        <table class="table table-dark">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">student id</th>
                <th scope="col">name</th>
                <th scope="col">Result</th>
                </tr>
            </thead>
        <tbody>

<?php

$i=0;

foreach($row as $student){
$i++;
?>
                    
                            <tr >
                            <th scope="row"><?=$i?></th>
                            <td><?=$student['id']?></td>
                            <td><?=$student['name']?></td>
                            <td><a href="student_dashboard.php?id=<?=$student['id']?>"><?= "View Result"?></a></td>
                            </tr>

<?php
}
?>
    
</tbody>
</table>
</div>
<?php
    

        }else{

            unset($_SESSION);
            session_destroy();

?>

            <div class="content">            
            <h1 class="display-1">User Authentication Failed!</h1>
            <a href="../index.php" class="returnHome">Return to Home Page</a>
            </div>

    
<?php
        }
?>

    
</body>
</html>


