<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Calendar</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #e9ecef; /* Soft background */
        }

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
            background-color: #007bff; /* Header color */
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
            background-color: #0056b3; /* Button color */
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 5px;
            transition: background-color 0.3s; /* Smooth transition */
        }

        .calendar-header button:hover {
            background-color: #004494; /* Darker on hover */
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
            background-color: #007bff; /* Header color */
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
