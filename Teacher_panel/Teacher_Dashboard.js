document.addEventListener("DOMContentLoaded", function () {
    const sections = {
        profileBtn: "profileSection",
        subjectsBtn: "subjectsSection",
        studentsBtn: "studentsSection",
        quizzesBtn: "quizzesSection",
        attendanceBtn: "attendanceSection",
        timetableBtn: "timetableSection", // Added Timetable Section
        reportsBtn: "reportsSection",
        feedbackBtn: "feedbackSection",
        articlesBtn: "articlesSection"
    };

    const dashboard = document.getElementById("dashboardOverview");

    // Hide all sections initially
    Object.values(sections).forEach(sec => document.getElementById(sec).classList.add("hidden"));

    // Show only the dashboard by default
    dashboard.classList.remove("hidden");

    Object.keys(sections).forEach((btnId) => {
        const btn = document.getElementById(btnId);
        if (btn) {
            btn.addEventListener("click", function () {
                // Hide all sections including dashboard
                dashboard.classList.add("hidden");
                Object.values(sections).forEach(sec => document.getElementById(sec).classList.add("hidden"));

                // Show the selected section
                const targetSection = document.getElementById(sections[btnId]);
                if (targetSection) {
                    targetSection.classList.remove("hidden");

                    // 👉 If it's the profile section, load the profile from backend
                    if (btnId === "profileBtn") {
                        loadTeacherProfile(); // this is correct
                    }
                    if (btnId === "subjectsBtn") {
                        loadSessionsAndSections(); // ✅ Load sessions and sections dynamically
                    }
                    if (btnId === "studentsBtn") {
                        loadStudentFilters();
                        // dynamically load options for session, section, subject
                    }
                    if (btnId === "timetableBtn") {
                        loadTeacherTimetable();
                    }
                    if (btnId === "quizzesBtn") {
                        loadQuizzesSection();
                    }
                    if (btnId === "attendanceBtn") {
                        loadAttendanceFilters(); // NEW: fetch session, section, subject
                    }
                    if (btnId === "reportsBtn") {
                        setupReportsSection(); // ✅✅✅ Yeh naya function call hoga
                    }
                    if (btnId === "feedbackBtn") {
                        setupFeedbackReport();
                    }

                }
            });

        }
    });
});


function loadTeacherProfile() {
    console.log("Fetching teacher profile...");

    fetch("backend/get_teacher_profile.php", {
        method: "GET",
        credentials: "include"
    })
        .then(res => res.json())
        .then(data => {
            console.log("Fetched Data:", data);

            if (data.status === "success") {
                const t = data.data;

                const fields = {
                    teacherName: t.TName,
                    teacherQualification: t.TQualification,
                    teacherPhone: t.TPhone,
                    teacherEmail: t.TEmail,
                    teacherAddress: t.TAddress,
                    teacherGender: t.TGender,
                    teacherMarried: t.TMarried,
                    teacherSalary: t.TSalary
                };

                Object.entries(fields).forEach(([id, value]) => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.textContent = value;
                    } else {
                        console.warn(`Element with ID '${id}' not found.`);
                    }
                });

            } else {
                alert(data.message || "Failed to load profile.");
            }
        })
        .catch(err => {
            console.error("Error fetching profile:", err);
        });
}


function loadSessionsAndSections() {
    const semesterSelect = document.getElementById("semesterSelect");
    const sectionSelect = document.getElementById("sectionSelect");
    const okButton = document.getElementById("fetchSubjectsBtn");
    const subjectsTableBody = document.getElementById("subjectsTableBody");

    // Reset dropdowns and table
    semesterSelect.innerHTML = "<option value=''>Select Semester</option>";
    sectionSelect.innerHTML = "<option value=''>Select Section</option>";
    subjectsTableBody.innerHTML = "";

    // Fetch semesters
    fetch("backend/get_sub_semesters.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            if (data.status === "success") {
                data.semesters.forEach(semester => {
                    semesterSelect.innerHTML += `<option value="${semester.SemId}">${semester.SemName}</option>`;
                });
            } else {
                console.error("Failed to fetch semesters.");
            }
        })
        .catch(error => {
            console.error("Error fetching semesters:", error);
        });

    // Update sections when a semester is selected
    semesterSelect.addEventListener("change", () => {
        const semesterId = semesterSelect.value;
        sectionSelect.innerHTML = "<option value=''>Select Section</option>";

        if (!semesterId) return;

        fetch(`backend/get_sub_sections.php?semester=${semesterId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                if (data.status === "success") {
                    data.sections.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section.SectionId}">${section.SectionName}</option>`;
                    });
                } else {
                    console.error("Failed to fetch sections.");
                }
            })
            .catch(error => {
                console.error("Error fetching sections:", error);
            });
    });

    /// 🔘 Fetch and display subjects on OK click
    okButton.addEventListener("click", () => {
        const semesterId = semesterSelect.value;
        const sectionId = sectionSelect.value;

        if (!semesterId || !sectionId) {
            alert("Please select both semester and section.");
            return;
        }

        fetch(`backend/get_sub_subjects.php?semester=${semesterId}&section=${sectionId}`)
            .then(response => response.json())
            .then(data => {
                subjectsTableBody.innerHTML = "";  // Reset the table

                if (data.status === "success" && data.subjects.length > 0) {
                    data.subjects.forEach(subject => {
                        // Make sure the correct properties are used here
                        subjectsTableBody.innerHTML += `
                        <tr>
                            <td>${subject.SubId}</td> <!-- Subject Code -->
                            <td>${subject.SubName}</td> <!-- Subject Name -->
                            <td>${subject.CreditHors}</td> <!-- Credits -->
                        </tr>
                    `;
                    });
                } else {
                    subjectsTableBody.innerHTML = `
                    <tr><td colspan="3">No subjects found for this selection.</td></tr>
                `;
                }
            })
            .catch(error => {
                console.error("Error fetching subjects:", error);
                subjectsTableBody.innerHTML = `
                <tr><td colspan="3">Something went wrong while fetching subjects.</td></tr>
            `;
            });
    });

}


