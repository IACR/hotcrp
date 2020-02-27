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
          This requires you to fill in their email addresses, but it improves the accuracy
          of identifying co-authors in the next step.
        <?php include "committee.php";?>
        <script>
        // This hides some things from hotcrp that we don't want.
        let nodes = document.querySelectorAll('div.g strong');
        nodes.forEach(function(node, currentIndex, listObj) {
          node.style.display = 'none';
        });
        </script>
        <form action="<?php echo hoturl_post('../profile/new', join('&amp;', array('u=new')) . '#bulk');?>" method="POST">
        <textarea class="w-100" name="bulkentry" id="pclist" placeholder="Select a conference above"></textarea>
        <input type="file" name="bulk" style="display:none">
        <button type="submit" class="my-2 button button-primary" name="savebulk" value="1" id="commSubmit" disabled>Add accounts for program committee</button>
        </form>
        </li>
        <li>
          <a href="../profile/new#bulk">Upload a CSV file containing names, affiliations,
          and email addresses</a>. Unfortunately, this doesn't import CryptoDB ids,
          which help in identifying collaborators automatically.
        </li>
      </ul>
      <p class="alert alert-info">
        <strong>Once you have created the accounts of the program committee, you should <a href="coll.php">import
        their recent collaborators<a>.</strong>
      </p>
    </div>
  </div>
</div>
<script>
 setActiveMenu('menucomm');
</script>
</body>
</html>
