<?php
/* ****************************************************************
   This is specific to IACR, and modifies the profile page to provide
   an extra option for importing the collaborators of a person.
   *************************************************************** */
?>
<script>
 function showError(msg) {
   let errorDiv = document.getElementById('iacrError');
   if (msg) {
     errorDiv.style.display = 'block';
     errorDiv.innerHTML = msg;
   } else {
     errorDiv.style.display = 'none';
     errorDiv.innerHTML = '';
   }
 }

 function fetchCollaborators(cryptodb) {
   showError(null);
   let url = 'https://iacr.org/cryptodb/data/hotcrp/collaborators.php?id=' + cryptodb;
   fetch(url,
         {
           credentials: 'same-origin'
         })
     .then((response) => {
       if (response.status !== 200 || !response.ok) {
         throw Error('Unable to fetch data from ' + url);
       }
       return response.json();
     })
     .then((data) => {
       let textarea = document.getElementsByName('collaborators')[0];
       // Don't add duplicates.
       let collab = new Set();
       if (textarea.value) {
         let lines = textarea.value.split(/\n/);
         for (let i = 0; i < lines.length; i++) {
           collab.add(lines[i].trim().replace(/\s{2,}/g, ' '));
         }
       }
       // remove parentheses from "IBM Research (Watson)"
       for(let i = 0; i < data.length; i++) {
         let line = data[i]['name'] + ' ';
         let aff = data[i]['affiliation'];
         if (aff) {
            aff = ' (' + aff.replace(/\(|\)/g, ' ') + ')';
         } else {
            aff = '';
         }
         line += aff;
         if (!collab.has(line)) {
           collab.add(line.trim().replace(/\s{2,}/g, ' '));
         }
       }
       showError('You may want to eliminate duplicates or add affiliations');
       textarea.setAttribute('rows', Math.max(5, collab.size));
       // sort to make it easier to spot duplicates
       textarea.value = Array.from(collab.values()).sort().join('\n');
     }).catch(function(error) {
       console.dir(url);
       console.dir(error);
       showError(error.message);
     });
}
</script>
<?php
// Called from hotcrp to decide whether there is a tag like cryptodb#155
function echoLookupForm($tags) {
  $missingNotice = "<p><em>A tag like</em> <a target=\"_blank\" href=\"https://www.iacr.org/cryptodb/data/author.php?authorkey=35\"><tt>cryptodb#35</tt></a> <em>is required for automatic lookup.</em></p>";
  if (isset($tags)) {
    $cryptodb = null;
    foreach ($tags as $tag) {
      if (preg_match('/cryptodb#(\d+)/', $tag, $vals)) {
        $cryptodb = $vals[1];
        break;
      }
    }
    if ($cryptodb !== null) {
       echo '<div class="g">',
            '<div style="display:none;margin:5px;padding: 5px;border: 1px solid red;color:red" id="iacrError"></div>',
            '  <strong style="color:green">Import from IACR: </strong> ';
       echo "<button type=\"button\" class=\"iacrButton\" onclick=\"fetchCollaborators($cryptodb);return false\">Fetch recent coauthors</button>";
       echo '</div>';
    } else {
      echo $missingNotice;
    }
  } else {
    echo $missingNotice;
  }
}
?>