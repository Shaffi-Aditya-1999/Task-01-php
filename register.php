<?php


include 'connection.php';

if(isset($_POST['submit'])){
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $username = $_POST['uname'];
    $password = $_POST['password'];
    $mobile   = $_POST['pnumber'];
    $role     = "user";


    

$secretKey = "6Le1KyksAAAAAOwRSnfbBG6G9CsXYhjXu58TrSQB";
$responseKey = $_POST['g-recaptcha-response'];
$userIP = $_SERVER['REMOTE_ADDR'];

$verifyURL = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

$response = file_get_contents($verifyURL);
$result = json_decode($response);





  // 1. NAME VALIDATION
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        echo "<script>
                alert('Name should only contain letters');
                window.history.back();
              </script>";
        exit();
    }

    // 2. EMAIL FORMAT VALIDATION
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Invalid email format');
                window.history.back();
              </script>";
        exit();
    }

    // 3. USERNAME VALIDATION (letters + numbers + underscore)
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


    // 6. PHONE NUMBER VALIDATION (10 digits only)
    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        echo "<script>
                alert('Phone number must be exactly 10 digits');
                window.history.back();
              </script>";
        exit();
    }




    //  CHECK IF EMAIL ALREADY EXISTS
    $checkEmailQuery = "SELECT * FROM role_based_table WHERE email_id = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        echo "<script>
                alert('This email is already registered. Please use another email.');
                window.location.href='register.php';
              </script>";
        exit();
    }


    if ($result->success) {
 

    // INSERT NEW USER
    $sql2 = "INSERT INTO role_based_table 
                (Name, email_id, UserName, my_password, phone_number, Role) 
             VALUES
                ('$name', '$email', '$username', '$password', '$mobile', '$role')";

    if ($conn->query($sql2)) {
        echo "<script>
                alert('Registration Successful');
                window.location.href='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Error Inserting Record: " . $conn->error . "');
              </script>";
    }
}
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh; width:700px">
    
    <div class="card shadow p-4" style="width: 350px; border-radius: 15px;">
        <h3 class="text-center mb-3">Registeration Form</h3>


        <form action="" method="post">

    <label class="form-label">Name:</label>
    <input type="text" name="name" class="form-control mb-3" required>

    <label class="form-label">Email:</label>
    <input type="email" name="email" class="form-control mb-3" required>

    <label class="form-label">Username:</label>
    <input type="text" name="uname" class="form-control mb-3" required>

    <label class="form-label">Password:</label>
    <input type="password" name="password" class="form-control mb-4" required>

    <label class="form-label">Phone Number:</label>
    <input type="text" name="pnumber" class="form-control mb-3" required>

    <!-- FIX: reCAPTCHA must be inside the form -->
    <div class="g-recaptcha mb-3"
         data-sitekey="6Le1KyksAAAAAGqAC8wh76LjPAEcteVU41Zrftbd"></div>

    <div class="d-flex gap-2">
        <button type="submit" name="submit" class="btn btn-success w-50">Register</button>
        <a href="index.php" class="btn btn-primary w-50">Existing User? Login Here</a>
    </div>

</form>
    </div>

        
</div>

</body>
</html>