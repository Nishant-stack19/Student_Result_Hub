<?php
// Include the database configuration file
include('config.php');

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username, email, and password from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert data into the database (storing the username, email, and hashed password)
    $sql = "INSERT INTO user_login_db (username, email, password) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('sss', $username, $email, $password);
    if ($stmt->execute()) {
        // Success, show success message or redirect
        echo "<script>
                alert('Data stored successfully!');
                window.location.href='login_staff.php';
              </script>";
    } else {
        // Error inserting data
        echo "<script>alert('Error storing data!');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $connect->close();
}
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
                <a href="login_staff.php" class="text-white hover:text-blue-400">Staff login</a>
                <p class="text-white">/</p>
                <a href="Admin_login.php" class="text-white hover:text-blue-400">Admin login</a>
            </div>
        </div>
    </nav>
    <!-- Side Menu -->
    <div id="side-menu" class="fixed inset-0 bg-black bg-opacity-75 z-20 transform -translate-x-full transition-transform duration-300">
        <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6 border"
         style="box-shadow: inset -10px 0 10px -10px rgba(255, 255, 255);">
            <button id="close-button" class="text-white self-end focus:outline-none">
                <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
            </button>
            <a href="#" class="text-white hover:text-gray-300">Home</a>
            <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="display_notice.php" class="text-white hover:text-gray-300">Notices</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a>
            <a href="view_result.php" class="text-white hover:text-gray-300">View Result</a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="ml-0 pt-0">
            <!-- Additional Content Section Above Footer-->
        <!-- Additional Content Section Above Footer-->
<section class="container mx-auto ">
  <div class="flex min-h-full flex-col justify-center px-6 py-16 lg:px-8">
    <div class="flex-grow container mx-auto mt-1 px-4 sm:px-auto rounded-lg border max-w-lg mx-auto backdrop-filter backdrop-blur-3xl bg-white bg-opacity-10 p-3 rounded-lg shadow-lg border border-white border-opacity-20">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm mb-7">
        <h2 class="mt-4 text-center text-lg font-semibold font-sans tracking-tight text-white">Create your Account</h2>
      </div>
      <div class="mt-1 sm:mx-auto sm:w-full sm:max-w-sm">
        <hr>
        <!-- Login form with PHP processing -->
        <form class="space-y-6" method="POST">
          <!-- Username field -->
          <div>
            <label for="username" class="block text-sm/6 font-medium text-white mt-3">Username</label>
            <div class="mt-2">
              <input type="text" name="username" id="username" autocomplete="username" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
            </div>
          </div>
          <!-- Email field -->
          <div>
            <label for="email" class="block text-sm/6 font-medium text-white mt-3">Email address</label>
            <div class="mt-2">
              <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
            </div>
          </div>
          <!-- Password field -->
          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
            </div>
            <div class="mt-2">
              <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
              <p class="mt-2 text-sm text-white">Password must contain at least 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.</p>
            </div>
          </div>
          <!-- Submit button and registration link -->
          <hr>
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-800 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mb-4">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- End of Additional Content Section -->
    </main>
    <footer class="text-white">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-5">
            <div>
                <h3 class="text-xl font-bold mb-4">About the System</h3>
                <p>The Student Result Management System simplifies result management, ensuring secure and efficient handling of student data.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-blue-400">
                    <li><a href="display_notice.php" class="hover:text-gray-300">Notices</a></li>
                    <li><a href="contact.php" class="hover:text-gray-300">Contact Support</a></li>
                    <li><a href="settings.php" class="hover:text-gray-300">Settings</a></li>
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
        <hr class="my-6 border-gray-600">

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
      
        <!-- Footer -->
        <div class="text-center text-gray-400 mt-6">
            2025 Student Result Management System.
        </div>
    </footer>
    <script src="/Javascript/script.js"></script>
</body>
</html>
