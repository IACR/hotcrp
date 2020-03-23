<?php
// This is included from src/papertable.php.

function echo_iacr_final_upload(DocumentPaperOption $docx, $paper, $email) {
  include_once("/var/www/util/hotcrp/hmac.php");
  $paper_msg = get_paper_message($docx->conf->opt["iacrType"],
                                 $docx->conf->opt["year"],
                                 $paper->paperId,
                                 $Me->email,
                                 $docx->conf->opt["shortName"]);
  $querydata = array("venue" => $docx->conf->opt["iacrType"],
                     "year" => $docx->conf->opt["year"],
                     "paperId" => $paper->paperId,
                     "email" => $email,
                     "shortName" => $docx->conf->opt["shortName"],
                     "auth" => get_hmac($paper_msg));
  $url = "https://iacr.org/submit/upload/paper.php?" . http_build_query($querydata);
  $extras = array("class" => "iacrSubmitButtons");
  echo Ht::link("Upload final paper", $url, $extras);
  $url = "https://iacr.org/submit/upload/slides.php?" . http_build_query($querydata);
  echo Ht::link("Upload slides", $url, $extras);
}

function echo_iacrcopyright_button($paperId, $shortName) {
  $extras = array("class" => "iacrSubmitButtons");
  $url = "/$shortName/iacrcopyright/" . strval($paperId);
  echo Ht::link("IACR copyright form", $url, $extras);
}

?>
