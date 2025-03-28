import Swal from "sweetalert2";

function popup(type) {
  if (type == "Registration successful!") {
    Swal.fire({
      title: "Success!",
      text: "Account successfully created.",
      icon: "success",
      confirmButtonText: "Confirm",
    });
  } else if (type == "Login successful!") {
    Swal.fire({
      title: "Success!",
      text: "Successfully logged in, please wait",
      icon: "success",
    });
  } else if (type == "Email already registered.") {
    Swal.fire({
      title: "Error!",
      text: "Account already exists.",
      icon: "error",
    });
  }
}

// onclick="popup('<?php echo addslashes($message) ?>')"
