<?php
require_once 'pdo.php';
session_start();
// Do not put any HTML above this line
if (isset($_POST['cancel'])) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
if (isset($_POST['email']) && isset($_POST['pass'])) {
    $check = hash('md5', $salt . $_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users
    WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) {
    $_SESSION['name'] = $row['name'];
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['success'] = true;

    // Redirect the browser to index.php
    header("Location: index.php");
    return;
    } else {
        $_SESSION['error'] = "Incorrect Password";
        header("Location: login.php");
        return;
    }
}
?>
<!-- view code goes here -->
<!DOCTYPE html>
<html><head>
    <?php require_once "bootstrap.php"; ?>
    <title>Saqib Ur Rehman's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if (isset($_SESSION['error'])) {
    echo '<p style= "color:red;">'. htmlentities($_SESSION['error'])."</p>\n";
    unset($_SESSION['error']);
}
?>

<form method="POST" action="">
    <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" name="email" id="id_1700">
    </div>
    <div class="form-group">
    <label for="id_1723">Password:</label>
    <input type="password" name="pass" id="id_1723">
    </div>
    <input type="submit" onclick="return doValidate();" value="Log In" class="btn btn-primary">
    <input type="submit" name="cancel" value="Cancel" class="btn btn-primary">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint:the account is umsi@umich.edu The password is the three character name of the programming language used in class(all lower case) followed by 123 -->
</p>
<!-- javascript Validation Code goes here -->
<script>
function doValidate() {
console.log('Validating...');
try {
addr = document.getElementById('id_1700').value;
 pw = document.getElementById('id_1723').value;
console.log("Validating = " + addr + " pw=" + pw);
if (addr == null || addr == "" || pw == null || pw == "") {
    alert("Both fields must be filled out");
    return false;
        }
if (addr.indexOf('@') == -1) {
    alert("Invalid Email Address");
     return false;
    }
    return true;
    }     catch (e) {
             return false;
            }
         return false;
            }
        </script>
    </div>
</body>