<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Admin_login.php");
    exit();
}
include 'config.php'; // Database connection

// Fetch staff details
$query = "SELECT * FROM user_login_db";
$result = mysqli_query($connect, $query);

// Handle deletion
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $deleteQuery = "DELETE FROM user_login_db WHERE id=$id";
    mysqli_query($connect, $deleteQuery);
    echo "<script>alert('Data has been successfully deleted'); window.location.href='';</script>";
}

// Handle update
if (isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $updateQuery = "UPDATE user_login_db SET username='$username', email='$email', password='$password' WHERE id=$id";
    mysqli_query($connect, $updateQuery);
    echo "<script>alert('Staff details have been successfully updated.'); window.location.href='';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage_Result_Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/CSS/Style1.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-black p-4 fixed w-full z-10 top-0">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <button class="text-white focus:outline-none mr-4" id="menu-button">
                    <img src="/icons/menu.svg" alt="Menu" class="w-6 h-6">
                </button>
                <p class="text-white font-bold text-xl">Student Results Hub</p>
            </div>
            
            <!-- Logout Icon -->
            <div class="flex items-center space-x-4">
            <!-- // ...existing code... -->
            <a href="logout.php" class="text-white hover:text-gray-300">
                <img src="/icons/log-out.svg" alt="Logout" class="w-6 h-6">
            </a>
            <!-- // ...existing code... -->
            </div>
        </div>
    </nav>

    <!-- Side Menu -->
    <div id="side-menu" class="fixed inset-0 bg-black bg-opacity-75 z-20 transform -translate-x-full transition-transform duration-300">
        <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6" style="box-shadow: inset -10px 0 10px -10px rgba(255, 255, 255);">
            <button id="close-button" class="text-white self-end focus:outline-none">
                <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
            </button>
            <a href="Admin_pannel.php" class="text-white hover:text-gray-300">Home</a>
            <a href="add_student_details.php">Add Student</a>
            <a href="manage_students.php">Manage Students</a>
            <a href="Result.php" id="add-student-link" class="text-white hover:text-gray-300">Add Student Result</a>
            
            <a href="Staff_details.php" id="Users_info" class="text-white hover:text-gray-300">Users_info</a>
            <a href="add_notice.php" id="Add_notices" class="text-white hover:text-gray-300">Add Notice</a>
            <a href="result_status.php" id="result_status" class="text-white hover:text-gray-300">Result_status</a>
            <!-- <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="#" class="text-white hover:text-gray-300">Services</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a> -->
        </div>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="mt-12 p-4">
        <!-- Add content here for your admin panel -->
         <!-- <div class="container mx-auto mt-10"> -->
        <div class="flex-grow container mx-auto mt-10 px-4 sm:px-auto rounded-lg border max-w-6xl mx-auto backdrop-filter backdrop-blur-3xl bg-white bg-opacity-10 p-7 rounded-lg shadow-lg border border-white border-opacity-20">
            <h2 class="text-3xl font-bold mb-6 text-center text-white">Manage Staff</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-lg shadow-md">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Username</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-50">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-4 text-center"> <?php echo $row['id']; ?> </td>
                                <td class="py-3 px-4"> <?php echo $row['username']; ?> </td>
                                <td class="py-3 px-4"> <?php echo $row['email']; ?> </td>
                                <td class="py-3 px-4 text-center">
                                    <button class="text-blue-600 hover:underline mr-2" onclick="editStaff(<?php echo $row['id']; ?>, '<?php echo $row['username']; ?>', '<?php echo $row['email']; ?>')">Edit</button>
                                    <form method="POST" class="inline-block">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden overflow-y-auto">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative max-h-screen overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4">Edit Staff</h2>
                <form method="POST">
                    <input type="hidden" name="update_id" id="edit_id">
                    <div class="mb-3">
                        <label class="block text-gray-700">Username</label>
                        <input type="text" name="username" id="edit_username" class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email" class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">New Password</label>
                        <input type="password" name="password" class="w-full p-2 border rounded-md" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Update</button>
                </form>
                <button class="absolute top-2 right-2 text-lg" id="close-modal">
                    <img src="/icons/x.svg" alt="close" class="w-6 h-6">
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-6">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h3 class="text-xl font-bold mb-3">About the System</h3>
                <p>The Student Result Management System simplifies result management, ensuring secure and efficient handling of student data.</p>
            </div>
            <div class="flex justify-center md:justify-end space-x-6">
                <a href="https://github.com/Nishant-stack19" class="hover:text-gray-300">
                    <img src="/icons/github.svg" alt="GitHub" class="w-6 h-6">
                </a>
                <a href="https://www.linkedin.com/in/nishant-dharukar-1658a433b" class="hover:text-gray-300">
                    <img src="/icons/linkedin.svg" alt="LinkedIn" class="w-6 h-6">
                </a>
                <a href="https://www.instagram.com/nishu_ghost7" class="hover:text-gray-300">
                    <img src="/icons/instagram.svg" alt="Instagram" class="w-6 h-6">
                </a>
                <a href="https://www.facebook.com/share/12FEuSRhMPt/" class="hover:text-gray-300">
                    <img src="/icons/facebook.svg" alt="Facebook" class="w-6 h-6">
                </a>
            </div>
        </div>
        <div class="text-center text-gray-400 mt-6">
            2025 Student Result Management System.
        </div>
    </footer>
    <!-- JavaScript to toggle the side menu -->
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            document.getElementById('side-menu').classList.toggle('-translate-x-full');
        });
        
        document.getElementById('close-button').addEventListener('click', function() {
            document.getElementById('side-menu').classList.add('-translate-x-full');
        });

                function editStaff(id, username, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('editModal').classList.remove('hidden');
        }
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('editModal').classList.add('hidden');
        });
    </script>
    
    <!-- logout functionality -->
    <!-- <script>
        // Listen for logout event
        window.addEventListener('storage', function(event) {
            if (event.key === 'logout-event') {
                window.location.href = 'Admin_login.php';
            }
        });

        // Trigger logout event
        document.querySelector('a[href="logout.php"]').addEventListener('click', function() {
            localStorage.setItem('logout-event', 'logout' + Math.random());
        });
    </script> -->
    <script src="/Javascript/Admin_script.js"></script>
</body>
</html>