function loadTeacherTimetable() {
    fetch("backend/get_timetable.php")
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById("timetableBody");
            tbody.innerHTML = "";

            // Check for errors from the backend
            if (data.error) {
                console.error(data.error);
                return;
            }

            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                <td>${row.Day}</td>
                <td>${row.TimeSlot}</td>
                <td>${row.Subject}</td>
                <td>${row.RoomNo}</td>
            `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error("Failed to load timetable:", error);
        });
}

// QUIZZES
function loadQuizzesSection() {
    fetch_Q_Semesters(); // Semesters ko load karega
}

// Semesters fetch karna
function fetch_Q_Semesters() {
    fetch('backend/get_sub_semesters.php') // Tumhara PHP file
        .then(response => response.json())
        .then(data => {
            const semesterSelect = document.getElementById('quizSemesterSelect');
            semesterSelect.innerHTML = ''; // Clear old options
            if (data.status === 'success') {
                data.semesters.forEach(sem => {
                    const option = document.createElement('option');
                    option.value = sem.SemId;
                    option.textContent = sem.SemName;
                    semesterSelect.appendChild(option);
                });

                // Add debugging here
                console.log("Semesters loaded. Adding change listener to the select element.");
                semesterSelect.addEventListener('change', function() {
                    const semId = this.value;
                    console.log("Semester selected:", semId); // Log to check if the change event is triggered
                    if (semId) {
                        fetch_Q_Sections(semId); // Sections ko fetch karne ke liye semesterId pass karo
                    }
                });

            } else {
                semesterSelect.innerHTML = '<option>No semesters found</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching semesters:', error);
            const semesterSelect = document.getElementById('quizSemesterSelect');
            semesterSelect.innerHTML = '<option>Failed to load semesters</option>';
        });
}

function fetch_Q_Sections(semId) {
    console.log("Fetching sections for semester:", semId); // Add a log to verify the value
    fetch(`backend/get_sub_sections.php?semester=${semId}`)
        .then(response => response.json())
        .then(data => {
            const sectionSelect = document.getElementById('quizSectionSelect');
            sectionSelect.innerHTML = ''; // Clear old options
            if (data.status === 'success' && data.sections.length > 0) {
                // Create default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Section';
                sectionSelect.appendChild(defaultOption);
                
                // Populate the dropdown with sections
                data.sections.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.SectionId;
                    option.textContent = section.SectionName;
                    sectionSelect.appendChild(option);
                });

                // Add event listener for section selection
                sectionSelect.addEventListener('change', function() {
                    const sectionId = this.value;
                    console.log("Section selected:", sectionId); // Log the selected section
                    if (sectionId) {
                        fetch_Q_Subjects(semId, sectionId); // Fetch subjects based on selected section
                    }
                });

            } else {
                sectionSelect.innerHTML = '<option>No sections found</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching sections:', error);
            const sectionSelect = document.getElementById('quizSectionSelect');
            sectionSelect.innerHTML = '<option>Failed to load sections</option>';
        });
}

function fetch_Q_Subjects(semesterId, sectionId) {
    if (!semesterId || !sectionId) {
        console.error('Semester and Section ID are missing');
        return;
    }

    console.log("Fetching subjects for Semester:", semesterId, "Section:", sectionId);

    fetch(`backend/get_sub_subjects.php?semester=${semesterId}&section=${sectionId}`)
        .then(response => response.json())
        .then(data => {
            const subjectSelect = document.getElementById('quizSubjectSelect');
            subjectSelect.innerHTML = ''; // Clear old options

            if (data.status === 'success' && data.subjects.length > 0) {
                // Create default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Subject';
                subjectSelect.appendChild(defaultOption);

                // Populate the dropdown with subjects
                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.SubId;
                    option.textContent = subject.SubName;
                    subjectSelect.appendChild(option);
                });

                // Add event listener for subject selection
                subjectSelect.addEventListener('change', function() {
                    const subjectId = this.value;
                    console.log("Subject selected:", subjectId);

                    if (subjectId) {
                        // Fetch OfferId based on Semester, Section, and Subject using getOfferIdFromDropdown
                        fetchOfferIdFromBackend();
                    }
                });

            } else {
                subjectSelect.innerHTML = '<option>No subjects found</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching subjects:', error);
            const subjectSelect = document.getElementById('quizSubjectSelect');
            subjectSelect.innerHTML = '<option>Failed to load subjects</option>';
        });
}



let quizzes = {}; // Store quizzes

function addQuiz() {
    // Get the values from the form fields
    const semester = document.getElementById('quizSemesterSelect').value;
    const section = document.getElementById('quizSectionSelect').value;
    const subject = document.getElementById('quizSubjectSelect').value;

    // Validate the selections
    if (!semester || !section || !subject) {
        alert("Please select all the fields (Semester, Section, Subject) before proceeding.");
        return; // Prevent form submission if validation fails
    }

    // Proceed with the rest of the functionality if validation is passed
    document.getElementById('quizForm').classList.remove('hidden');
    // document.getElementById('quizzesSection').classList.add('hidden');

    // Call the fetchOfferId function to get the OfferId
    fetchOfferIdFromBackend()
}

// Function to add a question
function addQuestion() {
    const container = document.getElementById("questionsContainer");
    const questionIndex = container.children.length;

    const questionDiv = document.createElement("div");
    questionDiv.classList.add("question-block");
    questionDiv.innerHTML = `
        <label>Question ${questionIndex + 1}:</label>
        <input type="text" class="questionText" required minlength="10" placeholder="Enter a meaningful question">
        <p class="error-message"></p>

        <label>Options:</label><br>
        A) <input type="text" class="optionA" required placeholder="Option A">
        <p class="error-message"></p>
        B) <input type="text" class="optionB" required placeholder="Option B">
        <p class="error-message"></p>
        C) <input type="text" class="optionC" required placeholder="Option C">
        <p class="error-message"></p>
        D) <input type="text" class="optionD" required placeholder="Option D">
        <p class="error-message"></p>

        <label>Correct Answer (A/B/C/D):</label>
        <input type="text" class="correctAnswer" maxlength="1" placeholder="A/B/C/D">
        <p class="error-message"></p>
    `;

    container.appendChild(questionDiv);

    if (container.children.length === 1) {
        insertRemoveQuestionButton();
}
}
// Function to insert remove question button
function insertRemoveQuestionButton() {
    let removeButton = document.createElement("button");
    removeButton.innerText = "Remove Question";
    removeButton.id = "removeQuestionBtn";
    removeButton.onclick = removeQuestion;
    
    let addQuestionButton = document.getElementById("addQuestionBtn");

    // Insert "Remove Question" button between "Add Question" and "Save Quiz"
    addQuestionButton.insertAdjacentElement("afterend", removeButton);
}

// Function to remove a question
function removeQuestion() {
    const container = document.getElementById("questionsContainer");

    if (container.children.length > 0) {
        container.lastChild.remove();
    }

    if (container.children.length === 0) {
        document.getElementById("removeQuestionBtn").remove();
        document.getElementById("questionError").innerText = "At least one question is required.";
    }
}

// Function to validate quiz inputs
function validateQuizInputs(title, marks, timer) {
    let isValid = true;
    const titleRegex = /^[a-zA-Z0-9\s]+$/;

    document.querySelectorAll(".error-message").forEach(msg => msg.innerText = "");

    // Validate Quiz Title
    if (!title || !title.match(titleRegex)) {
        const titleErrorElement = document.getElementById("quizTitleError");
        if (titleErrorElement) titleErrorElement.innerText = "Quiz title must contain only alphabets and numbers.";
        isValid = false;
    }

    // Validate Marks
    if (!marks || isNaN(marks) || marks <= 0 || marks > 100) {
        const marksErrorElement = document.getElementById("quizMarksError");
        if (marksErrorElement) marksErrorElement.innerText = "Please enter valid quiz marks (1-100).";
        isValid = false;
    }

    // Validate Timer
    if (!timer || isNaN(timer) || timer <= 0) {
        const timerErrorElement = document.getElementById("quizTimerError");
        if (timerErrorElement) timerErrorElement.innerText = "Please enter a valid time limit (at least 1 minute).";
        isValid = false;
    }

    // Validate Questions
    const questionBlocks = document.querySelectorAll(".question-block");
    if (questionBlocks.length === 0) {
        const questionErrorElement = document.getElementById("questionError");
        if (questionErrorElement) questionErrorElement.innerText = "At least one question is required.";
        isValid = false;
    }

    questionBlocks.forEach((questionBlock) => {
        const questionText = questionBlock.querySelector(".questionText");
        const options = {
            A: questionBlock.querySelector(".optionA"),
            B: questionBlock.querySelector(".optionB"),
            C: questionBlock.querySelector(".optionC"),
            D: questionBlock.querySelector(".optionD"),
        };
        const correctAnswer = questionBlock.querySelector(".correctAnswer");

        // Question Text
        if (!questionText.value || questionText.value.length < 10) {
            questionText.nextElementSibling.innerText = "Question must be at least 10 characters.";
            isValid = false;
        }

        // Options
        Object.keys(options).forEach(key => {
            if (!options[key].value.trim()) {
                options[key].nextElementSibling.innerText = `Option ${key} is required.`;

                isValid = false;
            }
        });

        // Correct Answer
        if (!["A", "B", "C", "D"].includes(correctAnswer.value.trim().toUpperCase())) {
            correctAnswer.nextElementSibling.innerText = "Correct answer must be A, B, C, or D.";
            isValid = false;
        }
    });

    return isValid;
}

let selectedOfferId = null;  // Declare this globally or at the beginning of the script

function fetchOfferIdFromBackend() {
    const semesterId = document.getElementById("quizSemesterSelect").value;
    const sectionId = document.getElementById("quizSectionSelect").value;
    const subjectId = document.getElementById("quizSubjectSelect").value;

    if (semesterId && sectionId && subjectId) {
        fetch(`backend/get_offer_id.php?semester=${semesterId}&section=${sectionId}&subject=${subjectId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    selectedOfferId = data.offerId;  // Save the OfferId globally
                    console.log("OfferId fetched successfully:", selectedOfferId);
                } else {
                    alert("Failed to fetch OfferId: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching OfferId:', error);
                alert("Error fetching OfferId. Please try again.");
            });
    } else {
        alert("Please select Semester, Section, and Subject.");
    }
}

