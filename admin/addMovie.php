<?php
	function addMovie($title, $year, $runtime, $story, $cover, $release, $genre) {
        include("connect.php");
        //echo "From addmovie.php";
        if($_FILES['cover']['type'] == "image/jpeg" ||
            $_FILES['cover']['type'] == "image/jpg" )
        {
        $target = "../images/{$cover['name']}";
         if(move_uploaded_file($_FILES['cover']['tmp_name'], $target)){
             
             $orig = $target;
             $th_copy = "../images/TH_{$cover['name']}";
             if(!copy($orig, $th_copy)){
                 echo "failed to copy";
             }
             $size = getimagesize($orig);
             //echo $size[1];
             $addstring = "INSERT INTO tbl_movies VALUES(NULL, '{$cover['name']}','{$title}','{$year}','{$runtime}','{$story}','{$cover}','{$release}')";
             $addresult = mysqli_query($link, $addstring);
             if($addresult){
                 $qstring = "SELECT * FROM tbl_movies ORDER BY movies_ID DESC LIMIT 1";
                 $lastmovie = mysqli_query($link, $qstring);
                 $row = mysqli_fetch_array($lastmovie);
                 $lastID = $row['movies_id'];
                 //echo $lastID;
                 $genstring = "INSERT INTO tbl_mov_genre VALUES(NULL, {$lastID}, {$genre})";
                    $genresult = mysqli_query($link, $genstring);
                redirect_to("admin_index.php");

             }

            }
            
        }
        mysqli_close($link);
    }


?>