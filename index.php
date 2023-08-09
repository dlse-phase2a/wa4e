<?php 
// connection to db
require_once 'pdo.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Saqib Ur Rehman's Resume Registry</title>
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
<h1>Saqib Ur Rehman's Resume Registry</h1>

<?php 
//Data added successfully
if (isset($_SESSION['add_success'])){
    echo $_SESSION['add_success'];
    unset ($_SESSION['add_success']);
}
//profile Updated successfully
if (isset($_SESSION['Update_success'])){
    echo $_SESSION['Update_success'];
    unset ($_SESSION['Update_success']);
}
//check whether user is logged in or not
if (!isset($_SESSION['success'])) {
    echo '<p><a href="login.php">Please Log In</a></p>';
} 
?>
<?php if (isset($_SESSION['success'])) { ?>
<p><a href="logout.php">Logout</a></p>
<p><a href="add.php">Add New Entry</a></p>
    <!-- if user is logged in -->
 <?php 
 $stmt = $pdo->prepare("SELECT * FROM `Profile`");
$stmt->execute();   
 $contents = $stmt->fetchAll();  
 if (!empty($contents)) { ?>
 <table border ="1">
<tr><th>Name</th><th>Headline</th><th>Action</th><tr>
<?php foreach($contents as $content){ ?>
    <tr>
        <td><a href="view.php?profile_id=<?php echo $content['profile_id']; ?> "> 
        <?php echo $content['first_name']; ?></a></td>
        <td> <?php echo $content['headline'] ?></td>
        <td><a href="edit.php?profile_id=<?php echo $content['profile_id']; ?>">Edit</a>
            <a href="delete.php?profile_id=<?php echo $content['profile_id']; ?>">Delete</a></td>
    </tr>
<?php }  ?>  
</table>  
<?php  } }?>
<p><strong>Note:</strong> Your implementation should retain data across multiple logout/login sessions. 
This sample implementation clears all its data periodically 
- which you should not do in your implementation.</p>
</div>
</body>