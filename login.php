
<?php

    session_start();

    if(isset($_SESSION['user'])){
      header('Location:bookflight.php');
      return;
    }
    $conn="";
    require "pdo.php";
        

	//// Sign in code ///////////////////////////////////////////////////////////////////////////
	if(isset($_POST['signin_email']) && isset($_POST["signin_pass"]) && $_POST["signin_email"]!="" && $_POST["signin_pass"]!=""){

		$email = $_POST['signin_email'];
    $pass = $_POST["signin_pass"];

    

		$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]); 
        $user = $stmt->fetch();
        if(isset($user["email"] )){
          $verify = password_verify($pass, $user["password"]);
          echo $user["password"]." ".$verify;
          if ($verify) {
            session_unset();
            $_SESSION["success"] = "Login successfull";
            $_SESSION["user"] = $user["email"];
            header("Location:bookflight.php");
            return;
          } 
          else {
            session_unset();
            $_SESSION["error"] = "Password Incorrect";
            header("Location:login.php");
            return;
          }
        }
        else{
            session_unset();
            $_SESSION["error"] = "User Not Found";
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
    <!-- <link rel="stylesheet" href="style2.css"> -->
</head>
<body>
	<div>
	<div>
		<?php
			if(isset($_SESSION["error"])){
				echo "<p style='color:red'>".$_SESSION["error"]."</p>";
        $_SESSION["error"]="";
			}
			else if(isset($_SESSION["success"])){
				echo "<p style='color:green'>".$_SESSION["success"]."</p>";
        $_SESSION["success"]="";
			}
		?>
	</div>
    
	<div >
		<form action="login.php" method="post">
			<h1>Sign in</h1>
			<input name="signin_email" type="email" placeholder="Email" oninvalid="this.setCustomValidity('Provide Mail Id')" oninput="this.setCustomValidity('')" required/>
			<input name="signin_pass" type="password" oninvalid="this.setCustomValidity('Create Password')" oninput="this.setCustomValidity('')" required/>
			<button>Sign In</button>
		</form>
    <a href="signup.php">Signup</a>
	</div>
</div>
</body>
</html>