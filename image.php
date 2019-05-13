<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Image</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
  <?php include("includes/header.php");
    $id = filter_input(INPUT_GET,'image_id',FILTER_VALIDATE_INT);

    $result = exec_sql_query($db,"SELECT * FROM images WHERE image_id = :image_id;",array(':image_id' => $id)) -> fetchAll();
    $file_name = $result[0]["image_name"];
    $image_description = $result[0]["image_description"];
    $source_name = $result[0]["source_name"];
    $source_link = $result[0]["source_link"];
    $basename = basename($file_name);
    $file_ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

    $result2 = exec_sql_query($db,"SELECT tag_name FROM tags INNER JOIN image_tags ON tags.tag_id = image_tags.tag_id WHERE image_ID = :image_id", array(':image_id' => $id)) -> fetchAll();

  ?>

  <h3>Image Information</h3>
  <div class="row">
      <div class="column4">
          <?php
            echo("<img src=\"uploads/images/" . $id. "." . $file_ext . "\" class=\"image\"");
          ?>
      </div>
      <div class="column5">
          <?php
            echo("<p class=\"information\">Image Name:</p><p class=\"information2\">$file_name </p>");
            echo("<p class=\"information\">Image Description: </p><p class=\"information2\">$image_description</p>");
            echo("<p class=\"information\">Source Name: <a href=$source_link>$source_name</p></a>");
            echo("<p class=\"information\">Tags:<p>");
          ?>
          <fieldset>
          <?php
          foreach($result2 as $record){
            $tag_name = $record['tag_name'];
            echo("<p class=\"tags\">$tag_name</p></a>");
          }
          ?>
          </fieldset>
      </div>
</div>

<footer>
<?php
  include("includes/footer.php");
  ?>
</footer>
</body>
</html>
