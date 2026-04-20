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
   
    $l_name = $_POST['nametxt'];
    $gender = $_POST['gender'];
    $password = $_POST['passtxt'];
    $addr = $_POST['addrtxt'];
    $phone = $_POST['phonetxt'];
    $mail = $_POST['emailtxt'];
    $section=$_POST['section'];
    try {
        $sql = "INSERT INTO student
        (StuName, password, StuGender, StuAddress, StuPhone, StuEmail, SectionId) 
        VALUES ('$l_name', '$password', '$gender', '$addr', '$phone', '$mail', '$section')";
    
        $conn->query($sql);
    
        echo "<script>alert('Student added successfully');</script>";
    } catch (mysqli_sql_exception $e) {
        $errorMessage = $e->getMessage();
    
        $errorMessageText = '';

if (strpos($errorMessage, 'password') !== false) {
    $errorMessageText .= 'Password already exists! ';
}

if (strpos($errorMessage, 'StuEmail') !== false) {
    $errorMessageText .= 'Email already exists!';
}

if ($errorMessageText !== '') {
    echo "<script>alert('" . addslashes(trim($errorMessageText)) . "');</script>";
} else {
    echo "<script>alert('An error occurred: " . addslashes($errorMessage) . "');</script>";
}

    }
    

  
}

