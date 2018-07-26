<?php 
defined('is_running') or die('Not an entry point...');

class SiteMaintenancePage{

  var $config   = array();

  var $defaults = array(
    'enabled'           => false,
    'show_msg'          => true,
    'background_image'  => '',
    'content'           => 'We apologize for the inconvenience. The site will be back up shortly. Please check back in 30 minutes.',
    'title'             => 'Site Under Maintenance',
    'theme'             => 'simple',
  );

  function __construct(){
    $this->config =   gpPlugin::GetConfig();
    $this->config +=  $this->defaults;
  }

  function WhichPage($page){
    if( !$this->config['enabled'] ){
      return $page;
    }
    $type = \gp\tool::SpecialOrAdmin($page);
    if (!common::LoggedIn() && $type != 'admin') {
      global $langmessage, $smp_config, $login_link;
      $login_link = common::Link('Admin', $langmessage['login'], '', 'rel="nofollow" data-cmd="login"');
      $smp_config = $this->config;
      gpPlugin::incl('view/' . $this->config['theme'] . '/maintenancepage.php');
      // dies
    }
    if( $this->config['show_msg'] && common::LoggedIn() ){
      msg('<i class="fa fa-warning"></i> Site Maintenance Page is enabled. '
        . 'Only logged in users can see the site. (' 
        . common::Link('Admin_SiteMaintenancePage', 'Disable Maintenance Page now', 'cmd=disable') 
        . ')');
    }
    return $page;
  }

}
