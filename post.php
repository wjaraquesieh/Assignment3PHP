<?php

/*******w******** 
    
    Name: Wadia Jara
    Date: 06/21/2024
    Description:

****************/

require('connect.php');

if ($_POST && !empty($_POST['title']) && !empty($_POST['content'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $query = "INSERT INTO blogpost (title, content) VALUES (:title, :content)";
    $statement = $db->prepare($query);

    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    
    //  Execute the INSERT.
    if($statement->execute()){
        echo "Success";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - New Post</a></h1>
        </div> 
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php" class="active">New Post</a></li>
        </ul> 
        <div id="all_blogs">
            <form action="process_post.php" method="post">
                <fieldset>
                    <legend>New Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"></textarea>
                    </p>
                    <p>
                        <input type="submit" name="command" value="Create" />
                    </p>
                </fieldset>
            </form>
        </div>
    </div> 
</body>
</html>