//------------------ Update Data ----------
if (isset($_POST['btn_upd'])) {
   
    $l_name = $_POST['lnametxt'];
    $gender = $_POST['gender'];
    $password = $_POST['passtxt'];
    $addr = $_POST['addrtxt'];
    $phone = $_POST['phonetxt'];
    $mail = $_POST['emailtxt'];
    $section = $_POST['section'];
  
    try {
        $sql = "UPDATE student SET 
                           
                            StuName='$l_name',
                            password='$password',
                            StuGender='$gender',
                            StuAddress='$addr',
                            StuPhone='$phone',
                            StuEmail='$mail',
                            SectionId='$section'
                           
                        WHERE StuId=$id";
    
        $conn->query($sql);
    
        echo "<script>alert('Student added successfully');</script>";
    } catch (mysqli_sql_exception $e) {
        $errorMessage = $e->getMessage();
    
        if (strpos($errorMessage, 'password') !== false) {
            echo "<script>alert('Password already exists!');</script>";
        } elseif (strpos($errorMessage, 'StuEmail') !== false) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
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
	.teacher_name_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_bdayPlace_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_address_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_mobile_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_mail_pos input {
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
	.teacher_name_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_bdayPlace_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_address_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_mobile_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_mail_pos input {
        padding: 7px;
        font-size: 14px;
    }
	.teacher_radio_pos span{
       font-size:18px;
	}
	.teacher_bday_box span{
       font-size:18px;
	}

    .submit_btn, .reset_btn {
        font-size: 14px !important;
        padding: 10px 15px !important;
    }
    .container p{
        font-size:18px;
        margin-bottom:10px !important;
        
    }
	.teacher_bday_box span{
        font-size:18px;
	}
	.teacher_name_pos{
		max-width:350px !important;
		
	}
	.teacher_name_pos input{
		font-size: 14px !important;
        padding: 5px !important;
        max-width:50%;
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
	.teacher_name_pos input {
		font-size: 14px;
        padding: 6px;
    }
	.teacher_bdayPlace_pos input {
        font-size: 14px;
        padding: 6px;
    }
	.teacher_address_pos input {
		font-size: 14px;
        padding: 6px;
    }
	.teacher_mobile_pos input {
        font-size: 14px;
        padding: 6px;
    }
	.teacher_mail_pos input {
        font-size: 14px;
        padding: 6px;
    }
	.teacher_radio_pos span{
       font-size:16px;
	}
	.teacher_bday_box span{
       font-size:16px;
	}
	.container p{
        font-size:16px;
        margin-bottom:10px !important;
        
    }
	.teacher_bday_box span{
        font-size:16px;
	}
	/* .teacher_name_pos{
		max-width:100% !important;
		
	}
	.teacher_name_pos input{
		font-size: 14px !important;
        padding: 5px !important;
        max-width:50%;
	} */
   
}

@media screen and (max-width: 400px) {
    .panel {
       
        padding: 10px !important;
    }
    .panel-heading{
        
    }
    .panel-heading h1 {
        font-size: 16px !important; 
        padding:3px !important;
        
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
	.teacher_name_pos{
		/* width:100%; */
		max-width:250px !important;
	}
	.teacher_name_pos input {
		font-size: 12px !important;
        padding: 5px !important;
        max-width:50% !important;
    }
	.teacher_bdayPlace_pos{
		width:85% !important;
		
	}
	.teacher_bdayPlace_pos input {
		font-size: 12px !important;
        padding: 5px !important;
        width:100%;
    }
	.teacher_address_pos{
		width: 85% !important;
	}
	.teacher_address_pos input {
		font-size: 12px !important;
        padding: 5px !important;
        /* width:100%; */
    }
	.teacher_mobile_pos{
		width:85% !important;
	}
	.teacher_mobile_pos input {
		font-size: 12px !important;
        padding: 5px !important;
        /* width:100%; */
    }
	.teacher_mail_pos{
		width:85% !important;
	}
	.teacher_mail_pos input {
		font-size: 12px !important;
        padding: 5px !important;
        /* width:100%; */
    }
	.teacher_radio_pos span{
       font-size:14px;
	}

	.container p{
        font-size:14px;
      
        
    }
	.teacher_bday_box{
		display:flex;
		flex-direction:column;
	}
	.teacher_bday_box span{
        font-size:14px;
	}
	.teacher_bday_box select{
		padding:5px;
		font-size:12px;
	}
}

</style>
</head>

<body>
<?php

if($opr=="upd")
{
	$sql_upd=mysqli_query($conn,"SELECT * FROM student WHERE StuId=$id");
	$rs_upd=mysqli_fetch_array($sql_upd);
	// list($y,$m,$d)=explode('-',$rs_upd['dob']);
?>

<div class="panel panel-default panel-p" style="background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Student Update Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
		 <div class="container" style="width:100%;">
			<p style="margin:0;padding:0;text-align:center;">Here, you'll update student's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
        <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">    

         <!-- <div class="container_form">
          <form method="post"> -->
				<div class="teacher_address_pos" style="margin:0;">
					
					<input type="text"  pattern="[A-Za-z\s]+" title="Only letters and spaces allowed"
					  minlength="2" maxlength="50" name="lnametxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['StuName'];?>"required />
				</div><br>
				
				<div class="teacher_radio_pos" style="margin:0;">
				    <span class="p_font">Gender: </span>&nbsp;
					<input type="radio" name="gender" value="Male" <?php if($rs_upd['StuGender']=="Male") echo "checked";?> required/> <span class="p_font">&nbsp;Male</span>
					<input type="radio" name="gender" value="Female" <?php if($rs_upd['StuGender']=="Female") echo "checked";?> /> <span class="p_font">&nbsp;Female</span>
				</div><br>
                <div class="teacher_bdayPlace_pos" style="margin:0;">
					<input type="password" name="passtxt"  pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{13}" value='<?php echo $rs_upd['password'];?>'
                      title="Password must be exactly 13 characters long, contain at least one letter and one digit" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Password" required />
				</div><br>
				
				<div class="teacher_address_pos" style="margin:0;">
					<input type="text" name="addrtxt" class="" pattern="^[A-Za-z0-9\s,.-]+$" title="Only letters, numbers, spaces, commas, and dots allowed"
					 minlength="5" maxlength="100" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value='<?php echo $rs_upd['StuAddress'];?>' required/>
				</div><br>
				
				<div class="teacher_mobile_pos" style="margin:0;">
					<input type="tel" pattern="^\+?[0-9]{10,15}$" title="Enter a valid mobile number (10-15 digits, optional + at start)" name="phonetxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['StuPhone'];?>" required />
				</div><br>
				
				<div class="teacher_mail_pos" style="margin:0;">
					<input type="email" minlength="5" maxlength="100" name="emailtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['StuEmail'];?> " required />
				</div><br>
				<div class="teacher_degree_pos" style="margin:0;margin-bottom:20px;">
    <span class="p_font" style="float:left;margin-top:5px;">Section: </span>
    <select name="section" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    <?php
     $sec_id = $rs_upd['SectionId']; // Already have Dep_Id

   
   ?> 
      <option><?php echo $sec_id;?></option>
        <?php
            $sql_sessions = mysqli_query($conn, "SELECT SectionId FROM section");
            while ($row = mysqli_fetch_assoc($sql_sessions)) {
                echo "<option value='" . htmlspecialchars($row['SectionId']) . "'>" . htmlspecialchars($row['SectionId']) . "</option>";
            }
        ?> 
    </select>
</div>

				
				
				<div>
					<input type="submit" name="btn_upd" href="#" class="submit_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" value="Update" />&nbsp;&nbsp;&nbsp;
					<input type="reset"  href="#" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" />
				</div>
                </form>
			<!-- </div> -->
		</div>
	</div><!-- end of style_informatios -->

<?php	
}
else
{
?>


		  <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Student Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
		 <div class="container" style="width:100%;">
			<p style="margin:0;padding:0;text-align:center;">Here, you'll add new student's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
                  <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">    
				<!-- <div class="teacher_name_pos" style="margin:0;">
					<input type="text" name="fnametxt" placeholder="First name"  pattern="[A-Za-z\s]+" title="Only letters and spaces allowed"
					  minlength="2" maxlength="50" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" required />
					<input type="text" name="lnametxt" placeholder="Last name"  pattern="[A-Za-z\s]+" title="Only letters and spaces allowed"
					  minlength="2" maxlength="50" style="width:100%;padding:8px;margin:5px;background:white;color:black;border-radius:5px;border:2px solid #662d91;" required/>
				</div><br> -->
				
				<!-- <div class="teacher_radio_pos" style="margin:0;display:flex;gap:0;align-items:center;">
				    <span class="p_font">Gender: </span>
					<input type="radio" name="gender" value="Male" required/> <span class="p_font">&nbsp;Male</span>
					<input type="radio" name="gender" value="Female" /> <span class="p_font">&nbsp;Female</span>
				</div><br> -->
                <div class="teacher_bdayPlace_pos" style="margin:0;">
                  <input type="text" name="nametxt" placeholder="Name"  pattern="[A-Za-z\s]+" title="Only letters and spaces allowed"
                   minlength="2" maxlength="50" style="width:100%;padding:8px;margin:5px;background:white;color:black;border-radius:5px;border:2px solid #662d91;" required/>
                </div><br>

				<div class="teacher_radio_pos" style="margin:0;display:flex;align-items:center;gap:20px;margin-bottom:20px;">
                    <span class="p_font">Gender: </span>
                    <div style="display:flex;align-items:center; gap:5px;">
                         <input type="radio" name="gender" value="Male" style="margin:0;padding:0;" required/> <span class="p_font">Male</span>
                    </div>
                    <div style="display:flex;align-items:center; gap:5px;">
                        <input type="radio" name="gender" value="Female" style="margin:0;padding:0;" /> <span class="p_font">Female</span>
                     </div>
                </div>
				
				
                <div class="teacher_bdayPlace_pos" style="margin:0;">
					<input type="password" name="passtxt"  pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{13}" 
                      title="Password must be exactly 13 characters long, contain at least one letter and one digit" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Password" required />
				</div><br>
				
				
				<div class="teacher_address_pos" style="margin:0;">
					<input type="text" name="addrtxt" class="" placeholder="Address" pattern="^[A-Za-z0-9\s,.-]+$" title="Only letters, numbers, spaces, commas, and dots allowed"
					  minlength="5" maxlength="100" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" required />
				</div><br>
				
				<div class="teacher_mobile_pos" style="margin:0;">
					<input type="text" name="phonetxt" pattern="^\+?[0-9]{10,15}$" title="Enter a valid mobile number (10-15 digits, optional + at start)" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Mobile no." required />
				</div><br>
				
				<div class="teacher_mail_pos" style="margin:0;">
					<input type="email" minlength="5" maxlength="100" name="emailtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Email address" required />
				</div><br>
				<div class="teacher_degree_pos" style="margin:0;margin-bottom:20px;">
    <span class="p_font" style="float:left;margin-top:5px;">Section: </span>
    <select name="section" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
        <option disabled selected>Select Section</option>
        <?php
            $sql_sessions = mysqli_query($conn, "SELECT SectionId FROM section");
            while ($row = mysqli_fetch_assoc($sql_sessions)) {
                echo "<option value='" . htmlspecialchars($row['SectionId']) . "'>" . htmlspecialchars($row['SectionId']) . "</option>";
            }
        ?> 
    </select>
</div>

				
				<div>
					<input type="submit" name="btn_sub" href="#" class="submit_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  value="Add Now" />&nbsp;&nbsp;&nbsp;
					<input type="reset"  href="#" class="reset_btn" value="Cancel" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" />
				</div>
             </form>
			</div>
		</div>
	</div>
<?php
}
?>
</body>
</html>