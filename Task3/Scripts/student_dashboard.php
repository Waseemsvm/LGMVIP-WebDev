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
        .buttonDiv{
            padding: 10px;
            width: 80%;
            margin-left: 20%;
            display: flex;
            justify-content: space-around;
        }

        .container{
            margin-top: 20px;
        }
        .buttonDiv button a{
            color: #000;
            font-size: 1.2em;
        }
        body{
            background-color: #021636
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
            $student_id = $_GET['id'];
            $sql = "select id, sub_id, sub_marks from marks where  id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $student_id);
            $stmt->execute();

            // if the rows exist then the user exists and stands authenticatd
            if($stmt->rowCount() > 0){

?>
        <div class="buttonDiv">
            <button class="btn btn-light">
            <?php
                    echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
                ?>
            </button>
            <button class="btn btn-light" > <a href="logout.php"> Logout</a></button><br><br>
        </div>
                
            
            
<?php
// fetch all the rows of the table
            $rows = $stmt->fetchAll();
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

foreach($rows as $mark){
$i++;

$sum+=$mark['sub_marks'];
$percent = round($sum/100*100, 2);
?>
                    
                    
                <tr>
                <th scope="col"><?=$i?></th>
                <th scope="col"><?=$mark['sub_id']?></th>
                <th scope="col"><?=$mark['sub_marks'] ?></th>
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
                <td><?=$percent." %"?></td>
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

                exit;
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

            exit;

        }
    }
    catch (PDOException $e) {
        echo "Connection Failed ! ". $e->getmessage();
    }

?>

    
</body>
</html>


