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
   
    $day = $_POST['day'];
    $time = $_POST['time'];
    $offer = $_POST['offer'];
    $room = $_POST['room'];
    


    // ✅ Use `mysqli_query` and pass `$conn`
    $sql_ins = mysqli_query($conn, "INSERT INTO timetable
                        (Day, TimeSlot,Offer_Id,RoomNo) 
                        VALUES ('$day', '$time','$offer','$room')");

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



            <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> TimeTable Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
          <form id="myForm" method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new timetable details to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->

            
               
                <div class="teacher_degree_pos" style="margin:0;">
					<span class="p_font" style="float:left;margin-top:5px;">Day: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="day" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option>Monday</option>
       						<?php
                                $mm=array("Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
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
					<span class="p_font" style="float:left;margin-top:5px;">Time Slot: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="time" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option>8:00-9:00</option>
       						<?php
                                $mm=array("9:00-10:00","10:00-12:00","11:00-12:00","1:00-2:00","1:00-3:00");
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
    <span class="p_font" style="float:left;margin-top:5px;">Offer Subject: </span>
    <select name="offer" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
        <option disabled selected>--Select--</option>
        <?php
        // Replace with your actual database credentials
        $conn = new mysqli("localhost", "root", "12345678", "edusphere2",3307);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch subject IDs (and optionally names)
        $sql = "SELECT OfferId FROM subjectoffer";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Assuming subject_name is a column in offer_subject table
                echo "<option value='" . $row["OfferId"] . "'>" . $row["OfferId"] . "</option>";
            }
        } else {
            echo "<option disabled>No subjects found</option>";
        }

        $conn->close();
        ?>
    </select>
</div>

                <div class="teacher_degree_pos" style="margin:0;">
					<span class="p_font" style="float:left;margin-top:5px;">Room No: </span>
					<!-- <div class="select_style" style="border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
    					<select name="room" class="form-select" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
       						<option>F-03</option>
       						<?php
                                $mm=array("F-02","F-09","F-12","G-10","G-08","G-07");
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
                  
                	<input type="submit" name="btn_sub" class="submit_btn" onclick="alert('Submitted Successfully')" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"/>
                    <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                </div>
           </form>
    	</div>
    </form>
    <!-- <p id="dname_empty" style="color:red; display:none;">Form submitted successfully!</p> -->
</div><!-- end of style_informatios -->

</body>
<!-- <script type="module" src="file2"></script> -->


</html>