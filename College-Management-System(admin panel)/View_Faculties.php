<?php
$msg = "";
$opr = "";
$id = "";

/include("conection/connect.php");

if (isset($_GET['opr'])) {
    $opr = $_GET['opr'];
}

if (isset($_GET['rs_id'])) {
    $id = $_GET['rs_id'];
}

if ($opr == "del") {
    $stmt = $mysqli->prepare("DELETE FROM facuties_tbl WHERE faculties_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $msg = "1 Record Deleted... !";
    } else {
        $msg = "Could not Delete: " . $mysqli->error;
    }
    $stmt->close();
}

echo $msg;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_view.css" />
</head>
<body>

<div class="btn_pos">
    <form method="post">
        <input type="text" name="searchtxt" class="input_box_pos form-control" placeholder="Search name.." />
        <div class="btn_pos_search">
            <input type="submit" class="btn btn-primary btn-large" name="btnsearch" value="Search"/>&nbsp;&nbsp;
            <a href="?tag=faculties_entry"><input type="button" class="btn btn-large btn-primary" value="Register new" name="butAdd"/></a>
        </div>
    </form>
</div><br><br>

<div class="table_margin">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Faculties Name</th>
                <th style="text-align: center;" width="250px">Note</th>
                <th style="text-align: center;" colspan="2">Operation</th>
            </tr>
        </thead>
        
        <?php
        $key = "";
        if (isset($_POST['searchtxt'])) {
            $key = $_POST['searchtxt'];
        }

        if ($key != "") {
            $stmt = $mysqli->prepare("SELECT * FROM facuties_tbl WHERE faculties_name LIKE ?");
            $searchKey = "%" . $key . "%";
            $stmt->bind_param("s", $searchKey);
        } else {
            $stmt = $mysqli->prepare("SELECT * FROM facuties_tbl");
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($row['faculties_name']); ?></td>
                <td><?php echo htmlspecialchars($row['note']); ?></td>
                <td align="center"><a href="?tag=faculties_entry&opr=upd&rs_id=<?php echo $row['faculties_id']; ?>" title="Update"><img src="picture/update.png" height="20" alt="Update" /></a></td>
                <td align="center"><a href="?tag=view_faculties&opr=del&rs_id=<?php echo $row['faculties_id']; ?>" title="Delete"><img src="picture/delete.jpg" height="20" alt="Delete" /></a></td>
            </tr>
        <?php
        }
        $stmt->close();
        ?>
    </table>
</div>

</body>
</html>

<?php
$mysqli->close();
?>