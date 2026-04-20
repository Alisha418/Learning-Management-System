<?php
require_once './vendor/autoload.php';
require_once './vendor/cloudinary/cloudinary_php/src/Cloudinary.php';
require_once './vendor/cloudinary/cloudinary_php/src/Configuration/Configuration.php';
require_once './vendor/cloudinary/cloudinary_php/src/Api/Upload/UploadApi.php';


$id = "";
$opr = "";
if (isset($_GET['opr']))
    $opr = $_GET['opr'];

if (isset($_GET['rs_id']))
    $id = $_GET['rs_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Include your connection file
        // include("your_connection_file.php"); // your db connection
    
        // Sanitize and validate inputs
        $title = mysqli_real_escape_string($conn, $_POST['dname']);
        $content = mysqli_real_escape_string($conn, $_POST['dcode']);
    
        // Check if file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageType = $_FILES['image']['type'];
    
            // Allowed image types and max size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB
    
            // Check if file type is allowed
            if (in_array($imageType, $allowedTypes)) {
                // Check file size
                if ($imageSize <= $maxSize) {
                    // Cloudinary config
                    $cloudinary = new \Cloudinary\Cloudinary([
                        'cloud' => [
                            'cloud_name' => 'dp9mrfhm7',
                            'api_key'    => '133473173891211',
                            'api_secret' => 'Hk0oL4HsvJNo2n2lUEnmwJv4epU',
                        ]
                    ]);
                    
    
                    // Upload image to Cloudinary
                    try {
                        $uploadResult = $cloudinary->uploadApi()->upload($imageTmp, [
                            'folder' => 'articles', // optional folder in Cloudinary
                        ]);
    
                        $imageUrl = $uploadResult['secure_url'];
    
                        // Prepared statement for inserting data into the database
                        $stmt = $conn->prepare("INSERT INTO article (ArticleTitle, Content, Image) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $title, $content, $imageUrl);
    
                        if ($stmt->execute()) {
                            echo "<script>alert('Article added successfully!');</script>";
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                        $stmt->close();
    
                    } catch (Exception $e) {
                        echo "Image upload failed: " . $e->getMessage();
                    }
                } else {
                    echo "Error: The image size exceeds the allowed limit of 5MB.";
                }
            } else {
                echo "Error: Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            }
        } else {
            echo "Error: No image uploaded or there was an issue with the upload.";
        }
    }
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style_entry.css" />
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
    #input-img{
        width:80px !important;
        height:80px !important;
    }
    .teacher_note_pos span{
        font-size:18px;
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
    .teacher_note_pos span{
        font-size:16px;
    }
    #input-img{
        width:60px !important;
        height:60px !important;
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
    #input-img{
        width:40px !important;
        height:40px !important;
    }
    .panel-heading h1 {
        font-size: 16px !important; 
        padding:3px !important;
        /* width:100%; */
    }
    .teacher_note_pos{
        width:85% !important;

    }
    .teacher_note_pos span{
        font-size:14px;
    }
    .teacher_note_pos input {
        font-size: 12px !important;
        padding: 5px !important;
        width:100%;
    }
    /* .teacher_note_pos img{
        width:40px;
        height:40px;
    } */
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
    
?>


     <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Article's Update Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
		 <div class="container" style="width:100%;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll update article's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->
                  <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">    
                   
                            <div class="teacher_note_pos" style="margin:0;">
                                <input type="text" class="form-control" name="dname"  id="textbox"  placeholder="Article's Title" value="<?php echo htmlspecialchars($dname); ?>" required style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                                <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's name should not be empty</p>
                                <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's name should contain at least 4 characters</p>
                                <p id="dname_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's name should contain only letters</p>
                            </div><br>
							
							<div class="teacher_note_pos" style="margin:0;">
                	          <textarea type="text" class="form-control" name="dcode"  id="textbox" placeholder="Content" value="<?php echo htmlspecialchars($dcode); ?>" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"></textarea>
                              <p id="dcode_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's content should not be empty</p>

                            </div><br>
                            <div class="teacher_note_pos" style="margin:0;">
                             <label htmlFor='file-input'>
                                 <img src={image?URL.createObjectURL(image):upload_area} style="width:40px;height:40px;" alt="" className='thumbnail-img' />
                             </label>
                             <input type="file" name='image' id='file-input' hidden />
                            </div>
                            
            
                            <div>
                            <input type="submit" class="submit_btn" value="Update" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
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
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Article Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
          <form method="post" enctype="multipart/form-data" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add new article's detail to record into database.</p>
		 </div>

         <!-- <div class="container_form"> -->

            
                <div class="teacher_note_pos" style="margin:0;">
                	<input type="text" class="form-control" name="dname" id="textbox" placeholder="Article's Title" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;" />
                    <p id="dname_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's name should not be empty</p>
                    <p id="dname_size" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's name should contain at least 4 characters</p>
                    <p id="dname_letter" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's name should contain only letters</p>
                </div><br>
            
                <div class="teacher_note_pos" style="margin:0;">
                	<textarea type="text" class="form-control" name="dcode"  id="textbox" placeholder="Content" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"></textarea>
                    <p id="dcode_empty" style="text-align:left;color:red;display:none;margin:0;padding:0;font-size:16px;">Article's content should not be empty</p>

                </div><br>

                <div class="teacher_note_pos" style="margin:0;">
        <span class="p_font">Image: </span>
        <label for="file-input">
            <img id="input-img" style="height:100px;width:100px;border-radius: 10px;object-fit: contain;margin: 10px 0px;" alt="Image Preview"/>
        </label>
        <input type="file" name="image" id="file-input" hidden style="margin-bottom:10px;" accept="image/*"/>
    </div>
            
                <div>
                	<input type="submit" class="submit_btn" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
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
    let dcodeInput = document.querySelector("textarea[name='dcode']");
    let submitBtn = document.querySelector(".submit_btn");

    let dnameEmpty = document.querySelector("#dname_empty");
    let dnameSize = document.querySelector("#dname_size");
    let dnameLetter = document.querySelector("#dname_letter");
    let dcodeEmpty = document.querySelector("#dcode_empty");

    let inputFile=document.querySelector("#file-input");
    let inputImage=document.querySelector("#input-img");
  

    // Function to clear error messages when typing
    function clearDnameErrors() {
        dnameEmpty.style.display = "none";
        dnameSize.style.display = "none";
        dnameLetter.style.display = "none";
    }

    function clearDcodeErrors() {
        dcodeEmpty.style.display = "none";
        dcodeLetter.style.display = "none";
    }

    // Add event listeners for real-time validation
    dnameInput.addEventListener("input", clearDnameErrors);
    dcodeInput.addEventListener("input", clearDcodeErrors);
    document.getElementById('file-input').addEventListener('change', function(event) {
     const inputImage = document.getElementById('input-img');
     const file = event.target.files[0];

     if (file) {
        const reader = new FileReader();
        
        // When the file is read, update the image preview
        reader.onload = function(e) {
            inputImage.src = e.target.result;
        };

        // Read the selected file as a data URL
        reader.readAsDataURL(file);
     } else {
        inputImage.src = ''; // Default image in case no file is selected
     }
});


    submitBtn.addEventListener("click", function (event) {
        let departmentName = dnameInput.value.trim();
        let departmentCode = dcodeInput.value.trim();
        let valid = true; // Track form validity

        // Validation for Department Name
        if (departmentName === "") {
            dnameEmpty.style.display = "block";
            valid = false;
        } else if (/^[A-Za-z ]+$/.test(departmentName) && departmentName.length < 4) {
            dnameSize.style.display = "block";
            valid = false;
        }
        else if (!/^[A-Za-z ]+$/.test(departmentName)) {
            dnameLetter.style.display = "block";
            valid = false;
        }

        // Validation for Department Code
        if (departmentCode === "") {
            dcodeEmpty.style.display = "block";
            valid = false;
        } 

        // Prevent form submission if invalid
        if (valid) {
            alert("Submitted successfully");
        }else{
            event.preventDefault();

        }
    });
});

</script>


</html>