function getOfferIdFromDropdown() {
    console.log("OfferId in frontend:", selectedOfferId);
    console.log("Getting OfferId:", selectedOfferId);  // Log before returning
    return selectedOfferId;  // Return the globally stored OfferId
}


function saveQuiz() {
    const title = document.getElementById("quizTitle").value;
    const marks = document.getElementById("quizMarks").value;
    const timer = document.getElementById("quizTimer").value;
    const offerId = getOfferIdFromDropdown();  // Get OfferId from the selected semester, section, and subject

    console.log("OfferId in frontend:", offerId); // Check if OfferId is correctly fetched

    // Collect all questions from the form
    const questions = [];
    const questionElements = document.querySelectorAll(".question-block");

    questionElements.forEach((questionElement) => {
        const questionText = questionElement.querySelector(".questionText").value;
        const optionA = questionElement.querySelector(".optionA").value;
        const optionB = questionElement.querySelector(".optionB").value;
        const optionC = questionElement.querySelector(".optionC").value;
        const optionD = questionElement.querySelector(".optionD").value;
        const correctAnswer = questionElement.querySelector(".correctAnswer").value;  // A, B, C, or D

        questions.push({
            text: questionText,
            options: { A: optionA, B: optionB, C: optionC, D: optionD },
            correctAnswer: correctAnswer
        });
    });

    // Validate Quiz Inputs
    const isValid = validateQuizInputs(title, marks, timer, questions);

    if (!isValid) {
        console.log("Form validation failed. Please correct the errors.");
        return;  // Stop the form submission if validation fails
    }

    // OfferId Validation
    if (!offerId) {
        alert('Please select a valid offer for the quiz.');
        return;
    }

    // Create quizData object
    const quizData = {
        title: title,
        marks: marks,
        timer: timer,
        offerId: offerId,
        questions: questions
    };

    // If editing an existing quiz (update scenario)
    if (window.currentEditQuiz) {
        // No need to fetch quizId now, offerId se update hoga
        fetch('backend/update_quiz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(quizData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert('Quiz updated successfully!');
                resetErrorMessages();
                window.currentEditQuiz = null;  // Reset after update
                fetchAndDisplayQuizzes();  // Refresh quizzes list
            } else {
                alert('Failed to update quiz: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating quiz:', error);
            alert('An error occurred while updating the quiz. Please try again.');
        });

    } else {
        // Save new quiz scenario
        fetch('backend/save_quiz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(quizData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert('Quiz saved successfully!');
                resetErrorMessages();
                fetchAndDisplayQuizzes();  // Refresh quiz list
            } else {
                alert('Failed to save quiz: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error saving quiz:', error);
            alert('An error occurred while saving the quiz. Please try again.');
        });
    }
}





