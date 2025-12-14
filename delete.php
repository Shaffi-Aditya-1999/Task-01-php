<?php
include 'connection.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];

   

    $sql1 = "DELETE FROM student WHERE EID = $id";

    $sql2="SELECT * FROM student WHERE EID=$id";

    $result=$conn->query($sql2);

    $row=$result->fetch_assoc();

    $attachment_name=$row['attachment'];

    $file = "./uploads/" .$attachment_name;


    unlink($file);

    if($conn->query($sql1)){
        echo "
            <script>
                alert('Row with ID $id has been deleted Successfully');
                window.location.href='admin.php'; // redirect back
            </script>
        ";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
