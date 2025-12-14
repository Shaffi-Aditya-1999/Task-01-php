<?php
include 'connection.php';



session_start();

$error = "";

// Check if error is sent via GET
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

if (isset($_POST['submit'])) {

    $username = $_POST['uname'];
    $password = $_POST['password'];


    // USERNAME VALIDATION (letters + numbers + underscore)
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        echo "<script>
                alert('Username can only contain letters, numbers, and underscore');
                window.history.back();
              </script>";
        exit();
    }
    

     // 4. PASSWORD MINIMUM LENGTH
    if (strlen($password) < 6) {
        echo "<script>
                alert('Password must be at least 6 characters long');
                window.history.back();
              </script>";
        exit();
    }


   if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z0-9@$!%*?&]{6,}$/", $password)) {
    echo "<script>
            alert('Password must contain at least 1 lowercase, 1 uppercase, 1 number, and 1 special symbol');
            window.history.back();
          </script>";
    exit();
}


    $sql = "SELECT * FROM role_based_table WHERE UserName='$username' AND my_password='$password'";
    $result = $conn->query($sql);

    if (!$result) {
        header("Location: index.php?error=Database query failed!");
        exit();
    } 
    elseif ($result->num_rows == 0) {
        echo "<script>
        alert('Invalid User Name Or Password');
        window.location.href='index.php';
        </script>";
    } 
    else {
        $row = $result->fetch_assoc();
         $_SESSION['username']=$username;
        $_SESSION['role']=$row['Role'];
        $role = strtolower($row['Role']);

        if ($role === "user") {
            header("Location: user.php");
            exit();
        } else {
            header("Location: admin.php");
            exit();
        }
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    
    <div class="card shadow p-4" style="width: 450px; border-radius: 15px;">
        <h3 class="text-center mb-3">Login</h3>

      

        <form action="" method="post">
            
            <label class="form-label">Username:</label>
            <input type="text" name="uname" class="form-control mb-3" required>

            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control mb-4" required>

            <div class="d-flex gap-2">
            <button type="submit" name="submit" class="btn btn-success w-50">Login</button>
           <a href="register.php" class="btn btn-primary w-50">New User Register Here?</a>
           <a href="forgotpassword.php" class="btn btn-secondary w-50">Forgot Password</a>
        </div>
</form>
    </div>

</div>

</body>
</html>



