<?php
    $swalLogin = '';
    $message   = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['email'] === 'admin@example.com' && $_POST['password'] === '123') {
            $message   = "Login success!";
            $swalLogin = "<script>Swal.fire('Success!', 'You are logged in.', 'success');</script>";
        } else {
            $message   = "Login failed!";
            $swalLogin = "<script>Swal.fire('Oops!', 'Invalid credentials.', 'error');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Test</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<form method="post">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Log In</button>
</form>

<p><?php echo $message; ?></p>

<?php echo $swalLogin; ?>

</body>
</html>
