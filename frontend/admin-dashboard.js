document.addEventListener('DOMContentLoaded', function() {
    // Determine the current page
    const currentPage = window.location.pathname.split('/').pop();

    if (currentPage === 'admin-dashboard.php') {
        initializeCalendar();
    }

    if (currentPage === 'admin-management.php') {
        initializeUserManagement();
    }

    /**
     * Function to initialize User Management functionalities
     */
    function initializeUserManagement() {
        // Modal Elements
        const addUserForm = document.getElementById('addUserForm');
        const editUserForm = document.getElementById('editUserForm');
        let editRowIndex = -1; // Variable to store the index of the row being edited

        // Handle Add User Form Submission
        addUserForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('new-username').value.trim();
            const email = document.getElementById('new-email').value.trim();
            const role = document.getElementById('new-role').value;

            if (username === '' || email === '' || role === '') {
                alert('Please fill in all fields.');
                return;
            }

            // Create a new table row
            const tbody = document.querySelector('.users-table tbody');
            const tr = document.createElement('tr');

            // Username
            const usernameTd = document.createElement('td');
            usernameTd.textContent = username;
            tr.appendChild(usernameTd);

            // Firstname and Lastname Placeholder (You can add logic to get this data)
            const firstnameTd = document.createElement('td');
            firstnameTd.textContent = 'First'; // Placeholder, change as needed
            tr.appendChild(firstnameTd);

            const lastnameTd = document.createElement('td');
            lastnameTd.textContent = 'Last'; // Placeholder, change as needed
            tr.appendChild(lastnameTd);

            // Email
            const emailTd = document.createElement('td');
            emailTd.textContent = email;
            tr.appendChild(emailTd);

            // Role
            const roleTd = document.createElement('td');
            roleTd.textContent = role;
            tr.appendChild(roleTd);

            // Actions
            const actionsTd = document.createElement('td');

            // Edit Button
            const editBtn = document.createElement('button');
            editBtn.className = 'btn btn-primary btn-sm edit-btn me-2';
            editBtn.innerHTML = '<i class="fas fa-edit me-1"></i> Edit';
            editBtn.onclick = function() {
                // Populate the edit form with current row data
                document.getElementById('edit-username').value = username;
                document.getElementById('edit-email').value = email;
                document.getElementById('edit-role').value = role;
                editRowIndex = tbody.children.length; // Store the current row index
                const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            };
            actionsTd.appendChild(editBtn);

            // Delete Button
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-danger btn-sm delete-btn';
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt me-1"></i> Delete';
            deleteBtn.onclick = function() {
                tbody.removeChild(tr);
            };
            actionsTd.appendChild(deleteBtn);

            tr.appendChild(actionsTd);
            tbody.appendChild(tr);

            // Reset form fields
            addUserForm.reset();
        });

        // Handle Edit User Form Submission
        editUserForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('edit-username').value.trim();
            const email = document.getElementById('edit-email').value.trim();
            const role = document.getElementById('edit-role').value;

            if (username === '' || email === '' || role === '') {
                alert('Please fill in all fields.');
                return;
            }

            // Update the row with new data
            const tbody = document.querySelector('.users-table tbody');
            const tr = tbody.children[editRowIndex];

            tr.children[0].textContent = username; // Username
            tr.children[1].textContent = 'First'; // Update with proper data
            tr.children[2].textContent = 'Last'; // Update with proper data
            tr.children[3].textContent = email; // Email
            tr.children[4].textContent = role; // Role

            // Close the modal
            const editModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            editModal.hide();
        });
    }
});
