document.addEventListener('DOMContentLoaded', function () {
    // Breadcrumb container
    const breadcrumbContainer = document.querySelector('.breadcrumb');

    if (!breadcrumbContainer) {
        console.error('Breadcrumb container not found!');
        return;
    }

    // Function to render breadcrumbs
    function renderBreadcrumbs(courseType) {
        let breadcrumbs = [
            { name: 'Dashboard', link: '/humanResource2/dashboard.php' },
            { name: 'Training', link: '#' },
            { name: 'Courses', link: '/humanResource2/training/courses.php' }
        ];

        if (courseType) {
            breadcrumbs.push({ name: courseType, link: '' });
        }

        // Render breadcrumbs
        breadcrumbContainer.innerHTML = breadcrumbs
            .map((breadcrumb) => {
                if (breadcrumb.link) {
                    return `<li class="breadcrumb-item"><a href="${breadcrumb.link}">${breadcrumb.name}</a></li>`;
                } else {
                    return `<li class="breadcrumb-item active" aria-current="page">${breadcrumb.name}</li>`;
                }
            })
            .join('');
    }

    // Function to load course details dynamically
    function loadCourseDetails(courseType) {
        const dynamicContent = document.getElementById('dynamic-content');
        if (!dynamicContent) {
            console.error('Dynamic content container not found!');
            return;
        }

        // Clear existing content
        dynamicContent.innerHTML = '';

        // Render breadcrumbs for the selected course
        renderBreadcrumbs(courseType);

        // Debugging: Log the courseType being passed to the fetch request
        console.log('Fetching details for courseType:', courseType);

        // Fetch course details from the server
        fetch(`/humanResource2/training/fetch_course_details.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ course: courseType }), // Use URLSearchParams for better encoding
        })
            .then(response => {
                console.log('Response status:', response.status); // Debugging line
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debugging line
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Redirect to a new file when the button is clicked
                const createLink = document.createElement('a');
                createLink.className = 'btn btn-primary mb-3 float-end';
                createLink.textContent = 'Create Program';
                createLink.href = `/humanResource2/training/add_program.php?course=${encodeURIComponent(courseType)}`;
                createLink.setAttribute('role', 'button');
                dynamicContent.appendChild(createLink);

                // Create a table for course details
                let table = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th style="width: 20%;">Competency Program</th>
                                <th style="width: 40%;">Description</th>
                                <th style="width: 10%;">Type</th>
                                <th style="width: 10%;">Content</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                // Populate table rows with data from the database
                data.forEach(row => {
                    table += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.competency_program}</td>
                            <td>${row.description}</td>
                            <td>${row.type}</td>
                            <td><a href="serve_lesson.php?id=${row.id}" target="_blank">View Lesson</a></td>
                            <td>
                                <button class="btn btn-warning" onclick="updateAction(${row.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" onclick="deleteAction(${row.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                table += `
                        </tbody>
                    </table>
                `;

                // Append table to dynamic content
                dynamicContent.innerHTML += table;
            })
            .catch(error => {
                console.error('Fetch error:', error); // Improved error logging
                alert('An error occurred while fetching course details.');
            });
    }

    // Add event listeners to course cards
    document.querySelectorAll('.course-card').forEach(card => {
        card.addEventListener('click', function () {
            const courseType = this.getAttribute('data-course');
            
            // Debugging: Log the courseType when a course card is clicked
            console.log('Course Type:', courseType);

            // Call the function to load course details
            loadCourseDetails(courseType);
        });
    });
});