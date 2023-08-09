<?php 
require_once 'pdo.php';
session_start();
if (isset($_POST['cancel'])) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}
if (isset($_POST['submit'])) {
    if (isset($_POST['first_name']) && isset($_POST['last_name'])&& isset($_POST['email'])&& isset($_POST['headline']) && isset($_POST['summary'])){
        if (empty($_POST['first_name']) || empty($_POST['last_name']) ||  empty($_POST['email']) || empty($_POST['headline']) || empty($_POST['summary'])) {
            $_SESSION['error'] = "All fields are required ";
            $_SESSION['hidden_field'] = $_POST['profile_id'];
            header("Location: edit.php");
            return; 
        
    }
    if (strpos($_POST['email'], '@')=== false) {
        $_SESSION['error'] = "Email Address must contain @";
        $_SESSION['hidden_field'] = $_POST['profile_id'];
            header("Location: edit.php");
            return; 
        } 
    } 
    $stmt =$pdo->prepare('UPDATE `Profile` SET `first_name`=:fn,`last_name`=:ln,`email`=:em,`headline`=:he,`summary`=:su WHERE `profile_id`=:p_id');
    $stmt->execute(array(
        ':fn' => htmlentities($_POST['first_name']),
        ':ln' => htmlentities($_POST['last_name']),
        ':em' => htmlentities($_POST['email']),
        ':he' => htmlentities($_POST['headline']),
        ':su' => htmlentities($_POST['summary']),
        ':p_id' => htmlentities($_POST['profile_id'])
    ));
    $_SESSION['Update_success'] = "Recored Updated";
    header("Location: index.php");
        return; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saqib Ur Rehman's Profile's Edit Page</title>
    <!-- bootstrap.php - this is HTML -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Editing Profile for <?php echo $_SESSION['name']; ?> </h1>
<?php 
if (isset($_SESSION['error'])) {
    echo '<p style= "color:red;">' . htmlentities($_SESSION['error']) . "</p>\n";
    unset($_SESSION['error']);
    } ?>
<form action="edit.php" method="post">
<?php  
if (isset($_GET['profile_id']) || isset($_POST['profile_id']) || isset($_SESSION['hidden_field'])) {
//Get the existing data from the database
if (isset($_GET['profile_id']) || isset($_POST['profile_id'])){
 $id = $_REQUEST['profile_id']; 
} else {
    $id = $_SESSION['hidden_field'];
}
$stmt = $pdo->prepare("SELECT * from Profile WHERE profile_id = $id");
$stmt->execute();
$contents = $stmt->fetchAll();
foreach($contents as $content){ ?>
<p>First Name:<input type="text" name="first_name" size="60" value="<?php echo $content['first_name'];  ?> "/></p>
<p>Last Name: <input type="text" name="last_name" size="60" value="<?php  echo $content['last_name']; ?> "/></p>
<p>Email: <input type="text" name="email" size="30" value="<?php echo $content['email'];  ?> "/></p>
<p>Headline:<input type="text" name="headline" size="80" value="<?php echo $content['headline']; ?> "/></p>
<p>Summary:<br/><textarea name="summary" rows="8" cols="80"><?php echo $content['summary']; ?> </textarea></p>
<input type="hidden" name="profile_id" value="<?php  echo $content['profile_id']?>"/>    
<input type="submit" name="submit" value="Update">
<input type="submit" name="cancel" value="Cancel">
</form>
<?php }} ?>

</div>
</body>
</html>