function resetErrorMessages() {
    document.querySelectorAll(".error-message").forEach(msg => {
        msg.innerText = "";
    });

    // Quiz Title, Marks, Timer errors bhi clear karo
    const titleError = document.getElementById("quizTitleError");
    const marksError = document.getElementById("quizMarksError");
    const timerError = document.getElementById("quizTimerError");
    const questionError = document.getElementById("questionError");

    if (titleError) titleError.innerText = "";
    if (marksError) marksError.innerText = "";
    if (timerError) timerError.innerText = "";
    if (questionError) questionError.innerText = "";
}


function displayQuizzes(quizzes) {
    const container = document.getElementById("quizzesContainer");
    container.innerHTML = "";  // Clear any previous content

    // Check if data is empty
    if (Object.keys(quizzes).length === 0) {
        container.innerHTML = "<p>No quizzes available.</p>";
        return;
    }

    // Iterate through the quizzes object
    for (let key in quizzes) {
        quizzes[key].forEach((quiz, index) => {
            let quizDiv = document.createElement("div");
            quizDiv.classList.add("quiz-card");
            console.log(quiz.offerId);
            // Render quiz details
            quizDiv.innerHTML = `
                <h3>${quiz.title}</h3>
                <p><strong>Semester:</strong> ${quiz.semester}</p>
                <p><strong>Section:</strong> ${quiz.section}</p>
                <p><strong>Subject:</strong> ${quiz.subject}</p>
                <p><strong>Marks:</strong> ${quiz.marks}</p>
                <p><strong>Time Limit:</strong> ${quiz.timer} min</p>
               
            `;

            // Append quiz to the container
            container.appendChild(quizDiv);
        });
    }

    // Show the quiz list container if it's hidden
    document.getElementById("quizList").classList.remove("hidden");
}



function fetchAndDisplayQuizzes() {
    fetch('backend/get_quizzes.php') // Replace with your PHP file path
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();  // Parse JSON response
        })
        .then(quizzes => {
            console.log("Fetched quizzes:", quizzes);  // Log data to see if it's correct
            displayQuizzes(quizzes);
        })
        .catch(error => {
            console.error('Error fetching quizzes:', error);
            alert('Failed to load quizzes. Please try again.');
        });
}

