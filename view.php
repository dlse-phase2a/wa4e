<?php 
require_once 'pdo.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Saqib Ur Rehman's Profile View</title>
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
<h1>Profile information</h1>

<?php
$id = $_GET['profile_id'];
$stmt = $pdo->prepare("SELECT * from Profile WHERE profile_id = $id");
$stmt->execute();
$data = $stmt->fetchAll(); 
//setting session varaiable

foreach ($data as $d) {?> 
    <p>First Name: <?php echo $d['first_name'] ?></p>    
    <p>Last Name: <?php echo $d['last_name'] ?></p>    
    <p>Email:<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fc8f9d8d959ebc9d9e9fd29f9391">[email&#160;protected]</a></p>
    <p>Headlines: <?php echo $d['headline'] ?></p>  
    <p>Summary: <?php echo $d['summary'] ?></p>  
<?php } ?>


</p><a href="index.php">Done</a>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js">
</script>
</body>
</html>
