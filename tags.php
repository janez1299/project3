<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Tags</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<?php include("includes/header.php");?>

<body>
    <h5>Tagged Pictures</h5>
<?php
    $id = filter_input(INPUT_GET,'tag_id',FILTER_VALIDATE_INT);

    $records = exec_sql_query($db,"SELECT image_name,images.image_id,file_type,source_name,source_link FROM image_tags INNER JOIN images ON image_tags.image_id = images.image_id WHERE tag_id = :tag_id;",array(':tag_id' => $id)) -> fetchAll();
    $counter = 0;
    foreach ($records as $record){
        if($counter%3==0) {
            echo("<div class=\"row\">");
        }
        echo("<div class=\"column3\">");
        echo("<img src=\"uploads/images/" . $record["image_id"] . "." . $record["file_type"] . "\" class=\"gallery_img\"></a>");
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