// function updateQuiz(offerId) {
//     // Instead of using quizId, fetch quiz data using offerId
//     const quiz = findQuizByOfferId(offerId);  // Fetch the quiz data using offerId
//     if (quiz) {
//         fillFormWithQuizData(quiz);  // Fill the form with the existing quiz data
//         window.currentEditQuiz = { offerId };  // Set the offerId for editing
//     } else {
//         alert('No quiz found for the selected offer.');
//     }
// }

// // Function to find the quiz based on offerId
// function findQuizByOfferId(offerId) {
//     for (let key in quizzes) {
//         for (let quiz of quizzes[key]) {
//             if (quiz.offerId === offerId) {
//                 return quiz;  // Return the quiz that matches the offerId
//             }
//         }
//     }
//     return null;  // Return null if no matching quiz is found
// }

// function fillFormWithQuizData(quizData) {
//     document.getElementById("quizTitle").value = quizData.title;
//     document.getElementById("quizMarks").value = quizData.marks;
//     document.getElementById("quizTimer").value = quizData.timer;

//     const questionsContainer = document.getElementById("questionsContainer");
//     questionsContainer.innerHTML = '';  // Clear any existing questions

//     quizData.questions.forEach((question, index) => {
//         const questionDiv = document.createElement("div");
//         questionDiv.classList.add("question-block");
//         questionDiv.innerHTML = `
//             <label>Question ${index + 1}:</label>
//             <input type="text" class="questionText" value="${question.text}" required minlength="10">
//             <p class="error-message"></p>

//             <label>Options:</label><br>
//             A) <input type="text" class="optionA" value="${question.options.A}" required>
//             <p class="error-message"></p>
//             B) <input type="text" class="optionB" value="${question.options.B}" required>
//             <p class="error-message"></p>
//             C) <input type="text" class="optionC" value="${question.options.C}" required>
//             <p class="error-message"></p>
//             D) <input type="text" class="optionD" value="${question.options.D}" required>
//             <p class="error-message"></p>

//             <label>Correct Answer (A/B/C/D):</label>
//             <input type="text" class="correctAnswer" value="${question.correctAnswer}" maxlength="1">
//             <p class="error-message"></p>
//         `;
//         questionsContainer.appendChild(questionDiv);
//     });
// }


// function resetForm() {
//     document.getElementById("quizTitle").value = '';
//     document.getElementById("quizMarks").value = '';
//     document.getElementById("quizTimer").value = '';
//     document.getElementById("questionsContainer").innerHTML = '';
// }



// function removeQuiz(offerId) {
//     // Confirm deletion
//     const confirmation = confirm("Are you sure you want to delete this quiz?");
//     if (!confirmation) return;

//     // Send delete request to the backend
//     fetch(`backend/delete_quiz.php?offerId=${offerId}`, {
//         method: 'DELETE',  // Use DELETE method for removing the quiz
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === "success") {
//             alert("Quiz removed successfully!");
//             fetchAndDisplayQuizzes();  // Refresh quizzes list after deletion
//         } else {
//             alert("Failed to delete quiz: " + data.message);
//         }
//     })
//     .catch(error => {
//         console.error("Error deleting quiz:", error);
//         alert("Error deleting quiz. Please try again.");
//     });
// }




// Define loadAttendanceFilters function
function loadAttendanceFilters() {
    // Clear previous selections
    document.getElementById('attendanceSectionSelect').innerHTML = '<option value="">Select Section</option>';
    document.getElementById('attendanceSubjectSelect').innerHTML = '<option value="">Select Subject</option>';
    document.getElementById('attendanceDate').value = ''; // clear date
    document.getElementById('attendanceTableBody').innerHTML = ''; // clear students
    document.getElementById('studentsList').classList.add('hidden'); // hide students list
    document.getElementById('attendanceSummary').classList.add('hidden'); // hide summary
    loadSections(); // Load Sections directly
}

// Load Sections
function loadSections() {
    fetch('backend/get_sections.php')
        .then(response => response.json())
        .then(data => {
            const sectionSelect = document.getElementById('attendanceSectionSelect');
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (data.status === 'success') {
                data.sections.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.SectionId;
                    option.textContent = section.SectionName;
                    sectionSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading sections:', error);
        });
}

// Load Subjects when Section is selected
document.getElementById('attendanceSectionSelect').addEventListener('change', function () {
    const sectionId = this.value;
    const subjectSelect = document.getElementById('attendanceSubjectSelect');
    subjectSelect.innerHTML = '<option value="">Select Subject</option>';

    if (sectionId) {
        fetch(`backend/get_subjects.php?section=${sectionId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    data.subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.SubId;
                        option.textContent = `${subject.SubName}`;
                        subjectSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading subjects:', error);
            });
    }
});

// Load Students on OK button click
function loadStudents() {
    const sectionId = document.getElementById('attendanceSectionSelect').value;
    const subjectId = document.getElementById('attendanceSubjectSelect').value;
    const attendanceDate = document.getElementById('attendanceDate').value;

    if (!sectionId || !subjectId || !attendanceDate) {
        alert('Please select section, subject, and date first.');
        return;
    }

    const formData = new FormData();
    formData.append('section', sectionId);
    formData.append('subject', subjectId);

    fetch('backend/get_students.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('attendanceTableBody');
            tableBody.innerHTML = '';

            if (data.students.length > 0) {
                data.students.forEach(student => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${student.StuId}</td>
                    <td>${student.StuName}</td>
                    <td>
                        <input type="radio" id="present_${student.StuId}" name="attendance_${student.StuId}" value="present" required>
                        <label for="present_${student.StuId}">Present</label>
                        
                        <input type="radio" id="absent_${student.StuId}" name="attendance_${student.StuId}" value="absent">
                        <label for="absent_${student.StuId}">Absent</label>
            
                        <input type="radio" id="leave_${student.StuId}" name="attendance_${student.StuId}" value="leave">
                        <label for="leave_${student.StuId}">Leave</label>
                    </td>
                `;
                    tableBody.appendChild(tr);
                });

                document.getElementById('studentsList').classList.remove('hidden');
            } else {
                alert('No students found for the selected section and subject.');
                document.getElementById('studentsList').classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error loading students:', error);
        });
}

// Submit Attendance
function submitAttendance() {
    const sectionId = document.getElementById('attendanceSectionSelect').value;
    const subjectId = document.getElementById('attendanceSubjectSelect').value;
    const attendanceDate = document.getElementById('attendanceDate').value;

    if (!sectionId || !subjectId || !attendanceDate) {
        alert('Please select section, subject, and date first.');
        return;
    }

    const attendanceData = [];
    const rows = document.querySelectorAll('#attendanceTableBody tr');

    // Validate if all students are marked
    for (const row of rows) {
        const studentId = row.children[0].textContent.trim();
        const selectedAttendance = document.querySelector(`input[name="attendance_${studentId}"]:checked`);

        if (!selectedAttendance) {
            alert(`Please mark attendance for student ID: ${studentId}`);
            return;
        }

        attendanceData.push({
            studentId: studentId,
            status: selectedAttendance.value
        });
    }

    // Now send to server
    const formData = new FormData();
    formData.append('section', sectionId);
    formData.append('subject', subjectId);
    formData.append('date', attendanceDate);
    formData.append('attendance', JSON.stringify(attendanceData));

    fetch('backend/save_attendance.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Attendance marked successfully!');
                loadAttendanceSummary(); // Load updated summary
            } else {
                alert('Error saving attendance.');
            }
        })
        .catch(error => {
            console.error('Error submitting attendance:', error);
        });
}

