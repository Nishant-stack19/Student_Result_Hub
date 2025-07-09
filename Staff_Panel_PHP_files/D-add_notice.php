<?php
session_start();
// Check if the user is NOT logged in
if (!isset($_SESSION['user'])) {
    header("Location: login_staff.php"); // Redirect to login if not logged in
    exit();
}
// Include the database configuration fil

include('config.php');

// Handle form submission for adding a new notice
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $noticeTitle = $_POST['notice-title'];
        $noticeContent = $_POST['notice-content'];

        // Insert the notice into the database
        $query = "INSERT INTO notices (title, content) VALUES (?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ss", $noticeTitle, $noticeContent);

        if ($stmt->execute()) {
            echo "<script>alert('Notice added successfully!'); window.location.href='add_notice.php';</script>";
        } else {
            echo "<script>alert('Error adding notice.'); window.location.href='add_notice.php';</script>";
        }
        $stmt->close();
    }

    // Handle edit operation
    if ($_POST['action'] === 'edit') {
        $noticeId = $_POST['notice-id'];
        $newTitle = $_POST['notice-title'];
        $newContent = $_POST['notice-content'];

        $query = "UPDATE notices SET title = ?, content = ? WHERE id = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ssi", $newTitle, $newContent, $noticeId);

        if ($stmt->execute()) {
            echo "<script>alert('Notice updated successfully!'); window.location.href='add_notice.php';</script>";
        } else {
            echo "<script>alert('Error updating notice: " . $stmt->error . "'); window.location.href='add_notice.php';</script>";
        }
        $stmt->close();
    }
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $noticeId = $_GET['delete'];
    $query = "DELETE FROM notices WHERE id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $noticeId);
    $stmt->execute();
    $stmt->close();
    header('Location: add_notice.php');
    exit;
}

// Fetch all notices
$query = "SELECT * FROM notices ORDER BY created_at DESC";
$result = $connect->query($query);
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
            <a href="/Staff_Panel_PHP_files/staff_panel.php" class="text-white hover:text-gray-300">Home</a>
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

            <main class="pt-10 mb-10">
            <!-- Notice Form -->
            <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
                <h1 class="text-2xl font-semibold mb-4">Add a New Notice</h1>
                <form action="add_notice.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-4">
                        <label class="block text-gray-700">Notice Title</label>
                        <input type="text" name="notice-title" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Notice Content</label>
                        <textarea name="notice-content" class="w-full p-3 border border-gray-300 rounded-md" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">Publish Notice</button>
                </form>
            </div>

            <!-- Display Notices -->
            <div class="max-w-4xl mx-auto mt-10 bg-black rounded-lg p-4">
                <h2 class="text-2xl font-semibold text-white text-center mb-4">Manage Notices</h2>
                <table class="min-w-full bg-white border rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="py-3 px-4 text-left text-gray-700">Title</th>
                            <th class="py-3 px-4 text-left text-gray-700">Content</th>
                            <th class="py-3 px-4 text-center text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($notice = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-3 px-4"><?= htmlspecialchars($notice['title']); ?></td>
                            <td class="py-3 px-4"><?= nl2br(htmlspecialchars($notice['content'])); ?></td>
                            <td class="py-3 px-4 text-center">
                                <button class="text-blue-500 hover:text-blue-700 edit-btn"
                                    data-id="<?= $notice['id']; ?>"
                                    data-title="<?= htmlspecialchars($notice['title']); ?>"
                                    data-content="<?= htmlspecialchars($notice['content']); ?>">
                                    Edit
                                </button>
                                <a href="?delete=<?= $notice['id']; ?>" class="text-red-500 hover:text-red-700 ml-4">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Edit Modal -->
        <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-8 rounded-lg shadow-md w-96 relative">
                <h2 class="text-2xl font-semibold mb-4">Edit Notice</h2>
                <form id="edit-form" action="add_notice.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="notice-id" id="notice-id">
                    <div class="mb-4">
                        <label class="block text-gray-700">Notice Title</label>
                        <input type="text" id="edit-title" name="notice-title" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Notice Content</label>
                        <textarea id="edit-content" name="notice-content" class="w-full p-3 border border-gray-300 rounded-md" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">Update Notice</button>
                </form>
                <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 focus:outline-none" id="close-modal">
                    <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
                </button>
            </div>
        </div>
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

        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-btn");
            const editModal = document.getElementById("edit-modal");
            const closeModal = document.getElementById("close-modal");

            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    document.getElementById("notice-id").value = this.getAttribute("data-id");
                    document.getElementById("edit-title").value = this.getAttribute("data-title");
                    document.getElementById("edit-content").value = this.getAttribute("data-content");

                    editModal.classList.remove("hidden");
                });
            });

            closeModal.addEventListener("click", function () {
                editModal.classList.add("hidden");
            });
        });
    </script>
    <script src="/Javascript/Admin_script.js"></script>
</body>
</html>
