<?php
include "dbconfig.php";
 if (isset($_POST['submit']))
 {
 $name = $_POST['name'];
 $age = $_POST['age'];
 $email = $_POST['email'];
 $sql = "INSERT INTO `students`(`name`, `age`, `email`) VALUES
('$name','$age','$email')";
 $result = $conn->query($sql);
 if ($result == TRUE)
 {
 echo "New record created successfully.";
 header('Location: view-process.php');
 }
 Else
 {
 echo "Error:". $sql . "<br>". $conn->error;
 }
 $conn->close();
 }
?>