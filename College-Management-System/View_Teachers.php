<?php
include("conection/connect.php");

$msg = "";
$opr = isset($_GET['opr']) ? $_GET['opr'] : "";
$id = isset($_GET['rs_id']) ? $_GET['rs_id'] : "";

if ($opr == "del" && !empty($id)) {
    $stmt = $conn->prepare("DELETE FROM teacher WHERE TeacherId = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // $msg = "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;'>"
        //     . "<span class='p_font'>1 Record Deleted... !</span></div>";
        echo "<script>alert('Deleted Successfully')</script>";
    } else {
        // $msg = "Could not Delete: " . $stmt->error;
        echo "<script>alert('Could not delete:',$stmt->error)</script>";
    // } else {
        // $msg = "Could not Delete: " . $stmt->error;
    }
    $stmt->close();
}

echo $msg;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style_view.css" />
    <link rel="stylesheet" type="text/css" href="somecss.css" />
    <style>
        @media screen and (max-width: 1280px) {

.btn_pos {
 margin-top: 30px;
 display: flex;
 align-items: center;
 /* justify-content: center; */
 flex-wrap: wrap; /* Ensures elements wrap within the container */
 width: 100%;
 max-width: 100%; /* Prevents overflow */
 overflow: hidden; /* Hides any overflow */
}


.input_box_pos {
    width: 50% !important;
    /* min-width: 200px;  */
    margin-right:20px !important;
}

/* Ensuring the search input takes full width within its container */
.input_box_pos input {
    width: 100% !important;
}

.btn_pos_search {
    display: flex;
    gap: 8px; /* Adds spacing between buttons */
}

.btn_pos_search input {
    width: auto !important; 
    min-width: 100px; 
    padding: 6px 10px; /* Reduce padding for smaller screens */
    font-size: 15px;
}

.table_margin {
    /* width: 100%;
    overflow-x: auto !important; */
   
    width: 95%;
    max-width: 100%;
    overflow-x: auto !important;
    display: block;
    white-space: nowrap; /* Prevents text wrapping */
}

table {
    min-width: 800px; 
    width: auto;
    font-size: 14px;
}
}
@media screen and (max-width: 900px) {



.btn_pos_search input {
width: auto !important; 
min-width: 100px; 
padding: 6px 10px; /* Reduce padding for smaller screens */
font-size: 14px;
}

.table_margin {
/* width: 100%;
overflow-x: auto !important; */

width: 95% !important;
max-width: 100%;
overflow-x: auto !important;
display: block;
white-space: nowrap; /* Prevents text wrapping */
}

table {
min-width: 800px; 
width: auto;
font-size: 14px;
}
}



@media screen and (max-width: 768px) {
.btn_pos {
    /* margin-top: 20px;
    flex-direction: column;
    align-items: center; */
    margin-top:100px !important;
    margin-left:10px;
} 
.input_box_pos {
    width: 100%;
    font-size: 14px;
}
.btn_pos_search input {
    width: 100%;
    font-size: 14px;
    padding: 6px 10px;
}
.table_margin {
    margin:0 auto;
    width:95% !important;
    overflow-x: scroll;
}
table {
    font-size: 12px !important;
}
th, td {
    padding: 5px;
}
}


@media screen and (max-width: 480px) {
.hamburger{
    font-size:20px !important;
}
.btn_pos {
    margin-top: 10px;
  
}
.input_box_pos {
    margin-right:8px !important;
    font-size: 12px !important;
    width:50% !important;
    padding:5px;
}
.btn_pos_search{
    gap:5px;
}
.btn_pos_search input {
    font-size: 12px;
    padding: 8px 5px!important;
}
.table_margin {
    width: 95% !important;
    max-width:95%;
    overflow-x: auto;
    margin:0 auto!important;
}
table {
    font-size: 10px;
}
th, td {
    padding: 3px;
}
th {
    font-size: 11px;
}
td {
    font-size: 10px;
}
}
@media screen and (max-width: 410px) {
.btn_pos {
    margin-top: 10px;
    display: flex;
    flex-direction: column; /* Stack items vertically */
    align-items: center;
    width: 100%;
}

.input_box_pos {
    width: 90% !important; /* Ensures full width while leaving some padding */
    max-width: 280px; /* Prevents it from being too wide */
    font-size: 12px !important;
    padding: 6px;
    margin-bottom: 5px; /* Adds spacing from the buttons */
}

.btn_pos_search {
    display: flex;
    flex-direction: column; /* Stack buttons vertically */
    align-items: center;
    gap: 5px; /* Adds spacing between buttons */
    width: 100%;
}

.btn_pos_search input {
    font-size: 12px;
    padding: 8px 5px !important;
    width: 80%; /* Ensures buttons are not too wide */
    max-width: 200px;
    text-align: center;
}
}

    </style>
</head>
<body>
   
    <div class="btn_pos" style="margin-top:50px;flex:1;">
    <form method="post">
        <input type="text" name="searchtxt" class="input_box_pos form-control" style="padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Search name.." />
        <div class="btn_pos_search">
            <input type="submit" class="" style="padding:8px 14px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" name="btnsearch" value="Search"/>&nbsp;
            <a href="?tag=teachers_entry"><input type="button" class="" style="padding:8px 14px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" value="Register new" name="butAdd"/></a>
        </div>
    </form>
</div><br><br>
<!-- <a href="?tag=student_entry"> -->

<div class="table_margin_teacher" style="width:98%;overflow-x:auto;border:2px solid #662d91">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Teacher Name</th>
                    <th>Gender</th>
                    <th>Password</th>
                    <th>Address</th>
                    <th>Qualification</th>
                    <th>Salary</th>
                    <th>Married</th>
                    <th>Phone</th>
                    <th>E-mail</th>
                    <th colspan="2">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $key = isset($_POST['searchtxt']) ? $_POST['searchtxt'] : "";
                
                $sql = "SELECT * FROM teacher";
                if (!empty($key)) {
                    $sql .= " WHERE TName LIKE ?";
                    $stmt = $conn->prepare($sql);
                    $searchKey = "%$key%";
                    $stmt->bind_param("s", $searchKey);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $result = $conn->query($sql);
                }
                
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['TName']); ?></td>
                        <td><?php echo htmlspecialchars($row['TGender']); ?></td>
                        <td><?php echo htmlspecialchars($row['TPass']); ?></td>
                        <td><?php echo htmlspecialchars($row['TAddress']); ?></td>
                        <td><?php echo htmlspecialchars($row['TQualification']); ?></td>
                        <td><?php echo htmlspecialchars($row['TSalary']); ?></td>
                        <td><?php echo htmlspecialchars($row['TMarried']); ?></td>
                        <td><?php echo htmlspecialchars($row['TPhone']); ?></td>
                        <td><?php echo htmlspecialchars($row['TEmail']); ?></td>
                        
                        <td><a href="?tag=teachers_entry&opr=upd&rs_id=<?php echo $row['TeacherId']; ?>" title="Update">
                                <img src="picture/update.png" height="20" alt="Update" />
                            </a></td>
                        <td><a href="?tag=view_teachers&opr=del&rs_id=<?php echo $row['TeacherId']; ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                                <img src="picture/delete.jpg" height="20" alt="Delete" />
                            </a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>


<!--
<td><a href="?tag=teachers_entry"><input type="button" title="Add new Teachers" name="butAdd" value="Add New" id="button-search" /></a></td>
        <td><input type="text" name="searchtxt" title="Enter name for search " class="search" autocomplete="off"/></td>
        <td style="float:right"><input type="submit" name="btnsearch" value="Search" id="button-search" title="Search Teacher" /></td>

-->