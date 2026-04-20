<?php

$msg = "";
$opr = "";
$id = "";

// Check if operation type and record ID are set
if (isset($_GET['opr'])) {
    $opr = $_GET['opr'];
}

if (isset($_GET['rs_id'])) {
    $id = $_GET['rs_id'];
}

// Database connection using MySQLi
include("conection/connect.php");

// Add new teacher record
if (isset($_POST['btn_sub'])) {
    $f_name = $_POST['fnametxt'];
    $l_name = $_POST['lnametxt'];
    $gender = $_POST['genderrdo'];
    $dob = $_POST['yy'] . "/" . $_POST['mm'] . "/" . $_POST['dd'];
    $pob = $_POST['pobtxt'];
    $addr = $_POST['addrtxt'];
    $degree = $_POST['degree'];
    $salary = $_POST['slarytxt'];
    $married = $_POST['marriedrdo'];
    $phone = $_POST['phonetxt'];
    $mail = $_POST['emailtxt'];
    $note = $_POST['notetxt'];

    $sql_ins = "INSERT INTO teacher_tbl (f_name, l_name, gender, dob, pob, address, degree, salary, married, phone, email, note) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_ins);
    $stmt->bind_param("ssssssssssss", $f_name, $l_name, $gender, $dob, $pob, $addr, $degree, $salary, $married, $phone, $mail, $note);

    if ($stmt->execute()) {
        $msg = "1 Row Inserted Successfully!";
    } else {
        $msg = "Insert Error: " . $stmt->error;
    }

    $stmt->close();
}

// Update teacher record
if (isset($_POST['btn_upd'])) {
    $f_name = $_POST['fnametxt'];
    $l_name = $_POST['lnametxt'];
    $gender = $_POST['genderrdo'];
    $dob = $_POST['yy'] . "/" . $_POST['mm'] . "/" . $_POST['dd'];
    $pob = $_POST['pobtxt'];
    $addr = $_POST['addrtxt'];
    $degree = $_POST['degree'];
    $salary = $_POST['slarytxt'];
    $married = $_POST['marriedrdo'];
    $phone = $_POST['phonetxt'];
    $mail = $_POST['emailtxt'];
    $note = $_POST['notetxt'];

    $sql_update = "UPDATE teacher_tbl SET 
                    f_name = ?, 
                    l_name = ?, 
                    gender = ?, 
                    dob = ?, 
                    pob = ?, 
                    address = ?, 
                    degree = ?, 
                    salary = ?, 
                    married = ?, 
                    phone = ?, 
                    email = ?, 
                    note = ? 
                    WHERE teacher_id = ?";

    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssssssssssi", $f_name, $l_name, $gender, $dob, $pob, $addr, $degree, $salary, $married, $phone, $mail, $note, $id);

    if ($stmt->execute()) {
        echo "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;'>"
            . "<span class='p_font'>"
            . "Record Updated Successfully!"
            . "</span>"
            . "</div>";
    } else {
        $msg = "Update Failed: " . $stmt->error;
    }

    $stmt->close();
}

// $conn->close();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style_entry.css" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Welcome to College Management system</title>
<link rel="stylesheet" type="text/css" href="css/style_entry.css" />
</head>

<body>

