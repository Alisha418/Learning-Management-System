<?php
// include "connect.php"; // Ensure connection file is included

$id = "";
$opr = "";
if (isset($_GET['opr']))
    $opr = $_GET['opr'];

if (isset($_GET['rs_id']))
    $id = $_GET['rs_id'];

//-------------- Add Data -----------------    
if (isset($_POST['btn_sub'])) {
   
    $sname = $_POST['sname'];
    $status = $_POST['status'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    
    try {
        $sql = "INSERT INTO session
                        (SessionName, StartDate, EndDate, Status) 
                        VALUES ('$sname', '$start','$end','$status')";
    
        $conn->query($sql);
    
        echo "<script>alert('Session added successfully');</script>";
    } catch (mysqli_sql_exception $e) {
        $errorMessage = $e->getMessage();
    
        if (strpos($errorMessage, 'SessionName') !== false) {
            echo "<script>alert('Session name already exists!');</script>";
        }  else {
            echo "<script>alert('An error occurred: " . addslashes($errorMessage) . "');</script>";
        }
    }
  
}

//------------------ Update Data ----------
if (isset($_POST['btn_upd'])) {
   
    $sname = $_POST['sname'];
    $status = $_POST['status'];
    $start = $_POST['start'];
    $end = $_POST['end'];
  
    try {
        $sql = "UPDATE session SET 
                           
                            SessionName='$sname',
                            StartDate='$start',
                            EndDate='$end',
                            Status='$status'
                           
                        WHERE SessionId=$id";
    
        $conn->query($sql);
    
        echo "<script>alert('Session added successfully');</script>";
    } catch (mysqli_sql_exception $e) {
        $errorMessage = $e->getMessage();
    
        if (strpos($errorMessage, 'SessionName') !== false) {
            echo "<script>alert('Session name already exists!');</script>";
        }  else {
            echo "<script>alert('An error occurred: " . addslashes($errorMessage) . "');</script>";
        }
    }
   
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style_entry.css" />
<link rel="stylesheet" type="text/css" href="somecss.css" />
<style>
    @media screen and (max-width: 1024px) {
    .panel {
        width: 95%;
        max-width:95%;
        margin:0 auto;
        /* height:max-content; */
        padding: 15px;
    }

    form {
        max-width: 450px;
    }

    .teacher_note_pos input {
        padding: 7px;
        font-size: 14px;
    }

    .submit_btn, .reset_btn {
        font-size: 14px;
        padding: 10px 15px;
    }
}

/* 🔹 Small Screens (Phones: < 768px) */
@media screen and (max-width: 768px) {
    .panel {
        width: 100% !important;
        height:max-content;
        margin:auto;
        padding: 15px;
        margin-top:100px !important;
        margin-left:10px !important;
        margin-right:10px !important;
    }

    .panel-heading h1 {
        font-size: 20px;
        
    }
    .panel-heading{
        padding:5px !important;
       
    }

    form {
        max-width: 100%;
    }

    .teacher_note_pos input {
        font-size: 14px !important;
        padding: 7px !important;
    }

    .submit_btn, .reset_btn {
        font-size: 14px !important;
        padding: 10px 15px !important;
    }
    .container p{
        font-size:14px;
        margin-bottom:10px !important;
        
    }
}

/* 🔹 Extra Small Screens (Very Small Phones: < 480px) */
@media screen and (max-width: 480px) {
    .panel {
        width: 95%;
        padding: 10px !important;
    }

    .panel-heading h1 {
        font-size: 18px !important;
    }

    .teacher_note_pos input {
        font-size: 14px;
        padding: 6px;
    }

    .submit_btn, .reset_btn {
        font-size: 12px !important;
        padding: 8px 12px !important;
    }
    .hamburger{
        font-size:20px !important;
        
    }
   
}
@media screen and (max-width: 380px) {
    .panel {
       
        padding: 10px !important;
    }
    .panel-heading{
        /* width:100%; */
    }
    .panel-heading h1 {
        font-size: 16px !important; 
        padding:3px !important;
        /* width:100%; */
    }
    .teacher_note_pos{
        width:85% !important;

    }
    .teacher_note_pos input {
        font-size: 12px !important;
        padding: 5px !important;
        width:100%;
    }

    .submit_btn, .reset_btn {
        font-size: 12px !important;
        padding: 10px !important;
    }
    .container p{
        font-size:14px;
    }
}
</style>
</head>

<body>


<?php

if ($opr == "upd") {
    $sql_upd=mysqli_query($conn,"SELECT * FROM session WHERE SessionId=$id");
	$rs_upd=mysqli_fetch_array($sql_upd);
?>


     <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Session Update Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
		 <div class="container">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll update session's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
                  <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">    
                   
                            <div class="teacher_note_pos" style="margin:0;">
                                <input type="text" class="form-control" name="sname"  id="textbox"  placeholder="Session Name" value='<?php echo $rs_upd['SessionName'];?>' required style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                                <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Session name should not be empty</p>
                                <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Session name should contain at least 4 characters</p>
                            </div>
                            <div class="teacher_note_pos" style="margin:0;">
                              <input type="date" name="start" class="form-control"  id="textbox" placeholder="Start Date" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value='<?php echo $rs_upd['StartDate'];?>' required />
                            </div>
                            <div class="teacher_note_pos" style="margin:0;">
                                <input type="date" name="end"  class="form-control"  id="textbox" placeholder="End Date" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value='<?php echo $rs_upd['EndDate'];?>' required />
                            </div>
            
                            <div class="teacher_note_pos" style="margin:0;">
                                <input type="text" class="form-control" name="status"  id="textbox"  placeholder="Status" value='<?php echo $rs_upd['Status'];?>' required style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                                <p id="dcode_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Status should not be empty</p>
                                <p id="dcode_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Status should be only active or inactive</p>
                            </div><br>
            
                            <div>
                            <input type="submit" name="btn_upd" class="submit_btn" value="Update" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
                            <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                            </div>
                  </form>            
    	</div>
    </form>
</div>
<?php
}
else
{
?>


            <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Session Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
          <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new session's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->

            
                <div class="teacher_note_pos" style="margin:0;">
                	<input type="text" class="form-control" name="sname" id="textbox" placeholder="Session Name" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                    <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Session name should not be empty</p>
                    <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Session name should contain at least 4 characters</p>
                </div>
                <div class="teacher_note_pos" style="margin:0;">
                 <input type="date" name="start" class="form-control"   id="textbox" placeholder="Start Date" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" required/>
                </div>
                <div class="teacher_note_pos" style="margin:0;">
                 <input type="date" name="end" class="form-control"   id="textbox" placeholder="End Date" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" required/>
                </div>
            
                <div class="teacher_note_pos" style="margin:0;">
                	<input type="text" class="form-control" name="status"  id="textbox" placeholder="Status" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"/>
                    <p id="dcode_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Status should not be empty</p>
                    <p id="dcode_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Status should be only active or inactive</p>
                </div><br>
                
            
                <div>
                	<input type="submit" name="btn_sub" class="submit_btn" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
                    <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                </div>
           </form>
    	</div>
    </form>
</div><!-- end of style_informatios -->

<?php
}
?>
</body>
<script>
  

document.addEventListener("DOMContentLoaded", function () {
    let dnameInput = document.querySelector("input[name='dname']");
    let dcodeInput = document.querySelector("input[name='dcode']");
    let submitBtn = document.querySelector(".submit_btn");

    let dnameEmpty = document.querySelector("#dname_empty");
    let dnameSize = document.querySelector("#dname_size");
    // let dnameLetter = document.querySelector("#dname_letter");
    let dcodeEmpty = document.querySelector("#dcode_empty");
    let dcodeLetter = document.querySelector("#dcode_letter");

    // Function to clear error messages when typing
    function clearDnameErrors() {
        dnameEmpty.style.display = "none";
        dnameSize.style.display = "none";
        // dnameLetter.style.display = "none";
    }

    function clearDcodeErrors() {
        dcodeEmpty.style.display = "none";
        dcodeLetter.style.display = "none";
    }

    // Add event listeners for real-time validation
    dnameInput.addEventListener("input", clearDnameErrors);
    dcodeInput.addEventListener("input", clearDcodeErrors);

    submitBtn.addEventListener("click", function (event) {
        let departmentName = dnameInput.value.trim();
        let departmentCode = dcodeInput.value.trim();
        let valid = true; // Track form validity

        // Validation for Department Name
        if (departmentName === "") {
            dnameEmpty.style.display = "block";
            valid = false;
        } else if (departmentName.length < 4) {
            dnameSize.style.display = "block";
            valid = false;
        }
        // else if (!/^[A-Za-z ]+$/.test(departmentName)) {
        //     dnameLetter.style.display = "block";
        //     valid = false;
        // }

        // Validation for Department Code
        if (departmentCode === "") {
            dcodeEmpty.style.display = "block";
            valid = false;
        } else if (departmentCode!=="active" && departmentCode!=="inactive") {
            dcodeLetter.style.display = "block";
            valid = false;
        }

        // Prevent form submission if invalid
        if (valid) {
            alert("Submitted Successfully");
           
        }else{
            event.preventDefault();

        }
    });
});

</script>


</html>