<?php
// Assuming you already have $conn = new mysqli(...) or include your db connection here

// Query counts
$subject_count = $conn->query("SELECT COUNT(*) as total FROM subject")->fetch_assoc()['total'];
$student_count = $conn->query("SELECT COUNT(*) as total FROM student")->fetch_assoc()['total'];
$teacher_count = $conn->query("SELECT COUNT(*) as total FROM teacher")->fetch_assoc()['total'];
$department_count = $conn->query("SELECT COUNT(*) as total FROM department")->fetch_assoc()['total'];
$session_count = $conn->query("SELECT COUNT(*) as total FROM session")->fetch_assoc()['total'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/home.css"/>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<title>College management system made by Rajendra Arora..</title>
<style>
    /* @media()
    @media(min-width:514px) and (max-width:700px){
      .main-container{
        width:90% !important;
        margin-right:auto !important;
        margin-left:auto !important;
        margin-top:100px !important;
      }

    }
    @media(max-width:280px){
      .main-container{
        width:99% !important;
        margin-right:auto !important;
        margin-left:auto !important;
        margin-top:100px !important;
      }

    } */
     /* Default styles (for larger screens) */
h3 {
    margin-left: 100px;
    margin-top: 30px;
}

.main-container {
    width: 99%;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-start;
    margin: 20px 100px;
}

.main-container div {
    width: 250px;
    display: flex;
    align-items: center;
    padding: 0 20px;
    position: relative;
    border-radius: 10px;
    height: 100px;
}

/* Large Screens (Desktops) - Above 1200px */
@media (min-width: 1200px) {
    .main-container {
        justify-content: flex-start;
    }
}

/* Medium Screens (Tablets) - 768px to 1199px */
@media (max-width: 1199px) {
    .main-container {
        justify-content: center;
        margin: 20px 50px;
    }

    h3 {
        margin-left: 50px;
    }
}
@media(max-width:890px){
  .main-container {
        /* justify-content: center; */
        margin: 20px !important;
  }
  h3 {
        margin-left: 20px !important;
  }

}

/* Small Screens (Tablets & Small Laptops) - 600px to 767px */
@media (max-width: 767px) {
    .main-container {
        flex-direction: column;
        align-items: center;
        margin: 20px;
        margin-left:5px;
    }

    h3 {
        margin-left: 20px;
        text-align: center;
    }

    .main-container div {
        width: 80%;
    }
}

/* Extra Small Screens (Mobile) - Below 600px */
@media (max-width: 599px) {
    .main-container {
        margin: 10px;
    }

    h3 {
        margin-left: 10px;
        font-size: 18px;
    }

    .main-container div {
        width: 90%;
        height: auto;
        flex-direction: column;
        text-align: center;
        padding: 10px;
    }

    .main-container div i {
        margin-bottom: 5px;
    }

    .main-container div p {
        position: static;
        margin-top: 5px;
    }
}
@media(max-width:350px){
  h3{
    font-size:16px !important;
  }
  .main-container{
     margin-left:5px !important;
     margin-right:15px !important;
  }
  .main-container div{
    width:80% !important;
  }
}

</style>
</head>

<body>
	<!-- <div class="panel panel-default"> -->
  <h3 style="margin-left:100px;margin-top:30px;">Dashboard Overview</h3>
<div style="width:99%;display:flex;flex-wrap:wrap;gap:10px;justify-content:flex-start;margin:20px 100px;" class="main-container">

  <div style="background-color:#89CFF0;width:250px;display:flex;align-items:center;padding:0 20px;position:relative;border-radius:10px;height:100px;">
      <div style="display:flex;align-items:center;">
        <i class="bi bi-book" style="color:#318CE7;font-size:30px;margin-right:5px;"></i>
        <span style="font-size:16px;">Subjects</span>
      </div>
      <p style="font-weight:bold;font-size:18px;position:absolute;right:5px;bottom:0;"><?php echo $subject_count; ?></p>
  </div>

  <div style="background-color:#FFB6C1;width:250px;display:flex;align-items:center;padding:0 20px;position:relative;border-radius:10px;height:100px;">
      <div style="display:flex;align-items:center;">
        <i class="bi bi-person" style="color:#FF69B4;font-size:30px;margin-right:5px;"></i>
        <span style="font-size:16px;">Students</span>
      </div>
      <p style="font-weight:bold;font-size:18px;position:absolute;right:5px;bottom:0;"><?php echo $student_count; ?></p>
  </div>

  <div style="background-color:#B9D9EB;width:250px;display:flex;align-items:center;padding:0 20px;position:relative;border-radius:10px;height:100px;">
      <div style="display:flex;align-items:center;">
        <i class="bi bi-person" style="color:#1F75FE;font-size:30px;margin-right:5px;"></i>
        <span style="font-size:16px;">Teachers</span>
      </div>
      <p style="font-weight:bold;font-size:18px;position:absolute;right:5px;bottom:0;"><?php echo $teacher_count; ?></p>
  </div>

  <div style="background-color:#AFE1AF;width:250px;display:flex;align-items:center;padding:0 20px;position:relative;border-radius:10px;height:100px;">
      <div style="display:flex;align-items:center;">
        <i class="bi bi-bank" style="color:#50C878;font-size:30px;margin-right:5px;"></i>
        <span style="font-size:16px;">Departments</span>
      </div>
      <p style="font-weight:bold;font-size:18px;position:absolute;right:5px;bottom:0;"><?php echo $department_count; ?></p>
  </div>

  <div style="background-color:#FFFDD0;width:250px;display:flex;align-items:center;padding:0 20px;position:relative;border-radius:10px;height:100px;">
      <div style="display:flex;align-items:center;">
        <i class="bi bi-clipboard-data" style="color:#FFEA00;font-size:30px;margin-right:5px;"></i>
        <span style="font-size:16px;">Sessions</span>
      </div>
      <p style="font-weight:bold;font-size:18px;position:absolute;right:5px;bottom:0;"><?php echo $session_count; ?></p>
  </div>

</div>

    
    
</body>
</html>