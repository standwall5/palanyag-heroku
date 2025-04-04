<?php
    session_start();
    require 'db.php';

    $message    = "";
    $messageReg = "";
    $swalLogin  = "";
    $swalReg    = "";
    // Register
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action']; // Determine if it's register or login

        $email    = $_POST['email'];
        $password = $_POST['password'];

        if ($action === "register") {
            $name = $_POST['name'];

            // Validate input
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $messageReg = "Invalid email format.";
                exit;
            }
            if (strlen($password) < 2) {
                $messageReg = "Password must be at least 2 characters long.";
                exit;
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Insert user into DB
                $sql  = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'name' => $name]);

                $message = "Registration successful!";
                $swalReg = "<script>Swal.fire({ title: 'Success!', text: 'Registration successful!', icon: 'success', showConfirmButton: false,
    timer: 1825});</script>";
            } catch (PDOException $e) {
                if ($e->getCode() == 23505) { // Unique constraint violation
                    $messageReg = "Email already registered.";
                    $swalReg    = "<script>Swal.fire({ title: 'Error!', text: 'Account already exists.', icon: 'error', showConfirmButton: false,
    timer: 1825});</script>";
                } else {
                    $messageReg = "Error: " . $e->getMessage();
                    $swalReg    = "<script>Swal.fire('Error!', '" . addslashes($messageReg) . "', 'error', showConfirmButton: false,
    timer: 1825);</script>";
                }
            }
        } elseif ($action === "login") {
            // Fetch user from DB
            $sql  = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Login successful, store session
                $message   = "Login successful!";
                $swalLogin = "<script>Swal.fire({ title: 'Success!', text: 'Login successful! Redirecting...', icon: 'success', showConfirmButton: false,
    timer: 1825}).then(function() {
        window.location = 'homepage.php';
    });;</script>";

                $_SESSION['user_id'] = $user['userid'];
                $_SESSION['email']   = $user['email'];
                $_SESSION['name']    = $user['name'];
            } else {
                $message   = "Invalid email or password.";
                $swalLogin = "<script>Swal.fire({ title: 'Login failed', text: 'Invalid email or password.', icon: 'error', showConfirmButton: false,
    timer: 1825});</script>";

            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="res/images/hp-logo.png"
      type="image/x-icon"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""
    />
    <script
      src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""
    ></script>
    <link rel="stylesheet" href="frontpageStyle.css" />
    <title>Navigation System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </head>
  <body>
    <nav>
      <div class="menu-icon" onclick="toggleMenu()">☰</div>
      <div class="brand-container">
        <img src="res/images/hp-logo.png" width="49" />
        <h2 class="brand-title">Palanyag Cemetery Digital Navigation System</h2>
      </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <ul>
        <li><a href="about.html">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contacts</a></li>
      </ul>
    </div>

    <div class="main-content" id="main-content">
      <div class="login">
        <img id="pqLogo" src="res/images/pqLogo.png" alt="" />
        <div id="slideshow">
          <div class="slide-wrapper">
            <div class="slide"></div>
            <div class="slide"></div>
            <div class="slide"></div>
            <div class="slide"></div>
            <div class="slide"></div>
          </div>
        </div>
        <!-- Login -->
        <form id="login-details" class="login-details" method="post" action="">
          <img src="res/images/hp-logo.png" alt="" />
          <div class="details">
          <input type="hidden" name="action" value="login">
          <input type="hidden" name="section" value="login">
            <label for="email"
              >EMAIL ADDRESS
              <input
                name="email"
                type="email"
                placeholder="Enter e-mail here"
                required
            /></label>
            <label for="password"
              >PASSWORD
              <input
                name="password"
                type="password"
                placeholder="Enter password"
                required
            /></label>
          </div>
          <button
            type="submit">
            Log in
          </button>
          <p class="indexMessage"><?php echo $message ?></p><?php echo $swalLogin ?>
          <a href="#" id="forgot">Forgot Password</a>
          <a href="#" id="signup">Signup!</a>
        </form>

        <!-- Sign-up/Register -->
        <form id="signup-details" class="signup-details login-details" method="POST" action="">
          <img src="res/images/hp-logo.png" alt="" />
          <div class="details">
          <input type="hidden" name="action" value="register">
          <input type="hidden" name="section" value="signup">
            <label for="email"
              >FULL NAME
              <input
                name="name"
                type="text"
                placeholder="ex. Juan P. Dela Cruz"
                required
            /></label>
            <label for="email"
              >EMAIL ADDRESS
              <input
                name="email"
                type="email"
                placeholder="Enter e-mail here"
                required
            /></label>
            <label for="password"
              >PASSWORD
              <input
                name="password"
                type="password"
                placeholder="Enter password"
                required
            /></label>
            <label for="repeat-password"
              >REPEAT PASSWORD
              <input
                name="repeat-password"
                type="password"
                placeholder="Repeat password"
                required
            /></label>
          </div>
          <button type="submit">Create Account</button>
          <p class="indexMessage"><?php echo $messageReg ?></p><?php echo $swalReg ?>
          <a href="#" class="login-btn">Already have an account? Login!</a>
        </form>

        <!-- Forgot details -->
        <form id="forgot-details" class="forgot-details login-details" action="">
          <img src="res/images/hp-logo.png" alt="" />
          <div class="details">
          <input type="hidden" name="section" value="forgot">
            <label for="email"
              >EMAIL ADDRESS
              <input
                name="email"
                type="email"
                placeholder="Enter e-mail here"
                required
            /></label>
          </div>
          <button type="submit">Change password</button>
          <a href="#" class="login-btn">Login!</a>
        </form>
      </div>
      <div class="map-container">
        <div class="search-container">
          <div class="search-box">
            <img src="res/images/search.png" alt="" />
            <input
              type="text"
              id="search"
              onkeydown="if(event.key === 'Enter') searchGrave()"
              class="search-bar"
              placeholder="name, birthday, death date...."
            />
          </div>
        </div>
        <a href="#" id="reset" onclick="resetMap()"
          ><img src="res/images/reset-icon.png" alt=""
        /></a>
        <div id="map"></div>
      </div>
    </div>

    <svg id="grainEffectSvg">
      <filter id="noiseFilter">
        <feTurbulence
          type="fractalNoise"
          baseFrequency="0.9"
          stitchTiles="stitch"
        />
        <feColorMatrix
          in="colorNoise"
          type="matrix"
          values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 1 0"
        />
        <feComposite operator="in" in2="SourceGraphic" result="monoNoise" />
        <feBlend in="SourceGraphic" in2="monoNoise" mode="screen" />
      </filter>
    </svg>

    <!-- Show login, signup & forgot -->

    <script>
 // Function to get URL parameters
