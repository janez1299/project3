<?php
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Add a Tag</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
  <?php include("includes/header.php"); ?>

    <img class="header" src="images/header3.jpg" alt="Add a Tag">
    <p class="source">Source: <cite><a id="link" href="https://www.expedia.ca/travelblog/34-breathtaking-places-north-america/">
    Expedia.ca</a></cite></p>

    <?php
      if (isset($_POST['add_old_tag'])) {
        $image_id = filter_input(INPUT_POST,'image',FILTER_SANITIZE_SPECIAL_CHARS);
        $old_tag = filter_input(INPUT_POST,'old_tag_id',FILTER_SANITIZE_SPECIAL_CHARS);
        $result = exec_sql_query($db,"SELECT * FROM images WHERE image_id = :image_id;",array(':image_id' => $image_id)) -> fetchAll();
        $file_name = $result[0]["image_name"];

        // check if the user selected tag is already tagged in the selected image
        $records= exec_sql_query($db,"SELECT tag_id FROM image_tags WHERE image_id = :image_id",array(':image_id' => $image_id)) -> fetchAll();
        $current_tag = array();
        foreach($records as $record){
          array_push($current_tag,$record['tag_id']);
        }
        if (!in_array($old_tag,$current_tag)){
        // add new relationship in image_tags table
          $sql = exec_sql_query($db,"INSERT INTO image_tags(image_id, tag_id) VALUES (:image_id,:tag_id)", array(':image_id' => $image_id,':tag_id' =>
          $old_tag)) -> fetchAll();
          echo("<p class=\"message\">");
          echo("The tag has been added to ". $file_name. "!");
         echo("</p>");
    } else {
        echo("<p class=\"message\">");
        echo("The selected tag is already tagged in the image!</p>");
    }
  }
        if (isset($_POST['add_new_tag']) && is_user_logged_in()) {
          $image_id2 = filter_input(INPUT_POST,'image',FILTER_SANITIZE_SPECIAL_CHARS);
          $new_tag = filter_input(INPUT_POST,new_tag,FILTER_SANITIZE_SPECIAL_CHARS);
          $result2 = exec_sql_query($db,"SELECT * FROM images WHERE image_id = :image_id;",array(':image_id' => $image_id2)) -> fetchAll();
          $file_name2 = $result2[0]["image_name"];

          //check if the tag already exists in the table
          $tags = exec_sql_query($db, "SELECT tag_name FROM tags", array()) -> fetchAll();
          $current_tag2 = array();
          foreach ($tags as $tag ){
            array_push($current_tag2,$tag['tag_name']);
          }

          if (!in_array($new_tag,$current_tag2)) {
            //add new tags to tags table
            $sql2 = exec_sql_query($db,"INSERT INTO tags(tag_name) VALUES (:tag_name)",array(':tag_name' => $new_tag)) -> fetchAll();

            //find tag ID of the tag that the user just added
            $sql3 = exec_sql_query($db,"SELECT tag_id FROM tags WHERE tag_name = :tag_name", array(':tag_name'=> $new_tag)) -> fetchAll();
            $tag_id = $sql3[0]['tag_id'];

            //add new relationship to image_tags table
            $sql4 = exec_sql_query($db,"INSERT INTO image_tags(image_id, tag_id) VALUES (:image_id,:tag_id)", array(':image_id' => $image_id2,':tag_id' =>
            $tag_id)) -> fetchAll();

            echo("<p class=\"message\">");
            echo("The tag has been added to ". $file_name2. "!");
            echo("</p>");
          } else {
            echo("<p class=\"message\">");
            echo("The selected tag already exists!</p>");
          }
        }
    ?>

    <form id="add_old_tag_form" method="post" action="addtag.php">
    <fieldset>
    <legend>Add an Existing Tag</legend>
    <p>Please select the image you want to add tags to: </p>
      <select name="image">
      <?php
      // only displays name of the images that the user uploaded in the drop-down menu
      $records = exec_sql_query($db, "SELECT * FROM images", array())-> fetchAll();
      foreach($records as $record){
        echo("<option value=\"");
        echo($record["image_id"]);
        echo("\">");
        echo($record["image_name"]);
        echo("</option>");
      }
      ?>
    </select>
    <p>If you want to add an existing tag to the selected image, please select it below:</p>
      <select name="old_tag_id">
      <?php
      // displays name of all images in the drop-down menu
      $records = exec_sql_query($db, "SELECT * FROM tags", array())-> fetchAll();
      foreach($records as $record){
        echo("<option value=\"");
        echo($record["tag_id"]);
        echo("\">");
        echo($record["tag_name"]);
        echo("</option>");
      }
      ?>
    </select>
      <input id="button" name="add_old_tag" type="submit" value="Submit"/>
    </fieldset>
</form>

    <form id="add_new_tag_form" method="post" action="addtag.php">
      <fieldset>
      <legend>Add a New Tag</legend>
    <p>Please select the image you want to add tags to: </p>
      <select name="image">
      <?php
      // displays name of all images in the drop-down menu
      $records = exec_sql_query($db, "SELECT * FROM images", array())-> fetchAll();
      foreach($records as $record){
        echo("<option value=\"");
        echo($record["image_id"]);
        echo("\">");
        echo($record["image_name"]);
        echo("</option>");
      }
      ?>
      </select>
      <p>If you want to add a new tag to the selected image, please input below:</p>
        <input type="text" name="new_tag">
      <input id="button2" name="add_new_tag" type="submit" value="Submit"/>
      </fieldset>
    </form>

<footer>
<?php
  include("includes/footer.php");

  ?>
</footer>
</body>
</html>
