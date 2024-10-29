<?php
// Database connection (update with your credentials)
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "u396395651_mediport";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch ECG parameters from the database
$sql = "SELECT * FROM ecg_parameters";
$result = $conn->query($sql);

$ecg_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ecg_data[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>MEDIPORT</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#">CONTACT A DOCTOR</a></li>
                <li><a href="#who_are_we">WHO WE ARE</a></li>
                <li><a href="#">NEWS STAND</a></li>
                <li id="profile-button" style="display: none;"><a href="#" class="profile-btn">MY PROFILE</a></li>
                <li id="auth-button"><a href="#" class="profile-btn" id="login-logout-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Our journey to wellness begins here—<br>Trusted care for a healthier tomorrow.</h2>
            <a href="#" class="btn" id="login-btn">Login</a>
        </section>

        <section class="images">
            <img src="./img/img1.jpeg" alt="Medical Image 1">
            <img src="./img/img2.jpeg" alt="Doctor Image">
        </section>

        <section class="content">
            <h3 id="who_are_we">What We Believe</h3>
            <p>We believe in treating the whole person—mind, body, and spirit—with compassionate, personalized care. Our mission is to empower patients through knowledge, combining cutting-edge medical science with a deeply human approach.</p>

            <h3>ECG Parameters</h3>
            <?php if (!empty($ecg_data)): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Age</th>
                        <th>HR Mean</th>
                        <th>HR Std</th>
                        <th>Amplitude Mean</th>
                        <th>QRS Mean</th>
                        <th>QT Mean</th>
                        <th>ST Level Mean</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ecg_data as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['subject']); ?></td>
                        <td><?php echo htmlspecialchars($data['age']); ?></td>
                        <td><?php echo htmlspecialchars($data['hr_mean']); ?></td>
                        <td><?php echo htmlspecialchars($data['hr_std']); ?></td>
                        <td><?php echo htmlspecialchars($data['amp_mean']); ?></td>
                        <td><?php echo htmlspecialchars($data['qrs_mean']); ?></td>
                        <td><?php echo htmlspecialchars($data['qt_mean']); ?></td>
                        <td><?php echo htmlspecialchars($data['st_level_mean']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No ECG data available.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Login Popup -->
    <div id="login-modal" class="modal_login" style="display:none;">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="form-title">Login</h2>
            <form action="#" method="post" id="login_form" style="display: block;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" ><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br><br>
                <button type="submit" id="login" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="./register.html" id="register_formbtn">Register here</a></p>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#login").click(function(e){
                e.preventDefault();
                let email = $("#email").val();
                let password = $("#password").val();
                if(email === "") {
                    alert("Email is required!");
                } else if(password === "") {
                    alert("Password is required!");
                } else {
                    $.ajax({
                        url: 'loginath.php',
                        method: "POST",
                        data: { email: email, password: password },
                        dataType: 'json',
                        success: function(response) {
                            if(response.status === 1) {
                                alert(response.message);
                                window.location.href = 'dashboard.php';
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            });
        });

        function updateAuthButton() {
            const authButton = document.getElementById('login-logout-btn');
            const profileButton = document.getElementById('profile-button');

            if (isLoggedIn) {
                authButton.textContent = 'Logout';
                profileButton.style.display = 'block';
            } else {
                authButton.textContent = 'Login';
                profileButton.style.display = 'none';
            }
        }

        let isLoggedIn = false;
        updateAuthButton();
    </script>
</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>MEDIPORT</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#">CONTACT A DOCTOR</a></li>
                <li><a href="#who_are_we">WHO WE ARE</a></li>
                <li><a href="#">NEWS STAND</a></li>
                <li id="profile-button" style="display: none;"><a href="#" class="profile-btn">MY PROFILE</a></li>
                <li id="auth-button"><a href="#" class="profile-btn" id="login-logout-btn">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Our journey to wellness begins here—<br>Trusted care for a healthier tomorrow.</h2>
            <a href="#" class="btn" id="login-btn">Login</a>
        </section>

        <section class="images">
            <img src="./img/img1.jpeg" alt="Medical Image 1">
            <img src="./img/img2.jpeg" alt="Doctor Image">
        </section>

        <section class="content">
            <h3 id="who_are_we">What We Believe</h3>
            <p>We believe in treating the whole person—mind, body, and spirit—with compassionate, personalized care. Our mission is to empower patients through knowledge, combining cutting-edge medical science with a deeply human approach.</p>
            <p>Building trust and fostering strong patient relationships are at the core of our practice. We are committed to promoting wellness, preventing disease, and supporting you on your journey to better health. Your voice matters, and your health is our shared priority.</p>

            <h3>What are We Forgetting?</h3>
            <p>In our busy lives, it's easy to overlook key aspects of our health. Regular check-ups, screenings, and following prescribed treatments are crucial for preventing and managing health issues. Prioritizing mental health, maintaining a balanced diet, exercising, getting enough sleep, and staying hydrated are essential for overall well-being. Don't forget the importance of follow-up appointments and self-care to reduce stress and recharge. We're here to support you in remembering and prioritizing these vital aspects of your health.</p>
        </section>
    </main>

    <!-- Login Popup -->
    <div id="login-modal" class="modal_login" style="display:none;">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="form-title">Login</h2>
            <form action="#" method="post" id="login_form" style="display: block;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" ><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br><br>
                <button type="submit" id="login" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="./register.html" id="register_formbtn">Register here</a></p>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--<script src="script.js"></script>-->
    <script>
        $(document).ready(function(){
            $("#login").click(function(e){
                e.preventDefault();
                let email = $("#email").val();
                let password = $("#password").val();
                if(email == "")
                {
                    alert("Email is required!");
                }
                else if(password == "")
                {
                    alert("Password is required!");
                }
                else 
                {
                    $.ajax({
                        url:   'loginath.php',
                        method: "POST",
                        data: {
                            email : email,
                            password: password
                        },
                        dataType: 'json',
                        success:function(response)
                        {
                            if(response['status'] == 1)
                            {
                                alert(response['message']);
                                window.location.href = 'dashboard.php' ;
                            }
                            else if(response['status'] == 2)
                            {
                                alert(response['message']);
                            }
                            else
                            {
                                alert("Something went wrong! Try again later");
                            } 
                        }
                    });
                }
            });
        });
    </script>
    <script>
        // Simulated login state (this should come from your actual authentication logic)
        let isLoggedIn = false; // Change this to true when the user logs in

        function updateAuthButton() {
            const authButton = document.getElementById('login-logout-btn');
            const profileButton = document.getElementById('profile-button');

            if (isLoggedIn) {
                authButton.textContent = 'Logout';
                authButton.href = '#'; // Set this to your logout function
                authButton.onclick = function () {
                    logout(); // Call logout function
                    return false; // Prevent default action
                };
                profileButton.style.display = 'block'; // Show "My Profile" button
            } else {
                authButton.textContent = 'Login';
                authButton.href = '#';
                authButton.onclick = function () {
                    openLoginModal(); // Call function to open login modal
                    return false; // Prevent default action
                };
                profileButton.style.display = 'none'; // Hide "My Profile" button
            }
        }

        function logout() {
            // Add your logout logic here
            isLoggedIn = false; // Update login state
            updateAuthButton(); // Update button after logout
            // You may also want to clear any user data from local storage or session storage
        }

        function openLoginModal() {
            const modal = document.getElementById('login-modal');
            modal.style.display = 'block'; // Show the login modal
        }

        // Call this function to set the initial state of the login/logout button
        updateAuthButton();
    </script>
</body>
</html>
