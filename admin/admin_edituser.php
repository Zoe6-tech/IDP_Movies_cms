<?php
require_once '../load.php';
confirm_logged_in();

$id = $_SESSION['user_id'];
$current_user = getSingleUser($id);

if (empty($current_user)) {
    $message = 'Failed to get user info';
}

if (isset($_POST['submit'])) {
    $data = array(
        'fname'=>trim($_POST['fname']),
        'username'=>trim($_POST['username']),
        'password'=>trim($_POST['password']),
        'email'=>trim($_POST['email']),
        // Only if you're Admin Above, Else it a "0" will be put
        'user_level'=>isCurrentUserAdminAbove()?trim($_POST['user_level']):'0',
        'id'=> $id
    );
    $message = editUser($data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <?php echo !empty($message)?$message:''; ?>
    <?php if (!empty($current_user)): ?>
    <form action="admin_edituser.php" method="post">
        <?php while ($user_info = $current_user->fetch(PDO::FETCH_ASSOC)): ?>
        <label for="first_name">First Name</label>
        <input type="text" name="fname" id="first_name" value="<?php echo $user_info['user_fname']; ?>"><br><br>

        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo $user_info['user_name']; ?>"><br><br>

        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="<?php echo $user_info['user_pass']; ?>"><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $user_info['user_email']; ?>"><br><br>
    <?php if (isCurrentUserAdminAbove()): ?>
        <label for="user_level">User Level</label>
        <!-- Looping an array -->
        <select name="user_level" id="user_level">
            <?php $user_level_map = getUserLevelMap();
                foreach ($user_level_map as $val => $label):?>
            <option value="<?php echo $val; ?>" <?php echo $val===(int)$user_info['user_level']?'selected':'';?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select><br><br>
    <?php endif; ?>

        <button type="submit" name="submit">Update User</button>
        <?php endwhile; ?>
    </form>
    <?php endif; ?>
</body>
</html>