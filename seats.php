<?php
session_start();

    if(!isset($_SESSION['user'])){
        header("Location:login.php");
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>

     <link rel="stylesheet" href="seats.css"> 

</head>
<body>
    <div class="container center">

    <h3  id="absents" style="color: green;align-items: center;"></h3>
    
     <?php
        $conn="";
        require "pdo.php";
        $stmt = $conn->prepare("SELECT * FROM flights WHERE date_time=? and source=? and destination=? ORDER BY date_time");
        $stmt->execute([$_SESSION['date'],$_SESSION['source'],$_SESSION['destination']]); 
        $user = $stmt->fetchAll();
        // print_r($user);

        if(count($user)>0){
            echo "<p>Available Flights </p><br><br><br>";
            foreach($user as $x ) {
                echo "<div class='container center' >";
                    echo "<div class='container center' style='border: thin solid black'><a style='text-decoration: none' href='seatselect.php?flight_id=".$x["flight_id"]."'";
                    echo "<p>".$x["source"]." -- to -- ".$x["destination"]."</p>";
                    echo "<p> Flight Number: ".$x["flight"]."</p>";
                    echo "<p> Date : ".$x["date_time"]."</p>";
                    echo "</a></div>";
                echo "</div";
            }
        }
        else{
            echo "<p>No Flights Found</p><br><br><br><a href='bookflight.php'>Back</a>";
        }
    ?> 

    </div>

    

</body>
</html>