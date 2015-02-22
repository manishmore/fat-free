<?php

class Standard {

  function load() {
    $settings = new Axon('settings');
    $settings->load('name="titel"');
    F3::set('system_titel', $settings->value);
    $navigation = new Axon('navigation');
    $list = $navigation->afind('', 'sort ASC');
    F3::set('navigation', $list);
  }

  function display() {
    $session = F3::get('SESSION.login');
    F3::set('debug', $session);
    echo Template::serve('site.html');
  }

  function start() {
    F3::reroute('/main/user/login');
  }

  function routeGet() {
    $this->route('get');
  }

  function routePost() {
    $this->route('post');
  }

  function route($kind) {
    $section = F3::scrub(F3::get('PARAMS.section'));
    $app = F3::scrub(F3::get('PARAMS.app'));
    $action = F3::scrub(F3::get('PARAMS.action'));
    if ($section == 'admin' || $section == 'main') {
            
        
      $login = F3::get('SESSION.login');
      if ($section == 'admin' && $login != 1) {
        F3::reroute('/main/error/show/0');
      } else {
        if ($section == 'admin') {
          F3::set('template', 'admin');
        }
        F3::call($section . '\\' . $app . '->' . $kind . '_' . $action);
      }
    } else {
      F3::reroute('/main/error/show/1');
    }
  }

  function minified() {
    if (isset($_GET['base']) && isset($_GET['files'])) {
      $_GET = F3::scrub($_GET);
      Web::minify($_GET['base'], explode(',', $_GET['files']));
    }
  }

  static function loadByName($table) {
    $obj = new Axon($table);
    $obj->def('num', 'COUNT(name)');
    $name = F3::scrub(F3::get('PARAMS.param'));
    $obj->load(array('name=:name', array(':name' => $name)));
    return $obj;
  }
    
  static function loadById($table) {
    $obj = new Axon($table);
    $obj->def('num', 'COUNT(id)');
    $Id = F3::scrub(F3::get('PARAMS.param'));
    $obj->load(array('id=:id', array(':id' => $Id)));
    return $obj;
  }
    
  static function getApp() {
    return F3::scrub(F3::get('PARAMS.app'));
  }
  static function emailAddress($email) {
    /*
     *
     * First, we check that there's one @ symbol, and that the lengths are right.
     */
    /*
      if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
      // Email invalid because wrong number of characters in one section or wrong number of @ symbols.
      return false;
      }
    */
    // Split it into sections to make life easier
    /*
      $email_array = explode("@", $email);
      $local_array = explode(".", $email_array[0]);
      for ($i = 0; $i < sizeof($local_array); $i++) {
      if
      (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
      ↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
      $local_array[$i])) {
      return false;
      }
      }
    */ 
    return true;
 
  }

}

?>
