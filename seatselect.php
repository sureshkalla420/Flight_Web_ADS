<?php
session_start();

    if(!isset($_SESSION['user'])){
        header("Location:login.php");
        return;
    }
    if(isset($_GET['flight_id']) && isset($_GET['seat_number']) && $_GET['seat_number']!=''){


        $zero=0;
        $one=1;
        $track_id=uniqid('TRACK_');
        $date1=date("l jS \of F Y h:i:s A");
        $conn="";
        require "pdo.php";
        $sql="INSERT INTO flight_seats (track_id,flight_id,seat_no,hold,booking_user_id,background_verification,payment_status,data_created,date_updated,confirmed) VALUES (:track_id,:flight_id,:seat_no,:hold,:booking_user_id,:background_verification,:payment_status,:data_created,:date_updated,:confirmed)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':track_id', $track_id);
        $stmt->bindParam(':flight_id', $_GET['flight_id']);
        $stmt->bindParam(':seat_no', $_GET['seat_number']);
        $stmt->bindParam(':hold', $zero);
        $stmt->bindParam(':booking_user_id', $_SESSION['user']);
        $stmt->bindParam(':background_verification', $one);
        $stmt->bindParam(':payment_status', $one);
        $stmt->bindParam(':data_created', $date1);
        $stmt->bindParam(':date_updated',$date1);
        $stmt->bindParam(':confirmed', $zero);

        $stmt->execute();
        
        $_SESSION["success"]="Seat Booked successfully Track No: ".$track_id;

        header("Location:bookflight.php");
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seat</title>

     <link rel="stylesheet" href="seats.css"> 

</head>
<body>
    <div class="container center">

    <table >

        <?php
			if(isset($_SESSION["error"])){
				echo "<p style='color:red'>".$_SESSION["error"]."</p>";
			}
			else if(isset($_SESSION["success"])){
				echo "<p style='color:green'>".$_SESSION["success"]."</p>";
			}
		?>
        <form method="get" action="seatselect.php">
    
        <?php

            $conn="";
            require "pdo.php";
            $stmt = $conn->prepare("SELECT * FROM flight_seats WHERE flight_id=? ORDER BY seat_no");
            $stmt->execute([$_GET['flight_id']]); 
            $user = $stmt->fetchAll();
            // print_r($user);
            $seat_array=array();
            // print_r(count($user));
            foreach($user as $x ) {
                array_push($seat_array,$x["seat_no"]);
            }
            // print_r($seat_array);

            
            echo "<table id='first'>";
            echo "<tr>";
            for( $i=1; $i<=100; $i++ )
            {
                if(in_array($i, $seat_array)){
                    echo "<td class='tablecolumndisable'>".$i."</td>";
                }
                else{
                    if($i%10==0){
                        echo "</tr>";
                        echo "<tr>";
                    }
                    else{
                        echo "<td class='tablecolumnborder'>".$i."</td>";
                    }
                }
            }
            echo "</tr></table>";

            echo "<input type='hidden' name='flight_id' value='".$_GET['flight_id']."' />"; // Just for references for flight_id from GET
            echo "<input name='seat_number' id='seat_number' style='color: green;align-items: center;display:none'/>";
        ?>
        <br>
        <br>
        
                
        <button>Book Seat</button>
           
        </form>

    </div>

    <script>
        "use strict";
        var $ =(id)=> document.getElementById(id);

        function sleep(milliseconds) {  
            return new Promise(resolve => setTimeout(resolve, milliseconds));  
        }  

        function highlight(element ){
            
            var x = document.querySelectorAll(".tablecolumnborder");  
            for (var i = 0; i <x.length ;i++) {
                if(x[i].className.indexOf("highlight")!=-1){
                    x[i].classList.toggle("highlight");
                }
            }
            
            if (element.id!="first" ){
                console.log(element);
                element.classList.toggle("highlight");
            }

            var y= $("seat_number");
            y.style.color= "blue";
            y.value=element.innerHTML;
            y.innerHTML= element.innerHTML;

        }

        document.addEventListener("DOMContentLoaded", ()=>{ 
            $("first").addEventListener("click",event=>{
                highlight(event.target);
            });
        });

        window.onload=function(){   }

    </script>
</body>
</html>