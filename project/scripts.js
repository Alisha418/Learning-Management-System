document.addEventListener("DOMContentLoaded", function () {
  

    let thankYouCard = document.getElementById("thankYouCard");
    if (thankYouCard) {
        thankYouCard.remove();
    }
    window.loadPage = function(event, page) {
        event.preventDefault();
        console.log("Loading page:", page);
    
        document.getElementById("content-area").innerHTML = "<p>Loading...</p>"; // Optional loader
       
    
        fetch(page)
            .then(response => {
                console.log("Response Status:", response.status);
                if (!response.ok) throw new Error("Page not found");
                return response.text();
            })
            .then(html => {
                const contentArea = document.getElementById("content-area");
                contentArea.innerHTML = html;
              
                // Optional: Re-run any dynamic JS functions like charts
                if (typeof initializeCharts === 'function') {
                    initializeCharts();
                }
            })
            .catch(error => {
                document.getElementById("content-area").innerHTML = "<h2>Page not found</h2>";
                console.error("Error loading page:", error);
            });
    };
  
    loadPage({ preventDefault: () => {} }, "dash.php"); 
    window.loadQuiz = function(quizId) {
        // Show a loading message or spinner while waiting for the response
        document.getElementById('content-area').innerHTML = "<p>Loading quiz...</p>";
        
        // Use fetch to dynamically load the content from loadquiz.php
        fetch('loadquiz.php?quiz_id=' + quizId)
            .then(response => {
                // Check if the response is OK (status code 200)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                // Update the content area with the content from loadquiz.php
                document.getElementById('content-area').innerHTML = html;
                // Check if timeLimit element exists, then start the timer
            if (document.getElementById('timeLimit')) {
                startTimer();  // Call the startTimer function
            }
            })
            .catch(error => {
                // Handle any errors and show a message
                document.getElementById('content-area').innerHTML = "<p>Error loading quiz. Please try again later.</p>";
                console.error('Error loading quiz:', error);
            });
    }
    window.loadQuizList= function() {
        const contentArea = document.getElementById('content-area');
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'start_quiz.php', true);  // Make a GET request to start_quiz.php
        xhr.onload = function() {
            if (xhr.status === 200) {
                contentArea.innerHTML = xhr.responseText;  // Insert the page content into content-area
            } else {
                console.error('Failed to load quiz list page');
                contentArea.innerHTML = 'Failed to load content.';
            }
        };
        xhr.onerror = function() {
            console.error('An error occurred while loading the page.');
            contentArea.innerHTML = 'Error loading content.';
        };
        xhr.send();  // Send the AJAX request
    }
    
    
    // Function to start the timer
function startTimer() {
    let timeLeft = parseInt(document.getElementById("timeLimit").value, 10);  // Get time limit from hidden input

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);  // Calculate minutes
        let seconds = timeLeft % 60;  // Calculate seconds

        // Update the timer display
        document.getElementById("timer").textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft > 0) {
            timeLeft--;  // Decrease time by 1 second
        } else {
            clearInterval(timerInterval);  // Stop the timer when time is up
            alert("Time's up! Submitting quiz...");
            document.getElementById("quizForm").submit();  // Submit the quiz form
        }
    }

    let timerInterval = setInterval(updateTimer, 1000);  // Update the timer every second
}

   
function initializeCharts() {
    document.querySelectorAll("canvas").forEach((canvas) => {
        if (!canvas.dataset.loaded) {
            let ctx = canvas.getContext("2d");

            if (canvas.id === "attendanceChart") {
                let data = JSON.parse(canvas.dataset.attendance);
                let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, "rgba(108, 92, 231, 0.5)");
                gradient.addColorStop(1, "rgba(108, 92, 231, 0)");

                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Attendance (%)",
                            data: data,
                            borderColor: "#6c5ce7",
                            backgroundColor: gradient,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { bottom: 20 }},
                        scales: {
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    font: { size: window.innerWidth < 500 ? 10 : 12 }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    font: { size: window.innerWidth < 500 ? 10 : 12 },
                                    callback: (value) => value + "%"
                                }
                            }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            } 
            else if (canvas.id === "quizChart") {
                let subjects = JSON.parse(canvas.dataset.subjects);
                let scores = JSON.parse(canvas.dataset.scores);

                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: subjects,
                        datasets: [{
                            label: "Quiz Percentage",
                            data: scores,
                            backgroundColor: [
                                "rgba(108, 92, 231, 0.8)",
                                "rgba(136, 84, 208, 0.8)",
                                "rgba(165, 94, 234, 0.8)",
                                "rgba(190, 144, 212, 0.8)",
                                "rgba(197, 108, 240, 0.8)",
                                "rgba(118, 68, 238, 0.8)"
                            ],
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }},
                        scales: {
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    font: { size: window.innerWidth < 500 ? 10 : 12 }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    font: { size: window.innerWidth < 500 ? 10 : 12 },
                                    callback: (value) => value + "%"
                                }
                            }
                        }
                    }
                });
            }

            canvas.dataset.loaded = "true";
        }
    });
}
   
    
    window.initSearch = function() {
        let searchBox = document.getElementById("searchBox");
        let messageBox = document.getElementById("noResultsMessage");
    
        if (!searchBox) {
            console.error("❌ Search box not found! Waiting for DOM update...");
            return;
        }
    
        console.log("✅ Search box found:", searchBox);
    
        searchBox.addEventListener("input", function () {
            let query = searchBox.value.toLowerCase();
            let cards = document.querySelectorAll(".card");
            let found = false;
    
            cards.forEach(card => {
                let subject = card.getAttribute("data-subject").toLowerCase();
                if (subject.includes(query)) {
                    card.style.display = "block";
                    found = true;  // ✅ Agar card match ho gaya to found ko true kar do
                } else {
                    card.style.display = "none";
                }
            });
    
            // ✅ Agar koi result mila (found true hai) to message hata do, warna dikhao
            messageBox.style.display = found ? "none" : "block";
        });
    }
    
    // MutationObserver to detect when search box appears
    const Observer = new MutationObserver(() => {
        if (document.getElementById("searchBox")) {
            initSearch();
            Observer.disconnect(); // Stop observing after initialization
        }
    });
    
    // Start observing document body for changes
    Observer.observe(document.body, { childList: true, subtree: true });
    

  
    // ✅ Define toggleSidebar function properly
    function toggleSidebar() {
        document.querySelector(".sidebar").classList.toggle("active"); // ✅ changed 'open' to 'active'
    }
    
    // Attach function globally
    window.toggleSidebar = toggleSidebar;
    
    // Add event listener to menu button
    document.querySelector(".toggle-btn").addEventListener("click", toggleSidebar);
    
   

     


    document.querySelectorAll(".submenu > a").forEach((submenuLink) => {
        submenuLink.addEventListener("click", function (event) {
            event.preventDefault();
            let submenuItems = this.nextElementSibling;
            if (submenuItems && submenuItems.classList.contains("submenu-items")) {
                submenuItems.classList.toggle("active");
            }
        });
    });
     window.selectQuiz=function(quizNumber) {
        let dummyData = {
            1: [{ id: "101", name: "Math", marks: "85", percentage: "85%", time: "30 mins" },
                { id: "102", name: "Science", marks: "90", percentage: "90%", time: "25 mins" },
                { id: "103", name: "English", marks: "75", percentage: "75%", time: "40 mins" },
                { id: "104", name: "History", marks: "80", percentage: "80%", time: "35 mins" },
                { id: "105", name: "Islamiat", marks: "88", percentage: "88%", time: "20 mins" }],
            2: [{ id: "101", name: "Math", marks: "85", percentage: "85%", time: "30 mins" },
                { id: "102", name: "Science", marks: "90", percentage: "90%", time: "25 mins" },
                { id: "103", name: "English", marks: "75", percentage: "75%", time: "40 mins" },
                { id: "104", name: "History", marks: "80", percentage: "80%", time: "35 mins" },
                { id: "105", name: "Islamiat", marks: "88", percentage: "88%", time: "20 mins" }],
            3: [{ id: "101", name: "Math", marks: "85", percentage: "85%", time: "30 mins" },
                { id: "102", name: "Science", marks: "90", percentage: "90%", time: "25 mins" },
                { id: "103", name: "English", marks: "75", percentage: "75%", time: "40 mins" },
                { id: "104", name: "History", marks: "80", percentage: "80%", time: "35 mins" },
                { id: "105", name: "Islamiat", marks: "88", percentage: "88%", time: "20 mins" }],
            4: [{ id: "101", name: "Math", marks: "85", percentage: "85%", time: "30 mins" },
                { id: "102", name: "Science", marks: "90", percentage: "90%", time: "25 mins" },
                { id: "103", name: "English", marks: "75", percentage: "75%", time: "40 mins" },
                { id: "104", name: "History", marks: "80", percentage: "80%", time: "35 mins" },
                { id: "105", name: "Islamiat", marks: "88", percentage: "88%", time: "20 mins" }]
        };
    
        // Get the table body where we will insert data
    let resultBody = document.getElementById("result-body");

    // Clear existing data before inserting new data
    resultBody.innerHTML = "";

    // Get the selected quiz data (Array of subjects)
    let subjects = dummyData[quizNumber];

    if (subjects) {
        subjects.forEach((data) => {
            let row = `<tr>
                        <td>${data.id}</td>
                        <td>${data.name}</td>
                        <td>${data.marks}</td>
                        <td>${data.percentage}</td>
                        <td>${data.time}</td>
                      </tr>`;
            resultBody.innerHTML += row; // Append each row
        });
    }
}

    



  
   // Variables to track the current and total number of questions

   window.loadSubjects = function () {
    document.getElementById("offerSubjectsCard").style.display = "none";
    document.getElementById("subjectsTable").style.display = "block";

    const sectionId = document.getElementById("section").value;
    const sessionId = document.getElementById("session").value;

    if (sectionId && sessionId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "load_subjects.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const subjects = JSON.parse(xhr.responseText);

                if (subjects.error) {
                    alert(subjects.error);
                } else {
                    const tableBody = document.getElementById("tableBody");
                    tableBody.innerHTML = ""; // Clear previous data

                    subjects.forEach(subject => {
                        const row = document.createElement("tr");

                        const isRegistered = localStorage.getItem(subject.OfferId) === '1';

                        row.innerHTML = `
                            <td>${subject.OfferId}</td>
                            <td>${subject.SubName}</td>
                            <td>${subject.TName}</td>
                            <td>
                                <button 
                                    class="register-btn" 
                                    onclick="registerSubject(this)"
                                    style="background-color: ${isRegistered ? 'grey' : 'green'}; color: white;"
                                    ${isRegistered ? 'disabled' : ''}
                                >
                                    ${isRegistered ? 'Registered' : 'Register'}
                                </button>
                                <button 
                                    class="unregister-btn" 
                                    onclick="unregisterSubject(this)"
                                    style="background-color: ${isRegistered ? 'red' : 'grey'}; color: white;"
                                    ${isRegistered ? '' : 'disabled'}
                                >
                                    ${isRegistered ? 'Unregister' : 'Unregistered'}
                                </button>
                            </td>
                        `;

                        tableBody.appendChild(row);
                    });
                }
            }
        };

        xhr.send(`sectionId=${sectionId}&sessionId=${sessionId}`);
    } else {
        alert("Please select both section and session.");
    }
}
window.registerSubject = function (button) {
    if (confirm("Are you sure you want to register for this subject?")) {
        const row = button.closest('tr');
        const offerId = row.children[0].textContent;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "register_subject.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.responseText.trim() === "registered") {
                localStorage.setItem(offerId, '1');
                // Update buttons manually
                const registerBtn = row.querySelector('.register-btn');
                const unregisterBtn = row.querySelector('.unregister-btn');

                registerBtn.disabled = true;
                registerBtn.style.backgroundColor = 'grey';
                registerBtn.innerText = 'Registered'; // Change text

                unregisterBtn.disabled = false;
                unregisterBtn.style.backgroundColor = 'red';
                unregisterBtn.innerText = 'Unregister'; // Change text
            } else {
                alert("Failed to register: " + xhr.responseText);
            }
        };

        xhr.send("offerId=" + offerId);
    }
};
window.unregisterSubject = function (button) {
    if (confirm("Are you sure you want to unregister from this subject?")) {
        const row = button.closest('tr');
        const offerId = row.children[0].textContent;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "unregister_subject.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.responseText.trim() === "unregistered") {
                localStorage.setItem(offerId, '0');
                // Update buttons manually
                const registerBtn = row.querySelector('.register-btn');
                const unregisterBtn = row.querySelector('.unregister-btn');

                registerBtn.disabled = false;
                registerBtn.style.backgroundColor = 'green';
                registerBtn.innerText = 'Register'; // Change text

                unregisterBtn.disabled = true;
                unregisterBtn.style.backgroundColor = 'grey';
                unregisterBtn.innerText = 'Unregistered'; // Change text
            } else {
                alert("Failed to unregister. Try again.");
            }
        };

        xhr.send("offerId=" + offerId);
    }
};

