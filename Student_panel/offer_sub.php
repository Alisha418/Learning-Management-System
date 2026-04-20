<?php
session_start();
include('connection.php');
if (!isset($_SESSION['user_email'])) {
    echo "User not logged in.";
    exit();
}
// Assume student is logged in and email is stored
$stuEmail = $_SESSION['user_email'];

// STEP 1: Find the department of the student
$sql = "
    SELECT department.DepId
    FROM student
    JOIN section ON student.SectionId = section.SectionId
    JOIN department ON section.Dep_Id = department.DepId
    WHERE student.StuEmail = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $stuEmail);
$stmt->execute();
$result = $stmt->get_result();
$depId = null;

if ($row = $result->fetch_assoc()) {
    $depId = $row['DepId'];
}

// STEP 2: Get all sections and sessions for that department
$sectionOptions = '';
$sessionOptions = '';

if ($depId !== null) {
    // Sections
    $sqlSections = "
        SELECT section.SectionId, section.SectionName 
        FROM section 
        WHERE section.Dep_Id = ?
    ";
    $stmtSections = $conn->prepare($sqlSections);
    $stmtSections->bind_param("i", $depId);
    $stmtSections->execute();
    $sectionsResult = $stmtSections->get_result();

    while ($row = $sectionsResult->fetch_assoc()) {
        $sectionOptions .= "<option value='{$row['SectionId']}'>{$row['SectionName']}</option>";
    }

    // Sessions
    $sqlSessions = "
        SELECT DISTINCT session.SessionId, session.SessionName 
        FROM section
        JOIN session ON section.Session_Id = session.SessionId
        WHERE section.Dep_Id = ?
    ";
    $stmtSessions = $conn->prepare($sqlSessions);
    $stmtSessions->bind_param("i", $depId);
    $stmtSessions->execute();
    $sessionsResult = $stmtSessions->get_result();

    while ($row = $sessionsResult->fetch_assoc()) {
        $sessionOptions .= "<option value='{$row['SessionId']}'>{$row['SessionName']}</option>";
    }
}
?>



<div class="main-content">
        <div class="quiz-title">
            <i class="bi bi-folder2-open"></i>
        <h2 class="dashboard-title">Offer Subjects</h2>
    </div>

    <div class="card-register" id="offerSubjectsCard">
        <h2>Offer Subjects</h2>
        <label for="session">Select Session:</label>
<select id="session">
    <?php echo $sessionOptions; ?>
</select>

<label for="section">Select Section:</label>
<select id="section">
    <?php echo $sectionOptions; ?>
</select>

        <button class="load-btn" onclick="loadSubjects()">Load Subjects</button>
    </div>

    <!-- Subjects Table -->
    <div id="subjectsTable" class=" cards-subject hidden">
        <table>
            <thead>
                <tr>
                    <th>Subject ID</th>
                    <th>Subject Name</th>
                    <th>Teacher</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>
</div>