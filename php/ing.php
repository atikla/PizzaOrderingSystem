<?php
header('Content-Type: application/json');
require('db.php');
$sql = "SELECT name FROM student";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $test[] = $row; 
    }
    echo json_encode($test);
} else {
    echo "empty";
}
$conn->close();
?>