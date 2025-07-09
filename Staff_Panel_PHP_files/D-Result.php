<?php
session_start();
// Check if the user is NOT logged in
if (!isset($_SESSION['user'])) {
    header("Location: login_staff.php"); // Redirect to login if not logged in
    exit();
}
// Database connection
include 'config.php';

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_result'])) {
    // Get form data
    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $mother_name = $_POST['mother_name'];

    // Insert student details into the database
    $insert_student_sql = "INSERT INTO student_result (student_name, roll_number, mother_name)
                            VALUES ('$student_name', '$roll_number', '$mother_name')";
    if ($connect->query($insert_student_sql) === TRUE) {
        // Get the student id for further marks insertion
        $student_id = $connect->insert_id;

        // Insert subjects and marks into the database
        foreach ($_POST['subjects'] as $index => $subject) {
            $marks = $_POST['marks'][$index];
            $total_marks = $_POST['total_marks'][$index];
            $percentage = ($marks / $total_marks) * 100;

            $insert_marks_sql = "INSERT INTO student_result (student_name, roll_number, mother_name, subject, marks, total_marks, percentage)
                                 VALUES ('$student_name', '$roll_number', '$mother_name', '$subject', '$marks', '$total_marks', '$percentage')";
            $connect->query($insert_marks_sql);
        }

        $message = "Student result added successfully!";
    } else {
        $message = "Error: " . $insert_student_sql . "<br>" . $connect->error;
    }
}
// Close connection
$connect->close();
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
    <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6 "
    style="box-shadow: inset -10px 0 10px -10px rgba(255, 255, 255);">
            <button id="close-button" class="text-white self-end focus:outline-none">
                <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
            </button>
            <a href="staff_panel.php" class="text-white hover:text-gray-300">Home</a>
            <a href="D-add_student_details.php">Add Student</a>
            <a href="student_list.php">Students List</a>
            <a href="D-Result.php" id="add-student-link" class="text-white hover:text-gray-300">Add Student Result</a>
            <a href="D-add_notice.php" id="Add_notices" class="text-white hover:text-gray-300">Add Notice</a>
            <a href="D-result_status.php" id="result_status" class="text-white hover:text-gray-300">Result_status</a>
            <!-- <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="#" class="text-white hover:text-gray-300">Services</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a> -->
        </div>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="ml-0 pt-10 mb-10">
        <!-- Add content here for your admin panel -->
         <!-- Admin Panel add Student Result -->
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg p-6 max-w-xl mx-auto">
            <h2 class="text-2xl font-bold text-center mb-6">Enter Student Details</h2>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="student_name" class="block text-sm font-medium text-gray-700">Student Name:</label>
                    <input type="text" id="student_name" name="student_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="roll_number" class="block text-sm font-medium text-gray-700">Roll Number:</label>
                    <input type="text" id="roll_number" name="roll_number" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="mother_name" class="block text-sm font-medium text-gray-700">Mother's Name:</label>
                    <input type="text" id="mother_name" name="mother_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Custom Subject Input Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Add Custom Subject</h3>
                    <div class="flex space-x-2 mb-4">
                        <input type="text" id="custom_subject" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Enter Custom Subject">
                        <button type="button" onclick="addCustomSubject()" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Add to Dropdown</button>
                    </div>
                </div>

                <!-- Subjects and Marks Table -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Enter Subjects and Marks</h3>
                    <div id="subjects_wrapper">
                        <div class="flex space-x-2 mb-4">
                            <select name="subjects[]" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm" id="subject_dropdown">
                                <option value="">Select a Subject</option>
                                <option value="Python">Python</option>
                                <option value="Java">Java</option>
                                <option value="C++">C++</option>
                                <option value="JavaScript">JavaScript</option>
                            </select>
                            <input type="number" name="marks[]" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Marks" required>
                            <input type="number" name="total_marks[]" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Total Marks" required>
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeSubjectRow(this)">Remove</button>
                        </div>
                    </div>

                    <button type="button" onclick="addSubjectRow()" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">Add More Subjects</button>
                </div>

                <div class="mb-4">
                    <input type="submit" name="submit_result" value="Submit Result" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                </div>

                <?php if (isset($message)): ?>
                    <div class="bg-green-500 text-white p-4 rounded-lg mt-6 text-center">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        // Function to add a new subject row
        function addSubjectRow() {
            const wrapper = document.getElementById('subjects_wrapper');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'space-x-2', 'mb-4');
            newRow.innerHTML = `
                <select name="subjects[]" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    <option value="">Select a Subject</option>
                    <option value="Python">Python</option>
                    <option value="Java">Java</option>
                    <option value="C++">C++</option>
                    <option value="JavaScript">JavaScript</option>
                </select>
                <input type="number" name="marks[]" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Marks" required>
                <input type="number" name="total_marks[]" class="w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Total Marks" required>
                <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="removeSubjectRow(this)">Remove</button>
            `;
            wrapper.appendChild(newRow);
        }

        // Function to remove a subject row
        function removeSubjectRow(button) {
            const row = button.parentElement;
            row.remove();
        }

        // Function to add a custom subject to the dropdown list dynamically
        function addCustomSubject() {
            const customSubject = document.getElementById('custom_subject').value;
            if (customSubject.trim() !== '') {
                const dropdown = document.getElementById('subject_dropdown');
                const newOption = document.createElement('option');
                newOption.value = customSubject;
                newOption.textContent = customSubject;
                dropdown.appendChild(newOption);
                document.getElementById('custom_subject').value = '';  // Clear the input after adding
            } else {
                alert("Please enter a custom subject.");
            }
        }
    </script>
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
</body>
</html>