// Load Attendance Summary
function loadAttendanceSummary() {
    const sectionId = document.getElementById('attendanceSectionSelect').value;
    const subjectId = document.getElementById('attendanceSubjectSelect').value;

    if (!sectionId || !subjectId) {
        return;
    }

    const formData = new FormData();
    formData.append('section', sectionId);
    formData.append('subject', subjectId);

    fetch('backend/get_attendance_summary.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const summaryBody = document.getElementById('summaryTableBody');
            summaryBody.innerHTML = '';

            if (data.status === 'success') {
                document.getElementById('attendanceSummary').classList.remove('hidden');

                data.records.forEach(record => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${record.ClassName}</td>
                    <td>${record.Date}</td>
                    <td>${record.TotalPresent}</td>
                    <td>${record.Percentage}%</td>
                    <td>
                       
                     <button onclick="updateAttendance('${record.AttendanceGroupId}')">Update</button>
                        <button onclick="deleteAttendance('${record.AttendanceGroupId}')">Delete</button>

                    </td>
                `;
                    summaryBody.appendChild(tr);
                });
            }
        })
        .catch(error => {
            console.error('Error loading attendance summary:', error);
        });
}


function deleteAttendance(attendanceGroupId) {
    if (!confirm('Are you sure you want to delete this attendance record?')) {
        return;
    }

    const sectionId = document.getElementById('attendanceSectionSelect').value;
    const subjectId = document.getElementById('attendanceSubjectSelect').value;

    if (!sectionId || !subjectId || !attendanceGroupId) {
        alert('Missing information for delete request.');
        return;
    }

    const formData = new FormData();
    formData.append('attendanceGroupId', attendanceGroupId.toString()); // make sure it's a string
    formData.append('section', sectionId.toString());
    formData.append('subject', subjectId.toString());

    fetch('backend/delete_attendance.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Attendance deleted successfully.');
                loadAttendanceSummary();
            } else {
                alert('Error deleting attendance: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting attendance:', error);
        });
}

// New updateAttendance function
function updateAttendance(attendanceGroupId) {
    if (!confirm('Are you sure you want to update this attendance record?')) {
        return;
    }

    const sectionId = document.getElementById('attendanceSectionSelect').value;
    const subjectId = document.getElementById('attendanceSubjectSelect').value;

    if (!sectionId || !subjectId || !attendanceGroupId) {
        alert('Missing information for update request.');
        return;
    }

    // Step 1: Clear previous selections (radio buttons)
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.checked = false;
    });

    // Step 2: Fetch students and their old attendance to refill
    const formData = new FormData();
    formData.append('attendanceGroupId', attendanceGroupId);
    formData.append('section', sectionId);
    formData.append('subject', subjectId);

    fetch('backend/get_attendance_for_update.php', { // You'll create this PHP file
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Show students dynamically with radio buttons (Present/Absent)
                const studentsTable = document.getElementById('studentsTableBody');
                studentsTable.innerHTML = ''; // Clear previous students list

                data.students.forEach(student => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${student.StudentName}</td>
                    <td>
                        <input type="radio" name="attendance_${student.StudentEnrollId}" value="Present" ${student.AttendanceStatus === 'Present' ? 'checked' : ''}> Present
                        <input type="radio" name="attendance_${student.StudentEnrollId}" value="Absent" ${student.AttendanceStatus === 'Absent' ? 'checked' : ''}> Absent
                    </td>
                `;
                    studentsTable.appendChild(tr);
                });

                // Step 3: Change Submit Button functionality to UPDATE mode
                const submitButton = document.getElementById('submitAttendanceButton');
                submitButton.innerText = 'Update Attendance';
                submitButton.onclick = function () {
                    submitUpdatedAttendance(attendanceGroupId);
                };

            } else {
                alert('Failed to load students for update.');
            }
        })
        .catch(error => {
            console.error('Error fetching attendance for update:', error);
        });
}

