<?php
include "../src/initweb.php";
include "includes/header.inc";
include "includes/lib.inc";

function progEdPath() {
  // for Kay's dev env
  if (empty($_SERVER['HTTP_HOST'])) {
    return "/program-editor";
  }
  return "https://iacr.org/tools/program";
}
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
        create the program for the website using the IACR tool. This form
        will automatically import your list of accepted papers.
      </p>
      <p>
        <strong>Submitting this form will require you to login with your IACR reference number and
        password</strong>.
      </p>
      <form action="<?php echo progEdPath(); ?>/receiveFromHotCRP.php" method="post">
        <button id="submitAccepted" class="button button-primary" href="https://iacr.org/tools/program/index.html?hotcrp=<?php echo get_token();?>" disabled>Create program</button>
        <input type="hidden" name="name" value="<?php echo $Opt['longName']; ?>" />
        <textarea id="accepted" class="d-none" name="accepted" rows="8" cols="80" readonly></textarea>
      </form>
    </div>
  </div>
</div>
<script>
  setActiveMenu('menuprogram');

  $.getJSON('downloadaccepted.php', function(data) {
    console.dir(data);
    $('#accepted').html(JSON.stringify(data, null, 2));
    let submitButton = document.getElementById('submitAccepted');
    if (submitButton) {
      submitButton.removeAttribute('disabled');
    }
  })
  .fail(function(jqxhr, textStatus, error) {
    console.dir(jqxhr);
  });
</script>
</body>
</html>
