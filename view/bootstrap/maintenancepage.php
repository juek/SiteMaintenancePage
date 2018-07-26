<?php 

header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 86400'); // in seconds

global $smp_config, $login_link, $config, $dirPrefix, $addonRelativeCode;
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $config['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo $dirPrefix; ?>/include/thirdparty/js/jquery.js"></script>
    <script src="<?php echo $dirPrefix; ?>/include/thirdparty/Bootstrap3/js/modal.js"></script>
    <link href="<?php echo $dirPrefix; ?>/include/thirdparty/Bootstrap3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $addonRelativeCode; ?>/view/bootstrap/style.css" rel="stylesheet">
    <style>
      body{ background-image:url('<?php echo $smp_config['background_image']; ?>'); }
    </style>
  </head>
  <body>
    <div id="mmModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <?php 
          if( !empty($smp_config['title']) ){
            echo '		<div class="modal-header"><h1>' . $smp_config['title'] . '</h1></div>';
          }
          ?>
          <div class="modal-body"><?php echo $smp_config['content']; ?></div>
          <div class="modal-footer"><?php echo $login_link; ?></div>
        </div>
      </div>
    </div>

    <script>
      $(function(){
        $('#mmModal')
          .modal({
            keyboard : false,
            backdrop : 'static'
          });
      });
    </script>
  </body>
</html>
<?php exit();
