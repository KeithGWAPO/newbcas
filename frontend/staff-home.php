<?php
session_start(); // Start session to retrieve user data
$firstname = $_SESSION['firstname'] ?? 'Staff';
$lastname = $_SESSION['lastname'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Barangay Clinic Appointment System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin-dashboard.css">

    <style>
        .calendar {
            width: 100%;
            max-width: 700px;
            margin: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: white; /* Card background */
        }

        .calendar-header {
            background-color: #28a745; /* Header color */
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-top-left-radius: 8px; /* Rounded corners */
            border-top-right-radius: 8px;
        }

        .calendar-header h2 {
            font-size: 24px;
            margin-right: auto; /* Pushes the buttons to the right */
        }

        .calendar-header button {
            background-color: #155724; /* Button color */
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 5px;
            transition: background-color 0.3s; /* Smooth transition */
        }

        .calendar-header button:hover {
            background-color: #0a2911; /* Darker on hover */
        }

        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #ddd;
        }

        .calendar-body div {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            background-color: #f8f9fa; /* Light cell background */
            position: relative; /* For absolute positioning of the box */
            transition: background-color 0.3s; /* Smooth transition */
        }

        .calendar-body div:nth-child(7n) {
            border-right: none;
        }

        .calendar-body .day-name {
            background-color: #28a745; /* Header color */
            color: white;
            font-weight: bold;
            padding: 10px;
        }

        .calendar-body .today {
            background-color: #cce5ff; /* Highlight today */
            font-weight: bold;
        }

        .calendar-body .disabled {
            color: #bbb;
            background-color: #f9f9f9;
        }

        .day-box {
            position: absolute;
            top: 10px; /* Adjust as needed */
            right: 10px; /* Adjust as needed */
            background-color: #e9ecef; /* Box background */
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 30px; /* Width of the box */
            height: 30px; /* Height of the box */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px; /* Font size for the number */
            color: #333; /* Number color */
        }

        .calendar-body div:hover {
            background-color: #f1f1f1; /* Highlight on hover */
        }
    </style>
            
</head>
<body>
    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center p-3 bg-success text-white">
        <div class="d-flex align-items-center">
            <img src="assets/logo.png" alt="Clinic Logo" class="me-3" width="50" height="50">
            <h1 class="h4 mb-0">Barangay Clinic Appointment System</h1>
        </div>
        
<div class="d-flex align-items-center">
    <img src="assets/profile.jpg" alt="User Profile" class="rounded-circle me-2" width="40" height="40">
    <span><?php echo "$firstname $lastname"; ?></span>
</div>
    </header>

    <!-- Sidebar and Main Content -->
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-light p-3" style="min-width: 250px; height: calc(100vh - 70px);">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="staff-home.php" class="nav-link active">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="staff-RegisterPatient.html" class="nav-link">
                        <i class="fas fa-users-cog me-2"></i>
                        Register Patient 
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="staff-ManageAppointment.html" class="nav-link">
                        <i class="fas fa-chart-line me-2"></i>
                        Appointments
                    </a>
                </li>
                  <li class="nav-item mb-2">
                    <a href="staff-PatientRecords.html" class="nav-link">
                        <i class="fas fa-chart-line me-2"></i>
                        Patient Records 
                    </a>
                </li>
            </ul>

            <hr>
            
            <a href="login.html" class="btn btn-danger w-100">
                <i class="fas fa-sign-out-alt me-2"></i>
                Logout
            </a>
        </nav>

        <!-- Main Content -->
        <main class="main-content p-4 w-100">


            <!-- Reports Section -->
            <section class="reports-section mt-5">
                <div class="calendar">
                    <div class="calendar-header">
                        <h2 id="monthYear"></h2>
                        <div>
                            <button id="prevBtn">&lt; Previous</button>
                            <button id="todayBtn">Today</button>
                            <button id="nextBtn">Next &gt;</button>
                        </div>
                    </div>
                    <div class="calendar-body" id="calendarBody">
                        <!-- Day Names -->
                        <div class="day-name">Sun</div>
                        <div class="day-name">Mon</div>
                        <div class="day-name">Tue</div>
                        <div class="day-name">Wed</div>
                        <div class="day-name">Thu</div>
                        <div class="day-name">Fri</div>
                        <div class="day-name">Sat</div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="admin-dashboard.js"></script>

    <script>
        const monthYear = document.getElementById('monthYear');
        const calendarBody = document.getElementById('calendarBody');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const todayBtn = document.getElementById('todayBtn');

        let currentDate = new Date();
        const today = new Date(); // Store today's date for reference

        // Function to render the calendar
        function renderCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();

            // Set the month and year in the header
            monthYear.textContent = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

            // Clear the previous calendar days
            calendarBody.querySelectorAll('.calendar-day').forEach(day => day.remove());

            // Get the first day and the total days in the month
            const firstDay = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();

            // Add empty days for the previous month
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('calendar-day', 'disabled');
                calendarBody.appendChild(emptyCell);
            }

            // Add the days of the current month
            for (let day = 1; day <= totalDays; day++) {
                const dayCell = document.createElement('div');
                dayCell.classList.add('calendar-day');
                dayCell.textContent = day;

                // Create a box with 0 inside
                const dayBox = document.createElement('div');
                dayBox.classList.add('day-box');
                dayBox.textContent = '0'; // Default number

                dayCell.appendChild(dayBox); // Add the box to the day cell

                // Highlight today's date
                if (
                    day === today.getDate() &&
                    month === today.getMonth() &&
                    year === today.getFullYear()
                ) {
                    dayCell.classList.add('today');
                }

                calendarBody.appendChild(dayCell);
            }
        }

        // Event listeners for previous, next, and today buttons
        prevBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        nextBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        todayBtn.addEventListener('click', () => {
            currentDate = new Date(today); // Reset to today's date
            renderCalendar(currentDate);
        });

        // Initial render
        renderCalendar(currentDate);
    </script>

</body>
</html>