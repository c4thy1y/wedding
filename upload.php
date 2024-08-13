<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(isset($_POST['submit']) && isset($_FILES['uploaded_image'])) 
{
    include "database_conn.php";

    if ($conn) {
        echo "Database connection successful.";
    } else {
        echo "Failed to connect to the database.";
    }

    echo "<pre>";
    print_r($_FILES['uploaded_image']);
    echo "</pre>";

   $img_name =$_FILES['uploaded_image']['name'];
   $img_size =$_FILES['uploaded_image']['size'];
   $temp_name =$_FILES['uploaded_image']['tmp_name'];
   $error =$_FILES['uploaded_image']['error'];
   

   if ($error === 0)
   {
      if($img_size > 10000000)
      {
        $em = "Sorry, your file is too large.";
        header("Location: index.php?error=$em#gallery");

      }
      else
      {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower(($img_ex));

        $allowed_exs = array("jpg", "jpeg", "png");

        if(in_array($img_ex_lc, $allowed_exs))
        {
            if (is_writable('uploads/')) {
                echo "Uploads directory is writable.";
            } else {
                echo "Uploads directory is not writable.";
            }
            
            
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_path = 'uploads/'.$new_img_name;
            if(move_uploaded_file($temp_name, $img_upload_path))
            {
                echo "File uploaded successfully!";

            }
            else 
            {
                echo "Failed to upload file.";
            }

            //insert into database
            $sql = "INSERT INTO images(image_url) VALUES('$new_img_name')";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php#gallery");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            

        }
        else
        {
            $em = "You can't upload files of this this type";
            header("Location: index.php?error=$em#gallery");
        }

      }

   }
   else
   {
    $em = "unknown error occurred!";
    header("Location: index.php?error=$em#gallery");

   }

}
else
{
    header("Location: index.php");
}


?>
