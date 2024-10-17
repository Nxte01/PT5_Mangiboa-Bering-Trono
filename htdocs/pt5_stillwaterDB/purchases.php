<?php
include("nav.php");
include("database.php");

$sql = "SELECT * FROM purchases ORDER BY p_date DESC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . mysqli_error($conn);
}
?>
</head>
<title>Purchase Record</title>

<body>
    <style>
        .td a[href*="update_p.php"] {
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

        .td a[href*="update_p.php"]:hover {
            background-color: #72BF78;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            /* Pink hover effect to match table details */
        }

        .td a[href*="purchases.php?action=delete"] {
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

        .td a[href*="purchases.php?action=delete"]:hover {
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

        .condition-excellent {
            color: gold;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
        }

        .condition-good {
            color: greenyellow;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
        }

        .condition-fair {
            color: orange;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
        }

        .condition-bad {
            color: red;
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
        }

        .container td:first-child {
            color: #FB667A;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
    <br>
    <br>
    <h1><span class="blue"></span>Stillwater<span class="blue"></span> <span class="yellow">Antique</span> Database</h1>
    <table class="container">
        <tbody>
            <tr>
                <th colspan="5">Stillwater Antique Purchases Record</th>
                <th></th>
                <th class="th">
                    <a href="insert_p.php">Add Record</a>
                </th>
            </tr>
            <tr align="center">
                <th>Date Purchased</th>
                <th>Condition of the Item</th>
                <th>Purchase Cost</th>
                <th>Purchase ID</th>
                <th>Item Number</th>
                <th>Client Number</th>
                <th>Action</th>
            </tr>
        <tbody align="center">
            <?php
            date_default_timezone_set("Asia/Manila");
            while ($result = mysqli_fetch_assoc($query)) {
                $formatCost = number_format($result['p_cost']);
                $datePurchased = !empty($result['p_date']) ? date("F j, Y -- g:i:s a", strtotime($result['p_date'])) : 'N/A';

                $conditionClass = '';
                switch (strtolower($result['condition_at_purchase'])) {
                    case 'excellent':
                        $conditionClass = 'condition-excellent';
                        break;
                    case 'good':
                        $conditionClass = 'condition-good';
                        break;
                    case 'fair':
                        $conditionClass = 'condition-fair';
                        break;
                    case 'bad':
                        $conditionClass = 'condition-bad';
                        break;
                }
            ?>
                <tr>
                    <td><?php echo $datePurchased; ?></td>
                    <td class="<?php echo $conditionClass; ?>"><?php echo $result['condition_at_purchase']; ?></td>
                    <td><span style="color: green;">₱ </span><?php echo $formatCost; ?></td>
                    <td><?php echo $result['purchase_id']; ?></td>
                    <td><?php echo $result['item_num']; ?></td>
                    <td><?php echo $result['ClientNumber']; ?></td>
                    <td class="td" width="20%">
                        <a href='purchases.php?action=delete&purchase_id=<?php echo $result["purchase_id"]; ?>' onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    if (isset($_GET['action']) && isset($_GET['purchase_id'])) {
        $action = $_GET['action'];
        $purchase_id = $_GET['purchase_id'];

        if ($action == 'delete') {
            $sql = "DELETE FROM purchases WHERE purchase_id = '$purchase_id'";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Purchase Record has been deleted successfully.'); window.location='purchases.php';</script>";
            } else {
                echo "<script>alert('Failed to delete the Purchase Record.'); window.location='purchases.php';</script>";
            }
        }
    }
    ?>
</body>

</html>