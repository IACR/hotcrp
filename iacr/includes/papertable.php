<?php
// This is included from src/papertable.php. and src/settings/s_options.php
// It is intended for handling of special IACR paper options in the submission
// form. These are created by create_conf.py, and have an id as follows:
//
// 5: copyright     (required for authors, may not be deleted)
// 6: upload paper  (required for authors, may not be deleted)
// 7: upload slides (optional for authors, may not be deleted)
// 8: upload video. (optional for authors, may be deleted)

/**
 * Called with a PaperOption to determine if it requires special
 * handling. If the chair deletes the video option, then ID 8 might be
 * replaced by something with a new name, so we check for that.
 */
function iacr_paper_option(PaperOption $opt) {
   return iacr_required_paper_option($opt->id) ||
          ($opt->id == 8 && $opt->name == "Upload video");
}

/**
 * These options may not be deleted by the administrator. The slides
 * option is not mandantory for authors.
 */
function iacr_required_paper_option($val) {
  return ($val == 5 || $val === 6 || $val == 7);
}

/**
 * Used to echo a button. $val should be one of 5, 6, 7, 8 (the IDs
 * of the relevant PaperOption).
*/
function echo_iacr_button($val, Conf $conf, $paperId) {
  global $Me;
  $email = $Me->email;
  include_once('/var/www/util/hotcrp/hmac.php');
  $paper_msg = get_paper_message($conf->opt['iacrType'],
                                 $conf->opt['year'],
                                 $paperId,
                                 $email,
                                 'hc',
                                 $conf->opt['dbName']);
  $querydata = array('venue' => $conf->opt['iacrType'],
                     'year' => $conf->opt['year'],
                     'paperId' => $paperId,
                     'email' => $email,
                     'shortName' => $conf->opt['dbName'],
                     'auth' => get_hmac($paper_msg),
                     'app' => 'hc');
  switch($val) {
    case 5:
      $url = '/' . $conf->opt['dbName'] . '/iacrcopyright/' . strval($paperId);
      $msg = 'IACR copyright form';
      break;
    case 6:
      $url = 'https://iacr.org/submit/upload/paper.php?' . http_build_query($querydata);
      $msg = 'Upload final paper';
      break;
    case 7:
      $url = 'https://iacr.org/submit/upload/slides.php?' . http_build_query($querydata);
      $msg = 'Upload slides';
      break;
    case 8:
      $url = 'https://iacr.org/submit/upload/video.php?' . http_build_query($querydata);
      $msg = 'Upload video';
      break;
    default:
      return;
  }
  $extras = array('class' => 'iacrSubmitButtons');
  echo Ht::link($msg, $url, $extras);
}

?>
