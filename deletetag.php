<?php
include("includes/init.php");


$image_id = 0; // default value for selected image_id
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Delete a Tag</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
  <?php include("includes/header.php");
  // displays login form if user is not currently logged in
    if (!is_user_logged_in()) {
      ?>
       <p class="message">All users must log in before adding and deleting images as well as deleting tags. </p>
        <form id="loginForm" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
          <fieldset>
          <legend>Log In</legend>
          <ul>
            <li>
               <label for="username">Username:</label>
                <input id="username" type="text" name="username" />
            </li>
             <li>
               <label for="password">Password:</label>
               <input id="password" type="password" name="password" />
             </li>
            </ul>
            <button name="login" type="submit">Sign In</button>
            </fieldset>
          </form>
    <?php
    // If user is logged in, let them upload a new image
  } else {
    ?>

    <img class="header" src="images/header4.jpg" alt="Delete a Tag">
    <p class="source">Source: <cite><a id="link" href="https://www.expedia.ca/travelblog/34-breathtaking-places-north-america/">
    Expedia.ca</a></cite></p>

    <?php
      if (isset($_POST['delete_tag']) && is_user_logged_in()) {
        $image_id = filter_input(INPUT_POST,'image',FILTER_SANITIZE_SPECIAL_CHARS);
      }

      if (isset($_POST['delete_tag_2']) && is_user_logged_in()) {
        $image_id = $_GET['image_id'];
        $tag_id = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_SPECIAL_CHARS);

        //delete the relationship from image_tags table
        $delete = exec_sql_query($db,"DELETE FROM image_tags WHERE tag_id =:tag_id AND image_id=:image_id", array(':tag_id' => $tag_id,
        ':image_id' => $image_id)) -> fetchAll();

        echo("<p class=\"message\">");
        echo("The tag has been deleted! </p>");
      }
    ?>

    <form id="delete_tag_form" method="post" action="deletetag.php">
    <fieldset>
    <legend>Delete a Tag</legend>
    <p>Please select the image you want to delete the tag from: </p>

    <select name="image">
      <?php
      // only displays name of the images that the user uploaded in the drop-down menu
      $records = exec_sql_query($db, "SELECT * FROM images WHERE user_id = :user_id;", array(':user_id' => $current_user['id']))-> fetchAll();
      foreach($records as $record){
        echo("<option value=\"");
        echo($record["image_id"]);
        echo("\">");
        echo($record["image_name"]);
        echo("</option>");
      }
      ?>
    </select>
    <input id="button" name="delete_tag" type="submit" value="Submit"/>
    </fieldset>
</form>

      <form id="delete_tag_form_2" method="post" action="<?php
      if ($image_id == 0) {
        echo ("deletetag.php");
      } else {
        echo ("deletetag.php?" . http_build_query(array('image_id' => $image_id)));
      }
      ?>">
        <fieldset>
          <legend>Delete a Tag</legend>
            <p>Please select the tag you want to delete for the image selected above: </p>

            <select name="tag">
              <?php
                //only displays tags of the above selected image
                $records2 = exec_sql_query($db, "SELECT * FROM tags INNER JOIN image_tags ON tags.tag_id = image_tags.tag_id WHERE
                image_tags.image_id = :image_id ", array(':image_id' => $image_id)) -> fetchAll();
                foreach($records2 as $record){
                  echo("<option value=\"");
                  echo($record["tag_id"]);
                  echo("\">");
                  echo($record["tag_name"]);
                  echo("</option>");
                }
              ?>
            </select>
          <input id="button2" name="delete_tag_2" type="submit" value="Submit"/>
    </fieldset>
    </form>

<footer>
<?php
  include("includes/footer.php");
  }
  ?>
</footer>

</body>
</html>