<?php
if ($opr == "upd") {
    $stmt = $conn->prepare("SELECT * FROM teacher_tbl WHERE teacher_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($rs_upd = $result->fetch_assoc()) {
        list($y, $m, $d) = explode('-', $rs_upd['dob']);
    }

    $stmt->close();
?>


<!-- <div class="panel panel-default">
  		<div class="panel-heading"><h1><span class="glyphicon glyphicon-user"></span> Teachers Update Form</h1></div>
  			<div class="panel-body">
			<div class="container">
				<p style="text-align:center;">Here, you'll update your teachers records into database.</p>
			</div>


<div class="container_form">
    <form method="post">
				<div class="teacher_name_pos">
					<input type="text" name="fnametxt" class="form-control" value="<?php echo $rs_upd['f_name'];?>" />
					<input type="text" name="lnametxt" class="form-control" value="<?php echo $rs_upd['f_name'];?>" />
				</div><br>
				
				<div class="teacher_radio_pos">
					<input type="radio" name="genderrdo" value="Male"<?php if($rs_upd['gender']=="Male") echo "checked";?> /> <span class="p_font">&nbsp;Male</span>
					<input type="radio" name="genderrdo" value="Female"<?php if($rs_upd['gender']=="Female") echo "checked";?> /> <span class="p_font">&nbsp;Female</span>
				</div><br>
				
				<div class="teacher_bday_box">
					<span class="p_font">Birthday: </span>&nbsp;&nbsp;&nbsp;
					<div class="select_style">
    					<select name="yy">
       						<option>Year</option>
       						<?php
							$sel="";
							for($i=1985;$i<=2015;$i++){	
								if($i==$y){
									$sel="selected='selected'";}
								else
								$sel="";
							echo"<option value='$i' $sel>$i </option>";
							}
							
						?>
						</select>
					</div>
					
					<div class="select_style">
    					<select name="mm">
       						<option>Month</option>
       						<?php
							$sel="";
                            $mm=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","NOv","Dec");
                            $i=0;
                            foreach($mm as $mon){
                                $i++;
									if($i==$m){
										$sel=$sel="selected='selected'";}
									else
										$sel="";
                                echo"<option value='$i' $sel> $mon</option>";		
                            }
                        ?>                        </select>
					</div>
					
					<div class="select_style">
    					<select name="dd">
       						<option>date</option>
       						<?php
						$sel="";
                        for($i=1;$i<=31;$i++){
							if($i==$d)
							$sel="selected='selected'";
							else
								$sel="";
                        ?>
                        <option value="<?php echo $i ;?>"<?php echo $sel ;?> >
                        <?php
                        if($i<10)
                            echo"0"."$i" ;
                        else
                            echo"$i";	
							  
						?>
						</option>	
						<?php 
						}?>
						</select>
					</div>
					
		     	</div><br><br>
		     	
				<div class="teacher_bdayPlace_pos">
					<input type="text" name="pobtxt" class="form-control" value=" <?php echo $rs_upd['pob']; ?>" />
				</div><br>
				
				<div class="teacher_address_pos">
					<input type="text" name="addrtxt" class="form-control" value=" <?php echo $rs_upd['address'];?>" />
				</div><br> -->
				<div class="panel panel-default panel-p" style=" background-color: #f4f4f4;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Teacher Entry Form</h1></div>
  		<div class="panel-body">
		 <div class="container">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll update teacher's detail to record into database.</p>
		 </div>

         <div class="container_form">
          <form method="post">
				<div class="teacher_name_pos">
					<input type="text" name="fnametxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['f_name'];?>" />
					<input type="text" name="lnametxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['l_name'];?>" />
				</div><br>
				
				<div class="teacher_radio_pos">
					<input type="radio" name="gender" value="Male" <?php if($rs_upd['gender']=="Male") echo "checked";?> /> <span class="p_font">&nbsp;Male</span>
					<input type="radio" name="gender" value="Female" <?php if($rs_upd['gender']=="Female") echo "checked";?> /> <span class="p_font">&nbsp;Female</span>
				</div><br>
				
				<div class="teacher_bday_box">
					<span class="p_font">Birthday: </span>&nbsp;&nbsp;&nbsp;
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="yy">
       						<option>Year</option>
       						<?php
							$sel="";
							for($i=1985;$i<=2015;$i++){	
								if($i==$y){
									$sel="selected='selected'";}
								else
								$sel="";
							echo"<option value='$i' $sel>$i </option>";
							}
							
						?>
						</select>
					</div>
					
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="mm">
       						<option>Month</option>
       						<?php
							$sel="";
                            $mm=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","NOv","Dec");
                            $i=0;
                            foreach($mm as $mon){
                                $i++;
									if($i==$m){
										$sel=$sel="selected='selected'";}
									else
										$sel="";
                                echo"<option value='$i' $sel> $mon</option>";		
                            }
                        ?>
                        </select>
					</div>
					
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="dd">
       						<option>date</option>
       						<?php
						$sel="";
                        for($i=1;$i<=31;$i++){
							if($i==$d){
								$sel=$sel="selected='selected'";}
							else
								$sel="";
                        ?>
                        <option value="<?php echo $i ;?>"<?php echo $sel?> >
                        <?php
                        if($i<10)
                            echo"0"."$i" ;
                        else
                            echo"$i";	
							  
						?>
						</option>	
						<?php 
						}?>
						</select>
					</div>
					
		     	</div><br><br>
		     	
				<div class="teacher_bdayPlace_pos">
					<input type="text" name="pobtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['pob'];?> " />
				</div><br>
				
				<div class="teacher_address_pos">
					<input type="text" name="addrtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value='<?php echo $rs_upd['address'];?>' />
				</div><br>
				
				<div class="teacher_degree_pos">
					<span class="p_font" style="float: left; margin-left: 88px;">Teacher's qualification: </span>
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="degree">
       						<option>Degree</option>
       						<?php
                                $mm=array("Bachelor","Master","P.HD");
                                $i=0;
                                foreach($mm as $mon){
                                    $i++;
										if($mon==$rs_upd['degree'])
											$iselect="selected";
										else
											$iselect="";
											
										echo"<option value='$mon' $iselect> $mon</option>";		
                                }
                            ?>			     					
                        </select>
					</div>
				</div><br>
				
				<div class="teacher_salary_pos">
					<input type="text" name="slarytxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['salary'];?>" />
				</div><br>
				
				<div class="teacher_married_pos">
					<span class="p_font">Married</span>
					<input type="radio" name="marriedrdo" value="Yes"<?php if($rs_upd['married']=="Yes") echo "checked";?> /> <span class="p_font">&nbsp;Yes</span>
					<input type="radio" name="marriedrdo" value="No"<?php if($rs_upd['married']=="No") echo "checked";?> /> <span class="p_font">&nbsp;No</span>
				</div><br>
				
				<div class="teacher_mobile_pos">
					<input type="text" name="phonetxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['phone'];?>" />
				</div><br>
				
				<div class="teacher_mail_pos">
					<input type="text" name="emailtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['email'];?>" />
				</div><br>
				
				<!-- <div class="teacher_note_pos">
					<input type="text" name="notetxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" value="<?php echo $rs_upd['note'];?>" />
				</div><br> -->
				<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="dd" value="IT">
       						<option>IT</option>
							<option>Computer Science</option>
							<option>Electrical</option>
						</select>
				</div>						
				
				<div class="teacher_btn_pos">
					<input type="submit" name="btn_upd" class="" value="Update" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" />&nbsp;&nbsp;&nbsp;
					<input type="reset"  href="#" class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" />
				</div>
                </form>
			</div>
		</div>
	</div>
<?php	
}
else
{
?>
<!-- <div class="panel panel-default">
  		<div class="panel-heading"><h1><span class="glyphicon glyphicon-user"></span> Teachers Entry Form</h1></div>
  			<div class="panel-body">
			<div class="container">
				<p style="text-align:center;">Here, you'll add new teachers detail to record into database.</p>
			</div>

<div class="container_form">
    <form method="post">
				<div class="teacher_name_pos">
					<input type="text" name="fnametxt" class="form-control" placeholder="First name" />
					<input type="text" name="lnametxt" class="form-control" placeholder="Last name" />
				</div><br>
				
				<div class="teacher_radio_pos">
					<input type="radio" name="genderrdo" value="Male" /> <span class="p_font">&nbsp;Male</span>
					<input type="radio" name="genderrdo" value="Female" /> <span class="p_font">&nbsp;Female</span>
				</div><br>
				
				<div class="teacher_bday_box">
					<span class="p_font">Birthday: </span>&nbsp;&nbsp;&nbsp;
					<div class="select_style">
    					<select name="yy">
       						<option>Year</option>
       						<?php
							for($i=1985;$i<=2015;$i++){	
							echo"<option value='$i'>$i</option>";
							}
						?>
						</select>
					</div>
					
					<div class="select_style">
    					<select name="mm">
       						<option>Month</option>
       						<?php
                            $mm=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","NOv","Dec");
                            $i=0;
                            foreach($mm as $mon){
                                $i++;
                                echo"<option value='$i'> $mon</option>";		
                            }
                        ?>
                        </select>
					</div>
					
					<div class="select_style">
    					<select name="dd">
       						<option>date</option>
       						<?php
                        for($i=1;$i<=31;$i++){
                        ?>
                        <option value="<?php echo $i; ?>">
                        <?php
                        if($i<10)
                            echo"0".$i;
                        else
                            echo"$i";	  
						?>
						</option>	
						<?php 
						}?>
						</select>
					</div>
					
		     	</div><br><br>
		     	
				<div class="teacher_bdayPlace_pos">
					<input type="text" name="pobtxt" class="form-control" placeholder="Place of birth" />
				</div><br>
				
				<div class="teacher_address_pos">
					<input type="text" name="addrtxt" class="form-control" placeholder="Address" />
				</div><br> -->
				<div class="panel panel-default panel-p" style=" background-color: #f4f4f4; border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Teacher Entry Form</h1></div>
  		<div class="panel-body">
		 <div class="container">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new teacher's detail to record into database.</p>
		 </div>

         <div class="container_form">
          <form method="post">
				<div class="teacher_name_pos">
					<input type="text" name="fnametxt" placeholder="First name" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
					<input type="text" name="lnametxt" placeholder="Last name" style="width:100%;padding:8px;margin:5px;background:white;color:black;border-radius:5px;border:2px solid #662d91; " />
				</div><br>
				
				<div class="teacher_radio_pos">
					<input type="radio" name="gender" value="Male"/> <span class="p_font">&nbsp;Male</span>
					<input type="radio" name="gender" value="Female" /> <span class="p_font">&nbsp;Female</span>
				</div><br>
				
				<div class="teacher_bday_box">
					<span class="p_font">Birthday: </span>&nbsp;&nbsp;&nbsp;
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="yy">
       						<option>Year</option>
       						<?php
							for($i=1985;$i<=2015;$i++){	
							echo"<option value='$i'>$i</option>";
							}
						?>
						</select>
					</div>
					
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="mm">
       						<option>Month</option>
       						<?php
                            $mm=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","NOv","Dec");
                            $i=0;
                            foreach($mm as $mon){
                                $i++;
                                echo"<option value='$i'> $mon</option>";		
                            }
                        ?>
                        </select>
					</div>
					
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="dd">
       						<option>date</option>
       						<?php
                        for($i=1;$i<=31;$i++){
                        ?>
                        <option value="<?php echo $i; ?>">
                        <?php
                        if($i<10)
                            echo"0".$i;
                        else
                            echo"$i";	  
						?>
						</option>	
						<?php 
						}?>
						</select>
					</div>
					
		     	</div><br><br>
		     	
				<div class="teacher_bdayPlace_pos">
					<input type="text" name="pobtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Place of birth" />
				</div><br>
				
				<div class="teacher_address_pos">
					<input type="text" name="addrtxt" class="" placeholder="Address" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
				</div><br>
				
				<div class="teacher_degree_pos">
					<span class="p_font" style="float: left; margin-left: 88px;">Teacher's qualification: </span>
					<div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
    					<select name="degree">
       						<option>Degree</option>
       						<?php
                                $mm=array("Bachelor","Master","P.HD");
                                $i=0;
                                foreach($mm as $mon){
                                    $i++;
										echo"<option value='$mon'> $mon</option>";
                                    //echo"<option value='$i'> $mon</option>";		
                                }
                            ?> 					     					
                        </select>
					</div>
				</div><br>
				
				<div class="teacher_salary_pos">
					<input type="text" name="slarytxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Salary" />
				</div><br>
				
				<div class="teacher_married_pos">
					<span class="p_font">Married</span>
					<input type="radio" name="marriedrdo" value="Yes"/> <span class="p_font">&nbsp;Yes</span>
					<input type="radio" name="marriedrdo" value="No"/> <span class="p_font">&nbsp;No</span>
				</div><br>
				
				<div class="teacher_mobile_pos">
					<input type="text" name="phonetxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Mobile no." />
				</div><br>
				
				<div class="teacher_mail_pos">
					<input type="text" name="emailtxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Email address" />
				</div><br>
				
				<!-- <div class="teacher_note_pos">
					<input type="text" name="notetxt" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" placeholder="Note" />
				</div><br> -->
			
				<!-- <div class="select_style" style="padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
				        <!-- <span class="p_font" style="text-align:left;">Department:</span>
    					<select name="dd" id="dep" style="width:150px;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option>IT</option>
							<option>Computer Science</option>
							<option>Electrical</option>
						</select> -->
				<!-- </div>		 -->
				
				<div class="teacher_btn_pos">
					<input type="submit" name="btn_sub" href="#" class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" value="Register" />&nbsp;&nbsp;&nbsp;
					<input type="reset"  href="#" class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" />
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