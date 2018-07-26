<?php 
defined('is_running') or die('Not an entry point...');

gpPlugin::incl('controller/SiteMaintenancePage.php');

class AdminSiteMaintenancePage extends SiteMaintenancePage{

  function __construct(){
    global $page, $langmessage, $addonRelativeCode;
    parent::__construct();
    $page->head_js[] = $addonRelativeCode . '/controller/AdminSiteMaintenancePage.js';

    $cmd = common::GetCommand();
    switch($cmd){
      case 'save_config':
        $this->SaveConfigForm();
        break;

      case $langmessage['restore_defaults']:
        $this->RestoreDefaults();
        break;

      case 'disable':
        $this->config['enabled'] = false;
        $this->SaveConfig();
        $url = $_SERVER['HTTP_REFERER'];
        if( empty($url) ) {
          $url = common::GetUrl();
        }
        common::Redirect($url);
        break;
    }

    echo  '<h2>';
    echo    common::Link('Admin_SiteMaintenancePage', 'Site Maintenance Page');
    echo    ' &raquo; ' . $langmessage['configuration'];
    echo  '</h2>';
    echo  '<br/>';

    $this->ConfigForm();
  }


  function SaveConfigForm(){
    global $langmessage;
    $content =& $_POST['content'];
    gpFiles::cleanText($content);
    $this->config['enabled']          = isset($_POST['enabled']) ? true : false;
    $this->config['show_msg']         = isset($_POST['show_msg']) ? true : false;
    $this->config['theme']            = $_POST['theme'];
    $this->config['background_image'] = $_POST['background_image'];
    $this->config['content']          = $content;
    $this->config['title']            = $_POST['title'];

    $this->SaveConfig();
  }


  function SaveConfig(){
    global $langmessage;
    if( gpPlugin::SaveConfig($this->config) ){
      message($langmessage['SAVED']);
    }else{
      message($langmessage['OOPS']);
    }
  }


  function RestoreDefaults(){
    global $langmessage;
    $this->config = $this->defaults;
    if( gpPlugin::SaveConfig($this->config) ){
      message($langmessage['SAVED']);
    }else{
      message($langmessage['OOPS']);
    }
  }


  function ConfigForm(){
    global $langmessage;
    $defaults = $this->defaults;
    $config   = $this->config;

    echo  '<form method="post" action="' . common::GetUrl('Admin_SiteMaintenancePage') . '">';
    echo    '<table style="width:100%" class="bordered">';

    echo      '<tr>';
    echo        '<th>' . $langmessage['options'] . '</th>';
    echo        '<th style="width:75%;">' . $langmessage['Value'] . '</th>';
    echo        '<th>' . $langmessage['default'] . '</th>';
    echo      '</tr>';

    echo      '<tr>';
    echo        '<td><strong>' . $langmessage['enabled'] . '</strong></td>';
    echo        '<td>';
    echo          '<input type="checkbox" name="enabled"' . ($config['enabled'] ? ' checked="checked"' : '') . ' />';
    echo         '</td>';
    echo        '<td>' . ($defaults['enabled'] ? $langmessage['On'] : $langmessage['Off']) . '</td>';
    echo      '</tr>';

    echo      '<tr>';
    echo        '<td><strong>' . $langmessage['administration'] . '&ndash;' . $langmessage['message'] . '</strong></td>';
    echo        '<td>';
    echo          '<input type="checkbox" name="show_msg"' . ($config['show_msg'] ? ' checked="checked"' : '') . ' />';
    echo         '</td>';
    echo        '<td>' . ($defaults['show_msg'] ? $langmessage['On'] : $langmessage['Off']) . '</td>';
    echo      '</tr>';

    echo      '<tr>';
    echo        '<td>' . $langmessage['theme'] . '</td>';
    echo        '<td>';
    echo          '<select class="gpselect" name="theme">';
    echo            '<option value="simple"' . ($config['theme'] == 'simple' ? ' selected="selected"' : '') . '>Lean and Simple</option>';
    echo            '<option value="bootstrap"' . ($config['theme'] == 'bootstrap' ? ' selected="selected"' : '') . '>Bootstrap Modal Box</option>';
    echo          '</select>';
    echo        '</td>';
    echo        '<td>' . $defaults['theme'] . '</td>';
    echo      '</tr>';

    echo      '<tr>';
    echo        '<td>' . $langmessage['title'] . '</td>';
    echo        '<td>';
    echo          '<input class="gpinput" style="width:100%;" type="text" name="title" value="' . $config['title'] . '" />';
    echo        '</td>';
    echo        '<td>' . $defaults['title'] . '</td>';
    echo      '</tr>';

    echo      '<tr>';
    echo        '<td>Content</td>';
    echo        '<td>';
    if( class_exists('gp_edit') ){
      gp_edit::UseCK($config['content'], 'content');
    }else{
      common::UseCK($config['content'], 'content');
    }
    echo        '</td>';
    echo        '<td>' . $defaults['content'] . '</td>';
    echo      '</tr>';

    echo      '<tr>';
    echo        '<td>Background Image</td>';
    echo        '<td>';
    echo          '<input class="gpinput" style="width:60%;" type="text" name="background_image" value="' . $config['background_image'] . '" /> ';
    echo          '<a class="gpbutton smp-select-image-button" style="text-decoration:none;">' . $langmessage['Select Image'] . '</a>';
    echo        '</td>';
    echo        '<td>' . (empty($defaults['background_image']) ? $langmessage['Empty'] : $defaults['background_image']) . '</td>';
    echo      '</tr>';

    echo    '</table>';
    echo    '<br/>';
    echo    '<input type="hidden" name="cmd" value="save_config" />';
    echo    '<input type="submit" value="' . $langmessage['save'] . '" class="gpsubmit" /> ';
    echo    '<input type="submit" name="cmd" value="' . $langmessage['cancel'] . '" class="gpcancel" /> ';
    echo    '<input type="submit" name="cmd" value="' . $langmessage['restore_defaults'] . '" class="gpcancel" />';
    echo  '</form>';
  }

}
