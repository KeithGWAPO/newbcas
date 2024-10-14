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
                <h2>Appointment Reports</h2>
                <div class="reports-container mt-3 p-4 bg-light rounded">
                    <p>Reports content goes here...</p>
                </div>
            </section>
        </main>
    </div>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="admin-dashboard.js"></script>
</body>
</html>