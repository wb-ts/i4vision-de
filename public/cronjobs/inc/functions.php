<?php
date_default_timezone_set('Europe/Berlin');

include("db.php");
include("thirdparty/phpmailer/PHPMailerAutoload.php");
include("thirdparty/mustache/src/Mustache/Autoloader.php");

global $db;
global $lang;

//Funktion, die einen Select durchfÃ¼hrt und als array ausgibt.
function dbselect($query){
  global $db;
  $ergebnis = mysqli_query($db, $query);
  if (mysqli_num_rows($ergebnis)==0 OR mysqli_num_rows($ergebnis)==false) return 0;
  while($row = mysqli_fetch_assoc($ergebnis))
  {
	  $results[] = $row;
  }
  return $results;
}

//Funktion fÃ¼hrt Query durch.
function dbexecute($query){
  global $db;
  $ergebnis = mysqli_query($db, $query);
  return $ergebnis;
}

//Gibt Var_dump in schÃ¶nerer Ansicht aus
function predump($array){
  echo "<pre class='text-primary'>";
  var_dump($array);
  echo "</pre>";
}

//gibt einen String aus, wenn in Konfig Debugmodus an ist. Gut um Fehler zu finden
function debug($string){
  global $config;
  if($config["debug"]){
    echo "<br><br>*****".$string."*****<br><br>";
  }
}

//Weiterleitung auf url/Datei
function redirect($url){
  header('Location: '.$url);
}

function cryptpassword($password){
  global $config;
  $password = md5(sha1($password.$config['hash'][0]).$config['hash'][1]);
  return $password;
}

function actcode($length){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sendmail($sender,$sendername,$receiver,$subject,$message,$attachments=array()){
  global $config;
  $smtp = $config["smtp"];
  $mail = new PHPMailer(true);
  try {
      //$mail->SMTPDebug = 2;
      $mail->isSMTP();
	  $mail->CharSet ="UTF-8";
      $mail->Host = $smtp['host'];
      $mail->SMTPAuth = true;
      $mail->Username = $smtp['user'];
      $mail->Password = $smtp['pass'];
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->setFrom($sender, $sendername);
      $mail->addAddress($receiver);
      if(sizeOf($attachments)>0){
        foreach($attachments as $att){
          $mail->addAttachment($att);
        }
      }
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $message;
      return ($mail->send())?true:false;
      debug('Message has been sent');
  } catch (Exception $e) {
      debug('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
  }
}

function lang($type,$name, $echo=true){
  global $lang;
  if($echo){
    echo $lang->$type->$name;
  } else {
    return $lang->$type->$name;
  }
}

function doCurl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
	curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function getColorByString($string){
	return substr(md5($string),10,6);
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

     $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 


function encryptthis($data, $key) {
$encryption_key = base64_decode($key);
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
return base64_encode($encrypted . '::' . $iv);
}


function decryptthis($data, $key) {
$encryption_key = base64_decode($key);
list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

?>
