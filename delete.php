<?php 
// include database connection file
require_once 'pdo.php'; 
if (isset($_POST['cancel'])) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Saqib Ur Rehman's Profile Delete Page</title>
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
<h1>Deleteing Profile</h1>
<form method="POST" action="">
<?php 
if (!isset($_POST['delete'])){
$id = $_GET['profile_id'];
$stmt = $pdo->prepare("SELECT * from Profile WHERE profile_id = $id");
$stmt->execute();
$contents = $stmt->fetchAll(); 
foreach($contents as $content){ ?>
<p>First Name: <?php echo $content['first_name'] ?> </p>
<p>Last Name: <?php echo $content['last_name'] ?> </p>
<input type="hidden" name="profile_id" value="<?php  echo $content['profile_id']  ?>"/>

<input type="submit" name="delete" value="Delete">
<input type="submit" name="cancel" value="Cancel">
</form>
<?php }}  
if (isset($_POST['delete'])) {

$profileId=intval($_GET['profile_id']);

$stmt = "DELETE FROM `Profile` WHERE `Profile`.`profile_id` =:id";
$query = $pdo->prepare($stmt);
$query-> bindParam(':id',$profileId, PDO::PARAM_STR);
// Query Execution
$query -> execute();
// Redirect the browser to index.php
header("Location: index.php");
return;
}



?>
</div>
</body>
</html>
