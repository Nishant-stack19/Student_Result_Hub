<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Admin_login.php");
    exit();
}
require 'config.php'; // Database connection

// Query to get unique students with their overall percentage
$query = "SELECT student_name, roll_number, mother_name, 
                 SUM(marks) AS total_obtained, 
                 SUM(total_marks) AS max_marks, 
                 (SUM(marks) / SUM(total_marks)) * 100 AS percentage
          FROM student_result
          GROUP BY student_name, roll_number, mother_name";

$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>result_status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/CSS/Style1.css">
</head>
<body>
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
                <a href="logout.php" class="text-white hover:text-gray-300">
                    <img src="/icons/log-out.svg" alt="Logout" class="w-6 h-6">
                </a>
            </div>
        </div>
    </nav>

    <!-- Side Menu -->
    <div id="side-menu" class="fixed inset-0 bg-black bg-opacity-75 z-20 transform -translate-x-full transition-transform duration-300">
        <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6">
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
    <main id="main-content" class="ml-0 pt-10 mb-10">
        <!-- Add content here for your admin panel -->
        <!-- <div class="container mx-auto mt-10 px-4"> -->
            <div class="flex-grow container mx-auto mt-10 px-4 sm:px-auto rounded-lg border max-w-lg mx-auto backdrop-filter backdrop-blur-3xl bg-white bg-opacity-10 p-7 rounded-lg shadow-lg border border-white border-opacity-20">
            <h1 class="text-2xl font-bold text-center mb-6 text-white">List of Students with Declared Results</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 border">Student Name</th>
                            <th class="py-2 px-4 border">Roll Number</th>
                            <th class="py-2 px-4 border">Mother's Name</th>
                            <th class="py-2 px-4 border">Total Marks Obtained</th>
                            <th class="py-2 px-4 border">Total Marks</th>
                            <th class="py-2 px-4 border">Percentage</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-4 border text-center"><?= htmlspecialchars($row['student_name']) ?></td>
                                    <td class="py-2 px-4 border text-center"><?= htmlspecialchars($row['roll_number']) ?></td>
                                    <td class="py-2 px-4 border text-center"><?= htmlspecialchars($row['mother_name']) ?></td>
                                    <td class="py-2 px-4 border text-center"><?= $row['total_obtained'] ?: 'N/A' ?></td>
                                    <td class="py-2 px-4 border text-center"><?= $row['max_marks'] ?: 'N/A' ?></td>
                                    <td class="py-2 px-4 border text-center"><?= $row['percentage'] ? round($row['percentage'], 2) . '%' : 'N/A' ?></td>
                                    <td class="py-2 px-4 border text-center">
                                        <span class="px-3 py-1 text-white 
                                            <?= ($row['percentage'] !== null) ? 'bg-blue-500' : 'bg-red-500' ?>">
                                            <?= ($row['percentage'] !== null) ? 'Published' : 'Pending' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-4 px-4 border text-center text-gray-600">No results have been published yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
                    <img src="/icons/linkedin.svg/icons/linkedin.svg" alt="LinkedIn" class="w-6 h-6">
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
    
    <script src="/Javascript/Admin_script.js"></script>

    <!-- JavaScript to toggle the side menu -->
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            document.getElementById('side-menu').classList.toggle('-translate-x-full');
        });
        
        document.getElementById('close-button').addEventListener('click', function() {
            document.getElementById('side-menu').classList.add('-translate-x-full');
        });
    </script>
    <!-- // ...existing code...
<script>
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
</script>
// ...existing code... -->
</body>
</html>