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
    
    $command = $_POST['command'];
    print_r($command);
    $query = "";
    $statement;
    switch ($command) {
        case 'Create':
            $query = "INSERT INTO blogpost (title, content) VALUES (:title, :content)";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            //  Execute the INSERT.
            $statement->execute();
            break;
        case 'Update':
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $query = "UPDATE blogpost SET title = :title, content = :content WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);        
            $statement->bindValue(':content', $content);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            $statement->execute();
            
            break;
        case 'Delete':
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            
            $query = "DELETE FROM blogpost WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            $statement->execute();
            break;  
        
        default:        
            header("Location: index.php");
            exit;

            break;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>My Blog Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1>
                <img src="./image/gossip.png" alt="gossip"><a href="index.php">Gossip blog</a>
            </h1>
        </div> 
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php" class="active">New Post</a></li>
        </ul> 
        <div id="all_blogs">
            <p>
                The information was <?= $command?> successfuly, you can come back to the <a href="index.php">Home page</a>.
            </p>
        </div>
    </div> 
</body>
</html>