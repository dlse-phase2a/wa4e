<?php
require_once 'pdo.php';

session_start();
if (isset($_POST['first_name'])){
    echo $_POST['first_name'];
}

if (!isset($_SESSION['user_id'])) {
    die('access denied');
    return;
} 
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}
//check the inputs that are set or not???
if (isset($_POST['first_name']) && isset($_POST['last_name'])&& isset($_POST['email'])&& isset($_POST['headline']) && isset($_POST['summary'])){
        if (strlen($_POST['first_name'])==0 || strlen($_POST['last_name'])==0 
        || strlen($_POST['email'])==0 || strlen($_POST['headline'])==0
        ||  strlen($_POST['summary'])==0){
        $_SESSION['error'] = "All fields are required ";
         header("Location: add.php");
         return; 
        }    
// check if user provide email with @ symbol
        if (strpos($_POST['email'], '@')=== false) {
        $_SESSION['error'] = "Email Address must contain @";
        header("Location: add.php");
        return;
        }
//insert data into database using prepare statment to avoid html injection
    $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES 
                         ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
            ':uid' => htmlentities($_SESSION['user_id']),
            ':fn' => htmlentities($_POST['first_name']),
            ':ln' => htmlentities($_POST['last_name']),
            ':em' => htmlentities($_POST['email']),
            ':he' => htmlentities($_POST['headline']),
            ':su' => htmlentities($_POST['summary'])
        )
    );
    $_SESSION['add_success'] = "Profile Added";
// Redirect to root page after data inserted into database
    header("Location: index.php");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Adding Profile for <?php echo $_SESSION['name'] ?></h1>
        <?php if (isset($_SESSION['error'])) {
            echo '<p style= "color:red;">' . htmlentities($_SESSION['error']) . "</p>\n";
            unset($_SESSION['error']);
        } ?>

        <form method="post" action="">
            <p>First Name:
                <input type="text" name="first_name" size="60" />
            </p>
            <p>Last Name:
                <input type="text" name="last_name" size="60" />
            </p>
            <p>Email:
                <input type="text" name="email" size="30" />
            </p>
            <p>Headline:<br />
                <input type="text" name="headline" size="80" />
            </p>
            <p>Summary:<br />
                <textarea name="summary" rows="8" cols="80">
                </textarea>
            <p>
                <input type="submit" value="Add">
                <input type="submit" name="cancel" value="Cancel">
            </p>
        </form>
    </div>
</body>
</html>