function getQueryParam(param) {
  var params = new URLSearchParams(window.location.search);
  return params.get(param);
}

// Function to show a specific section
function showSection(section) {
  // Update the URL without reloading the page
  var newUrl = window.location.pathname + "?section=" + section;
  window.history.pushState({ path: newUrl }, "", newUrl);

  // Show/hide sections
  document.getElementById("login-details").style.display = section === "login" ? "flex" : "none";
  document.getElementById("signup-details").style.display = section === "signup" ? "flex" : "none";
  document.getElementById("forgot-details").style.display = section === "forgot" ? "flex" : "none";
}

// On page load, check for section in URL
document.addEventListener("DOMContentLoaded", function () {
  var activeSection = getQueryParam("section") || "login";
  showSection(activeSection);
});

// Show signup
document.getElementById("signup").addEventListener("click", function (event) {
  event.preventDefault();
  showSection("signup");
});

// Show forgot details
document.getElementById("forgot").addEventListener("click", function (event) {
  event.preventDefault();
  showSection("forgot");
});

// Show login
document.querySelectorAll(".login-btn").forEach((btn) => {
  btn.addEventListener("click", function (event) {
    event.preventDefault();
    showSection("login");
  });
});

</script>



    <script src="map.js"></script>

    <script>
      function toggleMenu() {
        let sidebar = document.getElementById("sidebar");
        let mainContent = document.getElementById("main-content");

        if (sidebar.classList.contains("open")) {
          sidebar.classList.remove("open");
          mainContent.classList.remove("dark");

          // mainContent.classList.remove("shift");
        } else {
          sidebar.classList.add("open");
          mainContent.classList.add("dark");

          // mainContent.classList.add("shift");
        }
      }
    </script>
  </body>
</html>
