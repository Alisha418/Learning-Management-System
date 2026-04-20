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
   
   
    // Get Department ID
$sub = mysqli_real_escape_string($conn, $_POST['subject']);
$sec = mysqli_real_escape_string($conn, $_POST['section']);
$tea = mysqli_real_escape_string($conn, $_POST['teacher']);
$sem = mysqli_real_escape_string($conn, $_POST['semester']);
// Query department table
$dep_query = mysqli_query($conn, "SELECT SubId FROM subject WHERE SubName = '$sub'");
$dep_row = mysqli_fetch_assoc($dep_query);
$sub_id = $dep_row['SubId'];

// Query session table
$session_query = mysqli_query($conn, "SELECT SectionId FROM section WHERE SectionName = '$sec'");
$session_row = mysqli_fetch_assoc($session_query);
$section_id = $session_row['SectionId'];

$dep_query = mysqli_query($conn, "SELECT TeacherId FROM teacher WHERE TName = '$tea'");
$dep_row = mysqli_fetch_assoc($dep_query);
$tea_id = $dep_row['TeacherId'];

// Query session table
$session_query = mysqli_query($conn, "SELECT SemId FROM semester WHERE SemName = '$sem'");
$session_row = mysqli_fetch_assoc($session_query);
$semester_id = $session_row['SemId'];
   

    // ✅ Use `mysqli_query` and pass `$conn`
    $sql_ins = mysqli_query($conn, "INSERT INTO subjectoffer
                        (Sub_Id, Section_Id, T_Id, Sem_Id) 
                        VALUES ('$sub_id', '$section_id','$tea_id','$semester_id')");

    if ($sql_ins) {
        // echo "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;'>"
        //     . "<span class='p_font'>"
        //     . "1 Row Inserted Successfully!"
        //     . "</span>"
        //     . "</div>";
		echo "<script>alert('Submitted Successfully')</script>";
    } else {
		
		echo "<script>alert('Insert Error:',mysqli_error($conn))</script>";
        
    }
}

