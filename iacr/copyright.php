<?php
require "/var/www/util/hotcrp/copyright_db.php";
include "../conf/options.php";
include "../src/initweb.php";
include "includes/header.inc";
try {
  $db = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $dbuser, $dbpassword);
  // outcome>0 and timeWithdrawn = 0 corresponds to an accepted paper. optionId=6 is from create_conf.py when
  // the conference is first set up. It indicates that a final version was uploaded.
  $sql = "select paperId,title FROM copyright WHERE shortName=:shortName";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':shortName', $Opt['shortName']);
  if (!$stmt->execute()) {
    echo 'Unable to execute query';
    exit();
  }
  $copyrights = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
<div class="container-fluid float-left">
  <div class="row">
    <div class="col-4 col-lg-3 col-xl-2">
      <?php include "includes/leftnav.inc";?>
    </div>
    <div class="col-8">
      <h3>Submitted copyright forms</h3>
      <p>
        Once you open the papers for final submission, the authors will see an
        IACR copyright form to be filled out. You can see how many of them have
        filled out the form by
        <a href="../search?q=&t=acc#view">searching for accepted papers</a>
        and checking "IACR Copyright Agreement" in the options.
      </p>
      <ul>
      <?php foreach($copyrights as $paper) {
        echo '<li>' . $paper['title'] . '</li>';
      }
      ?>
      </ul>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menucopyright');
</script>
</body>
</html>
<?php
