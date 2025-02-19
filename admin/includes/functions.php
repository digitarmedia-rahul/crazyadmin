<?php



function sec_session_start() {

    // This stops JavaScript being able to access the session id.

    // Forces sessions to only use cookies.

    if (ini_set('session.use_only_cookies', 1) === FALSE) {

        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");

        exit();

    }

	// Gets current cookies params.

 	  session_start();            // Start the PHP session 

    }	

	

function login($username, $password, $mysqli) {

	$username = xss_clean(make_safe($username));

	$password = xss_clean(make_safe($password));

	$password = base64_encode($password);

	$c_date = date('Y-m-d H:i:s');

	$userip = $_SERVER['REMOTE_ADDR'];

	// Using prepared statements means that SQL injection is not possible. 

    if ($stmt = $mysqli->prepare("SELECT admin_id, admin_email, admin_pass, admin_type, admin_name FROM co_admin WHERE admin_email = ? AND admin_status = 1 LIMIT 1")) {

        $stmt->bind_param('s', $username);  // Bind "$username" to parameter.

        $stmt->execute();    // Execute the prepared query.

        $stmt->store_result();

        // get variables from result.

        $stmt->bind_result($user_id, $adminusers_email, $db_password, $admin_type,  $admin_name);

        $stmt->fetch();

		if ($stmt->num_rows === 1) {

			    // Check if the password in the database matches

                if($password === $db_password){

					// Password is correct!

                    // Get the user-agent string of the user.

                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value

                    $user_id = preg_replace("/[^0-9\-]+/", "", $user_id);

                    // XSS protection as we might print this value

                    $username = preg_replace("/[^a-zA-Z0-9_@.\-]+/", "", $username);

					$_SESSION['ADMINUSERID']   =  stripslashes($user_id);
                    $_SESSION['ADMINNAME'] =  stripslashes($admin_name);
                    $_SESSION['ADMINTYPE'] =  stripslashes($admin_type);


            		$_SESSION['ADMIN_USERNAME']         =  stripslashes($adminusers_email);  //admin name

					return true;

                } else {

                    return false;

                }

            

        } else {

          
             return false;

        }

    }

}





function login_check($mysqli) {

    // Check if all session variables are set 

    if (isset($_SESSION['ADMINUSERID'], $_SESSION['ADMIN_USERNAME'])) {

        $user_id = $_SESSION['ADMINUSERID'];

        $username = $_SESSION['ADMIN_USERNAME'];

		// Get the user-agent string of the user.

        //$user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT * FROM co_admin WHERE admin_id = ? AND admin_email = ? LIMIT 1")) {

            // Bind "$user_id" to parameter. 

            $stmt->bind_param('is', $user_id,$username);

            $stmt->execute();   // Execute the prepared query.

            $stmt->store_result();

            if ($stmt->num_rows == 1) {

				// If the user exists get variables from result.

 				return true;

            } else {

                // Not logged in 

                return false;

            }

        } else {

            // Not logged in 

            return false;

        }

    } else {

        // Not logged in 

        return false;

    }

}

// protect against XSS

function xss_clean($data)

{

        // Fix &entity\n;

        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);

        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);

        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);

        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns

        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Remove javascript: and vbscript: protocols

        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);

        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);

        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>

        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		// Remove namespaced elements (we do not need them)

        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		do

        {

                // Remove really unwanted tags

                $old_data = $data;

                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);

        }

        while ($old_data !== $data);

		// we are done...

        return $data;

}



// sanitize inputs 

function make_safe($str)

{

    global $mysqli;

	$str = $mysqli->real_escape_string($str);

	return strip_tags(trim($str));

}



// create notifications

function notification($type,$text) {

return '<div class="alert alert-'.$type.' alert-dismissible">'.$text.'</div>';

}





function dateTimeFormat ($time)

        {

         $time = time() - $time; // to get the time since that moment

         $time = ($time<1)? 1 : $time;

         $tokens = array (

                31536000 => 'year',

                2592000 => 'month',

                604800 => 'week',

                86400 => 'day',

                3600 => 'hour',

                60 => 'minute',

                1 => 'second'

         );



         foreach ($tokens as $unit => $text) {

            if ($time < $unit) continue;

                $numberOfUnits = floor($time / $unit);

                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');

          }

  }







?>