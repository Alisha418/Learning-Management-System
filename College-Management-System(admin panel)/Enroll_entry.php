<?php
// include("db_connect.php"); // Include your database connection file
$id = "";
$opr = "";

if (isset($_GET['opr']))
    $opr = $_GET['opr'];

// if (isset($_GET['rs_id']))
//     $id = $_GET['rs_id'];
$ID = isset($_GET['ID']) ? $_GET['ID'] : "";
$Sname = isset($_GET['Sname']) ? $_GET['Sname'] : "";
$dname = isset($_GET['dname']) ? urldecode($_GET['dname']) : "";
$dcode = isset($_GET['dcode']) ? urldecode($_GET['dcode']) : "";





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
					          <span class="p_font form-p" style="float:left;margin-top:5px;">Subject: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="Department" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option><?php echo htmlspecialchars($dname);?></option>
       						<?php
                                $mm=array("Programming Fundamentals","Computer Networks","Data Science");
                                $i=0;
                                foreach($mm as $mon){
                                    $i++;
										echo"<option value='$mon'> $mon</option>";
                                    //echo"<option value='$i'> $mon</option>";		
                                }
                            ?> 					     					
                        </select>
					<!-- </div> -->
				</div>
                <div class="teacher_degree_pos" style="margin:0;">
					<span class="p_font form-p" style="float:left;margin-top:5px;">Section: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="Session" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option><?php echo htmlspecialchars($dcode); ?></option>
       						<?php
                                $mm=array("A","B","C");
                                $i=0;
                                foreach($mm as $mon){
                                    $i++;
										echo"<option value='$mon'> $mon</option>";
                                    //echo"<option value='$i'> $mon</option>";		
                                }
                            ?> 					     					
                        </select>
					<!-- </div> -->
				</div>
            
            
                            <div style="margin-top:10px;">
                            <input type="submit" class="submit_btn" value="Update" id="updateButton" onClick="Update()" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
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
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Student Enrollment Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
          <form id="myForm" method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new student's enrollment details to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->

            
               
                <div class="teacher_degree_pos" style="margin:0;">
					<span class="p_font" style="float:left;margin-top:5px;">Offered Subject Id: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="degree" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option>1</option>
       						<?php
                                $mm=array("1","2");
                                $i=0;
                                foreach($mm as $mon){
                                    $i++;
										echo"<option value='$mon'> $mon</option>";
                                    //echo"<option value='$i'> $mon</option>";		
                                }
                            ?> 					     					
                        </select>
					<!-- </div> -->
				</div>
                <div class="teacher_degree_pos" style="margin:0;">
					<span class="p_font" style="float:left;margin-top:5px;">Student: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="degree" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option>Ali</option>
       						<?php
                                $mm=array("John","Kiran","Karan");
                                $i=0;
                                foreach($mm as $mon){
                                    $i++;
										echo"<option value='$mon'> $mon</option>";
                                    //echo"<option value='$i'> $mon</option>";		
                                }
                            ?> 					     					
                        </select>
					<!-- </div> -->
				</div>
               
                <div style="margin-top:10px;">
                  
                	<input type="submit" class="submit_btn" onclick="alert('Submitted Successfully')" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"/>
                    <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                </div>
           </form>
    	</div>
    </form>
    <!-- <p id="dname_empty" style="color:red; display:none;">Form submitted successfully!</p> -->
</div><!-- end of style_informatios -->

<?php
}
?>
</body>
<!-- <script type="module" src="file2"></script> -->


</html>