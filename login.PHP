<?php

// set global variables
$error = "";
$msg = "";
$htm = "index.htm";


function check ()
{
  global $htm, $error, $msg;

  if ($_SERVER["REQUEST_METHOD"] != "POST")
    return;
    
  $user     = $_POST["Username"];
  $password = $_POST["Password"];


  if ($user == '') {
    $error = "<br><h2>User Name Required</h2>";
    return;
  }

  if ($password == '') {
    $error = "<br><h2>Password Required</h2>";
    return;
  }

  $dbserver = "localhost";
  $dbuser   = "root";
  $dbpassword = "";


  $conn = mysqli_connect ($dbserver, $dbuser, $dbpassword);
  if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

  $sql = sprintf ("SELECT * FROM test.logins WHERE username = '%s' AND password = '%s'", $user, $password);

  $result = $conn->query($sql);
  if ($result->num_rows == 0) {
    mysqli_close($conn);
    $error = "Invalid Login";
    return;
  }

  $row = $result->fetch_assoc();
  $firstname = $row['Firstname'];
  $lastname = $row['Lastname'];


  mysqli_close($conn);

  $htm = "main.htm";
  $msg = sprintf ("Hello %s %s.", $firstname, $lastname);

}


// program starts here
check ();

// display html output;
include ($htm);

?>


