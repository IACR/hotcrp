<?php
require "../conf/options.php";
$randstuff = '2ln2j3,ZAb1';

function get_token() {
  global $Opt;
  return $Opt['shortName'] . hash_hmac('sha256', $Opt['shortName'], $randstuff);
}

function validate_token($tok) {
  return $tok == get_token();
}
?>
