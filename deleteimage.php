<?php
include("includes/init.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Delete an Image</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
<?php include("includes/header.php");

  //displays login form if user is not currently logged in
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
      // If user is logged in, let them delete an image
    } else {
  ?>
    <img class="header" src="images/header2.jpg" alt="Delete an Image">
    <p class="source">Source: <cite><a id="link" href="https://www.expedia.ca/travelblog/34-breathtaking-places-north-america/">
    Expedia.ca</a></cite></p>

    <?php
      if (isset($_POST['delete_image']) && is_user_logged_in()) {
        $image_id = filter_input(INPUT_POST,'image',FILTER_SANITIZE_SPECIAL_CHARS);
        $result = exec_sql_query($db,"SELECT * FROM images WHERE image_id = :image_id;",array(':image_id' => $image_id)) -> fetchAll();
        $file_name = $result[0]["image_name"];

        $basename = basename($file_name);
        $file_ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

        // delete image from images table
        $delete1 = exec_sql_query($db,"DELETE FROM images WHERE image_id = :image_id", array(':image_id' => $image_id)) -> fetchAll();
        // delete associated tags from image_tags table
        $delete1 = exec_sql_query($db,"DELETE FROM image_tags WHERE image_id = :image_id", array(':image_id' => $image_id)) -> fetchAll();
        // remove image from uploads folder
        unlink("uploads/images/".$image_id.'.'.$file_ext);

        echo("<p class=\"message\">");
        echo($file_name);
        echo(" has been deleted! </p>");
    }
    ?>

    <form id="delete_image_form" method="post" action="deleteimage.php">
    <fieldset>
    <legend>Delete an Image</legend>
    <p>Please select the image you want to delete: </p>

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
    <input id="button" name="delete_image" type="submit" value="Submit"/>
    </fieldset>
</form>


<h2>Images You Have Uploaded</h2>

<?php
//displays images that the current user has added
$records = exec_sql_query($db, "SELECT * FROM images WHERE user_id = :user_id;", array(':user_id' => $current_user['id']))-> fetchAll();

$counter = 0;

if(count($records)>0) {
  foreach ($records as $record){
    if($counter%3==0) {
        echo("<div class=\"row\">");
    }
    echo("<div class=\"column3\">");
    echo("<img alt=\"image\" src=\"uploads/images/" . $record["image_id"] . "." . $record["file_type"] . "\" class=\"gallery_img\">");
    $source = $record["source_name"];
    $link = $record["source_link"];
    echo($record["image_name"]);
    echo("<a href=\"$link\"><p class=\"source3\">Source: $source </p></a>");
    echo("</div>");
    if($counter%3==2){
        echo("</div>");
    }
    if($counter%3!=0){
        echo("</div>");
    }
    $counter=$counter+1;
}
} else {
  echo '<p><strong>No files uploaded by this user. Therefore there is nothing to delete! </strong></p>';

}
}
  include("includes/footer.php");
  ?>

</body>
</html>
