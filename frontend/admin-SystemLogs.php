<?php
session_start(); // Start session to retrieve user data
$firstname = $_SESSION['firstname'] ?? 'Admin';
$lastname = $_SESSION['lastname'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - Barangay Clinic Appointment System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="history.css">
    <style>
        /* Custom Styles for Navigation */
        .sidebar .nav-link {
            color: #333; /* Default link color */
        }

        .sidebar .nav-link:hover {
            background-color: #d4edda; /* Light Green */
            color: #155724; /* Dark Green */
        }
        .sidebar .nav-link.active {
            color: #155724; /* Dark Green */
            background-color: #d4edda; /* Light Green for active link */
        }

        /* History Section */
        .history-section h2 {
            color: #2E7D32; /* Dark Green */
            margin-bottom: 20px;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="d-flex justify-content-between align-items-center p-2 bg-success text-white">
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
        <nav class="sidebar bg-light p-3 d-flex flex-column" style="min-width: 250px; height: calc(100vh - 70px);">
            <ul class="nav flex-column mb-auto">
                <li class="nav-item mb-2">
                    <a href="admin-dashboard.php" class="nav-link ">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="admin-management.php" class="nav-link ">
                        <i class="fas fa-users-cog me-2"></i>
                        User Management
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="admin-SystemLogs.hphtml" class="nav-link active">
                        <i class="fas fa-history me-2"></i>
                        Logs
                    </a>
                </li>
            </ul>

            <!-- Logout Button placed at the bottom -->
            <a href="../backend/logout.php" class="btn btn-danger mt-auto w-100">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>

        <!-- Main Content -->
        <main class="main-content p-4 w-100">
            <h2>System Logs</h2>
            <table class="table table-striped logs-table">
                <thead class="table-success">
                    <tr>
                        <th>Date & Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody id="logs-body">
                    <!-- Log Rows will be dynamically generated here -->
                </tbody>
            </table>
        </main>
    </div>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example log data (this would typically come from your server)
        const logData = [
            { dateTime: '2024-10-11 10:15:30', user: 'johndoe', action: 'Logged In', details: 'Successful login to the system.' },
            { dateTime: '2024-10-11 10:20:15', user: 'janedoe', action: 'User Created', details: 'New user "marksmith" created by janedoe.' },
            { dateTime: '2024-10-11 10:30:45', user: 'admin', action: 'User Deleted', details: 'User "johndoe" deleted from the system.' },
            // Add more log entries as needed
        ];

        // Function to populate the log table
        function populateLogs() {
            const logsBody = document.getElementById('logs-body');
            logData.forEach(log => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${log.dateTime}</td>
                    <td>${log.user}</td>
                    <td>${log.action}</td>
                    <td>${log.details}</td>
                `;
                logsBody.appendChild(row);
            });
        }

        // Call the function to populate logs on page load
        window.onload = populateLogs;
    </script>
</body>
</html>