// Function to submit updated attendance
function submitUpdatedAttendance(attendanceGroupId) {
    const rows = document.querySelectorAll('#studentsTableBody tr');
    const attendanceData = [];

    rows.forEach(row => {
        const studentName = row.querySelector('td:first-child').innerText;
        const studentIdInputName = row.querySelector('input[type="radio"]').name;
        const studentId = studentIdInputName.split('_')[1]; // attendance_5 => 5
        const selectedStatus = row.querySelector(`input[name="attendance_${studentId}"]:checked`);

        if (selectedStatus) {
            attendanceData.push({
                studentEnrollId: studentId,
                status: selectedStatus.value
            });
        }
    });

    if (attendanceData.length === 0) {
        alert('Please mark attendance for students.');
        return;
    }

    const formData = new FormData();
    formData.append('attendanceGroupId', attendanceGroupId);
    formData.append('attendanceData', JSON.stringify(attendanceData));

    fetch('backend/update_attendance.php', { // New PHP file to update attendance
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Attendance updated successfully.');
                loadAttendanceSummary();
                // Reset the Submit Button
                const submitButton = document.getElementById('submitAttendanceButton');
                submitButton.innerText = 'Submit Attendance';
                submitButton.onclick = submitAttendance; // Old function for fresh attendance
            } else {
                alert('Error updating attendance: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating attendance:', error);
        });
}










let attendanceChart;

function setupReportsSection() {
    // Button listeners
    document.getElementById("generateReportBtn").addEventListener("click", generateReport);
    document.getElementById("downloadReportBtn").addEventListener("click", generatePDF);

    // Fetch sections and subjects dynamically when Reports section is opened
    fetchSections();  // Initial fetch to load sections

    // Listen to changes in section dropdown and fetch subjects accordingly
    document.getElementById("reportSection").addEventListener("change", function () {
        const sectionId = this.value;  // Get the selected section ID
        if (sectionId) {
            fetchSubjects(sectionId);  // Fetch subjects based on selected section
        } else {
            console.log("Please select a section.");
        }
    });
}

function fetchSections() {
    fetch('backend/get_sections.php')  // 🔥 Tumhari existing file
        .then(response => response.json())
        .then(data => {
            const sectionDropdown = document.getElementById("reportSection");
            sectionDropdown.innerHTML = '<option value="">Select Section</option>';

            if (data.status === 'success') {
                data.sections.forEach(section => {
                    const option = document.createElement("option");
                    option.value = section.SectionId;
                    option.textContent = section.SectionName;
                    sectionDropdown.appendChild(option);
                });
            } else {
                console.error("Failed to fetch sections:", data.message);
            }
        })
        .catch(error => {
            console.error("Error fetching sections:", error);
        });
}

function fetchSubjects(sectionId) {
    // Ensure sectionId is valid before making request
    if (!sectionId) {
        console.error("Section ID is missing.");
        return;
    }

    let url = 'backend/get_subjects.php?section=' + sectionId;  // Pass sectionId as parameter

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const subjectDropdown = document.getElementById("reportSubject");
            subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

            if (data.status === 'success') {
                data.subjects.forEach(subject => {
                    const option = document.createElement("option");
                    option.value = subject.SubId;
                    option.textContent = subject.SubName;
                    subjectDropdown.appendChild(option);
                });
            } else {
                console.error("Failed to fetch subjects:", data.message);
            }
        })
        .catch(error => {
            console.error("Error fetching subjects:", error);
        });
}




function generateReport() {
    const section = document.getElementById("reportSection").value;
    const subject = document.getElementById("reportSubject").value;

    // Validate if both section and subject are selected
    if (!section || !subject) {
        alert("Please select Section and Subject to generate a report.");
        return;
    }

    // Fetch data from backend
    fetch('backend/fetch_attendance_report.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ section: section, subject: subject })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status && data.status === 'error') {
                alert(`Error: ${data.message}`);
                return;
            }

            if (data.records.length === 0) {
                alert("No attendance records found for the selected criteria.");
                return;
            }

            const dates = data.records.map(record => record.date);
            const statuses = data.records.map(record => record.status);
            const presencePercentage = data.presencePercentage;

            // Display the presence percentage (you can also display the total and present days if needed)
            alert(`Presence Percentage: ${presencePercentage}%`);

            // Update chart with the attendance data
            updateChart(dates, statuses);

        })
        .catch(error => {
            console.error("Error fetching attendance data:", error);
            alert("There was an error fetching the attendance data.");
        });
}

