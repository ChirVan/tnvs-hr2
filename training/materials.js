$(document).ready(function () {
    // Group lessons by course type
    const groupedLessons = lessons.reduce((acc, lesson) => {
        if (!acc[lesson.course_type]) {
            acc[lesson.course_type] = [];
        }
        acc[lesson.course_type].push(lesson);
        return acc;
    }, {});

    // Generate course cards
    let courseCards = "";
    for (const courseType in groupedLessons) {
        courseCards += `
            <div class="course-card" data-course="${courseType}">
                <h3>${courseType.charAt(0).toUpperCase() + courseType.slice(1)}</h3>
                <p>${groupedLessons[courseType].length} Lessons Available</p>
            </div>
        `;
    }

    // Display course cards
    $("#dynamic-content").html(courseCards);

    // Handle click event on course cards
    $(".course-card").on("click", function () {
        const courseType = $(this).data("course");
        const lessons = groupedLessons[courseType];

        let lessonList = "";
        lessons.forEach((lesson, index) => {
            lessonList += `
                <div class="lesson-item" data-lesson-id="${lesson.id}">
                    <h4>${lesson.competency_program}</h4>
                    <p>${lesson.description}</p>
                    <button class="btn btn-primary view-lesson" data-id="${lesson.id}">View Lesson</button>
                </div>
            `;
        });

        const lessonContent = `
            <h3>${courseType.charAt(0).toUpperCase() + courseType.slice(1)} Lessons</h3>
            <div>${lessonList}</div>
            <button id="back-to-courses" class="btn btn-secondary">Back to Courses</button>
        `;

        $("#dynamic-content").html(lessonContent);

        // Handle "View Lesson" button click
        $(".view-lesson").on("click", function () {
            const lessonId = $(this).data("id");
            const lesson = lessons.find(l => l.id == lessonId);

            const lessonProper = `
                <h2>${lesson.competency_program}</h2>
                <div>${lesson.content}</div>
                <button id="back-to-lessons" class="btn btn-secondary">Back to Lessons</button>
            `;

            $("#dynamic-content").html(lessonProper);

            // Handle "Back to Lessons" button
            $("#back-to-lessons").on("click", function () {
                $(".course-card[data-course='" + courseType + "']").trigger("click");
            });
        });

        // Handle "Back to Courses" button
        $("#back-to-courses").on("click", function () {
            location.reload(); // Reload the page to show course cards again
        });
    });
});