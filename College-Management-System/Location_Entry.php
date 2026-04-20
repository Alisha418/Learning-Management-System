<?php

$id=" ";
$opr=" ";

if(isset($_GET['opr']))
	$opr=$_GET['opr'];

if(isset($_GET['rs_id']))
	$id=$_GET['rs_id'];
	
	
if(isset($_POST['btn_sub'])){
	$loca_name=$_POST['locationtxt'];
	$description=$_POST['descriptxt'];
	$note	=$_POST['notetxt'];
	

$sql_ins=mysqli_query($conn,"INSERT INTO location_tb 
						VALUES(
							NULL,
							'$loca_name',
							'$description' ,
							'$note'
							)
					");
if($sql_ins==true)
	echo "";
	else
		$msg="Update Failed...!";
	
}

//------------------uodate data----------
if(isset($_POST['btn_upd'])){
	$loca_name=$_POST['locationtxt'];
	$description=$_POST['descriptxt'];
	$note=$_POST['notetxt'];
	
	$sql_update=mysqli_query($conn,"UPDATE location_tb SET	
							l_name='$loca_name' ,
							description='$description' ,
							note='$note'
						WHERE loca_id=$id

					");
					
if($sql_update==true){
echo "<div style='background-color: white;padding: 20px;border: 1px solid black;margin-bottom: 25px;''>"
                . "<span class='p_font'>"
                . "Record Updated Successfully... !"
                . "</span>"
                . "</div>";
}
else
	$msg="Update Fail!...";	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style_entry.css" />
</head>

<body>

<?php

if($opr=="upd")
{
	$sql_upd=mysqli_query($conn,"SELECT * FROM location_tb WHERE loca_id=$id");
	$rs_upd=mysqli_fetch_array($sql_upd);
	
?>
    <!-- <div class="panel panel-default">
  		<div class="panel-heading"><h1><span class="glyphicon glyphicon-globe"></span> Location's Update Form</h1></div>
  			<div class="panel-body">
			<div class="container">
				<p style="text-align:center;">Here, you'll update your location's records into database.</p>
			</div> -->
      <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		 <div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Location Update Form</h1></div>
  		 <div class="panel-body">
		   <div class="container">
			 <p style="text-align:center;margin:0;padding:0;">Here, you'll update location's detail to record into database.</p>
		  </div>

                  <form method="post">    
    
                      <div class="teacher_note_pos">
                        <input type="text" class="" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" name="locationtxt" id="textbox" value="<?php echo $rs_upd['l_name'];?>" />
                      </div><br>
                
                      <div class="text_box_pos">
                        <textarea name="descriptxt" class="" style="margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" cols="23" rows="4"><?php echo $rs_upd['description'];?></textarea>
                      </div><br>
                
                      <div class="text_box_pos">
                        <textarea name="notetxt" style="margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" class="form-control" cols="23" rows="4"><?php echo $rs_upd['note'];?></textarea>
                      </div><br><br>                
                
                      <div>
                        <input type="submit" class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" name="btn_upd" value="Update" id="button-in"  />
                        <input type="reset" style="margin-left: 9px;" class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                      </div>    
       </div>
    
        </form>
    
    </div><!-- end of style_informatios -->
    
    <?php
}
else
{
?>

<!-- <div class="panel panel-default">
  		<div class="panel-heading"><h1><span class="glyphicon glyphicon-globe"></span> Location's Entry Form</h1></div>
  			<div class="panel-body">
			<div class="container">
				<p style="text-align:center;">Here, you'll add your location's records into database.</p>
			</div>
                  <form method="post">     -->
     <div class="panel panel-default panel-p" style=" background-color: #f4f4f4; border-radius: 8px; padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Location Entry Form</h1></div>
  		<div class="panel-body">
		 <div class="container">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new location to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
          <form method="post">
                      
                      <div class="teacher_note_pos">
                        <input class="form-control" type="text" name="locationtxt" id="textbox" placeholder='Location name' style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                      </div><br>
                      
                      <div class="text_box_pos">
                        <textarea name="descriptxt" class="form-control" cols="23" rows="4" placeholder='Add description..' style="margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"></textarea>
                      </div><br>
                      
                      <div class="text_box_pos">
                        <textarea name="notetxt" class="form-control" cols="23" rows="4" placeholder='Add note..' style="margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"></textarea>
                      </div><br><br>                
                
                      <div>
                        <input type="submit" class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" name="btn_sub" value="Add Now" id="button-in"  />
                        <input type="reset"  class="" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                      </div>
    
                  </form>
                      </div>
    </div><!-- end of style_informatios -->
    
<?php
}
?>
</body>
</html>