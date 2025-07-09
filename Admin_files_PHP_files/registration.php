<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert into the database
    $sql = "INSERT INTO admin_login_db (username, password) VALUES (?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('ss', $username, $hashedPassword);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'Admin_login.php'; 
              </script>";
    } else {
        echo "<script>
                alert('Registration failed!');
                window.history.back();
              </script>";
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
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="/CSS/Style.css">
</head>

<body class="bg-gray-100">
    <main class="ml-0 pt-0">
        <section class="container mx-auto px-6 mt-14">
            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="flex-grow container mx-auto mt-10 px-4 sm:px-auto rounded-lg border max-w-lg mx-auto backdrop-filter backdrop-blur-3xl bg-white bg-opacity-10 p-7 rounded-lg shadow-lg border border-white border-opacity-20">
                    <div class="sm:mx-auto sm:w-full sm:max-w-sm mb-7">
                        <h2 class="mt-1 text-center text-lg font-semibold font-sans tracking-tight text-white">Admin Registration</h2>
                    </div>
                    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-sm">
                        <hr>
                        <hr>
                        <form class="space-y-6" method="POST">
                            <div>
                                <label for="username" class="block text-sm/6 font-medium text-white mt-3">Username</label>
                                <div class="mt-2">
                                    <input type="text" name="username" id="username" autocomplete="username" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                            <div>
                                <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password" autocomplete="new-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-800 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mb-4">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
