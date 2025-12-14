<?php

include 'connection.php';

session_start();
if (isset($_POST['submit'])) {

    $eid = $_POST['id'];
    $empname = $_POST['ename'];
    $designation = $_POST['edes'];
    $salary = $_POST['esal'];
    


    // FILE DETAILS
    $name = $_FILES['myfile']['name'];
    $tmp = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    // Move uploaded file
    if (!empty($name)) {
        move_uploaded_file($tmp, "uploads/" . $name);
    }

    $sql = "UPDATE student SET 
                ENAME='$empname',
                EDESIGNATION='$designation',
                ESAL='$salary',
                attachment='$name'
            WHERE
                EID='$eid' ";

    $result = $conn->query($sql);

    if ($result) {

        $file = "./uploads/" .$_SESSION['existing_attachment'];
        unlink($file);
        echo "
            <script>
                alert('Record Updated Successfully');
                window.location.href='admin.php';
            </script>
        ";
    } else {
        echo "Error Occurred: " . $conn->error;
    }

    $conn->close();
}

?>