//------------------ Update Data ----------
if (isset($_POST['btn_upd'])) {
   
  
    // Get Department ID
$sub = mysqli_real_escape_string($conn, $_POST['subject']);
$sec = mysqli_real_escape_string($conn, $_POST['section']);
$tea = mysqli_real_escape_string($conn, $_POST['teacher']);
$sem = mysqli_real_escape_string($conn, $_POST['semester']);
// Query department table
$dep_query = mysqli_query($conn, "SELECT SubId FROM subject WHERE SubName = '$sub'");
$dep_row = mysqli_fetch_assoc($dep_query);
$sub_id = $dep_row['SubId'];

// Query session table
$session_query = mysqli_query($conn, "SELECT SectionId FROM section WHERE SectionName = '$sec'");
$session_row = mysqli_fetch_assoc($session_query);
$section_id = $session_row['SectionId'];

$dep_query = mysqli_query($conn, "SELECT TeacherId FROM teacher WHERE TName = '$tea'");
$dep_row = mysqli_fetch_assoc($dep_query);
$tea_id = $dep_row['TeacherId'];

// Query session table
$session_query = mysqli_query($conn, "SELECT SemId FROM semester WHERE SemName = '$sem'");
$session_row = mysqli_fetch_assoc($session_query);
$semester_id = $session_row['SemId'];
   
  

    $sql_update = mysqli_query($conn, "UPDATE subjectoffer SET 
                           
                            Sub_Id='$sub_id',
                            Section_Id='$section_id',
                            T_Id='$tea_id',
                            Sem_Id='$semester_id'
                           
                        WHERE OfferId=$id");

    if ($sql_update) {
        // echo "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;'>"
        //     . "<span class='p_font'>"
        //     . "Record Updated Successfully!"
        //     . "</span>"
        //     . "</div>";
		echo "<script>alert('Submitted Successfully')</script>";
    } else {
		
		echo "<script>alert('Can't Update:',mysqli_error($conn))</script>";
		
        
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
    .p_font{
        font-size:14px !important;
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
    .p_font{
        font-size:14px !important;
    }
}
</style>
</head>

<body>


<?php

if ($opr == "upd") {
    $sql_upd=mysqli_query($conn,"SELECT * FROM subjectoffer WHERE OfferId=$id");
	$rs_upd=mysqli_fetch_array($sql_upd);
?>


     <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Subject Offering Update Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
		 <div class="container" style="width:100%;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll update subject's offering detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
                  <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">    
                   
                            
                  <div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Subject: </span>
    <select name="subject" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $sub_id = $rs_upd['Sub_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT SubName FROM subject WHERE SubId = '$sub_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $sub_name = $dep_row['SubName'];
   ?> 
      <option><?php echo $sub_name;?></option>
        <?php
            $sql_departments = mysqli_query($conn, "SELECT SubName FROM subject");
            while ($row = mysqli_fetch_assoc($sql_departments)) {
                echo "<option value='" . htmlspecialchars($row['SubName']) . "'>" . htmlspecialchars($row['SubName']) . "</option>";
            }
        ?> 
    </select>
</div>
<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Section: </span>
    <select name="section" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $sec_id = $rs_upd['Section_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT SectionName FROM section WHERE SectionId = '$sec_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $section_name = $dep_row['SectionName'];
   ?> 
      <option><?php echo $section_name;?></option>
        <?php
            $sql_departments = mysqli_query($conn, "SELECT SectionName FROM section");
            while ($row = mysqli_fetch_assoc($sql_departments)) {
                echo "<option value='" . htmlspecialchars($row['SectionName']) . "'>" . htmlspecialchars($row['SectionName']) . "</option>";
            }
        ?> 
    </select>
</div>
<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Teacher: </span>
    <select name="teacher" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $tea_id = $rs_upd['T_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT TName FROM teacher WHERE TeacherId = '$tea_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $tea_name = $dep_row['TName'];
   ?> 
      <option><?php echo $tea_name;?></option>
        <?php
            $sql_departments = mysqli_query($conn, "SELECT TName FROM teacher");
            while ($row = mysqli_fetch_assoc($sql_departments)) {
                echo "<option value='" . htmlspecialchars($row['TName']) . "'>" . htmlspecialchars($row['TName']) . "</option>";
            }
        ?> 
    </select>
</div>
<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Semester: </span>
    <select name="semester" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $sem_id = $rs_upd['Sem_Id']; // Already have Dep_Id

    // Fetch DepName based on Dep_Id
    $dep_query = mysqli_query($conn, "SELECT SemName FROM semester WHERE SemId = '$sem_id'");
    $dep_row = mysqli_fetch_assoc($dep_query);
    $sem_name = $dep_row['SemName'];
   ?> 
      <option><?php echo $sem_name;?></option>
        <?php
            $sql_departments = mysqli_query($conn, "SELECT SemName FROM semester");
            while ($row = mysqli_fetch_assoc($sql_departments)) {
                echo "<option value='" . htmlspecialchars($row['SemName']) . "'>" . htmlspecialchars($row['SemName']) . "</option>";
            }
        ?> 
    </select>
</div>
            
            
                            <div style="margin-top:10px;">
                            <input type="submit" name="btn_upd"  class="submit_btn" value="Update" id="updateButton" onClick="Update()" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
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
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Subject Offering Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;overflow-y:auto;">
          <form id="myForm" method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new subject's offering details to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->

            
               
         <div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Subject: </span>
    <select name="subject" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
  
      <option disabled selected>Select Subject</option>
        <?php
            $sql_subjects = mysqli_query($conn, "SELECT SubName FROM subject");
            while ($row = mysqli_fetch_assoc($sql_subjects)) {
                echo "<option value='" . htmlspecialchars($row['SubName']) . "'>" . htmlspecialchars($row['SubName']) . "</option>";
            }
        ?> 
    </select>
</div>
<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Section: </span>
    <select name="section" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
   
      <option disabled selected>Select Section</option>
        <?php
            $sql_sections = mysqli_query($conn, "SELECT SectionName FROM section");
            while ($row = mysqli_fetch_assoc($sql_sections)) {
                echo "<option value='" . htmlspecialchars($row['SectionName']) . "'>" . htmlspecialchars($row['SectionName']) . "</option>";
            }
        ?> 
    </select>
</div>
<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Teacher: </span>
    <select name="teacher" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
   
      <option disabled selected>Select Teacher</option>
        <?php
            $sql_teachers = mysqli_query($conn, "SELECT TName FROM teacher");
            while ($row = mysqli_fetch_assoc($sql_teachers)) {
                echo "<option value='" . htmlspecialchars($row['TName']) . "'>" . htmlspecialchars($row['TName']) . "</option>";
            }
        ?> 
    </select>
</div>
<div class="teacher_degree_pos" style="margin:0;">
    <span class="p_font" style="float:left;margin-top:5px;">Semester: </span>
    <select name="semester" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
   
      <option disabled selected>Select Semester</option>
        <?php
            $sql_semesters = mysqli_query($conn, "SELECT SemName FROM semester");
            while ($row = mysqli_fetch_assoc($sql_semesters)) {
                echo "<option value='" . htmlspecialchars($row['SemName']) . "'>" . htmlspecialchars($row['SemName']) . "</option>";
            }
        ?> 
    </select>
</div>
                <div style="margin-top:10px;">
                  
                	<input type="submit" name="btn_sub"  class="submit_btn" onclick="alert('Submitted Successfully')" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"/>
                    <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                </div>
       
    	<!-- </div> -->
    </form>
   </div>
    <!-- <p id="dname_empty" style="color:red; display:none;">Form submitted successfully!</p> -->
</div><!-- end of style_informatios -->

<?php
}
?>
</body>
<!-- <script type="module" src="file2"></script> -->


</html>