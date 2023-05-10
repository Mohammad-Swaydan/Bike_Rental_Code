<?php

@include 'config.php';

session_start();

// Get the email from the session variable
$email = $_SESSION['email'];
// Use the email as needed
echo "The email is: " . $email;

if(isset($_POST['submit']))
{
   # prepare data to be saved in database
   $color = $_POST['color'];
   $type = $_POST['type'];
   $size = $_POST['size'];
   $nb_wheels = $_POST['nb_wheels'];
   $price = $_POST['price'];
   $user_email = $email;
   $available = true;

   // Handle image upload
   $target_dir = "uploads/";
   $target_file = $target_dir . basename($_FILES["image"]["name"]);
   move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

   $insert = "INSERT INTO bike_form(color, type, size, nb_wheels, price, available, image, user_email) VALUES('$color','$type','$size','$nb_wheels', '$price', '$available', '$target_file', '$user_email')";
   mysqli_query($conn, $insert);
   # go to login page
   header('location:main_page.php');

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Bike</title>

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
      <h3>Bike Data</h3>
      <?php
      if(isset($error))
      {
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      
      <!-- Bike Color DropDown Menu -->
      <select id="color-selector" name="color" required>
         <option value="">Select a color</option>
         <option value="Black">Black</option>
         <option value="White">White</option>
         <option value="Red">Red</option>
         <option value="Green">Green</option>
         <option value="Blue">Blue</option>
         <option value="Yellow">Yellow</option>
         <option value="Purple">Purple</option>
         <option value="Orange">Orange</option>
         <option value="Gray">Gray</option>
      </select>
      <!-- Bike Type DropDown Menu -->
      <select id="type-selector" name="type" required>
         <option value="">Select a bike type</option>
         <option value="Road Bike">Road Bike</option>
         <option value="Mountain Bike">Mountain Bike</option>
         <option value="Hybrid Bike">Hybrid Bike</option>
         <option value="Electric Bike">Electric Bike</option>
         <option value="Folding Bike">Folding Bike</option>
         <option value="BMX Bike">BMX Bike</option>
      </select>
      <!-- Bike Size DropDown Menu -->
      <select id="size-selector" name="size" required>
         <option value="">Select a bike size</option>
         <option value="Small">Small</option>
         <option value="Medium">Medium</option>
         <option value="Large">Large</option>
      </select>
      <input type="number" name="nb_wheels" required placeholder="Number of wheels" min="2" max="4">
      <input type="number" name="price" required placeholder="Rental Cost">
      <!-- Bike Image -->
      <label for="image">Bike Image:</label>
		<input type="file" id="image" name="image" accept="image/*" required>
		<br><br>

      <input type="submit" name="submit" value="Add Bike" class="form-btn">
   </form>

</div>

</body>
</html>

