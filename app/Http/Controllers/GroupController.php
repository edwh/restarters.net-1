<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Party;
use App\Device;

use Auth;
use FixometerHelper;
use FixometerFile;

class GroupController extends Controller
{
  // public function __construct($model, $controller, $action){
  //     parent::__construct($model, $controller, $action);
  //
  //     $Auth = new Auth($url);
  //     if(!$Auth->isLoggedIn() && $action != 'stats'){
  //         header('Location: /user/login');
  //     }
  //     else {
  //
  //         $user = $Auth->getProfile();
  //         $this->user = $user;
  //         $this->set('user', $user);
  //         $this->set('header', true);
  //
  //
  //         if(FixometerHelper::hasRole($this->user, 'Host')){
  //             $User = new User;
  //             $this->set('profile', $User->profilePage($this->user->id));
  //         }
  //     }
  // }

  public function index($response = null){

      // $this->set('title', 'Groups');
      // $this->set('list', $this->Group->findAll());

      // if(!is_null($response)){
      //     $this->set('response', $response);
      // }

      $Group = new Group;

      return view('group.index', [
        'title' => 'Groups',
        'list' => $Group->findAll(),
        'response' => $response,
        'user' => Auth::user(),
      ]);

  }

  public function create(){

      $user = User::find(Auth::id());

      // Administrators can add Groups.
      if(FixometerHelper::hasRole($user, 'Administrator')){
          // $this->set('title', 'New Group');
          // $this->set('gmaps', true);
          // $this->set('js',
          //             array('head' => array(
          //                             '/ext/geocoder.js'
          //             )));

          if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
              $error = array();
              $Group = new Group;

              // We got data! Elaborate. //NB:: Taken out frequency as it doesn't appear in the post data might be gmaps
              $name       =       $_POST['name'];
              $website    =       $_POST['website'];
              $area       =       $_POST['area'];
              // $freq       =       $_POST['frequency'];
              $location   =       $_POST['location'];
              $latitude   =       $_POST['latitude'];
              $longitude  =       $_POST['longitude'];
              $text       =       $_POST['free_text'];




              if(empty($name)){
                  $error['name'] = 'Please input a name.';
              }
              if(!empty($latitude) || !empty($longitude)) {
                  // check that these values are floats.
                  $check_lat = filter_var($latitude, FILTER_VALIDATE_FLOAT);
                  $check_lon = filter_var($longitude, FILTER_VALIDATE_FLOAT);

                  if(!$check_lat || !$check_lon){
                      $error['location'] = 'Coordinates must be in the correct format.';
                  }

              }


              if(empty($error)) {
                  // No errors. We can proceed and create the User.
                  $data = array(  'name'          => $name,
                                  'website'       => $website,
                                  'area'          => $area,
                                  // 'frequency'     => $freq,
                                  'location'      => $location,
                                  'latitude'      => $latitude,
                                  'longitude'     => $longitude,
                                  'free_text'     => $text,
                                  );
                  $idGroup = $Group->create($data)->id;

                  if( is_numeric($idGroup) && $idGroup !== false ){

                      $response['success'] = 'Group created correctly.';

                      if(isset($_FILES) && !empty($_FILES)){
                          $file = new File;
                          $group_avatar = $file->upload('image', 'image', $idGroup, env('TBL_GROUPS'), false, true);
                      }

                      /** Prepare Custom Fields for WP XML-RPC - get all needed data **/
                      // $Host = $Group->findHost($idGroup);
                      //
                      // $custom_fields = array(
                      //                 array('key' => 'group_city',            'value' => $area),
                      //                 array('key' => 'group_host',            'value' => $Host->hostname),
                      //                 array('key' => 'group_website',         'value' => $website),
                      //                 array('key' => 'group_hostavatarurl',   'value' => env('UPLOADS_URL') . 'mid_' .$Host->path),
                      //                 array('key' => 'group_hash',            'value' => $idGroup),
                      //                 array('key' => 'group_avatar_url',      'value' => env('UPLOADS_URL') . 'mid_' . $group_avatar ),
                      //                 array('key' => 'group_latitude',        'value' => $data['latitude']),
                      //                 array('key' => 'group_longitude',       'value' => $data['longitude']),
                      //                 );


                      /** Start WP XML-RPC **/
                      // $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
                      // $wpClient->setCredentials(WP_XMLRPC_ENDPOINT, WP_XMLRPC_USER, WP_XMLRPC_PSWD);
                      //
                      // $content = array(
                      //                 'post_type' => 'group',
                      //                 'custom_fields' => $custom_fields
                      //                 );
                      //
                      // $wpid = $wpClient->newPost($data['name'], $text, $content);
                      // $Group->update(array('wordpress_post_id' => $wpid), $idGroup);


                  }
                  else {
                      $response['danger'] = 'Group could <strong>not</strong> be created. Something went wrong with the database.';
                  }

              }
              else {
                  $response['danger'] = 'Group could <strong>not</strong> be created. Please look at the reported errors, correct them, and try again.';
              }


              // $this->set('response', $response);
              // $this->set('error', $error);
              // $this->set('udata', $_POST);

              if (!isset($response)) {
                $response = null;
              }

              if (!isset($error)) {
                $error = null;
              }

              if (!isset($_POST)) {
                $udata = null;
              } else {
                $udata = $_POST;
              }

              return view('group.create', [
                'title' => 'New Group',
                'gmaps' => true,
                'response' => $response,
                'error' => $error,
                'udata' => $udata,
              ]);

          }

          return view('group.create', [
            'title' => 'New Group',
            'gmaps' => true,
          ]);

      }
      else {
          header('Location: /user/forbidden', true, 403);
      }
  }

  /** sync all parties to wordpress - CREATES PARTIES! **/
  public function sync(){
      /*
      $groups = $this->Group->findAll();

      foreach($groups as $i => $group) {
          $Host = $this->Group->findHost($group->id);
          $Logo = $this->Group->findOne($group->id);


          if(!empty($Logo->path)) {
              $logo =  UPLOADS_URL . 'mid_' . $Logo->path;
          }
          else {
              $logo = 'PLACEHOLDER';
          }

          if(!empty($Host->path)) {
              $hostpic =  UPLOADS_URL . 'mid_' . $Host->path;
          }
          else {
              $hostpic = 'PLACEHOLDER';
          }


          $custom_fields = array(
                          array('key' => 'group_city',            'value' => $group->area),
                          array('key' => 'group_host',            'value' => $Host->hostname),
                          array('key' => 'group_hostavatarurl',   'value' => $hostpic),
                          array('key' => 'group_hash',            'value' => $group->id),
                          array('key' => 'group_avatar_url',      'value' => $logo ),
                          );

          echo "Connecting ... ";
          $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
          $wpClient->setCredentials(WP_XMLRPC_ENDPOINT, WP_XMLRPC_USER, WP_XMLRPC_PSWD);


          $content = array(
                      'post_type' => 'group',
                      'custom_fields' => $custom_fields
                      );

          $wpid = $wpClient->newPost($group->name, $group->free_text, $content);
          echo "<strong>Posted to WP</strong> ... ";
          $this->Group->update(array('wordpress_post_id' => $wpid), $group->id);
          echo "Updated Fixometer recordset with WPID: " . $wpid . "<br />";

      }
      */

  }


  public function edit($id) {

      $user = Auth::user();
      $Group = new Group;

      if(FixometerHelper::hasRole($user, 'Administrator') || hasRole($user, 'Host')){

          if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){

              $data = $_POST;

              // remove the extra "files" field that Summernote generates -
              unset($data['files']);
              unset($data['image']);

              $update = array(
                              'name'          => $data['name'],
                              'website'       => $data['website'],
                              'free_text'     => $data['free_text'],
                              'location'      => $data['location'],
                              'latitude'      => $data['latitude'],
                              'longitude'     => $data['longitude'],
                              );

              $u = $Group->where('idgroups', $id)->update($update);
              // echo "Updated---";
              if(!$u) {

                  $response['danger'] = 'Something went wrong. Please check the data and try again.';
                  echo $response['danger'];
              }
              else {
                 // echo "Here now --- ";
                  $response['success'] = 'Group updated!';

                  // dbga($_FILES);

                  if(isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['error'] != 4){
                     // echo "uploading image ... ";
                      $existing_image = $Group->hasImage($id, true);
                      if(count($existing_image) > 0){
                          $Group->removeImage($id, $existing_image[0]);
                      }
                      $file = new FixometerFile;
                      $group_avatar = $file->upload('image', 'image', $id, env('TBL_GROUPS'), false, true);
                      $group_avatar = env('UPLOADS_URL') . 'mid_' . $group_avatar ;
                  }
                  else {
                      $existing_image = $Group->hasImage($id, true);
                      if( count($existing_image) > 0 ) {
                          $group_avatar = env('UPLOADS_URL') . 'mid_' . $existing_image[0]->path;
                      }
                      else {
                          $group_avatar = 'null';
                      }
                  }

                   /** Prepare Custom Fields for WP XML-RPC - get all needed data **/
                  // $Host = $Group->findHost($id);
                  //
                  // $custom_fields = array(
                  //                     array('key' => 'group_city',            'value' => $data['area']),
                  //                     array('key' => 'group_host',            'value' => $Host->hostname),
                  //                     array('key' => 'group_website',         'value' => $data['website']),
                  //                     array('key' => 'group_hostavatarurl',   'value' => env('UPLOADS_URL') . 'mid_' . $Host->path),
                  //                     array('key' => 'group_hash',            'value' => $id),
                  //                     array('key' => 'group_avatar_url',      'value' => $group_avatar ),
                  //                     array('key' => 'group_latitude',        'value' => $data['latitude']),
                  //                     array('key' => 'group_longitude',       'value' => $data['longitude']),
                  //                 );
                  //
                  //
                  // /** Start WP XML-RPC **/
                  // $wpClient = new \HieuLe\WordpressXmlrpcClient\WordpressClient();
                  // $wpClient->setCredentials(env('WP_XMLRPC_ENDPOINT'), env('WP_XMLRPC_USER'), env('WP_XMLRPC_PSWD'));

                  // $content = array(
                  //                 'post_type' => 'group',
                  //                 'post_title' => $data['name'],
                  //                 'post_content' => $data['free_text'],
                  //                 'custom_fields' => $custom_fields
                  //                 );


                  // Check for WP existence in DB
                  // $theGroup = $Group->findOne($id);
                  // if(!empty($theGroup->wordpress_post_id)){
                  //
                  //     // we need to remap all custom fields because they all get unique IDs across all posts, so they don't get mixed up.
                  //     $thePost = $wpClient->getPost($theGroup->wordpress_post_id);
                  //
                  //     foreach( $thePost['custom_fields'] as $i => $field ){
                  //         foreach( $custom_fields as $k => $set_field){
                  //             if($field['key'] == $set_field['key']){
                  //                 $custom_fields[$k]['id'] = $field['id'];
                  //             }
                  //         }
                  //     }
                  //
                  //     $content['custom_fields'] = $custom_fields;
                  //     $wpClient->editPost($theGroup->wordpress_post_id, $content);
                  // }
                  // else {
                  //     $wpid = $wpClient->newPost($data['name'], $data['free_text'], $content);
                  //     $this->Group->update(array('wordpress_post_id' => $wpid), $id);
                  // }

                  if(FixometerHelper::hasRole($user, 'Host')){
                  //    header('Location: /host?action=gu&code=200');
                  }
              }

              // $this->set('response', $response);
          }
      }
      // $this->set('gmaps', true);
      // $this->set('js', array( 'head' => array( '/ext/geocoder.js')));

      $group = $Group->findOne($id);
      // $this->set('title', 'Edit Group ' . $Group->name );
      // $this->set('formdata', $Group);

      if (!isset($response)) {
        $response = null;
      }

      return view('group.edit', [
        'response' => $response,
        'gmaps' => true,
        'title' => 'Edit Group ' . $Group->name,
        'formdata' => $group,
        'user' => $user,
      ]);

  }

  public function delete($id){
      if(FixometerHelper::hasRole($this->user, 'Administrator')){
          $r = $this->Group->delete($id);
          if(!$r){
              $response = 'd:err';
          }
          else {
              $response = 'd:ok';
          }
          header('Location: /group/index/' . $response);
      }
      else {
          header('Location: /user/forbidden');
      }
  }

  public function stats($id, $format = 'row'){

      $Party = new Party;
      $Device = new Device;


      $weights = $Device->getWeights();
      $TotalWeight = $weights[0]->total_weights;
      $TotalEmission = $weights[0]->total_footprints;
      $EmissionRatio = $TotalEmission / $TotalWeight;


      $allparties = $Party->ofThisGroup($id, true, true);

      $participants = 0;
      $hours_volunteered = 0;
      $co2 = 0;
      $waste = 0;

      foreach($allparties as $i => $party){
          $partyco2 = 0;
          $participants += $party->pax;
          $hours_volunteered += (($party->volunteers > 0 ? $party->volunteers * 3 : 12 ) + 9);

          foreach($party->devices as $device){
              if($device->repair_status == DEVICE_FIXED){
              //  echo (!empty($device->estimate) && $device->category == 46 ? ( " Adding ESTIMATED: " . $device->estimate * $EmissionRatio . " - COEFF: " . $EmissionRatio . "<br />") : 'Adding ' . $device->footprint . '<br />');
                  $partyco2 +=     (!empty($device->estimate) && $device->category == 46 ? ($device->estimate * $EmissionRatio) : $device->footprint);
                  $waste +=   (!empty($device->estimate) && $device->category == 46 ? $device->estimate : $device->weight);
              }

          }
          $partyco2 =  number_format(round($partyco2 * $Device->displacement), 0, '.' , ',');
          $co2 += $partyco2;

      }

      $waste = number_format(round($waste), 0, '.', ',');

      $this->set('pax', $participants);
      $this->set('hours', $hours_volunteered);
      $this->set('parties', count($allparties));
      $this->set('co2', $co2);
      $this->set('waste', $waste);
      $this->set('format', $format);

      return view('groups.stats', [
        'pax' => $participants,
        'hours' => $hours_volunteered,
        'parties' => count($allparties),
        'co2' => $co2,
        'waste' => $waste,
        'format' => $format,
      ]);

  }

  // public function test() {
  //   $g = new Group;
  //   dd($g->findOne('1'));
  // }
}
