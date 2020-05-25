<?php
require "/var/www/util/hotcrp/copyright_db.php";
include "../conf/options.php";
include "../src/initweb.php";
include "includes/header.inc";
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
    </div>
  </div>
</div>
<script>
 setActiveMenu('menucopyright');
</script>
</body>
</html>
<?php
