<?php
include "../conf/options.php";
include "../src/initweb.php";
include "includes/header.inc";
global $Opt;
?>
<div class="container-fluid float-left">
  <div class="row">
    <div class="col-3">
      <?php include "includes/leftnav.inc";?>
    </div>
    <div class="col-9">
      <h3>Export list of accepted papers</h3>
      <p>
        Once the list of accepted papers has been decided, it is standard
        practice to put them on the conference website. The way to do this
        is to download the <tt>papers.json</tt> file and place it in the
        location <tt><?php echo $Opt['conferenceSite'] . '/json/papers.json';?></tt>
      </p>
      <p>
        TODO: create this form.
      </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menuaccepted');
</script>
 <script src="https://iacr.org/libs/css/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php
 include "includes/footer.inc";
?>
