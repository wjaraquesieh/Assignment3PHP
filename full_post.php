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
            <h1>
                <img src="./image/gossip.png" alt="gossip"><a href="index.php">Gossip blog</a>
            </h1>
        </div> 
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php">New Post</a></li>
        </ul> 
        <div id="all_blogs">
            <div class="blog_post">
                <h2><a href="full_post.php?id=<?=$quote['id']?>"><?=$quote['title']?></a></h2>
                <p>
                    <small>
                        <?php  
                            $date = $quote['datetime'];
                            $dateTime = new DateTime($date);
                            $dateFormat = $dateTime->format('F j, Y');
                        ?>
                        <?= $dateFormat ?>
                        <a href="edit.php?id=<?=$quote['id']?>">edit</a>
                    </small>
                </p>
                <div class="blog_content">
                    <?=$quote['content']?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>