// quiz.js

// Quiz data based on the assessment.php file
const quizzes = {
    quiz1: {
        title: "Quiz 1: Defensive Driving Scenarios",
        description: "Test your knowledge on defensive driving techniques.",
        questions: [
            {
                question: "What is the safe following distance?",
                options: ["1 second", "2 seconds", "3 seconds", "4 seconds"],
                answer: "3 seconds"
            },
            {
                question: "How do you handle a tailgater?",
                options: [
                    "Speed up to create distance",
                    "Brake suddenly to warn them",
                    "Move to another lane if possible",
                    "Ignore them and continue driving"
                ],
                answer: "Move to another lane if possible"
            },
            {
                question: "What are the key defensive driving techniques?",
                options: [
                    "Stay alert, maintain a safe distance, and anticipate hazards",
                    "Drive aggressively to avoid delays",
                    "Ignore traffic rules to save time",
                    "Focus only on your own vehicle"
                ],
                answer: "Stay alert, maintain a safe distance, and anticipate hazards"
            }
        ]
    },
    quiz2: {
        title: "Quiz 2: Vehicle Maintenance Knowledge",
        description: "Assess your understanding of vehicle maintenance.",
        questions: [
            {
                question: "How often should you check your tire pressure?",
                options: ["Daily", "Weekly", "Monthly", "Only before long trips"],
                answer: "Monthly"
            },
            {
                question: "What is the purpose of engine oil?",
                options: [
                    "To cool the engine",
                    "To lubricate engine parts",
                    "To clean the engine",
                    "All of the above"
                ],
                answer: "All of the above"
            },
            {
                question: "How do you identify a worn-out brake pad?",
                options: [
                    "By checking for squealing noises",
                    "By inspecting the brake pad thickness",
                    "By observing reduced braking performance",
                    "All of the above"
                ],
                answer: "All of the above"
            }
        ]
    },
    quiz3: {
        title: "Quiz 3: Routing Assessment",
        description: "Evaluate your routing and navigation skills.",
        questions: [
            {
                question: "What is the shortest route to your destination?",
                options: [
                    "The route with the least distance",
                    "The route with the least traffic",
                    "The route with the most scenic views",
                    "The route with the most rest stops"
                ],
                answer: "The route with the least distance"
            },
            {
                question: "How do you handle road closures?",
                options: [
                    "Turn around and go back home",
                    "Find an alternate route using a map or GPS",
                    "Wait until the roadblock is cleared",
                    "Ask other drivers for directions"
                ],
                answer: "Find an alternate route using a map or GPS"
            },
            {
                question: "What tools can you use for route planning?",
                options: [
                    "GPS devices",
                    "Navigation apps",
                    "Paper maps",
                    "All of the above"
                ],
                answer: "All of the above"
            }
        ]
    }
};

// Function to load quiz content dynamically
function showQuizContent(quizId) {
    const quiz = quizzes[quizId];
    if (!quiz) {
        alert("Quiz not found!");
        return;
    }

    // Update quiz title and description
    document.getElementById("quiz-title").textContent = quiz.title;
    document.getElementById("quiz-description").textContent = quiz.description;

    // Populate quiz questions
    const questionsList = document.getElementById("quiz-questions");
    questionsList.innerHTML = ""; // Clear previous questions
    quiz.questions.forEach((q, index) => {
        const questionItem = document.createElement("li");
        questionItem.innerHTML = `
            <p><strong>Question ${index + 1}:</strong> ${q.question}</p>
            <ul>
                ${q.options
                    .map(
                        (option, i) =>
                            `<li><label><input type="radio" name="question-${index}" value="${option}"> ${option}</label></li>`
                    )
                    .join("")}
            </ul>
        `;
        questionsList.appendChild(questionItem);
    });

    // Show quiz content and hide other sections
    document.getElementById("driver-exam-content").style.display = "none";
    document.getElementById("quiz-content").style.display = "block";
}