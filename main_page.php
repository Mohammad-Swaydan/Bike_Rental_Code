<?php

@include 'config.php';

session_start();

// Get the email from the session variable
$email = $_SESSION['email'];
// Use the email as needed
echo "The email is: " . $email;

?>


<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .topnav {
      overflow: hidden;
      background-color: #333;
    }

    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }

    .topnav a.active {
      background-color: #04AA6D;
      color: white;
    }
  </style>
</head>

<body>

  <div class="topnav">
    <a class="active" href="main_page.php">Home</a>
    <a href="add_bike.php">Add Bike</a>
    <a href="my_rented_bikes.php">My Rented Bikes</a>
    <a href="edit_user_info.php">Edit Account</a>
    <a href="logout.php">Logout</a>
  </div>


  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #333;
      color: white;
      padding: 20px;
      text-align: center;
    }

    h1 {
      margin: 0;
    }

    main {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin: 20px;
    }

    .card {
      background-color: #f2f2f2;
      border: 1px solid #ddd;
      box-shadow: 0px 2px 4px #ccc;
      margin: 10px;
      max-width: 300px;
      padding: 10px;
      text-align: center;
      transition: box-shadow 0.3s ease-in-out;
    }

    .card:hover {
      box-shadow: 0px 4px 8px #bbb;
    }

    h2 {
      margin-top: 0;
    }

    img {
      max-width: 100%;
      height: auto;
      margin-bottom: 10px;
      max-height: 200px;
    }
  </style>

  <body>
    <main>
      <?php

      // Retrieve all bikes from database
      $sql = "SELECT * FROM bike_form";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row["id"];
          $color = $row["color"];
          $type = $row["type"];
          $size = $row["size"];
          $nb_wheels = $row["nb_wheels"];
          $quantity = $row["quantity"];
          $price = $row["price"];
          $image_name = $row["image_name"];
          $user_email = $row["user_email"];

          echo "<div class='card'>";
          echo '<img src="images/' . $image_name . '" alt="Image">';
          echo "<h2> $type</h2>";
          echo "<p>Color: $color</p>";
          echo "<p>Size: $size</p>";
          echo "<p>Number of Wheels: $nb_wheels</p>";
          echo "<p>Available Quantity: $quantity</p>";
          echo "<p>Rental Cost: $price</p>";
          echo "<p>Owner: $user_email</p>";
          // Check if the bike was posted by the current user to show/hide edit and delete btns
          if ($email == $user_email) {
            echo "<p><a href='edit_bike.php?id=$id'>Edit</a> | <a href='delete_bike.php?id=$id'>Delete</a></p>";
          }
          else {
            if ($quantity>=1) {
              echo "<p><a href='rent_bike.php?id=$id'>Reserve</a></p>";
            }
          }
          echo "</div>";
        }
      } else {
        echo "<tr><td colspan='6'>No bikes found.</td></tr>";
      }

      mysqli_close($conn);

      ?>
    </main>
  </body>

</body>

</html>