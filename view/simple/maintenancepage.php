<?php 
defined('is_running') or die('Not an entry point...');

header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 86400'); // in seconds

global $smp_config, $login_link, $config, $addonRelativeCode;
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $config['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $addonRelativeCode; ?>/view/simple/style.css" rel="stylesheet">
    <?php
    if( !empty($smp_config['background_image']) ){
      echo '<style>';
      echo 'body{background-image:url(' . $smp_config['background_image'] . ');}';
      echo '</style>';
    }
    ?>
  </head>
  <body>
    <div class="simpleModal">
      <?php 
      if( !empty($smp_config['title']) ){
        echo '    <div class="simpleModal-header"><h1>' . $smp_config['title'] . '</h1></div>';
      }
      ?>
      <div class="simpleModal-body"><?php echo $smp_config['content']; ?></div>
      <div class="simpleModal-footer"><?php echo $login_link; ?></div>
    </div>
  </body>
</html>
<?php exit();
