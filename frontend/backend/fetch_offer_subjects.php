<?php
// Step 1: Connect to MySQL database
include 'db_connection.php';

// Step 2: Get data from subjectoffer and related tables
$sql = "SELECT 
            so.OfferId, s.SubName, sec.SectionName, sem.SemName
        FROM 
            subjectoffer so
        JOIN subject s ON so.Sub_Id = s.SubId
        JOIN section sec ON so.Section_Id = sec.SectionId
        JOIN semester sem ON so.Sem_Id = sem.SemId";

$result = $conn->query($sql);

// Step 3: Prepare arrays for dropdowns
$sessions = [];
$sections = [];
$subjects = [];

while ($row = $result->fetch_assoc()) {
    $sessions[$row['SemName']] = $row['SemName'];
    $sections[$row['SectionName']] = $row['SectionName'];
    $subjects[$row['SubName']] = $row['SubName'];
}

// Step 4: Output dropdown options (can also return as JSON if needed)
echo "<script>\n";

// Session options
echo "const sessionOptions = `<option value=''>Select Session</option>";
foreach ($sessions as $session) {
    echo "<option value='$session'>$session</option>";
}
echo "`;\n";

// Section options
echo "const sectionOptions = `<option value=''>Select Section</option>";
foreach ($sections as $section) {
    echo "<option value='$section'>$section</option>";
}
echo "`;\n";

// Subject options
echo "const subjectOptions = `<option value=''>Select Subject</option>";
foreach ($subjects as $subject) {
    echo "<option value='$subject'>$subject</option>";
}
echo "`;\n";

// JavaScript to insert into the HTML
echo "document.getElementById('studentSessionSelect').innerHTML = sessionOptions;\n";
echo "document.getElementById('studentSectionSelect').innerHTML = sectionOptions;\n";
echo "document.getElementById('studentSubjectSelect').innerHTML = subjectOptions;\n";

echo "</script>";

$conn->close();
?>
