<?php
include "database_conn.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View</title>

        <style>
        .photo-gallery{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            min-height: 70vh;
            }
            
        .alb {
            width: 200px;
            height: 200px;
            padding: 5px;
        }
        .alb img{
            width: 100%;
            height: 100%;
        }            
              
        </style>

    </head>
    <body class = photo-gallery>
        <a href="index.php">&#8592;</a>
        <?php
        $sql = "SELECT * FROM images ORDER BY id DESC";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0)
        {
            while ($images = mysqli_fetch_assoc($res)) {  ?>
            <div class="alb">
                <img src="uploads/<?=$images['image_url']?>">
            </div>

       <?php
            }
        }
       ?>
    </body>

</html>

