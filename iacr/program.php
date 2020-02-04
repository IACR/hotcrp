<?php
include "../src/initweb.php";
include "includes/header.inc";
include "includes/lib.inc";
?>
<div class="container-fluid float-left">
  <div class="row">
    <div class="col-3">
      <?php include "includes/leftnav.inc";?>
    </div>
    <div class="col-9">
      <h3>Program generation</h3>
      <p>
        Once the list of accepted papers is available, it's time to start
        working on the program so it can show up on the conference website.
        The program is best prepared with a tool that imports the list of
        accepted papers and allows you to arrange them into sessions using
        an easy UI.
      </p>
      <p>
        The tool requires you to login with your IACR reference number and
        password. Once you login, you will be presented with a UI that contains
        the list of accepted papers. Begin by
        <a href="https://iacr.org/tools/program/index.html?hotcrp=<?php echo get_token();?>">clicking here</a>
      </p>
    </div
  </div>
</div>
<script>
 setActiveMenu('menuprogram');
</script>
 <script src="https://iacr.org/libs/css/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php
 include "includes/footer.inc";
?>
