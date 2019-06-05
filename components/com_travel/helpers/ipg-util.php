<?php
 // Timezeone needs to be set
 date_default_timezone_set(date_default_timezone_get());
//  $dateTime = date("Y:m:d-H:i:s");
 
//  function getDateTime() {
//     global $dateTime;
//     return $dateTime;
//  }
//  /*
//  Function that calculates the hash of the following parameters:
//  - Store Id
//  - Date/Time(see $dateTime above)
//  - chargetotal
//  - currency (numeric ISO value)
//  - shared secret
//  */
//  function createHash($chargetotal, $currency) {
//     // Please change the store Id to your individual Store ID
//     $storeId = "1109688446";
//     // NOTE: Please DO NOT hardcode the secret in that script. For example read it from a database.
//     $sharedSecret = "dC^sf*36iM";
//     $stringToHash = $storeId . getDateTime() . $chargetotal . $currency . $sharedSecret;
//     $ascii = bin2hex($stringToHash);
//     return hash("sha256", $ascii);
//  }

 ?>