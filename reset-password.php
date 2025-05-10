<?php
$swalPass = '';
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $swalPass = "<script>Swal.fire({ title: 'Success!', text: 'Password successfully changed!', icon: 'success', showConfirmButton: false,
    timer: 1825});</script>";
} else if (isset($_GET['status']) && $_GET['status'] === 'fail') {
    $swalPass = "<script>Swal.fire({ title: 'Error', text: 'Passwords do not match', icon: 'error', showConfirmButton: false,
    timer: 1825});</script>";
}
$token = $_GET['token'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="frontpageStyle.css?v=1.2" />
    <title>Reset Password | Himlayang Palanyag</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body .main-content {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 0;
        height: 91.2vh;
        backdrop-filter: blur(20px);


    }

    .reset-container {
        margin-top: -5rem;
        width: 25rem;
        height: 10rem;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, .2);
        border-radius: 1rem;
        background-color: rgb(248, 248, 248);
        padding: 4rem;
    }

    .reset-container form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        gap: 2rem;
    }

    .reset-container form label {
        display: flex;
        flex-direction: column;
        gap: .2rem;
    }

    input {
        border: 1px solid grey;
        border-radius: 1rem;
        height: 2rem;
        padding: 0 1rem;
    }

    button {
        border: none;
        border-radius: 1rem;
        padding: 1rem;
        background-color: rgb(180, 233, 183);
        color: black;
        transition: .25s;
    }

    button:hover {
        cursor: pointer;
        background-color: rgb(144, 211, 164);
    }

    .grayscale {
        background: url('res/images/reset-password.jpg');
        -moz-filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
        -o-filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
        -webkit-filter: grayscale(100%);
        filter: gray;
        filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");

        border-image: linear-gradient(rgba(238, 238, 238, 0.3),
                rgba(238, 238, 238, 0.3)) fill 1;
    }

    .background-image {
        background-repeat: no-repeat;
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
    }
    </style>
</head>

<body>
    <div class="background-image grayscale"></div>
    <nav>
        <div class="brand-container">
            <img src="res/images/hp-logo.png" width="49" />
            <h2 class="brand-title">Himlayang Palanyag Cemetery <span>Digital Navigation System</span></h2>
        </div>
    </nav>
    <div class="main-content">
        <div class="reset-container">
            <form method="POST" action="process-reset-password.php">
                <label for="password">Password<input type="password" placeholder="Enter password here"></label>
                <label for="repeat-password">Repeat password<input type="password"
                        placeholder="Repeat password"></label>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <button type="submit">Change password</button><?php echo $swalPass ?>
            </form>
        </div>
    </div>
</body>

</html>