window.surveySubjects = function () {
    var session = document.getElementById('session').value;
    var section = document.getElementById('section').value;

    // Hide the session and section container
    document.getElementById('feedback').style.display = 'none';

    // Create the XMLHttpRequest to fetch subjects
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_subjects.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Handle the response after the AJAX request
    xhr.onload = function () {
        if (xhr.status == 200) {
            var container = document.getElementById('subjectContainer');
            container.innerHTML = xhr.responseText; // Insert the returned HTML from PHP
            container.style.display = 'block'; // Make the subject container visible
        }
    };

    // Send the session and section data to the server
    xhr.send('session=' + encodeURIComponent(session) + '&section=' + encodeURIComponent(section));
};



var selectedSubjectId = null; 


window.fillSurvey = function(subjectId) {
    selectedSubjectId = subjectId;  // <<< Save the subjectId here
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_survey_data.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status == 200) {
            var surveyContainer = document.getElementById('surveyQuestions');
            surveyContainer.innerHTML = xhr.responseText;  // Insert the dynamic survey questions
            document.getElementById('subjectContainer').style.display = 'none'; // Hide subject container
            document.getElementById('surveyContainer').style.display = 'block'; // Show survey container
        }
    };

    xhr.send('subject_id=' + subjectId);  // Send the selected subject's ID
};
document.addEventListener('submit', function(e) {
    if (e.target && e.target.id === 'surveyForm') {
        e.preventDefault();

        var studentId = document.getElementById('student-id').value;
        var email = document.getElementById('email').value;
        var feedback = document.getElementById('feedback').value; // Correct id

        var subjectId = selectedSubjectId; // global

        // Collect survey answers
        var surveyAnswers = {};
        var radios = document.querySelectorAll('input[type="radio"]:checked');
        radios.forEach(function(radio) {
            var quesId = radio.name.replace('question_', '');
            surveyAnswers[quesId] = radio.value;
        });

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'submit_survey.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            var response = JSON.parse(xhr.responseText);
            alert(response.message);

            if (response.status === 'success') {
                document.getElementById('surveyForm').reset();
            }
        };

        xhr.send('student_id=' + encodeURIComponent(studentId) + 
                 '&subject_id=' + encodeURIComponent(subjectId) + 
                 '&feedback=' + encodeURIComponent(feedback) + 
                 '&survey_answers=' + encodeURIComponent(JSON.stringify(surveyAnswers))
        );
    }
});


  // Log to check if the form is found
});