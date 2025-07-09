<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the connection was successful
    if ($connect) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Sanitize inputs
        $username = $connect->real_escape_string($username);
        $password = $connect->real_escape_string($password);

        // Query to check the username and password
        $sql = "SELECT * FROM admin_db WHERE username='$username' AND password='$password'";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $username;
            header("Location: Admin_pannel.php");
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        $error_message = "Database connection failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Result Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="/CSS/Style.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-black p-4 fixed w-full z-10 top-0">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <button class="text-white focus:outline-none mr-4" id="menu-button">
                    <img src="/icons/menu.svg" alt="Menu" class="w-6 h-6">
                </button>
                <p class="text-white font-bold text-xl">Student Results Hub</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/Staff_Panel_PHP_files/login_staff.php" class="text-white hover:text-blue-400">Staff Login</a>
                <p class="text-white">/</p>
                <a href="Admin_login.php" class="text-white hover:text-blue-400">Admin Login</a>
            </div>
        </div>
    </nav>
    
    <div id="side-menu" class="fixed inset-0 bg-black bg-opacity-75 z-20 transform -translate-x-full transition-transform duration-300">
        <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6">
            <button id="close-button" class="text-white self-end focus:outline-none">
                <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
            </button>
            <a href="/Homepage.php" class="text-white hover:text-gray-300">Home</a>
            <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="/display_notice.php" class="text-white hover:text-gray-300">Notices</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a>
            <a href="/view_result.php" class="text-white hover:text-gray-300">View Result</a>
        </div>
    </div>
    
    <main class="ml-0 pt-0">
        <section class="container mx-auto px-6 mt-14">
            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="container mx-auto mt-10 px-4 max-w-lg backdrop-filter backdrop-blur-3xl bg-white bg-opacity-10 p-7 rounded-lg shadow-lg border border-white border-opacity-20">
                    <div class="sm:mx-auto sm:w-full sm:max-w-sm mb-7">
                        <h2 class="mt-1 text-center text-lg font-semibold text-white">Admin Login</h2>
                    </div>
                    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-sm">
                        <hr>
                        <form class="space-y-6" method="post" action="Admin_login.php">
                            <div>
                                <label for="username" class="block text-sm font-medium text-white mt-3">Username</label>
                                <div class="mt-2">
                                    <input type="text" name="username" id="username" autocomplete="username" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-gray-300 placeholder-gray-400 focus:outline-indigo-600">
                                </div>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-white">Password</label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-gray-300 placeholder-gray-400 focus:outline-indigo-600">
                                </div>
                            </div>
                            <hr>
                            <div>
                                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-800 px-3 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-blue-700 focus:outline-indigo-600">Log In</button>
                            </div>
                        </form>
                        <?php if (isset($error_message)): ?>
                            <p class='mt-4 text-red-500'><?php echo $error_message; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
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
                    <input type="email" id="email" placeholder="Enter your email" class="px-3 py-2 rounded bg-gray-700 focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Subscribe</button>
                </form>
            </div>
        </div>
        <hr class="my-6 border-gray-600" />
        <div class="container mx-auto text-center flex flex-wrap justify-center space-x-6 mt-6">
            <a href="https://github.com/Nishant-stack19" class="hover:text-gray-300">
                <img src="/icons/github.svg" alt="GitHub" class="w-6 h-6" />
            </a>
            <a href="www.linkedin.com/in/nishant-dharukar-1658a433b" class="hover:text-gray-300">
                <img src="/icons/linkedin.svg" alt="LinkedIn" class="w-6 h-6" />
            </a>
            <a href="https://www.instagram.com/nishu_ghost7" class="hover:text-gray-300">
                <img src="/icons/instagram.svg" alt="Instagram" class="w-6 h-6" />
            </a>
            <a href="https://www.facebook.com/share/12FEuSRhMPt/" class="hover:text-gray-300">
                <img src="/icons/facebook.svg" alt="Facebook" class="w-6 h-6" />
            </a>
        </div>
        <div class="text-center text-gray-400 mt-6">
            2025 Student Result Management System.
        </div>
    </footer>
    <script src="/Javascript/script.js"></script>
</body>
</html>
