<?php
    session_start();
    $fullName  = $_SESSION['name'];
    $nameParts = explode(" ", $fullName);

    // Get the first two words (if available)
    if (count($nameParts) === 3) {
        $shortName = $nameParts[0] . " " . $nameParts[1]; // Get only the first two words
    } else {
        $shortName = $fullName; // Keep the original name if it's not exactly 3 words
    }
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/@codingnepal -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Himlayang Palanyag</title>
    <link rel="stylesheet" href="homeStyle.css" />
    <!-- Linking Google Fonts for Icons -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <!-- Mobile Sidebar Menu Button -->
    <button class="sidebar-menu-button">
      <span class="material-symbols-rounded">menu</span>
    </button>
    <div class="main-container">
      <aside class="sidebar">
        <!-- Sidebar Header -->
        <header class="sidebar-header">
          <a href="#" class="header-logo">
            <img src="res/images/pqLogo.png" alt="CodingNepal" />
          </a>
          <button class="sidebar-toggler">
            <span class="material-symbols-rounded">chevron_left</span>
          </button>
        </header>

        <nav class="sidebar-nav">
          <!-- Primary Top Nav -->
          <ul class="nav-list primary-nav">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <span class="material-symbols-rounded">home</span>
                <span class="nav-label">Home</span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="nav-link dropdown-title">Home</a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <span class="material-symbols-rounded">deceased</span>
                <span class="nav-label">Deceased</span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="nav-link dropdown-title">Deceased</a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <span class="material-symbols-rounded">add</span>
                <span class="nav-label">Add New</span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="nav-link dropdown-title">Add New</a>
                </li>
              </ul>
            </li>
          </ul>

          <!-- Secondary Bottom Nav -->
          <ul class="nav-list secondary-nav">
            <li class="nav-item" onclick="window.location.href='logout.php'">
              <a
                href="logout.php"
                class="nav-link"
              >
                <span class="material-symbols-rounded">logout</span>
                <span class="nav-label">Sign Out</span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item" onclick="window.location.href='logout.php'">
                  <a href="logout.php" class="nav-link dropdown-title">Sign Out</a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </aside>

      <div class="content">
        <div id="main-content">
          <h2>Welcome to Himlayang Palanyag,                                                                                                                                                                                 <?php echo $shortName ?></h2>
          <p>Dynamic content will appear here.</p>
        </div>
      </div>
    </div>

    <!-- Script -->
    <script src="homeScript.js"></script>
  </body>
</html>
