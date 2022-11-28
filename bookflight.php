<?php
session_start();

$_SESSION['error'] ='';


if(!isset($_SESSION['user'])){
    header("Location:login.php");
    return;
}
               
if(isset($_GET['date']) && $_GET["source"]!="0" && $_GET["destination"]!="0"){
    $source=$_GET["source"];
    $destination=$_GET["destination"];
    if($source==$destination){
        $_SESSION['error']=" Source and Destination cannot be same.";
    }
    else{
        echo $_GET["date"]." ".$_GET["destination"]." ".$_GET["source"];

        
        $_SESSION['date']=$_GET["date"];
        $_SESSION['source']=$_GET["source"];
        $_SESSION['destination']=$_GET["destination"];
        
        echo $_SESSION['date']." ".$_SESSION['destination']." ".$_SESSION['source'];
        header("Location:seats.php");
        return;
    }
}
else{
    
    if(isset($_GET["destination"]) && $_GET["destination"]=="0"){
        // session_unset();
        $_SESSION["error"]="Please Select a Destination Airport";
    }
    if(isset($_GET["source"]) && $_GET["source"]=="0"){
        // session_unset();
        $_SESSION["error"]="First Please Select a Source Airport";
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking</title>

     <link rel="stylesheet" href="bookflight.css"> 
     <link rel="stylesheet" href="track.css"> 
</head>
<body>
	<div>
        
        <div style="align-content:right">
            <a  href="logout.php" >Logout</a>
        </div>
        <div class="tab" id="container1">
            <button class="tablinks" id="bookflighttab" onclick="tabSwitch(event, 'bookflight')">BookFlight</button>
            <button class="tablinks" id="tracktickettab" onclick="tabSwitch(event, 'Track')">Track</button>
        </div>

        <div id="bookflight"  style="display: inline" class="tabcontent">
        <div >
                <form action="bookflight.php" method="get">
                    <h1></h1>
                    <div>
                        <?php
                            if(isset($_SESSION["error"])){
                                echo "<p style='color:red'>".$_SESSION["error"]."</p>";
                                $_SESSION["error"]="";
                            }
                            if(isset($_SESSION["success"])){
                                echo "<p style='color:green'>".$_SESSION["success"]."</p>";
                                $_SESSION["success"]="";
                            }
                        ?>
                    </div>
                    <label for="signin_email">Choose date of Journey</label>
                    <input name="date" id="date" type="date" value='<?php echo date('Y-m-d');?>' min='<?php echo date('Y-m-d');?>' required />

                    <p>Source :
                        <select name="source" id="source" >
                            <option value="0" >-- Please Select --</option>
                            <?php
                            $conn="";
                            require "pdo.php";
                            $stmt = $conn->prepare("SELECT * FROM places");
                            $stmt->execute(); 
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='".$row["place"]."'>".$row["place"]."</option>";
                            }
                            ?>
                        </select>
                    </p>
                    <p>Destination :
                        <select name="destination" id="destination" >
                            <option value="0" >-- Please Select --</option>
                            <?php
                            $conn="";
                            require "pdo.php";
                            $stmt = $conn->prepare("SELECT * FROM places");
                            $stmt->execute(); 
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='".$row["place"]."'>".$row["place"]."</option>";
                            }
                            ?>
                        </select>
                    </p>
                    
                    
                    <button>Search Flights</button>
                </form>
            </div>
        </div>

        <div id="Track" class="tabcontent">
        <div class="container">

            <div>
                    <form method="get" action="bookflight.php">
                            <input name="track_id" type="text" required/>
                                <button>Track</button>
                            </form>
                    </div>
            <?php

                    echo "<script>document.getElementsById('tracktickettab').className.replace('', ' active');;</script>";
                    if(isset($_GET['track_id'])){
                    $conn="";
                    require "pdo.php";
                    $stmt = $conn->prepare("SELECT * FROM flight_seats WHERE track_id=?");
                    $stmt->execute([$_GET['track_id']]); 
                    $user = $stmt->fetch();

                    // print_r($user);

                    echo "<div>";
                    echo "<div class='hh-grayBox pt45 pb20'>";
                    echo "<div class='justify-content-between'>";

                    echo "Tracking Number : <h2 style='color:green'>".$user["track_id"]."</h2>";

                    echo "<div class='order-tracking completed'>";
                    echo "<span class='is-complete'></span>";
                    echo "<p>Ticket Booked On<br><span>".$user['data_created']."</span></p>";
                    echo "</div><br><br><br>";
                    
                    if($user["background_verification"]){
                        echo "<div class='order-tracking completed'>";
                        echo "<span class='is-complete'></span>";
                        echo "<p>Background Verification<br><span>".$user["date_updated"]."</span></p>";
                        echo "</div><br><br><br>";
                    }
                    else{
                        echo "<div class='order-tracking'>";
                        echo "<span class='is-complete'></span>";
                        echo "<p>Background Verification<br><span>".$user["date_updated"]."</span></p>";
                        echo "</div><br><br><br>";
                    }
                    
                    if($user['payment_status']){
                        echo "<div class='order-tracking completed'>";
                        echo "<span class='is-complete'></span>";
                        echo "<p>Payment<br><span>".$user["date_updated"]."</span></p>";
                        echo "</div><br><br><br>";
                    }
                    else{
                        echo "<div class='order-tracking'>";
                        echo "<span class='is-complete'></span>";
                        echo "<p>Payment<br><span>".$user["date_updated"]."</span></p>";
                        echo "</div><br><br><br>";
                    }               
                    if($user['confirmed']){
                        echo "<div class='order-tracking completed'>";
                        echo "<span class='is-complete'></span>";
                        echo "<p>Ticket Confimation<br><span></span></p>";
                        echo "</div><br><br><br>";
                    }
                    else{
                        echo "<div class='order-tracking'>";
                        echo "<span class='is-complete'></span>";
                        echo "<p>Ticket Confimation<br><span></span></p>";
                        echo "</div><br><br><br>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    }
            ?>

  </div>
                
        </div>



<script>

window.onload = (event) => {

    // Date set to default today
    const date = new Date();
    let day = date.getDate().padStart(2, '0');
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    let currentDate = `${year}-${month}-${day}`;
    console.log(currentDate); 
    console.log(day);
    document.getElementById("date").defaultValue = currentDate;
    document.getElementById("date").min = currentDate;
};

function onSourceorDestinationChange() {
  var x = document.getElementById("source").value;
  var y= document.getElementById("destination").value;
  var date= document.getElementById("date").value;
  
  if(x!=y && x!=0 && y!=0){
    console.log(x);
    console.log(y);
    console.log(date);

    
    

  }
}


function tabSwitch(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}


</script>
    


	
</div>
</body>
</html>