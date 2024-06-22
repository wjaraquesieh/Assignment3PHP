<?php

/*******w******** 
    
    Name: Wadia Jara
    Date: 06/21/2024
    Description: 

****************/

require('connect.php'); 
require('authenticate.php');

if ($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "UPDATE blogpost SET title = :title, content = :content WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);        
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
    // Execute the INSERT.
    $statement->execute();
    
    // Redirect after update.
    header("Location: index.php");
    exit;
} else if (isset($_GET['id'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM blogpost WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $quote = $statement->fetch();
} else {
    $id = false; // False if we are not UPDATING or SELECTING.
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
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
            <form action="edit.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value="<?= $quote['title'] ?>" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?= $quote['content'] ?></textarea>
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