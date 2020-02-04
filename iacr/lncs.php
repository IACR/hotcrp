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
      <h3>Export table of contents for LNCS</h3>
      <p>
        If you are producing a proceedings in the Springer LNCS series, then you
        need to supply a table of contents for the volume(s). The form below allows
        you to do this.
      </p>
      <p class="text-danger">
        TODO: create this form.
      </p>
      <p>
        <a class="button button-primary" href="lncstoc.php">Download table of contents</a>
      </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menulncs');
</script>
 <script src="https://iacr.org/libs/css/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php
 include "includes/footer.inc";
?>