function updateChart(dates, statuses) {
    const ctx = document.getElementById("attendanceChart").getContext("2d");

    if (attendanceChart) {
        attendanceChart.destroy();
    }

    const presentDays = statuses.filter(status => status === 'present').length;
    const absentDays = statuses.filter(status => status === 'absent').length;

    attendanceChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: dates,
            datasets: [{
                label: "Attendance",
                data: [presentDays, absentDays],
                backgroundColor: [
                    "rgba(108, 92, 231, 0.8)",
                    "rgba(136, 84, 208, 0.8)"
                ],
                borderColor: "#333",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text(`Attendance Report`, 10, 10);

    const canvas = document.getElementById("attendanceChart");

    setTimeout(() => {
        const imgData = canvas.toDataURL("image/png");
        doc.addImage(imgData, "PNG", 10, 20, 180, 80);
        doc.save("Attendance_Report.pdf");
        alert("Attendance report downloaded!");
    }, 500);
}




function setupFeedbackReport() {
    // No need for generateReportBtn and downloadReportBtn because feedback has different buttons
    fetchFeedbackSections();

    document.getElementById("feedbackSectionSelect").addEventListener("change", function () {
        const sectionId = this.value;
        if (sectionId) {
            fetchFeedbackSubjects(sectionId);
        }
    });
}

function fetchFeedbackSections() {
    fetch('backend/get_sections.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const sectionSelect = document.getElementById("feedbackSectionSelect");
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                data.sections.forEach(section => {
                    const option = document.createElement("option");
                    option.value = section.SectionId;
                    option.textContent = section.SectionName;
                    sectionSelect.appendChild(option);
                });
            } else {
                alert('Failed to fetch sections');
            }
        })
        .catch(error => console.error('Error fetching sections:', error));
}

function fetchFeedbackSubjects(sectionId) {
    fetch('backend/get_subjects.php?section=' + sectionId)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const subjectSelect = document.getElementById("feedbackSubject");
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                data.subjects.forEach(subject => {
                    const option = document.createElement("option");
                    option.value = subject.SubId;
                    option.textContent = subject.SubName;
                    subjectSelect.appendChild(option);
                });
            } else {
                alert('Failed to fetch subjects');
            }
        })
        .catch(error => console.error('Error fetching subjects:', error));
}

function generateFeedback() {
    const sectionId = document.getElementById("feedbackSectionSelect").value;
    const subjectId = document.getElementById("feedbackSubject").value;


    if (!sectionId || !subjectId) {
        alert("Please select both section and subject.");
        return;
    }

    fetch(`backend/get_survey_feedback.php?section=${sectionId}&subject=${subjectId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const positive = data.feedback.positive;
                const negative = data.feedback.negative;

                const ctx = document.getElementById("feedbackChart").getContext("2d");


                // Clear previous chart if exists
                if (window.feedbackChartInstance) {
                    window.feedbackChartInstance.destroy();
                }

                // Create a new doughnut chart
                window.feedbackChartInstance = new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: ["Positive Feedback", "Negative Feedback"],
                        datasets: [{
                            data: [positive, negative],
                            backgroundColor: ["rgba(190, 144, 212, 0.8)", "rgba(136, 84, 208, 0.8)"],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                // Show overall feedback stats
                document.getElementById("overallFeedback").innerHTML =
                    `Overall Positive Feedback: ${positive}%<br>Overall Negative Feedback: ${negative}%`;
            } else {
                alert('Error fetching feedback data: ' + data.message);
            }
        })
        .catch(error => console.error('Error fetching feedback data:', error));
}

function downloadFeedbackPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'px',   // px use karo instead of mm or pt
        format: [600, 900] // large enough canvas
    });

    const canvas = document.getElementById("feedbackChart");

    if (!canvas) {
        alert("Feedback chart not found!");
        return;
    }

    // High-quality image from canvas
    const imgData = canvas.toDataURL("image/png", 1.0); // 1.0 = best quality

    // Title
    doc.setFontSize(22);
    doc.text('Student Feedback Report', 40, 40);

    // Image
    doc.addImage(imgData, "PNG", 50, 60, 500, 300); // adjust image size properly

    doc.save("Feedback_Report.pdf");
    alert("Feedback report downloaded!");
}





//Articles
function openArticle(url) {
    window.location.href = url;
}

document.getElementById("logoutBtn").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior

    // Send request to backend for logout
    fetch('backend/logout.php') // Make sure the correct path is provided to logout.php
        .then(response => response.json())
        .then(data => {
            if (data.status === 'logged_out') {
                // Clear session storage/local storage (if used)
                sessionStorage.clear();
                localStorage.removeItem("userToken"); // Remove token if stored

                // Redirect to login page
                window.location.href = "Teacher_Login.html"; // Redirect to login page
            } else {
                // Handle error, if any
                console.error('Logout failed:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});



// RESPONSIVE
// HAMBURGER
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const overlay = document.getElementById("overlay");

    // Open Sidebar when Clicking Hamburger
    menuToggle.addEventListener("click", function () {
        sidebar.classList.add("show");
        overlay.classList.add("show");
    });

    // Close Sidebar when Clicking Close Button
    closeSidebar.addEventListener("click", function () {
        sidebar.classList.remove("show");
        overlay.classList.remove("show");
    });

    // Close Sidebar when Clicking Outside (But Allow Clicking Inside)
    overlay.addEventListener("click", function () {
        sidebar.classList.remove("show");
        overlay.classList.remove("show");
    });

    // Prevent Sidebar from Closing When Clicking on Sidebar Links
    sidebar.addEventListener("click", function (event) {
        event.stopPropagation(); // Stops the click from closing the sidebar
    });
});

// LEADERBOARD