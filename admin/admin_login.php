<?php
require_once '../load.php';

$ip = $_SERVER['REMOTE_ADDR'];

if (isset($_SESSION['user_id'])) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (!empty($username) && !empty($password)) {
        $result = login($username, $password, $ip);
        $message = $result;
    } else {
        $message = 'Please fill out the required fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to The Admin Panel</title>
</head>
<body>
    <?php echo !empty($message)?$message:''; ?>
    <form action="admin_login.php" method="post">
        <label for="username">Username:</label>
        <input id="username" name="username" type="text" name="username" value="">
        <br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>