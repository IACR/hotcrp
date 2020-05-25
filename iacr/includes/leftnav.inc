<div class="leftnav d-flex flex-column p-3">
  <div><a id="menuhome" class="navitem" href=".">IACR Home</a></div>
  <div class="navheader font-weight-bold">Import</div>
  <div><a id="menucomm" class="navitem" href="comm.php">Program committee</a></div>
  <div><a id="menucoll" class="navitem" href="coll.php">PC Collaborators</a></div>
  <div class="navheader font-weight-bold">Final versions</div>
  <div><a id="menucopyright" class="navitem" href="copyright.php">Copyright forms</a></div>
<?php
global $Opt;
  if ($Opt['iacrType'] !== 'tosc' and $Opt['iacrType'] !== 'tches') {
  echo '<div><a id="menufinal" class="navitem" href="submit.php">Final papers</a></div>';
  }
?>
  <div><a id="menuaccepted" class="navitem" href="accepted.php">Accepted papers</a></div>
<?php
global $Opt;
  if ($Opt['iacrType'] !== 'tosc' and $Opt['iacrType'] !== 'tches') {
    echo '<div><a id="menulncs" class="navitem" href="lncs.php">LNCS table of contents</a></div>';
    echo '<div><a id="menuprogram" class="navitem" href="program.php">Program</a></div>';
  }
?>
  <div class="navheader font-weight-bold">IACR Documents</div>
  <div><a class="navitem" href="https://www.iacr.org/docs/progchair.pdf" target="_blank">Program chair guidelines</a></div>
  <div><a class="navitem" href="https://www.iacr.org/docs/genchair.pdf" target="_blank">General chair guidelines</a></div>
  <div><a class="navitem" href="https://www.iacr.org/docs/reviewer.pdf" target="_blank">IACR reviewer guidelines</a></div>
</div>
<script>
  function setActiveMenu(nodeid) {
    let nodes = document.querySelector('.leftnav a');
    for (let i = 0; i < nodes.length; i++) {
       nodes[i].classList.remove('active');
    }
    document.getElementById(nodeid).classList.add('active');
  }
</script>
