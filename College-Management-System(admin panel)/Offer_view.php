<?php
$msg = "";
$opr = "";
if (isset($_GET['opr']))
    $opr = $_GET['opr'];

if (isset($_GET['rs_id']))
    $id = $_GET['rs_id'];

// Database connection using mysqli
include("conection/connect.php");


if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];
    $del_sql = "DELETE FROM subjectoffer WHERE OfferId = ?";
    $stmt = $conn->prepare($del_sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Deleted Successfully')</script>";
    } else {
        echo "<script>alert('Could not delete')</script>";
    }
    $stmt->close();
}

echo $msg;
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
            <a href="?tag=offer_entry"><input type="button" class="" style="padding:8px 14px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" value="Register new" name="butAdd"/></a>
        </div>
    </form>
</div><br><br>


<div class="table_margin" style="width:98%;overflow-x:auto;border:2px solid #662d91">
 <table class="table table-bordered">
        <thead>
            <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Subject</th>
            <th style="text-align: center;">Section</th>
            <th style="text-align: center;">Teacher</th>
            <th style="text-align: center;">Semester</th>
            

            <th style="text-align: center;" colspan="2">Operation</th>
            </tr>
            
        </thead>
        <?php
    $key = "";
    if (isset($_POST['searchtxt']))
        $key = $_POST['searchtxt'];

    if ($key != "") {
        $sql_sel = "SELECT * FROM subjectoffer WHERE OfferId LIKE ? ";
        $stmt = $conn->prepare($sql_sel);
        $search_key = "%" . $key . "%";
        $stmt->bind_param("s", $search_key);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql_sel = "SELECT * FROM subjectoffer";
        $result = $conn->query($sql_sel);
    }

    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $i++;
    ?>
        <tr>
            <td><?php echo $i; ?></td>
            
            <?php
            $sub_id = $row['Sub_Id']; // Already have Dep_Id

// Fetch DepName based on Dep_Id
$sess_query = mysqli_query($conn, "SELECT SubName FROM subject WHERE SubId = '$sub_id'");
$sess_row = mysqli_fetch_assoc($sess_query);
$sub_name = $sess_row['SubName']; ?>
            <td><?php echo $sub_name; ?></td>
            <?php
     $sec_id = $row['Section_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT SectionName FROM section WHERE SectionId = '$sec_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $sec_name = $dep_row['SectionName'];
   ?> 
            <td><?php echo $sec_name; ?></td>
            <?php
     $tea_id = $row['T_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT TName FROM teacher WHERE TeacherId = '$tea_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $tea_name = $dep_row['TName'];
   ?> 
            <td><?php echo $tea_name; ?></td>
            <?php
     $sem_id = $row['Sem_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT SemName FROM semester WHERE SemId = '$sem_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $sem_name = $dep_row['SemName'];
   ?> 
            <td><?php echo $sem_name; ?></td>

            <td><a href="?tag=offer_entry&opr=upd&rs_id=<?php echo $row['OfferId']; ?>" title="Update"><img style="-webkit-box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);-moz-box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);" src="picture/update.png" height="20" alt="Update" /></a></td>
            <form method="post" style="display:inline;">
    <input type="hidden" name="delete_id" value="<?php echo $row['OfferId']; ?>">
    <td><button type="submit" name="delete_btn" style="border:none;background:none;padding:0;">
        <img src="picture/delete.jpg" height="20" alt="Delete" />
    </button></td>
</form>

            <!-- <td><a href="?tag=section_view&opr=del&rs_id=<?php echo $row['SectionId']; ?>" title="Delete"><img style="-webkit-box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);-moz-box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);box-shadow: 0px 0px 0px 0px rgba(50, 50, 50, 0.75);" src="picture/delete.jpg" height="20" alt="Delete" /></a></td> -->
        </tr>
    <?php
    }
    ?>
        
</table>
</div><!--end of content_input -->

</body>

</html>