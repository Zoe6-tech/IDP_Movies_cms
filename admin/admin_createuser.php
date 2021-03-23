<?php
require_once '../load.php';
// Redirect if user is Editor
// Like a switch to turn the 2nd level check in
// Yes, I am Admin
confirm_logged_in(true);

if (isset($_POST['submit'])) {
    $data = array(
        'fname'=>trim($_POST['fname']),
        'username'=>trim($_POST['username']),
        'password'=>trim($_POST['password']),
        'email'=>trim($_POST['email']),
        'user_level'=>trim($_POST['user_level'])
    );

    $message = createUser($data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>
    <h2>Create User</h2>
    <?php echo !empty($message)?$message:''; ?>
    <form action="admin_createuser.php" method="post">
        <label for="first_name">First Name</label>
        <input type="text" name="fname" id="first_name" value=""><br><br>

        <label for="username">Username</label>
        <input type="text" name="username" id="username" value=""><br><br>

        <label for="password">Password</label>
        <input type="text" name="passwprd" id="password" value=""><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value=""><br><br>

        <label for="user_level">User Level</label>
        <!-- Looping an array -->
        <select name="user_level" id="user_level">
            <?php $user_level_map = getUserLevelMap();
                foreach ($user_level_map as $val => $label):?>
            <option value="<?php echo $val; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>


        <button type="submit" name="submit">Create User</button>

    </form>
</body>
</html>