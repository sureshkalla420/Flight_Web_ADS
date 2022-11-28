<?php
    session_start();

    $conn="";
    require "pdo.php";
        
    if (isset($_POST['signup_name']) && isset($_POST['signup_email']) && isset($_POST["signup_pass"])){ // check if all values are present for signup

        $name = $_POST['signup_name'];
        $email = $_POST['signup_email'];
        $pass = $_POST["signup_pass"];


        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]); 
        $user = $stmt->fetch();
        if(isset($user["email"] )){
          // set error message to user already exists
          session_unset();
          $_SESSION["error"] = "User already exists";
          header("Location:index.php");
          return;
        }
        else{
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $sql="INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash);
            $stmt->execute();
            session_unset();
            $_SESSION["success"] = "User successfully created";
            header("Location:login.php");
            return;
            // set success message with session variable and redirect
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
			}
			else if(isset($_SESSION["success"])){
				echo "<p style='color:green'>".$_SESSION["success"]."</p>";
			}
		?>
	</div>
    <div>
		<form action="signup.php" method="post">
			<h1>Create Account</h1>
			<input name="signup_name" type="text" placeholder="Name" oninvalid="this.setCustomValidity('Enter Your Name Here')" oninput="this.setCustomValidity('')" required/>
			<input name="signup_email" type="email" placeholder="Email" oninvalid="this.setCustomValidity('Provide Mail Id')" oninput="this.setCustomValidity('')" required/>
			<input name="signup_pass" type="password" placeholder="Password" oninvalid="this.setCustomValidity('Create Password')" oninput="this.setCustomValidity('')" required/>
			<button>Sign Up</button>
		</form>

        <a href="login.php">Login</a>
	</div>

</div>
</body>
</html>
