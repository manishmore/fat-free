<?php
class PostHandler {
  public static function postEdit($model = '') {
    //F3::clear('message');
    $app = Standard::getApp();
    if ($model == '') {
      $model = $app;
    }
    //loadById
    $email = \F3::get('POST.email');
    if (!empty($email)) {
      $email = Standard::emailAddress($email);
    }
          
    if($model == 'user') {
      $obj = Standard::loadById($model);
    } else {
      $obj = Standard::loadByName($model);
    }

    if ($obj->num == 1) {
      $obj->copyFrom('POST');
      $obj->save();
      if($model == 'user') {  
        F3::set('SESSION.message', 1);  
        F3::set('edituser','save');
        
        //die('dfdfd');
        F3::reroute('/admin/' . $app . '/edit/' . $obj->id);
      } else {
        F3::reroute('/admin/' . $app . '/edit/' . $obj->name);
      }
      // message
    } else {
      F3::reroute('/main/error/show/1');
    }
  }

    

  public static function postAdd($model = '') {

    $app = Standard::getApp();
    if ($model == '') {
      $model = $app;
    }

    $obj = new Axon($model);

    $obj->copyFrom('POST');
        
    $obj->save();
    if($model == 'user') {     
      F3::reroute('/admin/' . $app . '/edit/' . $obj->_id);
    } else {
      F3::reroute('/admin/' . $app . '/edit/' . $obj->name);
    }
        
  }    

}
?>
