<?php
// Database connection
include 'config.php';

// Variable to store result data
$results = [];

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $mother_name = $_POST['mother_name'];

    // Query the database for the result
    $sql = "SELECT * FROM student_result WHERE roll_number = '$id' AND mother_name = '$mother_name'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the results from the query
        $results = $result->fetch_all(MYSQLI_ASSOC);

        // Calculate total marks obtained and percentage
        $total_marks_obtained = 0;
        $total_max_marks = 0;

        foreach ($results as $row) {
            $total_marks_obtained += $row['marks'];
            $total_max_marks += $row['total_marks'];
        }

        $percentage = ($total_marks_obtained / $total_max_marks) * 100;
        $status = $percentage >= 40 ? "Pass" : "Fail";
    } else {
        $message = "No result found for the provided details.";
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
    <link rel="stylesheet" href="/CSS/Style.css">
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
            <div class="flex items-center space-x-4">
                <a href="/Staff_Panel_PHP_files/login_staff.php" class="text-white hover:text-blue-400">Staff login</a>
                <p class="text-white">/</p>
                <a href="/Admin_files_PHP_files/Admin_login.php" class="text-white hover:text-blue-400">Admin login</a>
            </div>
        </div>
    </nav>

    <!-- Side Menu -->
    <div id="side-menu" class="fixed inset-0 bg-black bg-opacity-75 z-20 transform -translate-x-full transition-transform duration-300">
        <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6"
         style="box-shadow: inset -10px 0 10px -10px rgba(255, 255, 255);">
            <button id="close-button" class="text-white self-end focus:outline-none">
                <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
            </button>
            <a href="Index(Homepage).php" class="text-white hover:text-gray-300">Home</a>
            <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="display_notice.php" class="text-white hover:text-gray-300">Notices</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a>
            <a href="view_result.php" class="text-white hover:text-gray-300">View Result</a>
        </div>
    </div>

    <!-- Main Content -->
<main class="ml-0 pt-12 ">
    <body class="bg-gray-100 text-gray-900">
        <div class="flex-grow container mx-auto mt-10 px-4 sm:px-auto rounded-lg border max-w-lg mx-auto backdrop-filter backdrop-blur-3xl bg-white bg-opacity-10 p-7 rounded-lg shadow-lg border border-white border-opacity-20">
            <!-- Search Form -->
            <div class="bg-white shadow-md rounded-lg p-6 max-w-xl mx-auto mb-10">
                <h2 class="text-2xl font-bold text-center mb-6">Search Student Result</h2>
                <form action="view_result.php" method="post">
                    <div class="mb-4">
                        <label for="id" class="block text-sm font-medium text-gray-700">Student ID:</label>
                        <input type="text" id="id" name="id" required class="mt-1   block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500     focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="mother_name" class="block text-sm font-medium text-gray-700">Mother's Name:</label>
                        <input type="text" id="mother_name" name="mother_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="mt-6">
                        <input type="submit" value="View Result" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    </div>
                </form>
            </div>
            
            <!-- Display Result -->
<?php if (!empty($results)): ?>
    <div class="bg-white shadow-md rounded-lg p-6 max-w-xl mx-auto relative">
    <!-- Close Button -->
    <button id="close-result" class="absolute top-2 right-2 focus:outline-none">
        <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
    </button>

        <h1 class="text-3xl font-bold text-center mb-5">Certificate of Completion</h1>
        <p class="text-lg text-center mb-5">This is to certify that</p>

        <!-- Student Name -->
        <h2 class="text-2xl font-semibold text-center mb-4"><?= htmlspecialchars($results[0]['student_name']) ?></h2>
        <p class="text-lg text-center mb-5">Roll Number: <?= htmlspecialchars($results[0]['roll_number']) ?></p>
        <p class="text-lg text-center mb-5">Mother's Name: <?= htmlspecialchars($results[0]['mother_name']) ?></p>

        <h3 class="text-xl font-semibold mb-4">Has successfully completed the examination</h3>

        <!-- Results Table -->
        <table class="w-full table-auto border-collapse border border-gray-300 mb-5">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Subject</th>
                    <th class="border border-gray-300 px-4 py-2">Marks Obtained</th>
                    <th class="border border-gray-300 px-4 py-2">Total Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($result['subject']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($result['marks']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($result['total_marks']) ?></ td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                
        <!-- Percentage and Pass/Fail -->
        <p class="text-center text-lg mb-4">Percentage: <span class="font-bold"><?= number_format($percentage, 2) ?>%</span></p>
        <p class="text-center text-lg mb-5">Status: <span class="font-bold <?= $status == 'Pass' ? 'text-green-600' :  'text-red-600' ?>"><?= $status ?></span></p>
                
        <p class="text-center text-lg">Issued on: <?= date('F j, Y') ?></p>
                
        <div class="mt-5 text-center">
            <p class="font-semibold">Signature: ___________________</p>
        </div>
    </div>
        <?php elseif (isset($message)): ?>
            <div class="bg-red-500 text-white p-4 rounded-lg max-w-xl mx-auto mt-6">
                <p class="text-center"><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>
<footer class="text-white py-8 mt-10">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-5">
            <div>
                <h3 class="text-xl font-bold mb-4">About the System</h3>
                <p>The Student Result Management System simplifies result management, ensuring secure and efficient handling of student data.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-blue-400">
                    <li><a href="contact.php" class="hover:text-gray-300">Contact Support</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Stay Updated</h3>
                <form id="subscribeForm" class="flex flex-col space-y-2">
                    <input type="email" id="email" placeholder="Enter your email" class="px-3 py-2 rounded bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Subscribe</button>
                </form>
            </div>
        </div>
        <hr class="my-6 border-gray-600" />
      
        <!-- Social Media Section -->
        <div class="container mx-auto text-center flex flex-wrap justify-center space-x-6 mt-6">
          <a href="https://github.com/Nishant-stack19" class="hover:text-gray-300">
            <img src="/icons/github.svg" alt="GitHub" class="w-6 h-6" />
          </a>
          <a href="www.linkedin.com/in/nishant-dharukar-1658a433b" class="hover:text-gray-300">
            <img src="/icons/linkedin.svg" alt="LinkedIn" class="w-6 h-6" />
          </a>
          <a href="https://www.instagram.com/nishu_ghost7?utm_source=qr&igsh=Y2U4bGpvaHBqeHpz" class="hover:text-gray-300">
            <img src="/icons/instagram.svg" alt="Instagram" class="w-6 h-6" />
          </a>
          <a href="https://www.facebook.com/share/12FEuSRhMPt/" class="hover:text-gray-300">
            <img src="/icons/facebook.svg" alt="Facebook" class="w-6 h-6" />
          </a>
        </div>
      
        <!-- Footer Copyright -->
        <div class="text-center text-gray-400 mt-6">
          2025 Student Result Management System.
        </div>
    </footer>
    <script>
        // Close the result section
    document.getElementById("close-result").addEventListener("click", function () {
    const resultContainer = this.closest(".bg-white.shadow-md"); // Get the closest result container
    if (resultContainer) {
        resultContainer.style.display = "none"; // Hide the result container
    }
});
</script>
<script src="/Javascript/script.js"></script>
</body>
</html>