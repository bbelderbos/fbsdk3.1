<?php
require 'fbsdk/src/api_keys.php'; # ignored in git, create your own
require 'fbsdk/src/facebook.php';
require 'functions.php'; 

$currentPage = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pageTitle = "Facebook API SDK Example";

// create facebook instance - secret and app id hidden in api_keys.php
$facebook = new Facebook($config);
$user = $facebook->getUser();

// sample https://developers.facebook.com/blog/post/534/
if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  $access_token = $_SESSION["fb_${config['appId']}_access_token"];

} else {
  $loginUrl = $facebook->getLoginUrl(array(
    // define extended permissions here, in this case
    // to get user's interests, and post to your wall
    'req_perms' => 'friends_likes, publish_stream',
  ));
}
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title><?php echo $pageTitle; ?></title>
  </head>
  <body>
    <h1><?php echo $pageTitle; ?></h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>

      <?php
      // do stuff
      // todo ...
      $data = fbQueryGraph($objects, $access_token);

      ?>

    <?php else: ?>
      <fb:login-button scope="friends_likes,publish_stream">Login to see movies your friends like</fb:login-button>

    <?php endif ?>


    <?php if ($user): ?>
      <h3>Hi, <?php $user_profile['first_name']; ?></h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
    <?php endif ?>

  <?php include "fbsdk/src/facebook_js.php"; ?>

  </body>
</html>
