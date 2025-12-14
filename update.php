<?php
include 'connection.php';

session_start();

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM student WHERE EID = $id";

  

    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
          $_SESSION['existing_attachment']= $row['attachment'];
    } else {
        "Error Fetching Record:" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="update_process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['EID']; ?>">
        Enter Employee Name: <input type="text" name="ename" value="<?php echo $row['ENAME'] ?>" required><br><br>
        Enter Employee Designation: <input type="text" name="edes" value="<?php echo $row['EDESIGNATION'] ?>"
            required><br><br>
        Enter Employee Salary: <input type="text" name="esal" value="<?php echo $row['ESAL'] ?>" required><br><br>
        Upload A File :
        <input type="file" id="fileInput" name="myfile" value="<?php echo "uploads/" . $row['attachment'] ?>"
            onchange="checkSize()"><br><br>
        <button type="submit" name="submit">Update</button>
    </form>

    <script>
        function checkSize() {
            const fileInput = document.getElementById("fileInput");
            const file = fileInput.files[0];

            if (file.size > 20 * 1024) {
                alert("You cannot upload this file as it exceeds 20 KB.");
                fileInput.value = "";
            }
        }
    </script>
</body>

</html>