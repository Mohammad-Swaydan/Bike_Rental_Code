<?php

@include 'config.php';

session_start();

// Get the email from the session variable
$email = $_SESSION['email'];
// Use the email as needed
echo "The email is: " . $email;

// Get Id of reservation to be deleted
$reservationId = $_GET['id'];
echo "You are viewing document with ID: " . $reservationId;

// Get Id of bike
$bikeId = $_GET['bikeId'];
echo "You are viewing document with ID: " . $reservationId;

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

    <script>
        function unrentBike() {
            <?php
            # fetch bike from db to get quantity
            if (isset($_GET['bikeId'])) {
                $bikeId = $_GET['bikeId'];
                $select = " SELECT * FROM bike_form WHERE id = '$bikeId' ";
                $result = mysqli_query($conn, $select);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $quantity = $row["quantity"];
                    $newQuantity = $quantity + 1;
                }
                # case of invalid bike
                else {
                    $error[] = 'Invalid Bike';
                }
            } else {
                echo "No document ID provided.";
            }

            # update bike document
            $update = "UPDATE bike_form SET quantity='$newQuantity' WHERE id='$bikeId'";
            if (mysqli_query($conn, $update)) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }

            # delete reservation from database
            $delete = "DELETE FROM reservation WHERE id='$reservationId'";
            if (mysqli_query($conn, $delete)) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
            ?>
        }
    </script>
    </head>

    <body>
        <h1>Your Reservation Was Deleted Successfully</h1>
        <h1>Redirecting in 3 seconds...</h1>

        <script>
            // Timer in milliseconds (e.g., 5000ms = 5 seconds)
            var timer = 3000;

            // Function to redirect to the desired HTML page
            function redirect() {
                window.location.href = 'my_rented_bikes.php';
            }

            // Set the timer
            setTimeout(redirect, timer);
        </script>
    </body>

</html>