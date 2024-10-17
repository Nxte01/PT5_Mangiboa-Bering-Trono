<?php
include("database.php");

if (isset($_POST['submit'])) {
    $clientNumber = trim($_POST['ClientNumber']);
    $givenName = trim($_POST['givenName']);
    $lastName = trim($_POST['lastName']);
    $ClientAddress = trim($_POST['ClientAddress']);

    // Check if the client already exists
    $sql = "SELECT * FROM allclients WHERE givenName = '$givenName' AND lastName = '$lastName'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $clientData = mysqli_fetch_assoc($query);
        $clientNumber = $clientData['ClientNumber'];
    } else {
        // Insert a new client
        $sql = "INSERT INTO allclients (givenName, lastName, ClientAddress) 
                VALUES ('$givenName', '$lastName', '$ClientAddress')";
        if (mysqli_query($conn, $sql)) {
            $clientNumber = mysqli_insert_id($conn);
        } else {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
    }

    // Item information
    $asking_price = $_POST['asking_price'];
    $item_type = $_POST['item_type'];
    $description = $_POST['description'];
    $critiqued_comments = $_POST['critiqued_comments'];
    $condition_at_purchase = $_POST['condition_at_purchase'];

    // Insert the item
    $insertItemSql = "INSERT INTO items (asking_price, item_type, description, critiqued_comments, `condition`) 
                      VALUES ('$asking_price', '$item_type', '$description', '$critiqued_comments', '$condition_at_purchase')";
    if (mysqli_query($conn, $insertItemSql)) {
        $itemNumber = mysqli_insert_id($conn);

        // Purchase information
        $p_date = $_POST['p_date'];
        $p_cost = $_POST['p_cost'];

        // Insert the purchase record
        $insertPurchaseSql = "INSERT INTO purchases (p_date, p_cost, condition_at_purchase, ClientNumber, item_num) 
                              VALUES ('$p_date', '$p_cost', '$condition_at_purchase', '$clientNumber', '$itemNumber')";
        if (mysqli_query($conn, $insertPurchaseSql)) {
            echo "<script>alert('Client, Purchase, and Item have been added successfully.'); window.location='purchases.php';</script>";
        } else {
            echo "<script>alert('Failed to add Purchase: " . mysqli_error($conn) . "'); window.location='purchases.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to add Item: " . mysqli_error($conn) . "'); window.location='purchases.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Purchase Record</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #1F2739;
            color: #A7A1AE;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        h1 {
            font-size: 2em;
            font-weight: bold;
            /* Bold the header */
            text-align: center;
            color: #4DC3FA;
            /* Light red for the form heading */
            margin-bottom: 20px;
            margin-top: 0;
        }

        form {
            width: 50%;
            padding: 20px;
            background-color: #323C50;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #A7A1AE;
        }

        input[type="text"],
        input[type="number"],
        input[type="datetime-local"],
        input[type="submit"],
        select[id="ClientNumber"],
        select[id="condition_at_purchase"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #4DC3FA;
            /* Blue border */
            border-radius: 5px;
            background-color: #2C3446;
            /* Dark input background */
            color: #FFF;
            /* White text */
            box-sizing: border-box;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        input[type="text"],
        input[type="number"],
        select {
            background-color: #2C3446;
            /* Dark input background */
            color: #FFF;
            /* White text in input fields */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        input[type="submit"] {
            background-color: #FFF842;
            color: #403E10;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        input[type="submit"]:hover {
            background-color: #FB667A;
            color: #FFF;
        }

        a[href*="purchases.php"] {
            display: inline-block;
            padding: 5px 20px;
            margin: 0 10px;
            background-color: #185875;
            /* Blue accent to match table headings */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        a[href*="purchases.php"]:hover {
            background-color: #FB667A;
            cursor: pointer;
            transition: background-color 0.1s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            /* Pink hover effect to match table details */
        }
    </style>
</head>

<body>
    <br><br>
    <h1>&lt;Record a Purchase from <span style="color: yellow">Existing Client</span>&gt;</h2>
        <br>
        <form action="" method="POST">
            <a href="purchases.php">Back</a>
            <br>
            <h2>Client Information</h2>
            <label for="ClientNumber">Select Existing Client/s:</label>
            <select id="ClientNumber" name="ClientNumber" required>
                <option value="" align="center">-- PLEASE SELECT A CLIENT --</option>
                <?php
                $client_sql = "SELECT ClientNumber, givenName, lastName FROM allclients";
                $client_query = mysqli_query($conn, $client_sql);
                while ($row = mysqli_fetch_assoc($client_query)) {
                    echo "<option value='" . $row['ClientNumber'] . "'>" . $row['givenName'] . " " . $row['lastName'] . "</option>";
                }
                ?>
            </select>
            <!--
            <div id="new_client_fields">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>

                <label for="givenName">Given Name:</label>
                <input type="text" id="givenName" name="givenName" required>

                <label for="ClientAddress">Address:</label>
                <input type="text" id="ClientAddress" name="ClientAddress" required>
                </div>
                -->
            <hr>
            <!-- Form -->
            <h2>Purchase Information</h2>
            <label for="p_cost">Purchase Cost:</label>
            <input type="number" name="p_cost" required>

            <label for="condition_at_purchase">Condition:</label>
            <select name="condition_at_purchase" id="condition_at_purchase">
                <option value="" align="center">-- SELECT ITEM'S CONDITION --</option>
                <option value="Excellent" align="center" style="color: Gold;">Excellent</option>
                <option value="Good" align="center" style="color: greenyellow;">Good</option>
                <option value="Fair" align="center" style="color: Orange;">Fair</option>
                <option value="Bad" align="center" style="color: red;">Bad</option>
            </select>

            <label for="p_date">Date Purchased:</label>
            <input type="datetime-local" name="p_date" required>

            <hr>

            <h2>Item Information</h2>
            <label for="asking_price">Asking Price:</label>
            <input type="number" name="asking_price" required>

            <label for="item_type">Item Type:</label>
            <input type="text" name="item_type" required>

            <label for="description">Description:</label>
            <input type="text" name="description" required>

            <label for="critiqued_comments">Critiqued Comments:</label>
            <input type="text" name="critiqued_comments" required>

            <input type="submit" name="submit" value="Add Record">
        </form>
</body>

</html>