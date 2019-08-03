<?php
  function search($letters, $symbol, $low, $high){
    if($high < $low || $low > $high || $high > count($letters) || $low < 0){return -1;
    }
    $mid = (int)(($high + $low)/2);
    if ($letters[$mid] == $symbol){
      return $mid;
    }
    else if (ord($letters[$mid]) < ord($symbol)){
      return search($letters, $symbol, $mid+1, $high);
    }
    else if (ord($letters[$mid]) > ord($symbol)){
      return search($letters, $symbol, $low, $mid-1);
    }
  }
  function encrypt($plaintext, $key){
    $S = ['-','!','"','#','$','%','&','\'','(',')','*','+',',','-','.','/',':',';','<','=','>','?','@','[','\\',']','^','_','`','{','|','}','~'];
    $S_LEN = count($S);
    $LC = ['a','b','c','d','e','f','g','h','i',
    'j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    $LC_LEN = count($LC);
    $UC = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S'
    ,'T','U','V','W','X','Y','Z'];
    $UC_LEN = count($UC);
    $N  = ['0','1','2','3','4','5','6','7','8','9'];
    $N_LEN = count($N);

    $key_index = 0;
    $key_len = strlen($key);
    for($i = 0; $i < $key_len; $i++){
      $key[$i] = ord($key[$i]) - ord('a') + 1;
    }
    $ciphertext = "";
    for($i = 0, $l = strlen($plaintext); $i < $l; $i++){
      $pchar = $plaintext[$i];
      $cchar = "";
      if ( ($index = search($S, $pchar, 0, $S_LEN)) != -1) {
        $cchar = $S[($index + $key[$key_index]) % $S_LEN];
      }
      else if ( ($index = search($LC, $pchar, 0, $LC_LEN)) != -1){
        $cchar = $LC[($index + $key[$key_index]) % $LC_LEN];
      }
      else if ( ($index = search($UC, $pchar, 0, $UC_LEN)) != -1){
        $cchar = $UC[($index + $key[$key_index]) % $UC_LEN];
      }
      else if ( ($index = search($N, $pchar, 0, $N_LEN)) != -1){
        $cchar = $N[($index + $key[$key_index]) % $N_LEN];
      }
      $key_index = ($key_index + 1) % $key_len;
      $ciphertext .= $cchar;
    }
    return $ciphertext;
  }
  function decrypt($ciphertext, $key){
    $S = ['-','!','"','#','$','%','&','\'','(',')','*','+',',','-','.','/',':',';','<','=','>','?','@','[','\\',']','^','_','`','{','|','}','~'];
    $S_LEN = count($S);
    $LC = ['a','b','c','d','e','f','g','h','i',
    'j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    $LC_LEN = count($LC);
    $UC = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S'
    ,'T','U','V','W','X','Y','Z'];
    $UC_LEN = count($UC);
    $N  = ['0','1','2','3','4','5','6','7','8','9'];
    $N_LEN = count($N);

    $key_index = 0;
    $key_len = strlen($key);
    for($i = 0; $i < $key_len; $i++){
      $key[$i] = ord($key[$i]) - ord('a') + 1;
    }
    $plaintext = "";
    for($i = 0, $l = strlen($ciphertext); $i < $l; $i++){
      $cchar = $ciphertext[$i];
      $pchar = "";
      if ( ($index = search($S, $cchar, 0, $S_LEN)) != -1) {
        $pchar = $S[($S_LEN + $index - $key[$key_index]) % $S_LEN];
      }
      else if ( ($index = search($LC, $cchar, 0, $LC_LEN)) != -1){
        $pchar = $LC[($LC_LEN + $index - $key[$key_index]) % $LC_LEN];
      }
      else if ( ($index = search($UC, $cchar, 0, $UC_LEN)) != -1){
        $pchar = $UC[($UC_LEN + $index - $key[$key_index]) % $UC_LEN];
      }
      else if ( ($index = search($N, (string)$cchar, 0, $N_LEN)) != -1){
        $pchar = $N[($N_LEN + $index - $key[$key_index]) % $N_LEN];
      }
      $key_index = ($key_index + 1) % $key_len;
      $plaintext .= $pchar;
    }
    return $plaintext;
  }
  
  $e =  explode("\n",fread($file = fopen("API","r"), filesize("API")+1));
  $b = base64_decode(decrypt($e[0], "thydarestepethonlanduncharted"));
  $t = base64_decode(decrypt($e[1], "jackalsdonthaveahearts"));
  fclose($file);
?>
