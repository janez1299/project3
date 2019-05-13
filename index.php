<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
  <?php include("includes/header.php"); ?>
  <!-- TODO: This should be your main page for your site. -->
  <img class="slideshow" src="images/slideshow.jpg" alt="Slideshow">
    <p class="source"> Source: <cite><a href="https://unsplash.com/photos/Yui5vfKHuzs">Unsplash.com</a></cite></p>

  <div class="row">
    <div class="column">
      <h1 class="promo">Relive the Moments</h1>
      <p class="promo">Add photos to our gallery. Relive your favorite moments anytime. </p>
    </div>

    <div class="column2">
      <img class="moments" src="images/moments.png" alt="Relive the Moments">
      <p class="source2">Source: <cite><a href="https://myalbum.com">myalbum.com</a></cite></p>
    </div>
  </div>

  <hr>

  <h2>Discover Stories</h2>
  <p class="promo2">Trending stories from all over the world in our Curated Collection. </p>
  <div class="row">
    <div class="column3">
      <img class="story" src="images/story1.png" alt="Normandie & Provence">
      <p class="source3">Source: <cite><a href="https://myalbum.com/album/GH5g8GgEq2o1">myalbum.com</a></cite></p>
    </div>

    <div class="column3">
    <img class="story" src="images/story2.png" alt="Malediven">
      <p class="source3">Source: <cite><a href="https://myalbum.com/album/fcg1pLswMMBG">myalbum.com</a></cite></p>
    </div>

    <div class="column3">
    <img class="story" src="images/story3.png" alt="Fjord Norway">
      <p class="source3">Source: <cite><a href="https://myalbum.com/album/zFPhu8RJda9e">myalbum.com</a></cite></p>
    </div>
</div>

<footer>
<?php
  include("includes/footer.php");
  ?>
</footer>
</body>
</html>
