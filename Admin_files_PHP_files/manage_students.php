<?php
// Include the session and header
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Admin_login.php");
    exit();
}
// Include the database connection file
include 'config.php';

// Update student details if a form submission is received
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update_query = "UPDATE students SET 
        student_name='$student_name', 
        roll_number='$roll_number', 
        course='$course', 
        semester='$semester', 
        email='$email', 
        phone='$phone' 
        WHERE id='$id'";

    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('Student details updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($connect) . "');</script>";
    }
}

// Delete student record if a delete request is received
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $delete_query = "DELETE FROM students WHERE id='$id'";

    if (mysqli_query($connect, $delete_query)) {
        echo "<script>alert('Student record deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($connect) . "');</script>";
    }
}

// Fetch all student records
$students_query = "SELECT * FROM students";
$students_result = mysqli_query($connect, $students_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff_panel</title>
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
    <main id="main-content" class="ml-0 pt-10 mb-10">
        <!-- Add content here for your admin panel -->
        <div class="container mx-auto mt-10 transition-transform transform hover:scale-105">
            <h2 class="text-3xl font-bold text-center mb-6 text-white">Manage Students</h2>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="p-3 border">ID</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Roll Number</th>
                            <th class="p-3 border">Course</th>
                            <th class="p-3 border">Semester</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Phone</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($students_result)): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="p-3 border"> <?php echo $row['id']; ?> </td>
                                <td class="p-3 border"> <?php echo $row['student_name']; ?> </td>
                                <td class="p-3 border"> <?php echo $row['roll_number']; ?> </td>
                                <td class="p-3 border"> <?php echo $row['course']; ?> </td>
                                <td class="p-3 border"> <?php echo $row['semester']; ?> </td>
                                <td class="p-3 border"> <?php echo $row['email']; ?> </td>
                                <td class="p-3 border"> <?php echo $row['phone']; ?> </td>
                                <td class="p-3 border">
                                    <button class="text-blue-500 underline text-lg font-bold px-4 py-2 rounded edit-button"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-name="<?php echo $row['student_name']; ?>"
                                        data-roll="<?php echo $row['roll_number']; ?>"
                                        data-course="<?php echo $row['course']; ?>"
                                        data-semester="<?php echo $row['semester']; ?>"
                                        data-email="<?php echo $row['email']; ?>"
                                        data-phone="<?php echo $row['phone']; ?>">
                                        Edit
                                    </button> /
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete" class="text-red-500 text-lg font-semibold underline px-4 py-2 rounded delete-button">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <!-- Edit Student Modal -->
    <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center mb-24">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-bold mb-4">Edit Student</h3>
            <form id="edit-form" method="POST">
                <input type="hidden" name="id" id="edit-id">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block">Name</label>
                        <input type="text" name="student_name" id="edit-student_name" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block">Roll Number</label>
                        <input type="text" name="roll_number" id="edit-roll_number" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block">Course</label>
                        <input type="text" name="course" id="edit-course" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block">Semester</label>
                        <input type="text" name="semester" id="edit-semester" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block">Email</label>
                        <input type="email" name="email" id="edit-email" class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label class="block">Phone</label>
                        <input type="text" name="phone" id="edit-phone" class="w-full border p-2 rounded">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" id="close-modal" class="bg-gray-500 text-white px-4 py-2 ml-2 rounded">Cancel</button>
                </div>
            </form>
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
    <script src="/Javascript/staff_script.js"></script>

    <!-- JavaScript to toggle the side menu and handle edit/delete functionality -->
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            document.getElementById('side-menu').classList.toggle('-translate-x-full');
        });
        
        document.getElementById('close-button').addEventListener('click', function() {
            document.getElementById('side-menu').classList.add('-translate-x-full');
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.getAttribute('data-id');
                document.getElementById('edit-student_name').value = this.getAttribute('data-name');
                document.getElementById('edit-roll_number').value = this.getAttribute('data-roll');
                document.getElementById('edit-course').value = this.getAttribute('data-course');
                document.getElementById('edit-semester').value = this.getAttribute('data-semester');
                document.getElementById('edit-email').value = this.getAttribute('data-email');
                document.getElementById('edit-phone').value = this.getAttribute('data-phone');

                document.getElementById('edit-modal').classList.remove('hidden');
            });
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('edit-modal').classList.add('hidden');
        });

        // Script to handle delete button functionality
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this record?')) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';

                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = this.getAttribute('data-id');
                    form.appendChild(input);

                    var submit = document.createElement('input');
                    submit.type = 'hidden';
                    submit.name = 'delete';
                    submit.value = 'delete';
                    form.appendChild(submit);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
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
