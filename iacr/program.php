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
        Once the acceptance decisions are finalized, you should
        create the program for the website using the IACR tool. This tool
        will automatically import your list of accepted papers.
      </p>
      <p>
        <strong>This tool requires you to login with your IACR reference number and
        password</strong>.
      </p>
      <p>
        <a class="button button-primary" href="https://iacr.org/tools/program/index.html?hotcrp=<?php echo get_token();?>">Create program</a>
      </p>
      <p class="text-danger">
        TODO: make this be a post to a php file in the program editor.
        <ul class="text-danger">
        <li>require login</li>
        <li>receive list of accepted papers as json in a hidden field</li>
        <li>prompt user to select a template (crypto, asiacrypt, etc).</li>
        </ul>
      </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menuprogram');
</script>
</body>
</html>
