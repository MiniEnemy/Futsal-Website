<?php
include 'connect.php';
$id = $_GET['editid'];
$sql = "SELECT * FROM `signup` WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['Username'];
$email = $row['Email'];
$phone = $row['Phone'];

if(isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE signup SET Username='$name', Email='$email', Phone='$phone' WHERE ID=$id";
    $result = mysqli_query($conn, $sql);
    if($result) {
        header("Location: customer.php");
        exit(); // Exit to prevent further execution
    } else {
        echo "Error: ". $sql. "<br>". mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
            margin: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Account</h2>
        <form action="customer.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value=<?php echo $name;?>>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"value=<?php echo $email;?> >
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" id="phone" name="phone"value=<?php echo $phone;?> >
            </div>
            <button type="submit" class="btn btn-primary" name="submit">update</button>
        </form>
    </div>
</body>

</html>
