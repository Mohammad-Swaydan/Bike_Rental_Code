<?php

@include 'config.php';

session_start();

if(isset($_POST['submit']))
{
   # data used to login
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
   $result = mysqli_query($conn, $select);
   # case of successful login
   if(mysqli_num_rows($result) > 0)
   {
      # get email from db to be passed to next pages
      $row = mysqli_fetch_array($result);
      $_SESSION['email'] = $row['email'];
      header('location:main_page.php');
   }
   # case of incorrect email or password
   else
   {
      $error[] = 'Incorrect Email Or Password!';
   }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
		body {
			background-image: url("/Bike_Rental_Code/images/background.jpg");
			background-repeat: no-repeat;
			background-size: cover;
		}
	</style>

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <?php
      if(isset($error))
      {
         foreach($error as $error)
         {
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>

      <input type="email" name="email" required placeholder="Email">
      <input type="password" name="password" required placeholder="Password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't Have An Account? <a href="register_form.php">Register Now</a></p>
      <p>Forget Your Password? <a href="reset_password.php">Reset Your Password</a></p>
   </form>

</div>

</body>
</html>