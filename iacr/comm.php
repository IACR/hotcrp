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
      <h3>Import program committee</h3>
      <p>
        The standard HotCRP user interface provides several
        ways to create accounts for your program committee:
      </p>        
      <ul>
        <li>
          <a href="../profile/new#bulk">Import the program committee directly from the conference website</a>.
          Unfortunately this doesn't import email addresses, but it's about as easy to add these as it is
          to construct the CSV in the next option.
        </li>
        <li>
          <a href="../profile/new#bulk">Upload a CSV file containing names, affiliations, and email addresses</a>.
          Unfortunately, this doesn't import CryptoDB ids, which would allow you
          to import their collaborators automatically.
        </li>
      </ul>
      <p>
        <strong>Once you have created the accounts of the program committee, you should <a href="coll.php">import
        their recent collaborators<a>.</strong>
      </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menucomm');
</script>
 <script src="https://iacr.org/libs/css/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<?php
 include "includes/footer.inc";
?>
