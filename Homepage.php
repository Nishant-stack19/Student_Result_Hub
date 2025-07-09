<!-- New code with the functionality of pop up -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage_Result_Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="/CSS/Style.css">
        <!-- Style.css -->
    <!-- <style>
        html, body {
            height: 100%; /* Ensure the full height is used */
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Makes the main content area expand */
        }
        footer {
            background-color: #000103; /* Dark gray */
            padding: 20px;
            text-align: center;
            position: relative;
            box-shadow: inset 0 10px 10px -10px rgba(11, 113, 230); /* Top border with blur effect inward */
            backdrop-filter: blur(10px);
        }
        nav {
            z-index: 40;  /* Navbar stays on top */
            border-bottom: 1px solid transparent; /* Transparent border to create space for the blur */
            box-shadow: inset 0 -10px 10px -10px rgba(255, 255, 255, 0.5); /* white color with blur effect */
            backdrop-filter: blur(10px); /* Optional: Adds blur to the background */
        }
        /* Popup form */
        #view-result-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        #view-result-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            position: relative;
        }
        #view-result-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        #close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style> -->
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
            <a href="Homepage.php" class="text-white hover:text-gray-300">Home</a>
            <a href="#" class="text-white hover:text-gray-300">About</a>
            <a href="display_notice.php" class="text-white hover:text-gray-300">Notices</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a>
            <a href="view_result.php" class="text-white hover:text-gray-300">View Result</a>
        </div>
    </div>
    <!-- Main Content -->
    <main class="ml-0 pt-20">
        <h1 class="text-3xl font-bold text-center mt-10 text-white fr-view">Welcome to Student Results Hub</h1>
<!-- -----------------Pop up adding section-------- -->
        <!-- Full-Screen Overlay -->
          <!-- View Results Popup -->
<!-- --------------------------------------------- -->
<!-- Additional Content Section Above Footer-->
        <section class="container mx-auto px-6 mt-10">
            <div class="bg-black rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Additional Resources</h2>
                <p class="text-gray-600 mb-6">
                    Explore the latest tools, resources, and updates to help you get the most out of the Student Result Management System.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-100 rounded-lg p-4 text-center shadow">
                        <h3 class="text-lg font-bold text-blue-600">Documentation</h3>
                        <p class="text-gray-500 mt-2">
                            Learn how to use the system with step-by-step guides.
                        </p>
                        <a href="documentation.php" class="text-blue-500 hover:underline mt-4 block">Read More</a>
                    </div>

                    <div class="bg-gray-100 rounded-lg p-4 text-center shadow">
                        <h3 class="text-lg font-bold text-blue-600">Tutorials</h3>
                        <p class="text-gray-500 mt-2">
                            Watch tutorials to quickly master the platform.
                        </p>
                        <a href="tutorials.php" class="text-blue-500 hover:underline mt-4 block">Explore Tutorials</a>
                    </div>

                    <div class="bg-gray-100 rounded-lg p-4 text-center shadow">
                        <h3 class="text-lg font-bold text-blue-600">Community Forum</h3>
                        <p class="text-gray-500 mt-2">
                            Connect with other users and share experiences.
                        </p>
                        <a href="forum.php" class="text-blue-500 hover:underline mt-4 block">Join Forum</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Additional Content Section -->
<!-- <div class="bg-yellow-100 py-3 text-center">
    <marquee class="text-red-600 font-semibold">
        📢 Results for Semester 5 have been published! | 📢 Server maintenance on February 5th, 2025. 
    </marquee>
</div> -->
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
    <!-- JavaScript -->
    <!-- <script>
        const menuButton = document.getElementById('menu-button');
        const sideMenu = document.getElementById('side-menu');
        const closeButton = document.getElementById('close-button');
        const viewResultPopup = document.getElementById('view-result-popup');
        const closePopup = document.getElementById('close-popup');
        const viewResultLink = document.getElementById('view-result-link');
        // Toggle menu on clicking the menu button
        menuButton.addEventListener('click', () => {
            sideMenu.classList.toggle('-translate-x-full');
        });
        // Close menu on clicking the close button
        closeButton.addEventListener('click', () => {
            sideMenu.classList.add('-translate-x-full');
        });
        // Show result popup when the "View Results" link is clicked
        viewResultLink.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default link behavior
            viewResultPopup.style.display = 'flex';
        });
        // Close popup when clicking the close icon
        closePopup.addEventListener('click', () => {
            viewResultPopup.style.display = 'none';
        });
        // Close popup if clicked outside of the form
        viewResultPopup.addEventListener('click', (event) => {
            if (event.target === viewResultPopup) {
                viewResultPopup.style.display = 'none';
            }
        });
        // Footer subscribe form functionality
        document.getElementById('subscribeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            if (email) {
                alert(`Thank you for subscribing to updates, ${email}!`);
                document.getElementById('email').value = ''; // Clear input
            } else {
                alert('Please enter a valid email address.');
            }
        });
    </script> -->
<script src="/Javascript/script.js"></script>
</body>
</html>