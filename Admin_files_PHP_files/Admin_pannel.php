<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Admin_login.php");
    exit();
}

// Your admin dashboard code here
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
        </div>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="ml-0 pt-10 mb-10">
        <!-- Add content here for your admin panel -->
        <h1 class="text-3xl font-bold text-center mt-10 text-white animate-bounce">Admin pannel</h1>
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
</body>
</html>