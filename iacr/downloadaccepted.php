<?php
  include "../conf/options.php";
  include "../src/initweb.php";

  global $Opt;
  $dbname = $Opt['dbName'];

  try {
    $db = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $Opt['dbUser'], $Opt['dbPassword']);
    $sql = "SELECT paperId,title,authorInformation,abstract FROM Paper WHERE outcome > 0 AND timeWithdrawn = 0";
    $stmt = $db->query($sql);
    $papers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($papers as &$paper) {
      $authorInfo = preg_split("/[\n]/", $paper['authorInformation'], -1, PREG_SPLIT_NO_EMPTY);
      $paper['authors'] = array();
      $paper['affiliations'] = array();

      // concats first and last names and adds to authors array + populates affiliations array
      foreach ($authorInfo as $authorLine) {
        // because explode = ¯\_(ツ)_/¯
        $fields = preg_split("/[\t]/", $authorLine, -1, PREG_SPLIT_NO_EMPTY);

        // $authorLine structure is first\tlast\temail\taffiliation
        $paper['authors'][] = $fields[0] . ' ' . $fields[1];
        $paper['affiliations'][] = $fields[3];
      }
      unset($paper['authorInformation']);
    }

    unset($paper);
    header('Content-Type: application/json');
    $data = array('_source' => 'IACR/hotcrp v1', 'acceptedPapers' => $papers);
    echo json_encode($data, JSON_PRETTY_PRINT);
    $db = null;
  } catch (PDOException $e) {
    echo $e->message();
  }
?>
