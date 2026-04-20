<?php
// include "connect.php"; // Ensure connection file is included

$id = "";
$opr = "";
if (isset($_GET['opr']))
    $opr = $_GET['opr'];

if (isset($_GET['rs_id']))
    $id = $_GET['rs_id'];


?> 
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_sub'])) {
    // include 'db_connection.php'; // or your connection file

    $subjectName = $_POST['subject'];

    // Get Sub_Id from subject table
    $subjectQuery = "SELECT SubId FROM subject WHERE SubName = ?";
    $stmt = $conn->prepare($subjectQuery);
    $stmt->bind_param("s", $subjectName);
    $stmt->execute();
    $result = $stmt->get_result();
    $subject = $result->fetch_assoc();

    if ($subject) {
        $subId = $subject['SubId'];

        $i = 1;
        while (isset($_POST["question$i"])) {
            $questionText = $_POST["question$i"];

            // Insert into surveyquestions
            $insertQ = "INSERT INTO surveyquestions (Sub_Id, QuesText) VALUES (?, ?)";
            $stmtQ = $conn->prepare($insertQ);
            $stmtQ->bind_param("is", $subId, $questionText);
            $stmtQ->execute();
            $quesId = $stmtQ->insert_id; // Get inserted question ID

            // Insert related options
            for ($j = 1; $j <= 4; $j++) {
                $optionKey = "option{$i}_{$j}";
                if (!empty($_POST[$optionKey])) {
                    $optionText = $_POST[$optionKey];
                    $insertO = "INSERT INTO surveyoptions (OptionText, Ques_Id) VALUES (?, ?)";
                    $stmtO = $conn->prepare($insertO);
                    $stmtO->bind_param("si", $optionText, $quesId);
                    $stmtO->execute();
                }
            }
            $i++;
        }

        echo "<script>alert('Questions and options added successfully!');</script>";
    } else {
        echo "<script>alert('Subject not found!');</script>";
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
     body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        /* .question-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .options {
            margin-left: 20px;
        } */
        .question-container {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"] {
            padding: 8px;
            border: 2px solid #662d91;
            border-radius: 5px;
            width: 100%;
            margin: 5px 0;
        }
        .options {
            margin-top: 10px;
            padding-left: 20px;
        }
        .options input[type="text"] {
            margin-bottom: 10px; /* Space between options */
        }
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
    .teacher_degree_pos label{
        font-size:18px !important;
    }
    .teacher_degree_pos  span{
        font-size:18px;
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
    .teacher_degree_pos label{
        font-size:16px !important;
    }
    .teacher_degree_pos  span{
        font-size:16px !important;
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
    .teacher_degree_pos label{
        font-size:14px !important;
    }
    .teacher_degree_pos  span{
        font-size:14px !important;
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



            <div class="panel panel-default panel-p" style=" background-color: #f4f4f4;border-radius: 8px;padding: 20px;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
  		<div class="panel-heading" style="background:#662d91;color:#ffffff;padding:10px;text-align-center;border-radius:5px 5px 0 0;"><h1><span class="glyphicon glyphicon-user"></span> Survey Entry Form</h1></div>
  		<div class="panel-body" style="display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0;margin-top:30px;padding:0;">
          <form method="post" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;max-width:500px;">   
		 <div class="container" style="width:auto;text-align:center;">
			<p style="text-align:center;margin:0;padding:0;">Here, you'll add each subject's survey to record into database.</p>
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
                <!-- <span class="p_font" style="float:left;margin-top:5px;">Subject: </span> -->
                <div class="teacher_degree_pos" style="margin:0;">
                 <label for="numQuestions" class="p_font" style="float:left;margin-top:5px;">Enter Number of Questions: </label>
                 <input type="number" name="question" id="numQuestions" min="1" max="10" style="width:80%;padding:6px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;">
                </div>
                <!-- <label for="numQuestions" class="p_font" style="text-align:left;margin-top:5px;">Enter Number of Questions:</label>
                <input type="number" id="numQuestions" min="1" max="10" style="width:100%;padding:8px;margin:5px 0;border:2px solid #662d91;border-radius:5px;background-color:white;color:black;"> -->
                <button class="submit_btn" style="margin-top:15px;padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;" onclick="generateFields()">Generate</button>

                <form id="quizForm">
                 <div id="questionsContainer"></div>
                 
                 <div style="margin-top:10px;display:none;" id="submit-btn">
                     <input type="submit" name="btn_sub" class="submit_btn" value="Add Now" id="button-in" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color: #662d91;color: white;transition: background 0.3s ease;"  />
                     <input type="reset" class="reset_btn" style="padding:12px 20px;font-size:16px;border-radius:5px;cursor:pointer;border:none;background-color:white;color:#662d91;border:2px solid #662d91;transtion:all 0.3s ease;" value="Cancel" id="button-in"/>
                 </div>
                </form>
           </form>
    	</div>
    </form>
</div><!-- end of style_informatios -->

</body>
<script>
  

  function generateFields() {
            const numQuestions = document.getElementById("numQuestions").value;
            const container = document.getElementById("questionsContainer");
            container.innerHTML = ""; // Clear previous questions
            let submitBtn=document.getElementById("submit-btn");

            if (numQuestions < 1) {
                alert("Please enter at least 1 question.");
                return;
            }
            submitBtn.style.display="block";
            for (let i = 1; i <= numQuestions; i++) {
                // Create question container
                const questionDiv = document.createElement("div");
                questionDiv.classList.add("question-container");

                // Question input field
                const questionLabel = document.createElement("label");
                questionLabel.innerText = `Question ${i}: `;
                const questionInput = document.createElement("input");
                questionInput.type = "text";
                questionInput.name = `question${i}`;
                questionInput.required = true;
                
                questionDiv.appendChild(questionLabel);
                questionDiv.appendChild(questionInput);
                questionDiv.appendChild(document.createElement("br"));

                // Options (Text inputs instead of radio buttons)
                const optionsDiv = document.createElement("div");
                optionsDiv.classList.add("options");

                for (let j = 1; j <= 4; j++) {
                    const optionLabel = document.createElement("label");
                    optionLabel.innerText = `Option ${j}: `;

                    const optionInput = document.createElement("input");
                    optionInput.type = "text";
                    optionInput.name = `option${i}_${j}`;
                    optionInput.placeholder = `Enter option ${j}`;
                    optionInput.required = true;

                    optionsDiv.appendChild(optionLabel);
                    optionsDiv.appendChild(optionInput);
                    optionsDiv.appendChild(document.createElement("br"));
                }

                questionDiv.appendChild(optionsDiv);
                container.appendChild(questionDiv);
            }
         
        }

        // Handle form submission
        document.getElementById("quizForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent actual form submission
            alert("Quiz submitted successfully!");
        });

</script>


</html>