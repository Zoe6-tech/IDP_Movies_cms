<?php

function getUserLevelMap()
{
    return array(
        '0'=>'Web Editor',
        '1'=>'Web Admin'
    );
}

function getCurrentUserLevel()
{
    $user_level_map = getUserLevelMap();
    // If this  guy is login, compare to our level user map - it should be "0" or "1" - then load the value from the array
    if (isset($_SESSION['user_level']) && array_key_exists($_SESSION['user_level'], $user_level_map)) {
        return $user_level_map[$_SESSION['user_level']];
    } else {
        return "Unrecognized";
    }
}

function createUser($user_data)
{
    // For testing only, remove it later
    // - to test what the parameter will show
    // return var_export($user_data, true);

    // If the user data does not have a username OR the username is already existed
    if (empty($user_data['user_name']) || isUserNameExisted($user_data['username'])) {
        return 'Username is invalid';
    }
    # 1. Run the proper SQL query to insert user
    $pdo = Database::getInstance()->getConnection();

    $create_user_query = 'INSERT INTO tbl_user(user_fname, user_name, user_pass, user_email, user_level)';
    $create_user_query .= 'VALUES(:fname, :username, :password, :email, :user_level)';

    ## Testing only, remove later
    // return $create_user_query;

    $create_user_set = $pdo ->prepare($create_user_query);
    $create_user_result = $create_user_set->execute(
        array(
            ':fname'=>$user_data['fname'],
            ':username'=>$user_data['username'],
            ':password'=>$user_data['password'],
            ':email'=>$user_data['email'],
            ':user_level'=>$user_data['user_level']

        )
    );

    # 2. Redirect to index.php if create user successfully - with message maybe?,
    # Otherwise, show some error message
    if ($create_user_result) {
        redirect_to('index.php');
    } else {
        return 'User did not go through.';
    }
}

function getSingleUser($user_id)
{
    $pdo = Database::getInstance()->getConnection();

    $get_user_query = 'SELECT * FROM tbl_user WHERE user_id = :id';
    $get_user_set = $pdo->prepare($get_user_query);
    $result = $get_user_set->execute(
        array(
            ':id'=>$user_id
        )
    );

    if ($result && $get_user_set->rowCount()) {
        return $get_user_set;
    } else {
        return false;
    }
}

function editUser($user_data)
{
    if (empty($user_data['user_name']) || isUserNameExisted($user_data['username'])) {
        return 'Username is invalid';
    }
    $pdo = Database::getInstance()->getConnection();

    $update_user_query = 'UPDATE tbl_user SET user_fname=:fname, user_name =:username, user_pass=:password, user_email=:email, user_level=:user_level WHERE user_id = :id';

    $update_user_set = $pdo ->prepare($update_user_query);
    $update_user_result = $update_user_set->execute(
        array(
              ':fname'=>$user_data['fname'],
              ':username'=>$user_data['username'],
              ':password'=>$user_data['password'],
              ':email'=>$user_data['email'],
              ':user_level'=>$user_data['user_level'],
              ':id'=>$user_data['id']

          )
    );

    // This line is used to show all params and their values
    // $update_user_set->debugDumpParams();
    // exit;

    if ($update_user_result) {
        $_SESSION['user_name'] = $user_data['fname'];
        $_SESSION['user_level'] = $user_data['user_level'];
        redirect_to('index.php');
    } else {
        return 'Oops, I guess it did not work.';
    }
}

function isCurrentUserAdminAbove()
{
    return !empty($_SESSION['user_level']);
}

// True or False - True means existed, False means not existed
function isUserNameExisted()
{
    $pdo = Database::getInstance()->getConnection();
    $user_existed_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name = :username';
    $user_existed_set = $pdo->prepare($user_existed_query);
    $user_existed_result = $user_existed_set->execute(
        array(
            ':username'=>$username
        )
    );
    // If current COUNT is more than 0 means it existed
    return !$user_existed_result || $user_existed_set->fetchColumn()>0;
}
