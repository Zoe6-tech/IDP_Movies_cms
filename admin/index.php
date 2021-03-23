<?php
require_once '../load.php';
confirm_logged_in();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Welcome to your Dashboard, <?php echo $_SESSION['user_name']; ?>!</h2>
    <h3>You are in level: <?php echo getCurrentUserLevel(); ?></h3>
    <!-- If your session user level is not equal to 0 -->
    <?php if (isCurrentUserAdminAbove()):?>
        <a href="admin_createuser.php">Create User</a>
    <?php endif; ?>

    <a href="admin_edituser.php">Edit User</a>
    <a href="admin_logout.php">Sign Out</a>
</body>
</html>
