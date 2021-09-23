
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        .content{
            background-color: #021636;
            color: white;
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .returnHome{
            font-size: 1.5em;
            color: #fff;
        }
    </style>

</head>
<body>
    <?php

    session_start();
    session_unset();
    session_destroy();
    ?>
    <div class="content">
    
    <h1 class ="display-1">You have been logged out </h1>
    
    <a href=" ../index.php "  class="returnHome">Return to Home Page</a>
    </div>
    <?php
    exit();  
?>
</body>
</html>
