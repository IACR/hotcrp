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
        conferences. This includes the ability to import information for your
        conference as well as the ability to export the list of accepted papers,
        the program for the conference, and the proceedings for LNCS (if
        applicable).
      </p>
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
