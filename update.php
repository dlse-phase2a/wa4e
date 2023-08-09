<?php
// ************upadate posted data***********
if (isset($_POST['update'])) {
  //check the inputs that are set or not???
    if (strlen($_POST['first_name'])==0 || strlen($_POST['last_name'])==0 
        || strlen($_POST['email'])==0 || strlen($_POST['headline'])==0
        ||  strlen($_POST['summary'])==0){
        $_SESSION['error'] = "All fields are required ";
         header("Location: index.php");
         return; 
        }
// check if user provide email with @ symbol
        if (strpos($_POST['email'], '@')=== false) {
        $_SESSION['error'] = "Email Address must contain @";
        header("Location: edit1.php");
    return;
        }
    $stmt =$pdo->prepare('UPDATE `Profile` SET `first_name`=:fn,`last_name`=:ln,`email`=:em,`headline`=:he,`summary`=:su WHERE `profile_id`=:p_id');
    $stmt->execute(array(
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'],
        ':p_id' => $_POST['profile_id']
    ));
    header("Location: index.php");
    return; 
    
}

