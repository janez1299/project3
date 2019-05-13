  <header>
    <h1 id="title"><?php echo $title; ?></h1>
    <?php
    ?>
    <!-- Source: (original work) Jane Zhang -->
    <img class="logo" src="images/logo.png" alt="logo">

    <nav id="menu">
      <ul>
        <li><a id="navPage" href="index.php">Home</a></li>
        <li class="dropdown">
            <a class="dropbtn">Gallery</a>
            <div class="container">
              <div class="dropdown-content">
                  <a href="gallery.php">View All Images</a>
                  <a href="alltags.php">View All Tags</a>
              </div>
            </div>

        </li>
        <li class="dropdown">
            <a class="dropbtn">Edit</a>
            <div class="container">
              <div class="dropdown-content">
                  <a href="addimage.php">Add an Image</a>
                  <a href="deleteimage.php">Delete an Image</a>
                  <a href="addtag.php">Add a Tag</a>
                  <a href="deletetag.php">Delete a Tag</a>
              </div>
            </div>
        </li>

    <?php
    if (!is_user_logged_in()){
        ?>
        <form action="login.php">
            <button class="login" type="submit">Log In</button>
          </form>
        <?php
    }
    // Source: Kyle Harms INFO 2300 Spring 2019 Lab 8 header.php
    if ( is_user_logged_in() ) {
        $logout_url = htmlspecialchars( $_SERVER['PHP_SELF'] ) . '?' . http_build_query( array( 'logout' => '' ) );

        echo '<li><a href="' . $logout_url . '">Sign Out ' . htmlspecialchars($current_user['username']) . '</a></li>';
      }
      ?>
    </ul>
  </nav>
  </header>
