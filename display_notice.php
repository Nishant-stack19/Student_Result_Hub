<?php
// Include the database configuration file
include('config.php');

// Fetch the latest notice
$newNoticeQuery = "SELECT * FROM notices ORDER BY created_at DESC LIMIT 1";
$newNoticeResult = $connect->query($newNoticeQuery);

// Fetch all other notices excluding the new one
$otherNoticesQuery = "SELECT * FROM notices ORDER BY created_at DESC LIMIT 1, 9999";
$otherNoticesResult = $connect->query($otherNoticesQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="/CSS/Style.css">
    <style>
        main {
            margin: 0;
            padding: 0;
        }
        .content {
            max-height: 75px;
            overflow: hidden;
            transition: max-height 0.3s ease;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .expanded {
            max-height: 1000px;
        }
        .read-more-btn {
            display: inline-block;
            margin-top: 0px;
            padding: 0;
            text-decoration: none;
            color: #3b82f6;
            font-size: 14px;
            margin-bottom: 0;
            border: none;
            background: none;
        }
        .notice-container {
            margin-bottom: 10px;
            padding: 10px;
            position: relative;
        }
        .notice-container .text-gray-600 {
            margin-bottom: 10px;
        }
        .notice-container .font-bold {
            margin-bottom: 4px;
        }
        .notice-container .text-right {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
    </style>
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
        <div class="w-64 bg-black p-4 h-full flex flex-col space-y-6"
         style="box-shadow: inset -10px 0 10px -10px rgba(255, 255, 255);">
            <button id="close-button" class="text-white self-end focus:outline-none">
                <img src="/icons/x.svg" alt="Close" class="w-6 h-6">
            </button>
            <a href="Homepage.php" class="text-white hover:text-gray-300">Home</a>
            <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="display_notice.php" class="text-white hover:text-gray-300">Notices</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a>
            <a href="view_result.php" class="text-white hover:text-gray-300">View Result</a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="font-sans">
    <!-- Container for Notices -->
    <div class="max-w-4xl mx-auto my-20 p-3 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Notices</h1>

        <?php
        // Display the latest notice at the top
        if ($newNoticeResult->num_rows > 0) {
            $newNotice = $newNoticeResult->fetch_assoc();
            $content = nl2br(htmlspecialchars($newNotice['content']));
            $shortContent = substr($content, 0, 100); // Show only first 100 characters
            $fullContent = $content; // Full content for "Read More"
            echo "<div class='notice-container bg-white border rounded-lg shadow-md p-4'>";
            echo "<div class='font-bold text-lg text-gray-800 mb-2'>" . htmlspecialchars($newNotice['title']) . "</div>";
            echo "<div class='text-gray-600 mb-0 content' id='content-" . $newNotice['id'] . "'>" . $shortContent . "...</div>";
            echo "<button class='read-more-btn' onclick='toggleContent(" . $newNotice['id'] . ")' id='toggle-btn-" . $newNotice['id'] . "'>Read More</button>";
            echo "<div class='hidden' id='full-content-" . $newNotice['id'] . "'>" . $fullContent . "</div>";
            echo "<div class='text-right text-sm text-gray-500'>Posted on: " . date('Y-m-d', strtotime($newNotice['created_at'])) . "</div>";
            echo "</div>";
        }
        ?>

        <!-- Display all other notices below the new one -->
        <?php
        if ($otherNoticesResult->num_rows > 0) {
            while ($row = $otherNoticesResult->fetch_assoc()) {
                $content = nl2br(htmlspecialchars($row['content']));
                $shortContent = substr($content, 0, 100); // Show only first 100 characters
                $fullContent = $content; // Full content for "Read More"
                echo "<div class='notice-container bg-white border rounded-lg shadow-md p-4'>";
                echo "<div class='font-bold text-lg text-gray-800 mb-2'>" . htmlspecialchars($row['title']) . "</div>";
                echo "<div class='text-gray-600 mb-0 content' id='content-" . $row['id'] . "'>" . $shortContent . "...</div>";
                echo "<button class='read-more-btn' onclick='toggleContent(" . $row['id'] . ")' id='toggle-btn-" . $row['id'] . "'>Read More</button>";
                echo "<div class='hidden' id='full-content-" . $row['id'] . "'>" . $fullContent . "</div>";
                echo "<div class='text-right text-sm text-gray-500'>Posted on: " . date('Y-m-d', strtotime($row['created_at'])) . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center text-gray-600'>No notices available.</p>";
        }
        ?>
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
        <hr class="my-6 border-gray-600"/>

        <!-- Social Media Section -->
        <div class="container mx-auto text-center flex flex-wrap justify-center space-x-6 mt-6">
            <a href="https://github.com/Nishant-stack19" class="hover:text-gray-100">
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
        function toggleContent(id) {
            const shortContentDiv = document.getElementById('content-' + id);
            const fullContentDiv = document.getElementById('full-content-' + id);
            const toggleButton = document.getElementById('toggle-btn-' + id);

            if (fullContentDiv.classList.contains('hidden')) {
                shortContentDiv.classList.add('hidden');
                fullContentDiv.classList.remove('hidden');
                toggleButton.textContent = 'Read Less';
            } else {
                fullContentDiv.classList.add('hidden');
                shortContentDiv.classList.remove('hidden');
                toggleButton.textContent = 'Read More';
            }
        }
    </script>
    <script src="/Javascript/script.js"></script>
</body>
</html>