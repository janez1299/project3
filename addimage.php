<?php
include("includes/init.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Add an Image</title>
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
    <img class="header" src="images/header.jpg" alt="Add an Image">
    <p class="source">Source: <cite><a id="link" href="https://www.expedia.ca/travelblog/34-breathtaking-places-north-america/">
    Expedia.ca</a></cite></p>

    <?php

      // Users must be logged in before adding an image
      if (isset($_POST['add_image']) && is_user_logged_in()) {
      $file_name = filter_input(INPUT_POST,'image_name',FILTER_SANITIZE_SPECIAL_CHARS);
      if ($file_name != "" && $_FILES['image']['error']=="UPLOAD_ERR_OK"){
        $upload_info = $_FILES["image"];
        $description = filter_input(INPUT_POST,'image_description',FILTER_SANITIZE_SPECIAL_CHARS);
        $source_name = filter_input(INPUT_POST,'source_name',FILTER_SANITIZE_SPECIAL_CHARS);
        $source_link = filter_input(INPUT_POST,'source_link',FILTER_SANITIZE_SPECIAL_CHARS);
        $basename = basename($file_name);
        $upload_ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));

        $sql = "INSERT INTO images (user_id,image_name,image_description,file_type,source_name,source_link) VALUES (:user_id,:image_name,:image_description,:file_type,:source_name,:source_link);";

        $params = array(
          ':user_id' => $current_user['id'],
          ':image_name' => $file_name,
          ':image_description' => $description,
          ':file_type' => $upload_ext,
          ':source_name' => $source_name,
          ':source_link' => $source_link
        );
        $add_result = exec_sql_query($db,$sql,$params);
        $id = $db->lastInsertId("image_id");
        $new_path = "uploads/images/" . $id . "." . $upload_ext;
        move_uploaded_file($upload_info["tmp_name"],$new_path);

        echo("<p class=\"message\">");
        echo($file_name);
        echo(" has been added! </p>");
  } else {
        // displays warning message if user does not provide a file name or if the file exceeds the maximum size
        echo("<p class=\"message\">File exceeded the maximum file size. File name cannot be empty. Please resubmit the form.</p>");
  }
}
        ?>

    <form id="add_image_form" action="addimage.php" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend>Add an Image</legend>
      <p>Please input the following information about the image you want to add: </p>
      <ul>
        <li><p>Choose image:
          <input type="file" id="image" name="image" accept="image/png,image/jpeg">
         </p></li>
        <li>File Name: <input type="text" name="image_name"></li>
        <li>Image Description: <textarea name="image_description" rows="3" cols="40"></textarea></li>
        <li>File Format:
          <select name="file_format">
            <option value="PNG">PNG</option>
            <option value="JEPG">JPEG</option>
          </select></li>
        <li>Source Name: <input type="text" name="source_name"></li>
        <li>Source Link: <input type="url" name="source_link"></li>
    </ul>
      <input id="button" name="add_image" type="submit" value="Submit"/>
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
    echo("<img alt=\"Image\" src=\"uploads/images/" . $record["image_id"] . "." . $record["file_type"] . "\" class=\"gallery_img\">");
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
  echo '<p><strong>No files uploaded yet. Try uploading a new file! </strong></p>';
}
    }
  include("includes/footer.php");
  ?>

  </body>
</html>
