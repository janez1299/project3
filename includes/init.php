<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version to ensure it meets 2300's requirements
function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}
// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.

$db = open_or_init_sqlite_db('secure/gallery.sqlite', 'secure/init.sql');



// ---- Login & Logout ----
// *Source: Kyle Harms INFO 2300 Spring 2019 Lab 8 (init.php)

define('SESSION_DURATION',3600);

$session_messages = array();

function log_in($username,$password) {
  global $db;
  global $current_user;
  global $session_messages;

  if(isset($username) && isset($password)) {
    // Does the username exist in the database?
    $sql = "SELECT * FROM users WHERE username=:username;";
    $params = array(':username' => $username);
    $records = exec_sql_query($db,$sql,$params) -> fetchAll();

    if ($records){
      // Username is unique as defined in the table, so there should only be 1 record
      $user_account = $records[0];

      // Check user input password against hashed password in database
      if (password_verify($password, $user_account['password'])) {
        // Generate a new session
        $session = session_create_id();

      // Store session ID in database
      $sql = "INSERT INTO sessions (user_id, session_id) VALUES (:user_id, :session_id)";
      $params = array(
        ':user_id' => $user_account['id'],
        ':session_id' => $session
      );

      $result = exec_sql_query($db, $sql, $params);
      if ($result) {
        // Success, session id is stored in database

        // Send this back to the user
        setcookie("session",$session,time()+ SESSION_DURATION);

        $current_user = $user_account;
        return $current_user;
      } else {
        array_push($session_messages, "Log in failed.");
      }
      } else {
        array_push($session_messages,"Incorrect username or password.");
      }
    } else {
        array_push($session_messages,"Invalid username or password.");
    }
      } else {
        array_push($session_messages,"No username or password entered.");
    }
      $current_user = NULL;
      return NULL;
   }


   function find_user($user_id) {
     global $db;

     $sql = "SELECT * FROM users WHERE id = :user_id";
     $params = array(
       ':user_id' => $user_id
     );
     $records = exec_sql_query($db, $sql, $params) -> fetchAll();
     if ($records) {
       return $records[0];
     }
     return NULL;
   }

   function find_session($session_id) {
     global $db;

     if(isset($session_id)) {
       $sql = "SELECT * FROM sessions WHERE session_id = :session_id;";
       $params = array(
         ':session_id' => $session_id
       );

       $records = exec_sql_query($db, $sql, $params) -> fetchAll();
       if ($records) {
         // Session ID is unique, so only 1 record should be returned
         return $records[0];
       }
     }
        return NULL;
   }

   function session_login() {
     global $db;
     global $current_user;

     if (isset($_COOKIE["session"])) {
       $session = $_COOKIE["session"];

       $session_record = find_session($session);

       if (isset($session_record)) {
         $current_user = find_user($session_record['user_id']);

         // Renew the cookie for 1 more hour
         setcookie("session",$session,time() + SESSION_DURATION);

         return $current_user;
       }
     }
     $current_user = NULL;
     return NULL;
   }

   function is_user_logged_in() {
     global $current_user;

    // If $current_user is not NULL, then the user is logged in
     return ($current_user != NULL);
   }

   function log_out() {
     global $current_user;

     // Remove the session from the cookie and make it expire (subtract time)
     setcookie('session','',time()- SESSION_DURATION);
     $current_user = NULL;
   }

   // Check if we should log in the user
   if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
     $username = trim($_POST['username']);
     $password = trim($_POST['password']);

     log_in($username, $password);
   } else {
     // check if logged in already via cookie
     session_login();
   }

   //check if we should log out the user
   if (isset($current_user) && (isset($_GET['logout']) ||
   isset($_POST['logout']))) {
     log_out();
   }

?>
