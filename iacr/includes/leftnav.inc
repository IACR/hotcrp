<div class="leftnav d-flex flex-column px-2">
  <div><a id="menuhome" class="navitem" href=".">Home</a></div>
  <div class="navheader font-weight-bold">Import</div>
  <div><a id="menucomm" class="navitem" href="comm.php">Program committee</a></div>
  <div><a id="menucoll" class="navitem" href="coll.php">PC Collaborators</a></div>
  <div class="navheader font-weight-bold">Export</div>
  <div><a id="menuaccepted" class="navitem" href="accepted.php">Accepted papers</a></div>
  <div><a id="menulncs" class="navitem" href="lncs.php">LNCS table of contents</a></div>
  <div><a id="menuprogram" class="navitem" href="program.php">Program</a></div>
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
