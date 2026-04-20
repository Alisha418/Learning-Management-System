<?php
$msg = "";
$opr = "";
if (isset($_GET['opr'])) {
    $opr = $_GET['opr'];
}

if (isset($_GET['rs_id'])) {
    $id = intval($_GET['rs_id']); // Convert to integer to prevent SQL injection
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style_view.css" />
<link rel="stylesheet" type="text/css" href="somecss.css" />
</head>
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
<body>

<div class="btn_pos" style="margin-top:50px;flex:1;display:flex;flex-wrap:wrap;align-items:center;width:100%;max-width:100%;overflow:hidden;">
    <form method="post">
        <input type="text" name="searchtxt" class="input_box_pos form-control" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Search name.." />
        <div class="btn_pos_search">
            <input type="submit" class="" style="border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" name="btnsearch" value="Search"/>&nbsp;
            <a href="?tag=artical_entry"><input type="button" class="" style="border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" value="Register new" name="butAdd"/></a>
        </div>
    </form>
</div><br><br>

<div class="table_margin" style="width:98%;overflow-x:auto;border:2px solid #662d91">
<table class="table table-bordered">
        <thead>
            <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Article Title</th>
            <th style="text-align: center;">Content</th>
            <th style="text-align: center;">Image</th>

            <th style="text-align: center;" colspan="2">Operation</th>
            </tr>
           
        </thead>
        <?php
    $key = "";
    if (isset($_POST['searchtxt']))
        $key = $_POST['searchtxt'];

    if ($key != "") {
        $sql_sel = "SELECT * FROM article WHERE ArticleTitle LIKE ?";
        $stmt = $conn->prepare($sql_sel);
        $search_key = "%" . $key . "%";
        $stmt->bind_param("s", $search_key);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql_sel = "SELECT * FROM article";
        $result = $conn->query($sql_sel);
    }

    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $i++;
?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo htmlspecialchars($row['ArticleTitle']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($row['Content'])); ?></td>
            <td>
                <?php if (!empty($row['Image'])): ?>
                    <img src="<?php echo htmlspecialchars($row['Image']); ?>" alt="Article Image" height="60" />
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>
            <td>
                <a href="?tag=Artical_Entry&opr=upd&rs_id=<?php echo $row['ArticleId']; ?>" title="Update">
                    <img src="picture/update.png" height="20" alt="Update" />
                </a>
            </td>
            <td>
                <a href="?tag=article_view&opr=del&rs_id=<?php echo $row['ArticleId']; ?>" title="Delete">
                    <img src="picture/delete.jpg" height="20" alt="Delete" />
                </a>
            </td>
        </tr>
<?php
    }
?>


        
</table>
</div><!--end of content_input -->
</body>
</html>