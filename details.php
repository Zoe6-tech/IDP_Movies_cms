<?php
    require_once 'load.php';
    // require_once 'load.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $movie = getSingleMovie($id);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
</head>
<body>
    <?php include 'templates/header.php';?>

    <!-- A GOOD STRATERGY TO DEBUG / A BREAKPOINT 
    Remember to open with < ? php and close it wit ? >
    var_dump($getMovies);
    exit; -->

    <!-- Putting HTML between 2 php tags -->
    <?php if (!empty($movie)):?>
    <div class="movie-item">
        <img src="images/<?php echo $movie['movies_cover']; ?>" alt="<?php echo $movie['movies_title']; ?>Cover Image">
        <h2><?php echo $movie['movies_title']; ?></h2>
        <h4>Movie Released:</h4><p><?php echo $movie['movies_release']; ?></p>
        <h4>Runtime:</h4> <p><?php echo $movie['movies_runtime']; ?></p>
        <h4>Description:</h4><p><?php echo $movie['movies_storyline']; ?></p>
    </div>
    <?php else:?>
        <p>Can't find that movie.</p>
    <?php endif; ?>

    <?php include 'templates/footer.php';?>

</body>
</html>