<?php
include "../conf/options.php";
include "../src/initweb.php";
include "includes/header.inc";
global $Opt;
$dbname = $Opt['dbName'];

?>
<div class="container-fluid float-left">
  <div class="row">
    <div class="col-4 col-lg-3 col-xl-2">
      <?php include "includes/leftnav.inc";?>
    </div>
    <div class="col-8">
      <h3>LNCS Preparation</h3>
      <p>
        Once you have all of the final versions uploaded, you can proceed to create
        the material required by Springer for the LNCS volumes of the proceedings.
        You can view which authors have uploaded their final versions the same
        way you can view who has signed the copyright forms, namely by
        <a href="../search?q=&t=acc#view">searching for accepted papers</a>
        and selecting "View options" to see how many have uploaded their final versions.
      </p>
      <p>
        Preparation of the Springer LNCS volumes should follow the instructions
        provided by Springer, which have in the past been located at
        <a href="https://www.springer.com/gp/computer-science/lncs/editor-guidelines-for-springer-proceedings">this URL</a>. Note that IACR uses their own copyright
        forms, so you should ignore the LNCS instructions for Copyright.
      </p>
      <p>
        The instructions for preparation of the frontmatter of an LNCS volume requires
        two items:
      </p>
      <ol>
        <li>the bundle of all final versions of papers</li>
        <li>the front matter for the LNCS volume (in a LaTeX file). This contains the program committee, external reviewers, and table of contents.</li>
      </ol>
      <p>
        These items may be downloaded below.
      </p>
<?php
try {
  $db = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $Opt['dbUser'], $Opt['dbPassword']);
  $sql = "select paperId,title from Paper where outcome>0 and timeWithdrawn = 0 and paperId not in (select paperId from PaperOption where optionId=6)";
  $stmt = $db->query($sql);
  $papers = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($papers && count($papers) > 0) {
    echo "<div class='alert alert-warning'><p>Warning: the following accepted papers appear to have not uploaded their final versions yet:</p><ul>";
    foreach($papers as $paper) {
      echo "<li><a href=\"../paper/" . $paper['paperId'] . "\">" . $paper['title'] . "</a></li>";
    }
    echo "</ul></div>";
  } else {
    echo "<div class='alert alert-success'>All final versions have been uploaded.</div>";
  }
  $db = null;
} catch (PDOException $e) {
  echo $e->message();
}
?>
    <p>
      <a class="button button-primary" target="_blank" href="getFrontMatter.php" download="frontmatter.tex">Download LaTeX frontmatter</a>
      <a class="button button-primary" target="_blank" href="<?php 
  require "/var/www/util/hotcrp/hmac.php";
$url = "https://iacr.org/submit/api/?action=download&venue=" . $Opt['iacrType'] . "&shortName=" . $Opt['shortName'] . "&year=" . $Opt['year'];
$url .= "&auth=" . get_hmac(get_conf_message($Opt['shortName'], $Opt['iacrType'], $Opt['year']));
echo $url . '" download=' . $Opt['shortName'] . '.zip">'
?>Download Zip archive</a>
    </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menulncs');
</script>
</body>
</html>
