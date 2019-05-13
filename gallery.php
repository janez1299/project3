<?php
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Gallery</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
  <?php include("includes/header.php"); ?>


<?php
    $sql = "SELECT * FROM images;";
    $params = array();
    $records = exec_sql_query($db,$sql,$params);

    $counter = 0;
    foreach ($records as $record){
        if($counter%3==0) {
            echo("<div class=\"row\">");
        }
        echo("<div class=\"column3\">");
        echo("<a href=\"image.php?" . http_build_query(array("image_id" => $record["image_id"])) . "\"><img alt=\"image\" src=\"uploads/images/" . $record["image_id"] . "." . $record["file_type"] . "\" class=\"gallery_img\"></a>");
        $source = $record["source_name"];
        $link = $record["source_link"];
        echo($record["image_name"]);
        echo("<a href=\"$link\"><p class=\"source3\">Source: $source </p></a>");
        echo("</div>");
        if($counter%3==2){
            echo("</div>");
        }
        $counter=$counter+1;
    }
    if ($counter % 3 != 0){
      echo("</div>");
    }
?>

<footer>
<?php
  include("includes/footer.php");
  ?>
</footer>
</body>
</html>
