<?php

@include 'config.php';

if(isset($_POST['submit']))
{
   # prepare data to be saved in db
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $gender = $_POST['gender'];
   $dob = $_POST['dob'];

   # check first if the email is used
   $select = " SELECT * FROM user_form WHERE email = '$email' ";
   $result = mysqli_query($conn, $select);
   # case of email already used
   if(mysqli_num_rows($result) > 0)
   {
      $error[] = 'user already exist!';
   }
   # case of email not used before
   else
   {
      # check if passwords match
      if($pass != $cpass)
      {
         # case of passwords doesn't match
         $error[] = 'Password Does Not Match!';
      }
      else
      {
         # if passwords match save document to db
         $insert = "INSERT INTO user_form(name, email, password, gender, dob) VALUES('$name','$email','$pass','$gender', '$dob')";
         mysqli_query($conn, $insert);
         # go to login page
         header('location:login_form.php');
      }
   }

};



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

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
      <h3>register now</h3>
      <?php
      if(isset($error))
      {
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      
      <input type="text" name="name" required placeholder="Name">
      <input type="email" name="email" required placeholder="Email">
      <input type="password" name="password" required placeholder="Password">
      <input type="password" name="cpassword" required placeholder="Confirm Password">
      <input type="date" name="dob" required placeholder="Date of Birth" onfocus="this.max=new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split('T')[0]">
      <div >
         <table>
            <tbody>
               <tr>
                  <td>Gender: </td>
                  <td><input type="radio" name="gender" id="genderMale" value="Male"></td>
                  <td>Male</td>
                  <td><input type="radio" name="gender" id="genderFemale" value="Female"></td>
                  <td>Female</td>
               </tr>
            </tbody>
         </table>
      </div>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login Now</a></p>
   </form>

</div>

</body>
</html>