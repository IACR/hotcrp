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
        Once the acceptance decisions are finalized, you should
        list the accepted papers on the website.  The way to do this
        is to download the <tt>papers.json</tt> file and place it in the
        location <tt><?php echo $Opt['conferenceSite'] . '/json/papers.json';?></tt>
      </p>
      <p class="text-danger">
        TODO: create this form.
      </p>
      <p>
        <a class="button button-primary" href="downloadaccepted.php">Download papers.json</a>
      </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menuaccepted');
</script>
</body>
</html>
