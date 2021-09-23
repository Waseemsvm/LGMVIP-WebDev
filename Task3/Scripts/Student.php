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
            transition-property: background-color 2s;
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

        .buttonDiv button a{
            color: #000;
            font-size: 1.2em;
        }

        body{
            
            background-color: #021636;
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
            $sql = "select * from student where  id = :userid and password= :password";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":userid", $userid);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

        }else{

            ?>

            <div class="content">                
            <h1 class="display-1">User Authentication Failed!</h1>
            <p>(Login as a Student)</p>
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
        $sql = "select distinct name from student where id=:userid and password=:password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $row = $stmt->fetch();
            
?>
    <!-- This is shown when the user is authenticated -->

        
    <nav>
        <h1> Hello <?=$row['name']?> ! </h1>
        <div class="buttonDiv">
        <button class="btn btn-light" > <a href="logout.php"> Logout</a></button><br><br>

        </div>
    </nav>

        

<?php
            
        $sql = "select id, sub_id, sub_marks from marks where id=:userid";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $marks = $stmt->fetchAll();
        // print_r($marks);

?>  
    <div class="container">
        <table class="table table-dark">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">sub_id</th>
                <th scope="col">Marks</th>
                </tr>
            </thead>
        <tbody>
<?php

            $i=0;
            $sum = 0;
            foreach($marks as $mark){
            $i++;
            $sum+=$mark['sub_marks'];
            $percent = round($sum/100*100, 2);

?>
                                
                                        <tr>
                                        <th scope="row"><?=$i?></th>
                                        <td><?=$mark['sub_id']?></td>
                                        <td><?=$mark['sub_marks']?></td>
                                        </tr>

<?php
            }
?>
  
                                        <tr>
                                        <th scope="row" colspan="2" >Total</th>
                                        <td><?=$sum?></td>
                                        </tr>
                                        <tr>
                                        <th scope="row" colspan="2" >Percentage</th>
                                        <td><?=$percent?></td>
                                        </tr>
                                        <tr>
                <th scope="row" colspan="2" >Result</th>
                <td><?= ($percent > 50)? "PASS": "FAIL";?></td>
                </tr>
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


