<?php

/*******w******** 
    
    Name: Wadia Jara
    Date: 06/21/2024
    Description:

****************/

require('connect.php');

$query = "SELECT * FROM blogpost";
$statement = $db->prepare($query);
$statement->execute(); 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - Index</a></h1>
        </div> 
        <ul id="menu">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="post.php">New Post</a></li>
        </ul> 
        <div id="all_blogs">
            <?php while($row = $statement->fetch()): ?>
                <div class="blog_post">
                    <h2><a href="show.php?id=<?=$row['id']?>"><?=$row['title']?></a></h2>
                    <p>
                        <small>
                            <?php  
                                $date = $row['datetime'];
                                $dateTime = new DateTime($date);
                                $dateFormat = $dateTime->format('F j, Y');
                            ?>
                            <?= $dateFormat ?>
                            <a href="edit.php?id=<?=$row['id']?>">edit</a>
                        </small>
                    </p>
                    <div class="blog_content">
                        <?=$row['content']?>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
    </div> 
</body>
</html>