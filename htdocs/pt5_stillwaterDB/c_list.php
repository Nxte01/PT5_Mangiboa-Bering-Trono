<?php
include("nav.php");
include("database.php");

$sql = "SELECT * FROM allclients ORDER BY lastName ASC";
$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
</head>
<link rel="stylesheet" href="css/style.css">
<style>
    .td a[href*="update_c.php"] {
        display: inline-block;
        padding: 10px 20px;
        margin: 0 10px;
        background-color: #185875;
        /* Blue accent to match table headings */
        color: white;
        text-decoration: none;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .td a[href*="update_c.php"]:hover {
        background-color: #72BF78;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Pink hover effect to match table details */
    }

    .td a[href*="c_list.php?action=delete"] {
        display: inline-block;
        padding: 10px 20px;
        margin: 0 10px;
        background-color: #185875;
        /* Blue accent to match table headings */
        color: white;
        text-decoration: none;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .td a[href*="c_list.php?action=delete"]:hover {
        background-color: #FB667A;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Pink hover effect to match table details */
    }

    .td a:hover {
        background-color: #FB667A;
        /* Pink hover effect to match table details */
    }

    .container {
        text-align: left;
        width: 70%;
        margin: 0 auto;
        display: table;
        padding: 0 0 8em 0;
    }
</style>

<body>
    <br><br><br>
    <h1><span class="blue"></span>Stillwater<span class="blue"></span> <span class="yellow">Antique</span> Database</h1>
    <form action="c_list.php" method="POST">
        <table class="container" border="0">
            <thead>
                <tr>
                    <th colspan="3">Stillwater Clients List</th>
                    <th class="th">
                        <a href="insert_c.php">Insert Client</a>
                    </th>
                </tr>
                <tr>
                    <th align="center">Given Name</th>
                    <th align="center">Address</th>
                    <th align="center">Client Number</th>
                    <th align="center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($result = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td align="left" width="25%"><span style="color: yellow;"><?php echo htmlspecialchars($result['lastName']); ?></span>, 
                        <?php echo htmlspecialchars($result['givenName']); ?></td>
                        <td align="center" width="40%"><?php echo $result['ClientAddress']; ?></td>
                        <td align="center"><span style="color: #FB667A;"><?php echo $result['ClientNumber']; ?></td>
                        <td align="center" class="td">
                            <a href='update_c.php?action=edit&ClientNumber=<?php echo $result["ClientNumber"]; ?>'>Edit</a>
                            <a href='c_list.php?action=delete&ClientNumber=<?php echo $result["ClientNumber"]; ?>' onclick="return confirm('Are you sure you want to delete this client?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>

    <?php
    if (isset($_GET['action']) && isset($_GET['ClientNumber'])) {
        $action = $_GET['action'];
        $clientNumber = $_GET['ClientNumber'];

        if ($action == 'delete') {
            $sql = "DELETE FROM allclients WHERE ClientNumber = '$clientNumber'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Client has been deleted successfully.'); window.location='c_list.php';</script>";
            } else {
                echo "<script>alert('Failed to delete client.'); window.location='c_list.php';</script>";
            }
        }
    }
    ?>
</body>

</html>