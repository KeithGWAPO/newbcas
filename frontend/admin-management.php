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
    <title>User Management - Barangay Clinic Appointment System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin-dashboard.css">
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
                    <a href="admin-management.php" class="nav-link active">
                        <i class="fas fa-users-cog me-2"></i>
                        User Management
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="admin-SystemLogs.php" class="nav-link">
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
            <h2>User Management</h2>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus me-2"></i> Add New User
            </button>
            <table class="table table-striped users-table">
                <thead class="table-success">
                    <tr>
                        <th>Username</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example User Rows -->
                    <tr>
                        <td>johndoe</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>johndoe@example.com</td>
                        <td>Admin</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn me-2" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user='{"username":"johndoe","firstname":"John","lastname":"Doe","email":"johndoe@example.com","role":"Admin"}'>
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-username="johndoe">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>janedoe</td>
                        <td>Jane</td>
                        <td>Doe</td>
                        <td>janedoe@example.com</td>
                        <td>Staff</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn me-2" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user='{"username":"janedoe","firstname":"Jane","lastname":"Doe","email":"janedoe@example.com","role":"Staff"}'>
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-username="janedoe">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <!-- Add more user rows as needed -->
                </tbody>
            </table>

            <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="addUserForm" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="new-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="new-username" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="new-firstname" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="new-lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="new-email" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-role" class="form-label">Role</label>
                                <select class="form-select" id="new-role" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add User</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="editUserForm" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit-username" required>
                            <div class="mb-3">
                                <label for="edit-firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="edit-firstname" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="edit-lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-role" class="form-label">Role</label>
                                <select class="form-select" id="edit-role" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addUserForm = document.getElementById('addUserForm');
            const editUserForm = document.getElementById('editUserForm');
            const usersTableBody = document.querySelector('.users-table tbody');

            // Add User Functionality
            addUserForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const newUsername = document.getElementById('new-username').value;
                const newFirstname = document.getElementById('new-firstname').value;
                const newLastname = document.getElementById('new-lastname').value;
                const newEmail = document.getElementById('new-email').value;
                const newRole = document.getElementById('new-role').value;

                // Simulate adding user (replace this with an AJAX call to the server)
                const newRow = `
                    <tr>
                        <td>${newUsername}</td>
                        <td>${newFirstname}</td>
                        <td>${newLastname}</td>
                        <td>${newEmail}</td>
                        <td>${newRole}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn me-2" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user='{"username":"${newUsername}","firstname":"${newFirstname}","lastname":"${newLastname}","email":"${newEmail}","role":"${newRole}"}'>
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-username="${newUsername}">
                                <i class="fas fa-trash-alt me-1"></i> Delete
                            </button>
                        </td>
                    </tr>
                `;
                usersTableBody.insertAdjacentHTML('beforeend', newRow);
                addUserForm.reset();
                $('#addUserModal').modal('hide'); // Hide modal
            });

            // Edit User Functionality
            usersTableBody.addEventListener('click', function (e) {
                if (e.target.closest('.edit-btn')) {
                    const userData = JSON.parse(e.target.closest('.edit-btn').dataset.user);
                    document.getElementById('edit-username').value = userData.username;
                    document.getElementById('edit-firstname').value = userData.firstname;
                    document.getElementById('edit-lastname').value = userData.lastname;
                    document.getElementById('edit-email').value = userData.email;
                    document.getElementById('edit-role').value = userData.role;
                }
            });

            // Save Changes from Edit User Modal
            editUserForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const username = document.getElementById('edit-username').value;
                const firstname = document.getElementById('edit-firstname').value;
                const lastname = document.getElementById('edit-lastname').value;
                const email = document.getElementById('edit-email').value;
                const role = document.getElementById('edit-role').value;

                // Simulate updating user (replace this with an AJAX call to the server)
                const rowToUpdate = [...usersTableBody.querySelectorAll('tr')].find(row => row.cells[0].innerText === username);
                if (rowToUpdate) {
                    rowToUpdate.cells[1].innerText = firstname; // Update firstname
                    rowToUpdate.cells[2].innerText = lastname; // Update lastname
                    rowToUpdate.cells[3].innerText = email; // Update email
                    rowToUpdate.cells[4].innerText = role; // Update role
                }
                $('#editUserModal').modal('hide'); // Hide modal
            });

            // Delete User Functionality
            usersTableBody.addEventListener('click', function (e) {
                if (e.target.closest('.delete-btn')) {
                    const username = e.target.closest('.delete-btn').dataset.username;
                    const rowToDelete = [...usersTableBody.querySelectorAll('tr')].find(row => row.cells[0].innerText === username);
                    if (rowToDelete) {
                        usersTableBody.removeChild(rowToDelete);
                    }
                }
            });
        });
    </script>
</body>
</html>
