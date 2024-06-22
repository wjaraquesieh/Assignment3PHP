<?php

/*******w******** 
    
    Name: Wadia Jara
    Date: 06/21/2024
    Description: 

****************/

require('connect.php'); 
require('authenticate.php');

if (isset($_GET['id'])) { 
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $query = "SELECT * FROM blogpost WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
    $statement->execute();
    $quote = $statement->fetch();
} else {
    $id = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Edit this Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - Edit Post</a></h1>
        </div> 
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php">New Post</a></li>
        </ul> 
        <div id="all_blogs">
            <form action="process_post.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value="<?= $quote['title'] ?>" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content" row=""><?= $quote['content'] ?></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?= $quote['id'] ?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>