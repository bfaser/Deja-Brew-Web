
<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" href="../styles/defualt.css">
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$firstNameErr = $lastNameErr = $emailErr = $commentErr = "";
$firstName = $lastName = $email = $comment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstName"])) {
    $firstNameErr = "Name is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName)) {
      $firstNameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["lastName"])) {
    $lastNameErr = "Last Name is required";
  } else {
    $lastName = test_input($_POST["lastName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastName)) {
      $lastNameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["comment"])) {
    $commentErr = "Comment is required";
  } else {
    $comment = test_input($_POST["comment"]);
  }
  if (!preg_match("/^[a-zA-Z-' ]*$/",$comment)) {
    $commentErr = "Only letters and white space allowed";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<header>
<h2>PHP Form Validation Example</h2>
</header>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  First Name: <input type="text" name="firstName" value="<?php echo $firstName;?>">
  <span class="error">* <?php echo $firstNameErr;?></span>
  Last Name: <input type="text" name="lastName" value="<?php echo $lastName;?>">
  <span class="error">* <?php echo $lastNameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <span class="error">*</span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $firstName;
echo "&nbsp";
echo $lastName;
echo "<br>";
echo $email;
echo "<br>";
echo $comment;
echo "<br>";

$feedbackFile = fopen('feedbackDoc.txt','a') or die("Unable to open file");
date_default_timezone_set("America/Los_Angeles");
$feedback = "\n $firstName  $lastName \n $email \n $comment \n";
$date = date("m/d/Y");
$time = date("h:i:sa");
$timestamp = "$time    $date";
fwrite($feedbackFile, $timestamp);
fwrite($feedbackFile, $feedback);
fclose($feedbackFile);
?>

</body>
</html>