<?php
include "../conf/options.php";
include "../src/initweb.php";
include "includes/header.inc";
?>
<div class="container-fluid float-left">
  <div class="row">
    <div class="col-3">
      <?php include "includes/leftnav.inc";?>
    </div>
    <div class="col-9">
      <h3>Import collaborators of the program committee</h3>
      <p>
        Before you open the site to submissions, you should import the recent
        collaborators of the program committee in order to detect conflict
        of interest. This form uses CryptoDB and/or DBLP to import coauthors.
      </p>
      <p>
        <a class="button button-primary" href="#">Import coauthors for program committee</a>
      </p>
    <p class="text-danger">TODO: This needs an ajax form</p>
      <dl>
      <?php
      global $Opt;
      $dbname = $Opt['dbName'];
      try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $Opt['dbUser'], $Opt['dbPassword']);
        $sql = "SELECT contactId,email,firstname,lastname,affiliation,collaborators FROM ContactInfo WHERE (roles & 51) != 0 order by (roles & 5) DESC";
        $stmt = $db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
          echo '<dt><a href="../profile/' . urlencode($row['email']) . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</a> (' . $row['affiliation'] . ')</dt>';
          echo '<dd style="margin-left:10px"><pre>' . $row['collaborators'] . '</pre></dd>';
        }
        $db = null;
        } catch (PDOException $e) {
        echo $e->message();
        }
      ?>
      </dl>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menucoll');
</script>
</body>
</html>
