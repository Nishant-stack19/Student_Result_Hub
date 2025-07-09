<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Admin_login.php");
    exit();
}
// Include the database connection file
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs to prevent SQL injection
    $student_name = mysqli_real_escape_string($connect, $_POST['student_name']);
    $roll_number = mysqli_real_escape_string($connect, $_POST['roll_number']);
    $course = mysqli_real_escape_string($connect, $_POST['course']);
    $semester = mysqli_real_escape_string($connect, $_POST['semester']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);

    // Check if the roll number or email already exists
    $check_query = "SELECT * FROM students WHERE roll_number = '$roll_number' OR email = '$email'";
    $result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('The student details are already added!');</script>";
    } else {
        // Insert data into the database
        $query = "INSERT INTO students (student_name, roll_number, course, semester, email, phone, address, dob) 
                  VALUES ('$student_name', '$roll_number', '$course', '$semester', '$email', '$phone', '$address', '$dob')";

        if (mysqli_query($connect, $query)) {
            echo "<script>
                alert('Student details added successfully!');
                document.getElementById('studentForm').reset(); // Clear the form
            </script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
        }
    }
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
            // ...existing code...
            <a href="logout.php" class="text-white hover:text-gray-300">
                <img src="/icons/log-out.svg" alt="Logout" class="w-6 h-6">
            </a>
            // ...existing code...
            </div>
        </div>
    </nav>

    <!-- Side Menu -->
    <div id="side-menu" class="fixed inset-0 bg-black bg-opacity-75 z-20 transform -translate-x-full transition-transform duration-300">
    <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6 "
    style="box-shadow: inset -10px 0 10px -10px rgba(255, 255, 255);">
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
<main class="min-h-screen flex items-center justify-center px-4 pt-80 mb-20">
    <div class="bg-white p-6 md:p-10 rounded-lg shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800 text-center">Add Student Details</h2>

        <form id="studentForm" action="" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="student_name" class="block text-sm font-medium text-gray-700">Student Name</label>
                    <input type="text" id="student_name" name="student_name" placeholder="Enter student name" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label for="roll_number" class="block text-sm font-medium text-gray-700">Roll Number</label>
                    <input type="text" id="roll_number" name="roll_number" placeholder="Enter roll number" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                    <input type="text" id="course" name="course" placeholder="Enter course name" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select id="semester" name="semester" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter phone number" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" name="address" placeholder="Enter address" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Add Student</button>
        </form>
    </div>
</main>

        <!-- Footer -->
        <footer class="bg-black text-white py-6 mt-40">
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
    <!-- // ...existing code... -->
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
<!-- // ...existing code... -->
</body>
</html>
