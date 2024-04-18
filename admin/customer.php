<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Records</title>
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
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .btn {
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .filter-btns {
            margin-bottom: 20px;
        }
        .form-control {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            width: 200px;
        }
        .btn-edit {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Customers Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                include 'connect.php';
                // Fetching and displaying results
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["Username"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>"; 
                    echo "<td>" . $row["Phone"]  . "</td>";
                    echo "<td>";
                    echo '<a href="edit.php?editid='. $row["ID"].'" class="btn btn-edit">Edit</a>';
                    echo '<a href="delete-customer.php?deleteid=' . $row["ID"] . '" class="btn btn-danger">Delete</a>';;
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
