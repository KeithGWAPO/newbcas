<?php
session_start(); // Start session to retrieve user data
$firstname = $_SESSION['firstname'] ?? 'Admin';
$lastname = $_SESSION['lastname'] ?? 'User';

// Database connection parameters
$host = 'localhost'; // Replace with your host
$dbname = 'bcas'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch users
    $stmt = $pdo->prepare("SELECT username, firstname, lastname, email, role FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle adding a new user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addUser'])) {
        $newUsername = $_POST['new_username'];
        $newPassword = $_POST['new_password']; // You may want to hash this
        $newFirstname = $_POST['new_firstname'];
        $newLastname = $_POST['new_lastname'];
        $newEmail = $_POST['new_email'];
        $newRole = $_POST['new_role'];

        $stmt = $pdo->prepare("INSERT INTO users (username, password, firstname, lastname, email, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$newUsername, $newPassword, $newFirstname, $newLastname, $newEmail, $newRole]);

        header("Location: admin-management.php"); // Redirect to the same page to see updated user list
        exit();
    }

    // Handle editing a user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editUser'])) {
        $editUsername = $_POST['edit_username'];
        $editFirstname = $_POST['edit_firstname'];
        $editLastname = $_POST['edit_lastname'];
        $editEmail = $_POST['edit_email'];
        $editRole = $_POST['edit_role'];

        $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, role = ? WHERE username = ?");
        $stmt->execute([$editFirstname, $editLastname, $editEmail, $editRole, $editUsername]);

        header("Location: admin-management.php"); // Redirect to the same page to see updated user list
        exit();
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit; // Stop execution if database connection fails
}
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
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn me-2" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user='{"username":"<?php echo htmlspecialchars($user['username']); ?>","firstname":"<?php echo htmlspecialchars($user['firstname']); ?>","lastname":"<?php echo htmlspecialchars($user['lastname']); ?>","email":"<?php echo htmlspecialchars($user['email']); ?>","role":"<?php echo htmlspecialchars($user['role']); ?>"}'>
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-username="<?php echo htmlspecialchars($user['username']); ?>">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="new-username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="new_username" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" name="new_firstname" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" name="new_lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="new_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-role" class="form-label">Role</label>
                                <select class="form-select" name="new_role" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="addUser" class="btn btn-success">Add User</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="edit-username" name="edit_username" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit-firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="edit-firstname" name="edit_firstname" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="edit-lastname" name="edit_lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" name="edit_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-role" class="form-label">Role</label>
                                <select class="form-select" id="edit-role" name="edit_role" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="editUser" class="btn btn-warning">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        // Fill in the edit modal with user data
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const user = JSON.parse(button.getAttribute('data-user'));
                document.getElementById('edit-username').value = user.username;
                document.getElementById('edit-firstname').value = user.firstname;
                document.getElementById('edit-lastname').value = user.lastname;
                document.getElementById('edit-email').value = user.email;
                document.getElementById('edit-role').value = user.role;
            });
        });

        // Handle delete button click (optional)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                const username = button.getAttribute('data-username');
                if (confirm(`Are you sure you want to delete the user "${username}"?`)) {
                    // Implement the delete user functionality here
                    // Use AJAX or form submission to delete the user
                }
            });
        });
    </script>
</body>
</html>
