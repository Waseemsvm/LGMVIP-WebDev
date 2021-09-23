<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        form{
            width: 50%;
            margin: 100px auto;
        }
        form input{
            margin-top: 20px;
            margin-bottom: 20px; 
        }
        body{
            background-color: #021636;
            color: white;
        }

        .form-group{
            display: flex;
            align-items: center;
        }
        .form-group > label{
            width: 30%;
        }
        button[type='submit']{
            width: 100%;
        }

        .buttonDiv{
            padding: 10px;
            width: 80%;
            margin-left: 20%;
            display: flex;
            justify-content: space-around;
        }
       
        .buttonDiv button a{
            color: #000;
            font-size: 1.2em;
        }

        .container{
            margin-top: 20px;
        }
        body{
            background-color: #021636
        }
    </style>
</head>
<body>
    
<?php
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['password'])){
       
        $username = "root";
        $password = "";
        $dbname = "test";
        $servername = "localhost";
        
        try{
            // connect to the database
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected Successfully !";

            ?>

<div class="buttonDiv">
            <button class="btn btn-light">
            <?php
                    echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
                ?>
            </button>
            <button class="btn btn-light"> <a href="logout.php"> Logout</a></button><br><br>
        </div>

<form method="get" action="">
  <div class="form-group">
    <label for="student_id">Enter Student ID : </label>
    <input type="text" 
            class="form-control" 
            id="student_id" 
            placeholder="Enter Student ID"
            name="student_id"
            required>
  </div>
  <div class="form-group">
    <label for="subject_id">Enter the subject ID</label>
    <input type="marks"
           class="form-control"
           id="subject_id"
           placeholder="Enter the Subject ID"
           name="subject_id"
           required>
  </div>
  <div class="form-group">
    <label for="marks">Enter the Marks</label>
    <input type="number"
           class="form-control"
           id="marks"
           placeholder="Enter the Marks"
           name="marks"
           min="0"
           max = "20"
           required>
  </div>
    <button type="submit"  
          class="btn btn-primary btn-block"
          name="submitButton">Submit</button>
</form>

<?php

        if(isset($_GET['submitButton'])){

            if(isset($_GET['subject_id']) && isset($_GET['marks']) && isset($_GET['student_id'])){
                $student_id=$_GET['student_id'];
                $subject_id=$_GET['subject_id'];
                $marks = $_GET['marks'];
                $sql = "select * from marks where id=:id and sub_id=:sid";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $student_id);
                $stmt->bindParam(':sid', $subject_id);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $sql = "update marks set sub_marks = :mark where id= :id and sub_id= :sid";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':mark', $marks);
                    $stmt->bindParam(':id', $student_id);
                    $stmt->bindParam(':sid', $subject_id);
                    $stmt->execute();
                    header('Location: ./student_dashboard.php?id='.$student_id);

                }else{
                    ?>
                        <p style="text-align: center; color: red;">Subject ID or STUDENT ID is incorrect!</p>
                    <?php
                }
            }


        }


        }catch(PDOException $e){
            echo "Connection Failed ! ". $e->getMessage();
        }

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

