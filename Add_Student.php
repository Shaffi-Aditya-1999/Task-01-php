<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        Enter Employee Name: <input type="text" name="ename" placeholder="Enter Employee Name" required><br><br>
        Enter Employee Designation: <input type="text" name="edes" placeholder="Enter Employee Designation" required><br><br>
        Enter Employee Salary: <input type="text" name="esal" placeholder="Enter Employee Salary" required><br><br>
        Upload A File :
        <input type="file" id="fileInput" name="myfile" onchange="checkSize()"><br><br> 

        <button type="submit" name="submit">Add</button>
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

<?php

 include 'connection.php';

 if(isset($_POST['submit'])){
    

     $empname= $_POST['ename'];
     $designation=$_POST['edes'];
     $salary=$_POST['esal'];
     $name = $_FILES['myfile']['name'];
     $tmp  = $_FILES['myfile']['tmp_name'];
     $size= $_FILES['myfile']['size'];


     
    if ($size > 20 * 1024) {
        echo "<script>alert('File size must be less than 20 KB');</script>";
        exit;
    }

    if(!is_dir("uploads")) {
        mkdir("uploads");
    }



    move_uploaded_file($tmp, "uploads/" . $name);


   


  

     $sql="INSERT into 
     student (ENAME,EDESIGNATION,ESAL,attachment)

     values ('$empname','$designation',' $salary','$name') 
     ";

     $result= $conn-> query($sql);

     if($result)
     {
        echo "
            <script>
                alert('Record Inserted Successfully');
                window.location.href='admin.php';
            </script>
        ";
     }

     else{
        echo "Error Occurred" .$conn->error;
     }
     $conn->close();
 }
   

   
?>


