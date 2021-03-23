<?php
function login($username, $password, $ip)
{
    $pdo = Database::getInstance()->getConnection();
    #TODO: Finish the following query to check if username and password are matching in DB
    $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username AND user_pass = :password';
    $user_set = $pdo->prepare($get_user_query);
    $user_set->execute(
        array(
            ':username'=>$username,
            ':password'=>$password
        )
    );

    if ($found_user = $user_set->fetch(PDO::FETCH_ASSOC)) {
        // We found user in DB, log in
        $found_user_id = $found_user['user_id'];

        //Write the username and userid into session
        $_SESSION['user_id'] = $found_user_id;
        $_SESSION['user_name'] = $found_user['user_fname'];
        $_SESSION['user_level'] = $found_user['user_level'];

        // Update user's IP with the current IP
        $update_user_query = 'UPDATE tbl_user SET user_ip= :user_ip WHERE user_id=:user_id';
        $update_user_set = $pdo->prepare($update_user_query);
        $update_user_set->execute(
            array(
                ':user_ip'=>$ip,
                ':user_id'=>$found_user_id
            )
        );
        // Redirect user back to index.php
        redirect_to('index.php');
    } else {
        // This is an invalid attempt, reject it
        return 'Invalid login credentials';
    }
}

// We assign a value to our parameter & this parameter is optional, if we don't specify it, by default, it is False
// This function has become a 2nd level protection
function confirm_logged_in($are_you_admin=false)
{
    if (!isset($_SESSION['user_id'])) {
        redirect_to("admin_login.php");
    }

    // Already logged in but for whatever reason, the user level session is 0 or unrecognized
    // This is an Editor or unrecognized - Redirect him
    // Empty checks if the variable is empty or not, returns false if it exists and not empty, otherwise returns true. 0 is evaluate to empty
    // If 1st condition is checked -> then move on to 2nd condition
    // 1st condition: if $are_you_admin existed - which is True, this variable does exist -> so move on to 2nd condition
    // 2nd condition: if your session user level is equal to 0
    if (!isset($are_you_admin) && empty($_SESSION['user_level'])) {
        redirect_to('index.php');
    }
}

function logout()
{
    session_destroy();

    redirect_to('admin_login.php');
}
