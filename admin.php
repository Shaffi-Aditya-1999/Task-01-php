<?php 
include 'auth.php'; 
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" rel="stylesheet">
    <link href= "https://cdn.datatables.net/buttons/3.2.5/css/buttons.dataTables.css" rel="stylesheet">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">Employee Records</a>

   

    <!-- USER DETAILS -->
    <div class="ms-auto d-flex flex-column text-end text-white" style="line-height: 1.2;">
        <span><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']); ?></span>
        <span><strong>Logged In As:</strong> <?= htmlspecialchars($_SESSION['role']); ?></span>
    </div>

    <a href="Add_Student.php" class="btn btn-primary ms-3">+ Add Employee</a>
    <a href="logout.php" class="btn btn-info ms-3" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
</nav>



<!-- TABLE SECTION -->
<div class="container p-4">

<?php
$sql = "SELECT * FROM student";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "
        <table id='example' class='display table table-striped table-bordered'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

    $i = 0;
    while ($row = $result->fetch_assoc()) {

        echo "
            <tr>
                <td>" . ++$i . "</td>
                <td>" . $row['ENAME'] . "</td>
                <td>" . $row['EDESIGNATION'] . "</td>
                <td>" . $row['ESAL'] . "</td>
                <td>
                    <a href='update.php?id=" . $row['EID'] . "' class='btn btn-primary'>Update</a>
                    <a href='delete.php?id=" . $row['EID'] . "' class='btn btn-danger'
                        onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                    <a href='./uploads/" . $row['attachment'] . "' target='_blank' class='btn btn-info'>View</a>
                </td>
            </tr>";
    }

    echo "</tbody></table>";

} else {
    echo "<h3 class='text-center'>No Records Found</h3>";
}

$conn->close();
?>

</div>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.5/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.dataTables.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    $('#example').DataTable({
        "pageLength": 5,
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });
});
</script>
</body>
</html>
