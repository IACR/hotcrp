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
      <h3>IACR extensions to HotCRP</h3>
      <p>
        This section provides extra functionality that is specific to IACR
        conferences. <strong>Before opening the site to submissions</strong>,
        you should perform the following steps using the menu on the left:
      </p>
      <ul>
        <li>Create accounts for your program committee.</li>
        <li>Import the recent collaborators of your program committee</li>
      </ul>
      <p>
        After you have finalized acceptance decisions, you can perform
        the following steps:
      </p>
      <ul>
        <li>Announce the list of accepted papers</li>
        <li>Prepare the proceedings (if you are publishing with LNCS)</li>
        <li>Prepare the program for the web site</li>
      </ul>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menuhome');
</script>
 <script src="https://iacr.org/libs/css/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php
 include "includes/footer.inc";
?>
