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

if (is_user_logged_in()) {
  ?>
  <p class="message">You have successfully logged in! You can now add and delete images as well as remove tags from your uploaded images.</p>
  <?php
} else {

?>
<ul>
  <?php
  foreach ($session_messages as $message) {
    echo "<li><strong>" . htmlspecialchars($message) . "</strong></li>\n";
  }
  ?>
</ul>

<p>All users must log in before adding and deleting images as well as deleting tags. </p>
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
}
?>


<?php
  include("includes/footer.php");
  ?>

</body>
</html>
