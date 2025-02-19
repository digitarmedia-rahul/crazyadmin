<?php
  
  date_default_timezone_set('Asia/Kolkata');
  $cdate =  date('Y-m-d');
  $date =  date('Y-m-d H:i:s');
  include("includes/constants.php");
  $type = $_GET['type'];
  // Replace with the real server API key from Google APIs
  $apiKey = "AAAAHYJCusk:APA91bHg4tqhh3ax3xQ2ryEsLl6ea6dD_LYb-dLQg_JP7L9OxywsCl_rKU5Jv6fUoCFIVhHc_Foyz4kbn7QCHtRt9x9K3GpF4kOGGkX4JIgTlxcwLuE-4oLEvOJcAi81jj6AOcnmlXQS";
  $type = "hidden";
  $dtoken = $mysqli->query("SELECT * FROM `deviceid` WHERE `token_id` != '' AND `allow_status` = '1' AND `push_status` = '0' LIMIT 1");
  if($dtoken->num_rows != 0){
  while($devToken = $dtoken->fetch_assoc()){
  $regId = $devToken['token_id'];
  $devid = $devToken['id']; 
  $deviceId = $devToken['deviceId'];
  $registrationIDs = array($regId); // Replace with the real client registration IDs 
  $fields = array(
        'registration_ids' => $registrationIDs,
        'data' => array( "title" => "browse_link", "body" => "Welcome to GamingYards","icon" => "https://gamingyards.com/admin/icon.png","browse_link" => "normal"),
      );



    // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';

    $headers = array(
        'Authorization: key=' . $apiKey,
        'Content-Type: application/json'
    );

    //echo  json_encode( $fields);
    //die();
    $ch = curl_init();
    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_POST, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));
    echo $result = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($result, true);
    $success = $response['success'];
    if($success == 1){
      $sent = 1;
      $error_response = 'Registered';
    }else{
      $sent = 0;
      echo $error_response = $response['results']['0']['error'];
      $mysqli->query("UPDATE `deviceid` SET `status`= 'inactive'  WHERE deviceId = '$deviceId'");
    }
    echo "UPDATE `deviceid` SET `push_status`= '1', `push_response`= '$error_response'  WHERE `deviceId` = '$deviceId' AND `id` = '$devid'";
    $mysqli->query("UPDATE `deviceid` SET `push_status`= '1', `push_response`= '$error_response'  WHERE `deviceId` = '$deviceId' AND `id` = '$devid'");

    $uid = $type.$cdate;
    $push     = $mysqli->query("select * from reports_push where uid = '$uid'");
    if($push->num_rows != 0){
       // $mysqli->query("UPDATE `reports_push` SET `total_sms`= total_sms +1 ,`total_sent`= total_sent+$sent WHERE uid = '$uid'");
    }else{
        //$mysqli->query("INSERT INTO `reports_push`(`total_sms`, `total_sent`, `type`, `date_added`, `uid`) VALUES ('1','$sent','$type','$cdate','$uid')");
    }
    }
    }

  ?>