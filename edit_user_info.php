<?php

@include 'config.php';

session_start();

// Get the email from the session variable
$email = $_SESSION['email'];
// Use the email as needed
echo "The email is: " . $email;

# fetch user from db
$select = " SELECT * FROM user_form WHERE email = '$email' ";
$result = mysqli_query($conn, $select);
# case of user exists in db
if(mysqli_num_rows($result) > 0)
{
     # get data from db
     $row = mysqli_fetch_array($result);
}# case of invalid user
else
{
     $error[] = 'Invalid User';
}

if(isset($_POST['submit']))
{
   # prepare data to be updated in db
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $old_pass = md5($_POST['old_password']);
   $pass = md5($_POST['new_password']);
   $cpass = md5($_POST['cpassword']);
   $gender = $_POST['gender'];
   $dob = $_POST['dob'];
   $address = $_POST['address'];
   $phone = $_POST['phone'];

   # fetch user from db
   $select = " SELECT * FROM user_form WHERE email = '$email' ";
   $result = mysqli_query($conn, $select);
   # case of user exists in db
   if(mysqli_num_rows($result) > 0)
   {
        # check if old password match pw in db
        $row = mysqli_fetch_array($result);
        if($row['password'] == $old_pass)
        {
            # check if new password match confirm password
            if($pass != $cpass)
            {
                # case of passwords doesn't match
                $error[] = 'Password Does Not Match!';
            }
            else
            {
                # if passwords match update document to db
                $update = "UPDATE user_form SET name='$name', email='$email', password='$pass', gender='$gender', dob='$dob', address='$address', phone='$phone' WHERE email='$email'";
                if (mysqli_query($conn, $update))
                {
                    echo "Record updated successfully";
                }
                else
                {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }            
        }
        else
        {
            $error[] = 'Incorrect Old Password';
        }
   }
   # case of invalid user
   else
   {
        $error[] = 'Invalid User';
   }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit User</title>

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

<div class="topnav">
  <a class="active" href="#home">Home</a>
  <a href="add_bike.php">Add Bike</a>
  <a href="edit_user_info.php">Edit Account</a>
  <a href="logout.php">Logout</a>
</div>

<div class="form-container">

   <form action="" method="post">
      <h3>Edit Data</h3>
      <?php
      if(isset($error))
      {
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      
      <input type="text" name="name" placeholder="Name" value="<?php echo $row["name"]; ?>">
      <input type="password" name="old_password" required placeholder="Password">
      <input type="password" name="new_password" required placeholder="Password">
      <input type="password" name="cpassword" required placeholder="Confirm Password">
      <input type="date" name="dob" placeholder="Date of Birth" onfocus="this.max=new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split('T')[0]" value="<?php echo $row["dob"]; ?>">
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
      <input type="text" name="address" placeholder="Address" value="<?php echo $row["address"]; ?>">
      <input type="tel" id="phone" name="phone" placeholder="70123456" pattern="[0-9]{8}">
      <input type="submit" name="submit" value="Submit Changes" class="form-btn">
   </form>

</div>

</body>
</html>

