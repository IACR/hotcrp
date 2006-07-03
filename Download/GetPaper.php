<?php 
//
// GetPaper -- this is a PHP script where execution is specified in a .htaccess
// file. This is done so the paper that is being requested is specified as a
// suffix to the GetPaper request. It's necessary to have automatic file naming
// work for specific browsers (I think Mozilla/netscape).
//
include('../Code/confHeader.inc');
$Conf->connect();
$Me = $_SESSION['Me'];
$Me->goIfInvalid("../");

//
// Determine the intended paper
//
if (isset($_REQUEST['paperId'])) {
    $paperId = cvtint($_REQUEST["paperId"]);
    if ($paperId < 0)
	$Error = "Invalid paper ID '" . htmlspecialchars($_REQUEST['paperId']) . "'.";
} else {
    $paper = preg_replace("|.*/GetPaper/*|", "", $_SERVER["PHP_SELF"]);
    if (preg_match("/^(" . $Conf->paperPrefix . "-)?(\d+).*$/", $paper, $match)
	&& $match[2] > 0)
	$paperId = $match[2];
    else
	$Error = "Invalid paper name '" . htmlspecialchars($paper) . "'.";
}

//
// Security checks - people who can download all paperss
// are assistants, chairs & PC members. Otherwise, you need
// to be a contact person for that paper.
//
if (!isset($Error) && !($Me->isChair || $Me->isPC || $Me->isAssistant
			|| $Me->amPaperAuthor($paperId, $Conf)
			|| $Me->iCanReview($paperId, $Conf)))
    $Error = "You are not authorized to download paper #$paperId.  You must be one of the paper's authors, or a PC member or reviewer, to download papers.";

//
// Actually download paper.
//
if (!isset($Error)) {
    $result = $Conf->downloadPaper($paperId, cvtint($_REQUEST['save']) > 0);
    if (!PEAR::isError($result)) {
	$Conf->log("Downloaded #$paperId for review", $_SESSION['Me']);
	exit;
    } else
	$Error = $result->getMessage();
 }

//
// If we get here, there is an error.
//
$Conf->header("Download Paper #$paperId");
$Conf->errorMsg($Error);
?>
</div>
<?php $Conf->footer() ?>
</body>
</html>
