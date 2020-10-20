<?php
// test06.php -- HotCRP review and some setting tests
// Copyright (c) 2006-2020 Eddie Kohler; see LICENSE.
/** @phan-file-suppress PhanUndeclaredProperty */

declare(strict_types=1);
require_once(preg_replace('/\/test\/[^\/]+/', '/test/setup.php', __FILE__));

// load users
$user_chair = $Conf->checked_user_by_email("chair@_.com");
$user_mgbaker = $Conf->checked_user_by_email("mgbaker@cs.stanford.edu"); // pc
$user_diot = $Conf->checked_user_by_email("christophe.diot@sophia.inria.fr"); // pc, red
$user_pdruschel = $Conf->checked_user_by_email("pdruschel@cs.rice.edu"); // pc
$user_mjh = $Conf->checked_user_by_email("mjh@isi.edu"); // pc
$Conf->save_setting("rev_open", 1);

// 1-18 have 3 assignments, reset have 0
assert_search_papers($user_chair, "re:3", "1-18");
assert_search_papers($user_chair, "-re:3", "19-30");
assert_search_papers($user_chair, "ire:3", "1-18");
assert_search_papers($user_chair, "-ire:3", "19-30");
assert_search_papers($user_chair, "pre:3", "");
assert_search_papers($user_chair, "-pre:3", "1-30");
assert_search_papers($user_chair, "cre:3", "");
assert_search_papers($user_chair, "-cre:3", "1-30");
assert_search_papers($user_chair, "re<4", "1-30");
assert_search_papers($user_chair, "-re<4", "");
assert_search_papers($user_chair, "re≤3", "1-30");
assert_search_papers($user_chair, "-re≤3", "");
assert_search_papers($user_chair, "re<=3", "1-30");
assert_search_papers($user_chair, "-re<=3", "");
assert_search_papers($user_chair, "re!=3", "19-30");
assert_search_papers($user_chair, "-re!=3", "1-18");
assert_search_papers($user_chair, "re≠3", "19-30");
assert_search_papers($user_chair, "-re≠3", "1-18");
assert_search_papers($user_chair, "-re>4", "1-30");
assert_search_papers($user_chair, "re>4", "");
assert_search_papers($user_chair, "-re≥3", "19-30");
assert_search_papers($user_chair, "re≥3", "1-18");
assert_search_papers($user_chair, "-re>=3", "19-30");
assert_search_papers($user_chair, "re>=3", "1-18");

assert_search_papers($user_chair, "re:mgbaker", "1 13 17");
assert_search_papers($user_chair, "-re:mgbaker", "2-12 14-16 18-30");
assert_search_papers($user_chair, "ire:mgbaker", "1 13 17");
assert_search_papers($user_chair, "-ire:mgbaker", "2-12 14-16 18-30");
assert_search_papers($user_chair, "pre:mgbaker", "");
assert_search_papers($user_chair, "-pre:mgbaker", "1-30");
assert_search_papers($user_chair, "cre:mgbaker", "");
assert_search_papers($user_chair, "-cre:mgbaker", "1-30");

// Add a partial review
save_review(1, $user_mgbaker, ["overAllMerit" => 5, "ready" => false]);

assert_search_papers($user_chair, "re:3", "1-18");
assert_search_papers($user_chair, "-re:3", "19-30");
assert_search_papers($user_chair, "ire:3", "1-18");
assert_search_papers($user_chair, "-ire:3", "19-30");
assert_search_papers($user_chair, "pre:3", "");
assert_search_papers($user_chair, "-pre:3", "1-30");
assert_search_papers($user_chair, "cre:3", "");
assert_search_papers($user_chair, "-cre:3", "1-30");
assert_search_papers($user_chair, "pre:any", "1");
assert_search_papers($user_chair, "-pre:any", "2-30");
assert_search_papers($user_chair, "cre:any", "");
assert_search_papers($user_chair, "-cre:any", "1-30");

assert_search_papers($user_chair, "re:mgbaker", "1 13 17");
assert_search_papers($user_chair, "-re:mgbaker", "2-12 14-16 18-30");
assert_search_papers($user_chair, "ire:mgbaker", "1 13 17");
assert_search_papers($user_chair, "-ire:mgbaker", "2-12 14-16 18-30");
assert_search_papers($user_chair, "pre:mgbaker", "1");
assert_search_papers($user_chair, "-pre:mgbaker", "2-30");
assert_search_papers($user_chair, "cre:mgbaker", "");
assert_search_papers($user_chair, "-cre:mgbaker", "1-30");

assert_search_papers($user_chair, "ovemer:5", "");

// Add a complete review
save_review(1, $user_mgbaker, ["overAllMerit" => 5, "reviewerQualification" => 1, "ready" => true]);

assert_search_papers($user_chair, "re:3", "1-18");
assert_search_papers($user_chair, "-re:3", "19-30");
assert_search_papers($user_chair, "ire:3", "2-18");
assert_search_papers($user_chair, "-ire:3", "1 19-30");
assert_search_papers($user_chair, "pre:3", "");
assert_search_papers($user_chair, "-pre:3", "1-30");
assert_search_papers($user_chair, "cre:3", "");
assert_search_papers($user_chair, "-cre:3", "1-30");
assert_search_papers($user_chair, "pre:any", "");
assert_search_papers($user_chair, "-pre:any", "1-30");
assert_search_papers($user_chair, "cre:any", "1");
assert_search_papers($user_chair, "-cre:any", "2-30");

assert_search_papers($user_chair, "re:mgbaker", "1 13 17");
assert_search_papers($user_chair, "-re:mgbaker", "2-12 14-16 18-30");
assert_search_papers($user_chair, "ire:mgbaker", "13 17");
assert_search_papers($user_chair, "-ire:mgbaker", "1-12 14-16 18-30");
assert_search_papers($user_chair, "pre:mgbaker", "");
assert_search_papers($user_chair, "-pre:mgbaker", "1-30");
assert_search_papers($user_chair, "cre:mgbaker", "1");
assert_search_papers($user_chair, "-cre:mgbaker", "2-30");

assert_search_papers($user_chair, "ovemer:5", "1");


// Test offline review parsing

// Change a score
$paper1 = $Conf->checked_paper_by_id(1, $user_chair);
$rrow = fetch_review($paper1, $user_mgbaker);
$review1A = file_get_contents(SiteLoader::find("test/review1A.txt"));
$tf = ReviewValues::make_text($Conf->review_form(), $review1A, "review1A.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_mgbaker));

assert_search_papers($user_chair, "ovemer:4", "1");
$rrow = fetch_review($paper1, $user_mgbaker);
xassert_eqq($rrow->t03, "  This is a test of leading whitespace\n\n  It should be preserved\nAnd defended\n");

// Catch different-conference form
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/Testconf I/', 'Testconf IIII', $review1A), "review1A-1.txt");
xassert(!$tf->parse_text(false));
xassert($tf->has_error_at("confid"));

// Catch invalid value
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/^4/m', 'Mumps', $review1A), "review1A-2.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_mgbaker));
xassert_eqq(join(" ", $tf->unchanged), "#1A");
xassert($tf->has_problem_at("overAllMerit"));

// “No entry” is invalid
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/^4/m', 'No entry', $review1A), "review1A-3.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_mgbaker));
xassert_eqq(join(" ", $tf->unchanged), "#1A");
xassert($tf->has_problem_at("overAllMerit"));
xassert(strpos(join("\n", $tf->message_texts_at("overAllMerit")), "Entry required") !== false);
//error_log(var_export($tf->message_list(), true));

// Different reviewer
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/Reviewer: .*/m', 'Reviewer: butt@butt.com', $review1A), "review1A-4.txt");
xassert($tf->parse_text(false));
xassert(!$tf->check_and_save($user_mgbaker));
xassert($tf->has_problem_at("reviewerEmail"));

// Different reviewer
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/Reviewer: .*/m', 'Reviewer: Mary Baaaker <mgbaker193r8219@butt.com>', preg_replace('/^4/m', "5", $review1A)), "review1A-5.txt");
xassert($tf->parse_text(false));
xassert(!$tf->check_and_save($user_mgbaker, $paper1, fetch_review($paper1, $user_mgbaker)));
xassert($tf->has_problem_at("reviewerEmail"));

// Different reviewer with same name (OK)
// Also add a description of the field
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/Reviewer: .*/m', 'Reviewer: Mary Baker <mgbaker193r8219@butt.com>', preg_replace('/^4/m', "5. Strong accept", $review1A)), "review1A-5.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_mgbaker, $paper1, fetch_review($paper1, $user_mgbaker)));
xassert(!$tf->has_problem_at("reviewerEmail"));
//error_log(var_export($tf->message_list(), true));


// Settings changes

// Add “no entry”
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s01_name" => "Overall merit",
    "rf_s01_options" => "1. Reject\n2. Weak reject\n3. Weak accept\n4. Accept\n5. Strong accept\nNo entry\n"
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

// Now it's OK to save “no entry”
$tf = ReviewValues::make_text($Conf->review_form(), preg_replace('/^4/m', 'No entry', $review1A), "review1A-6.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_mgbaker));
xassert_eqq(join(" ", $tf->updated), "#1A");
xassert(!$tf->has_problem_at("overAllMerit"));
//error_log(var_export($tf->message_list(), true));

assert_search_papers($user_chair, "has:ovemer", "");

// Restore overall-merit 4
$tf = ReviewValues::make_text($Conf->review_form(), $review1A, "review1A-7.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_mgbaker));
xassert_eqq(join(" ", $tf->updated), "#1A");
xassert(!$tf->has_problem_at("overAllMerit"));
//error_log(var_export($tf->message_list(), true));

assert_search_papers($user_chair, "ovemer:4", "1");

// “4” is no longer a valid overall-merit score
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s01_name" => "Overall merit",
    "rf_s01_options" => "1. Reject\n2. Weak reject\n3. Weak accept\nNo entry\n"
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

// So the 4 score has been removed
assert_search_papers($user_chair, "ovemer:4", "");

// revexp has not
assert_search_papers($user_chair, "revexp:2", "1");
assert_search_papers($user_chair, "has:revexp", "1");

// Stop displaying reviewer expertise
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s02_name" => "Reviewer expertise",
    "rf_s02_position" => 0
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

// Add reviewer expertise back
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s02_name" => "Reviewer expertise",
    "rf_s02_options" => "1. No familiarity\n2. Some familiarity\n3. Knowledgeable\n4. Expert",
    "rf_s02_position" => 1.5
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

// It has been removed from the review
assert_search_papers($user_chair, "has:revexp", "");

// Text fields not there yet
assert_search_papers($user_chair, "has:papsum", "");
assert_search_papers($user_chair, "has:comaut", "");

// Check text field representation
save_review(1, $user_mgbaker, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "This is the summary",
    "comaut" => "Comments for äuthor", "compc" => "Comments for PC",
    "ready" => true
]);
$rrow = fetch_review($paper1, $user_mgbaker);
xassert_eqq((string) $rrow->overAllMerit, "2");
xassert_eqq((string) $rrow->reviewerQualification, "1");
xassert_eqq((string) $rrow->t01, "This is the summary\n");
xassert_eqq((string) $rrow->t02, "Comments for äuthor\n");
xassert_eqq((string) $rrow->t03, "Comments for PC\n");

assert_search_papers($user_chair, "has:papsum", "1");
assert_search_papers($user_chair, "has:comaut", "1");
assert_search_papers($user_chair, "has:compc", "1");
assert_search_papers($user_chair, "papsum:this", "1");
assert_search_papers($user_chair, "comaut:author", "1");
assert_search_papers($user_chair, "comaut:äuthor", "1");
assert_search_papers($user_chair, "papsum:author", "");
assert_search_papers($user_chair, "comaut:pc", "");
assert_search_papers($user_chair, "compc:author", "");

// Add extension fields
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s03_name" => "Score 3", "rf_s03_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s03_position" => 2.03,
    "rf_s04_name" => "Score 4", "rf_s04_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s04_position" => 2.04,
    "rf_s05_name" => "Score 5", "rf_s05_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s05_position" => 2.05,
    "rf_s06_name" => "Score 6", "rf_s06_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s06_position" => 2.06,
    "rf_s07_name" => "Score 7", "rf_s07_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s07_position" => 2.07,
    "rf_s08_name" => "Score 8", "rf_s08_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s08_position" => 2.08,
    "rf_s09_name" => "Score 9", "rf_s09_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s09_position" => 2.09,
    "rf_s10_name" => "Score 10", "rf_s10_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s10_position" => 2.10,
    "rf_s11_name" => "Score 11", "rf_s11_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s11_position" => 2.11,
    "rf_s12_name" => "Score 12", "rf_s12_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s12_position" => 2.12,
    "rf_s13_name" => "Score 13", "rf_s13_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s13_position" => 2.13,
    "rf_s14_name" => "Score 14", "rf_s14_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s14_position" => 2.14,
    "rf_s15_name" => "Score 15", "rf_s15_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s15_position" => 2.15,
    "rf_s16_name" => "Score 16", "rf_s16_options" => "1. Yes\n2. No\n3. Maybe\nNo entry\n", "rf_s16_position" => 2.16,
    "rf_t04_name" => "Text 4", "rf_t04_position" => 5.04,
    "rf_t05_name" => "Text 5", "rf_t05_position" => 5.05,
    "rf_t06_name" => "Text 6", "rf_t06_position" => 5.06,
    "rf_t07_name" => "Text 7", "rf_t07_position" => 5.07,
    "rf_t08_name" => "Text 8", "rf_t08_position" => 5.08,
    "rf_t09_name" => "Text 9", "rf_t09_position" => 5.09,
    "rf_t10_name" => "Text 10", "rf_t10_position" => 5.10,
    "rf_t11_name" => "Text 11", "rf_t11_position" => 5.11
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

save_review(1, $user_mgbaker, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "This is the summary",
    "comaut" => "Comments for äuthor", "compc" => "Comments for PC",
    "sco3" => 1, "sco4" => 2, "sco5" => 3, "sco6" => 0,
    "sco7" => 1, "sco8" => 2, "sco9" => 3, "sco10" => 0,
    "sco11" => 1, "sco12" => 2, "sco13" => 3, "sco14" => 0,
    "sco15" => 1, "sco16" => 3,
    "tex4" => "bobcat", "tex5" => "", "tex6" => "fishercat",
    "tex7" => "tiger", "tex8" => "leopard", "tex9" => "tremolo",
    "tex10" => "underwear", "tex11" => "",
    "ready" => true
]);

assert_search_papers($user_chair, "has:sco3", "1");
assert_search_papers($user_chair, "has:sco4", "1");
assert_search_papers($user_chair, "has:sco5", "1");
assert_search_papers($user_chair, "has:sco6", "");
assert_search_papers($user_chair, "has:sco7", "1");
assert_search_papers($user_chair, "has:sco8", "1");
assert_search_papers($user_chair, "has:sco9", "1");
assert_search_papers($user_chair, "has:sco10", "");
assert_search_papers($user_chair, "has:sco11", "1");
assert_search_papers($user_chair, "has:sco12", "1");
assert_search_papers($user_chair, "has:sco13", "1");
assert_search_papers($user_chair, "has:sco14", "");
assert_search_papers($user_chair, "has:sco15", "1");
assert_search_papers($user_chair, "has:sco16", "1");
assert_search_papers($user_chair, "has:tex4", "1");
assert_search_papers($user_chair, "has:tex5", "");
assert_search_papers($user_chair, "has:tex6", "1");
assert_search_papers($user_chair, "has:tex7", "1");
assert_search_papers($user_chair, "has:tex8", "1");
assert_search_papers($user_chair, "has:tex9", "1");
assert_search_papers($user_chair, "has:tex10", "1");
assert_search_papers($user_chair, "has:tex11", "");

$rrow = fetch_review($paper1, $user_mgbaker);
xassert_eqq((string) $rrow->s16, "3");

// Remove some fields and truncate their options
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s15_name" => "Score 15", "rf_s15_position" => 0,
    "rf_s16_name" => "Score 16", "rf_s16_options" => "1. Yes\n2. No\nNo entry\n",
    "rf_t10_name" => "Text 10", "rf_t10_position" => 0
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_s15_name" => "Score 15", "rf_s15_options" => "1. Yes\n2. No\nNo entry\n", "rf_s15_position" => 100,
    "rf_t10_name" => "Text 10", "rf_t10_position" => 101
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

$rrow = fetch_review($paper1, $user_mgbaker);
xassert(!isset($rrow->s16) || (string) $rrow->s16 === "0");
xassert(!isset($rrow->s15) || (string) $rrow->s15 === "0");
xassert(!isset($rrow->t10) || $rrow->t10 === "");

assert_search_papers($user_chair, "has:sco3", "1");
assert_search_papers($user_chair, "has:sco4", "1");
assert_search_papers($user_chair, "has:sco5", "1");
assert_search_papers($user_chair, "has:sco6", "");
assert_search_papers($user_chair, "has:sco7", "1");
assert_search_papers($user_chair, "has:sco8", "1");
assert_search_papers($user_chair, "has:sco9", "1");
assert_search_papers($user_chair, "has:sco10", "");
assert_search_papers($user_chair, "has:sco11", "1");
assert_search_papers($user_chair, "has:sco12", "1");
assert_search_papers($user_chair, "has:sco13", "1");
assert_search_papers($user_chair, "has:sco14", "");
assert_search_papers($user_chair, "has:sco15", "");
assert_search_papers($user_chair, "has:sco16", "");
assert_search_papers($user_chair, "has:tex4", "1");
assert_search_papers($user_chair, "has:tex5", "");
assert_search_papers($user_chair, "has:tex6", "1");
assert_search_papers($user_chair, "has:tex7", "1");
assert_search_papers($user_chair, "has:tex8", "1");
assert_search_papers($user_chair, "has:tex9", "1");
assert_search_papers($user_chair, "has:tex10", "");
assert_search_papers($user_chair, "has:tex11", "");

assert_search_papers($user_chair, "sco3:1", "1");
assert_search_papers($user_chair, "sco4:2", "1");
assert_search_papers($user_chair, "sco5:3", "1");
assert_search_papers($user_chair, "sco6:0", "1");
assert_search_papers($user_chair, "sco7:1", "1");
assert_search_papers($user_chair, "sco8:2", "1");
assert_search_papers($user_chair, "sco9:3", "1");
assert_search_papers($user_chair, "sco10:0", "1");
assert_search_papers($user_chair, "sco11:1", "1");
assert_search_papers($user_chair, "sco12:2", "1");
assert_search_papers($user_chair, "sco13:3", "1");
assert_search_papers($user_chair, "sco14:0", "1");
assert_search_papers($user_chair, "sco15:0", "1");
assert_search_papers($user_chair, "sco16:0", "1");
assert_search_papers($user_chair, "tex4:bobcat", "1");
assert_search_papers($user_chair, "tex6:fisher*", "1");
assert_search_papers($user_chair, "tex7:tiger", "1");
assert_search_papers($user_chair, "tex8:leopard", "1");
assert_search_papers($user_chair, "tex9:tremolo", "1");

// check handling of sfields and tfields: don't lose unchanged fields
save_review(1, $user_mgbaker, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "This is the summary",
    "comaut" => "Comments for äuthor", "compc" => "Comments for PC",
    "sco11" => 2, "sco16" => 1, "tex11" => "butt",
    "ready" => true
]);

assert_search_papers($user_chair, "sco3:1", "1");
assert_search_papers($user_chair, "sco4:2", "1");
assert_search_papers($user_chair, "sco5:3", "1");
assert_search_papers($user_chair, "sco6:0", "1");
assert_search_papers($user_chair, "sco7:1", "1");
assert_search_papers($user_chair, "sco8:2", "1");
assert_search_papers($user_chair, "sco9:3", "1");
assert_search_papers($user_chair, "sco10:0", "1");
assert_search_papers($user_chair, "sco11:2", "1");
assert_search_papers($user_chair, "sco12:2", "1");
assert_search_papers($user_chair, "sco13:3", "1");
assert_search_papers($user_chair, "sco14:0", "1");
assert_search_papers($user_chair, "sco15:0", "1");
assert_search_papers($user_chair, "sco16:1", "1");
assert_search_papers($user_chair, "comaut:author", "1");
assert_search_papers($user_chair, "comaut:äuthor", "1");
assert_search_papers($user_chair, "comaut:áuthor", "");
assert_search_papers($user_chair, "tex4:bobcat", "1");
assert_search_papers($user_chair, "tex6:fisher*", "1");
assert_search_papers($user_chair, "tex7:tiger", "1");
assert_search_papers($user_chair, "tex8:leopard", "1");
assert_search_papers($user_chair, "tex9:tremolo", "1");
assert_search_papers($user_chair, "tex11:butt", "1");

// check handling of sfields and tfields: no changes at all
save_review(1, $user_mgbaker, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "This is the summary",
    "comaut" => "Comments for äuthor", "compc" => "Comments for PC",
    "sco13" => 3, "sco14" => 0, "sco15" => 0, "sco16" => 1,
    "tex4" => "bobcat", "tex5" => "", "tex6" => "fishercat", "tex7" => "tiger",
    "tex8" => "leopard", "tex9" => "tremolo", "tex10" => "", "tex11" => "butt",
    "ready" => true
]);

assert_search_papers($user_chair, "sco3:1", "1");
assert_search_papers($user_chair, "sco4:2", "1");
assert_search_papers($user_chair, "sco5:3", "1");
assert_search_papers($user_chair, "sco6:0", "1");
assert_search_papers($user_chair, "sco7:1", "1");
assert_search_papers($user_chair, "sco8:2", "1");
assert_search_papers($user_chair, "sco9:3", "1");
assert_search_papers($user_chair, "sco10:0", "1");
assert_search_papers($user_chair, "sco11:2", "1");
assert_search_papers($user_chair, "sco12:2", "1");
assert_search_papers($user_chair, "sco13:3", "1");
assert_search_papers($user_chair, "sco14:0", "1");
assert_search_papers($user_chair, "sco15:0", "1");
assert_search_papers($user_chair, "sco16:1", "1");
assert_search_papers($user_chair, "tex4:bobcat", "1");
assert_search_papers($user_chair, "tex6:fisher*", "1");
assert_search_papers($user_chair, "tex7:tiger", "1");
assert_search_papers($user_chair, "tex8:leopard", "1");
assert_search_papers($user_chair, "tex9:tremolo", "1");
assert_search_papers($user_chair, "tex11:butt", "1");

// check handling of sfields and tfields: clear extension fields
save_review(1, $user_mgbaker, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "",
    "comaut" => "", "compc" => "", "sco12" => 0,
    "sco13" => 0, "sco14" => 0, "sco15" => 0, "sco16" => 0,
    "tex4" => "", "tex5" => "", "tex6" => "", "tex7" => "",
    "tex8" => "", "tex9" => "", "tex10" => "", "tex11" => "",
    "ready" => true
]);

$rrow = fetch_review($paper1, $user_mgbaker);
xassert(!$rrow->sfields);
xassert(!$rrow->tfields);

save_review(1, $user_mgbaker, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "This is the summary",
    "comaut" => "Comments for äuthor", "compc" => "Comments for PC",
    "sco3" => 1, "sco4" => 2, "sco5" => 3, "sco6" => 0, "sco7" => 1,
    "sco8" => 2, "sco9" => 3, "sco10" => 0, "sco11" => 2,
    "sco12" => 2, "sco13" => 3, "sco14" => 0, "sco15" => 0, "sco16" => 1,
    "tex4" => "bobcat", "tex5" => "", "tex6" => "fishercat", "tex7" => "tiger",
    "tex8" => "leopard", "tex9" => "tremolo", "tex10" => "", "tex11" => "butt",
    "ready" => true
]);

assert_search_papers($user_chair, "sco3:1", "1");
assert_search_papers($user_chair, "sco4:2", "1");
assert_search_papers($user_chair, "sco5:3", "1");
assert_search_papers($user_chair, "sco6:0", "1");
assert_search_papers($user_chair, "sco7:1", "1");
assert_search_papers($user_chair, "sco8:2", "1");
assert_search_papers($user_chair, "sco9:3", "1");
assert_search_papers($user_chair, "sco10:0", "1");
assert_search_papers($user_chair, "sco11:2", "1");
assert_search_papers($user_chair, "sco12:2", "1");
assert_search_papers($user_chair, "sco13:3", "1");
assert_search_papers($user_chair, "sco14:0", "1");
assert_search_papers($user_chair, "sco15:0", "1");
assert_search_papers($user_chair, "sco16:1", "1");
assert_search_papers($user_chair, "tex4:bobcat", "1");
assert_search_papers($user_chair, "tex6:fisher*", "1");
assert_search_papers($user_chair, "tex7:tiger", "1");
assert_search_papers($user_chair, "tex8:leopard", "1");
assert_search_papers($user_chair, "tex9:tremolo", "1");
assert_search_papers($user_chair, "tex11:butt", "1");

save_review(1, $user_mgbaker, [
    "ovemer" => 3, "sco15" => 2,
    "tex8" => "leopardino", "ready" => true
]);

assert_search_papers($user_chair, "sco3:1", "1");
assert_search_papers($user_chair, "sco4:2", "1");
assert_search_papers($user_chair, "sco5:3", "1");
assert_search_papers($user_chair, "sco6:0", "1");
assert_search_papers($user_chair, "sco7:1", "1");
assert_search_papers($user_chair, "sco8:2", "1");
assert_search_papers($user_chair, "sco9:3", "1");
assert_search_papers($user_chair, "sco10:0", "1");
assert_search_papers($user_chair, "sco11:2", "1");
assert_search_papers($user_chair, "sco12:2", "1");
assert_search_papers($user_chair, "sco13:3", "1");
assert_search_papers($user_chair, "sco14:0", "1");
assert_search_papers($user_chair, "sco15:2", "1");
assert_search_papers($user_chair, "sco16:1", "1");
assert_search_papers($user_chair, "tex4:bobcat", "1");
assert_search_papers($user_chair, "tex6:fisher*", "1");
assert_search_papers($user_chair, "tex7:tiger", "1");
assert_search_papers($user_chair, "tex8:leopard", "");
assert_search_papers($user_chair, "tex8:leopardino", "1");
assert_search_papers($user_chair, "tex9:tremolo", "1");
assert_search_papers($user_chair, "tex11:butt", "1");

// simplify review form
$sx = ["has_review_form" => 1];
for ($i = 3; $i <= 16; ++$i) {
    $sx[sprintf("order_s%02d", $i)] = $sx[sprintf("order_t%02d", $i)] = -1;
}
$sv = SettingValues::make_request($user_chair, $sx);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "review_form");

// saving a JSON review defaults to ready
xassert_assign($user_chair, "paper,lead\n17,pdruschel\n");
$paper17 = $user_mgbaker->checked_paper_by_id(17);

xassert_eqq($paper17->review_type($user_mgbaker), REVIEW_PRIMARY);
xassert_eqq($paper17->review_type($user_diot), 0);
xassert(!$user_mgbaker->can_view_authors($paper17));
xassert(!$user_diot->can_view_authors($paper17));
xassert(!$user_pdruschel->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_NEVER);
Contact::update_rights();
xassert($user_mgbaker->can_view_authors($paper17));
xassert($user_diot->can_view_authors($paper17));
xassert($user_pdruschel->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_OPTIONAL);
Contact::update_rights();
xassert(!$user_mgbaker->can_view_authors($paper17));
xassert(!$user_diot->can_view_authors($paper17));
xassert(!$user_pdruschel->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_UNTILREVIEW);
Contact::update_rights();
xassert(!$user_mgbaker->can_view_authors($paper17));
xassert(!$user_diot->can_view_authors($paper17));
xassert(!$user_pdruschel->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_ALWAYS);

$rrow17m = fetch_review($paper17, $user_mgbaker);
xassert(!$rrow17m->reviewModified);

$tf = new ReviewValues($Conf->review_form());
xassert($tf->parse_json(["ovemer" => 2, "revexp" => 1, "papsum" => "No summary", "comaut" => "No comments"]));
xassert($tf->check_and_save($user_mgbaker, $paper17));

$rrow17m = fetch_review($paper17, $user_mgbaker);
xassert_eq($rrow17m->overAllMerit, 2);
xassert_eq($rrow17m->reviewerQualification, 1);
xassert_eqq($rrow17m->t01, "No summary\n");
xassert_eqq($rrow17m->t02, "No comments\n");
xassert_eqq($rrow17m->reviewOrdinal, 1);
xassert($rrow17m->reviewSubmitted > 0);

xassert(!$user_mgbaker->can_view_authors($paper17));
xassert(!$user_diot->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_NEVER);
Contact::update_rights();
xassert($user_mgbaker->can_view_authors($paper17));
xassert($user_diot->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_OPTIONAL);
Contact::update_rights();
xassert(!$user_mgbaker->can_view_authors($paper17));
xassert(!$user_diot->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_UNTILREVIEW);
Contact::update_rights();
xassert($user_mgbaker->can_view_authors($paper17));
xassert(!$user_diot->can_view_authors($paper17));
$Conf->save_setting("sub_blind", Conf::BLIND_ALWAYS);

// Check review diffs
$paper18 = $user_diot->checked_paper_by_id(18);
$tf = new ReviewValues($Conf->review_form());
xassert($tf->parse_json(["ovemer" => 2, "revexp" => 1, "papsum" => "No summary", "comaut" => "No comments"]));
xassert($tf->check_and_save($user_diot, $paper18));

$rrow18d = fetch_review($paper18, $user_diot);
$rd = new ReviewDiffInfo($paper18, $rrow18d);
$rd->add_field($Conf->find_review_field("ovemer"), 3);
$rd->add_field($Conf->find_review_field("papsum"), "There definitely is a summary in this position.");
xassert_eqq(ReviewDiffInfo::unparse_patch($rd->make_patch()),
            '{"s01":2,"t01":"No summary\\n"}');
xassert_eqq(ReviewDiffInfo::unparse_patch($rd->make_patch(1)),
            '{"s01":3,"t01":"There definitely is a summary in this position."}');

$rrow18d2 = clone $rrow18d;
xassert_eq($rrow18d2->overAllMerit, 2);
xassert_eq($rrow18d2->reviewerQualification, 1);
xassert_eqq($rrow18d2->t01, "No summary\n");
ReviewDiffInfo::apply_patch($rrow18d2, $rd->make_patch(1));
xassert_eq($rrow18d2->overAllMerit, 3);
xassert_eq($rrow18d2->reviewerQualification, 1);
xassert_eqq($rrow18d2->t01, "There definitely is a summary in this position.");
ReviewDiffInfo::apply_patch($rrow18d2, $rd->make_patch());
xassert_eq($rrow18d2->overAllMerit, 2);
xassert_eq($rrow18d2->reviewerQualification, 1);
xassert_eqq($rrow18d2->t01, "No summary\n");

$tf = new ReviewValues($Conf->review_form());
xassert($tf->parse_json(["papsum" =>
    "Four score and seven years ago our fathers brought forth on this continent, a new nation, conceived in Liberty, and dedicated to the proposition that all men are created equal.\n\
\n\
Now we are engaged in a great civil war, testing whether that nation, or any nation so conceived and so dedicated, can long endure. We are met on a great battle-field of that war. We have come to dedicate a portion of that field, as a final resting place for those who here gave their lives that that nation might live. It is altogether fitting and proper that we should do this.\n\
\n\
But, in a larger sense, we can not dedicate -- we can not consecrate -- we can not hallow -- this ground. The brave men, living and dead, who struggled here, have consecrated it, far above our poor power to add or detract. The world will little note, nor long remember what we say here, but it can never forget what they did here. It is for us the living, rather, to be dedicated here to the unfinished work which they who fought here have thus far so nobly advanced. It is rather for us to be here dedicated to the great task remaining before us -- that from these honored dead we take increased devotion to that cause for which they gave the last full measure of devotion -- that we here highly resolve that these dead shall not have died in vain -- that this nation, under God, shall have a new birth of freedom -- and that government of the people, by the people, for the people, shall not perish from the earth.\n"]));
xassert($tf->check_and_save($user_diot, $paper18));

$rrow18d = fetch_review($paper18, $user_diot);
$gettysburg = $rrow18d->t01;
$gettysburg2 = str_replace("by the people", "near the people", $gettysburg);

$rd = new ReviewDiffInfo($paper18, $rrow18d);
$rd->add_field($Conf->find_review_field("papsum"), $gettysburg2);

$rrow18d2 = clone $rrow18d;
xassert_eqq($rrow18d2->t01, $gettysburg);
ReviewDiffInfo::apply_patch($rrow18d2, $rd->make_patch(1));
xassert_eqq($rrow18d2->t01, $gettysburg2);
ReviewDiffInfo::apply_patch($rrow18d2, $rd->make_patch());
xassert_eqq($rrow18d2->t01, $gettysburg);

// offline review parsing for UTF-8 review questions
$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_t04_name" => "Questions for authors’ response",
    "rf_t04_description" => "Specific questions that could affect your accept/reject decision. Remember that the authors have limited space and must respond to all reviewers.",
    "rf_t04_visibility" => "au",
    "rf_t04_position" => 5
]);
xassert($sv->execute());

$review18A = file_get_contents(SiteLoader::find("test/review18A.txt"));
$tf = ReviewValues::make_text($Conf->review_form(), $review18A, "review18A.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_diot));

$rrow = fetch_review($paper18, $user_diot);
xassert_eqq($rrow->t04, "This is the stuff I want to add for the authors’ response.\n");

$review18A2 = str_replace("This is the stuff", "That was the stuff",
    str_replace("authors’ response\n", "authors' response\n", $review18A));
$tf = ReviewValues::make_text($Conf->review_form(), $review18A2, "review18A2.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_diot));

$rrow = fetch_review($paper18, $user_diot);
xassert_eqq($rrow->t04, "That was the stuff I want to add for the authors’ response.\n");

$sv = SettingValues::make_request($user_chair, [
    "has_review_form" => 1,
    "rf_t04_name" => "Questions for authors’ response (hidden from authors)",
    "rf_t04_forcename" => 1
]);
xassert($sv->execute());

$review18A3 = str_replace("That was the stuff", "Whence the stuff",
    str_replace("authors' response\n", "authors' response (hidden from authors)\n", $review18A2));
$tf = ReviewValues::make_text($Conf->review_form(), $review18A3, "review18A3.txt");
xassert($tf->parse_text(false));
xassert($tf->check_and_save($user_diot));

$rrow = fetch_review($paper18, $user_diot);
xassert_eqq($rrow->t04, "Whence the stuff I want to add for the authors’ response.\n");

// check some review visibility policies
$user_external = Contact::create($Conf, null, ["email" => "external@_.com", "name" => "External Reviewer"]);
assert(!!$user_external);
$user_mgbaker->assign_review(17, $user_external->contactId, REVIEW_EXTERNAL,
    ["round_number" => $Conf->round_number("R2", false)]);
xassert(!$user_external->can_view_review($paper17, $rrow17m));
xassert(!$user_external->can_view_review_identity($paper17, $rrow17m));
xassert(!$user_mjh->can_view_review($paper17, $rrow17m));
$Conf->save_setting("extrev_view", 0);
save_review(17, $user_external, [
    "ovemer" => 2, "revexp" => 1, "papsum" => "Hi", "comaut" => "Bye", "ready" => true
]);
MailChecker::check_db("test06-17external");
xassert(!$user_external->can_view_review($paper17, $rrow17m));
xassert(!$user_external->can_view_review_identity($paper17, $rrow17m));
$Conf->save_setting("extrev_view", 1);
xassert($user_external->can_view_review($paper17, $rrow17m));
xassert(!$user_external->can_view_review_identity($paper17, $rrow17m));
$Conf->save_setting("extrev_view", 2);
xassert($user_external->can_view_review($paper17, $rrow17m));
xassert($user_external->can_view_review_identity($paper17, $rrow17m));

// per-round review visibility
$user_lixia = $Conf->checked_user_by_email("lixia@cs.ucla.edu");
$tf = new ReviewValues($Conf->review_form());
xassert($tf->parse_json(["ovemer" => 2, "revexp" => 1, "papsum" => "Radical", "comaut" => "Nonradical"]));
xassert($tf->check_and_save($user_lixia, $paper17));
MailChecker::check_db("test06-17lixia");
$rrow17h = fetch_review($paper17, $user_lixia);
$rrow17x = fetch_review($paper17, $user_external);
xassert_eqq($rrow17m->reviewRound, $Conf->round_number("R2", false));
xassert_eqq($rrow17h->reviewRound, $Conf->round_number("R1", false));
xassert_eqq($rrow17x->reviewRound, $Conf->round_number("R2", false));
Contact::update_rights();

xassert($user_mgbaker->can_view_review($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review($paper17, $rrow17x));
xassert($user_lixia->can_view_review($paper17, $rrow17m));
xassert($user_lixia->can_view_review($paper17, $rrow17h));
xassert($user_lixia->can_view_review($paper17, $rrow17x));
xassert($user_external->can_view_review($paper17, $rrow17m));
xassert($user_external->can_view_review($paper17, $rrow17h));
xassert($user_external->can_view_review($paper17, $rrow17x));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17x));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17m));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17h));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17x));
xassert($user_external->can_view_review_identity($paper17, $rrow17m));
xassert($user_external->can_view_review_identity($paper17, $rrow17h));
xassert($user_external->can_view_review_identity($paper17, $rrow17x));

function save_round_settings($map) {
    global $Conf;
    $settings = [];
    foreach ($Conf->round_list() as $rname) {
        $settings[] = isset($map[$rname]) ? $map[$rname] : null;
    }
    $Conf->save_setting("round_settings", 1, json_encode_db($settings));
}
save_round_settings(["R1" => ["extrev_view" => 0]]);
Contact::update_rights();

xassert($user_mgbaker->can_view_review($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review($paper17, $rrow17x));
xassert($user_lixia->can_view_review($paper17, $rrow17m));
xassert($user_lixia->can_view_review($paper17, $rrow17h));
xassert($user_lixia->can_view_review($paper17, $rrow17x));
xassert($user_external->can_view_review($paper17, $rrow17m));
xassert(!$user_external->can_view_review($paper17, $rrow17h));
xassert($user_external->can_view_review($paper17, $rrow17x));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17x));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17m));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17h));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17x));
xassert($user_external->can_view_review_identity($paper17, $rrow17m));
xassert(!$user_external->can_view_review_identity($paper17, $rrow17h));
xassert($user_external->can_view_review_identity($paper17, $rrow17x));
assert_search_papers($user_chair, "re:mgbaker", "1 13 17");
assert_search_papers($user_lixia, "re:mgbaker", "1 13 17");

// Extrev cannot view R1; PC cannot view R2
save_round_settings(["R1" => ["extrev_view" => 0], "R2" => ["pc_seeallrev" => -1]]);
Contact::update_rights();

xassert($user_mgbaker->can_view_review($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review($paper17, $rrow17h));
xassert(!$user_mgbaker->can_view_review($paper17, $rrow17x));
xassert(!$user_lixia->can_view_review($paper17, $rrow17m));
xassert($user_lixia->can_view_review($paper17, $rrow17h));
xassert(!$user_lixia->can_view_review($paper17, $rrow17x));
xassert($user_external->can_view_review($paper17, $rrow17m));
xassert(!$user_external->can_view_review($paper17, $rrow17h));
xassert($user_external->can_view_review($paper17, $rrow17x));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17x));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17m));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17h));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17x));
xassert($user_external->can_view_review_identity($paper17, $rrow17m));
xassert(!$user_external->can_view_review_identity($paper17, $rrow17h));
xassert($user_external->can_view_review_identity($paper17, $rrow17x));
assert_search_papers($user_chair, "re:mgbaker", "1 13 17");
assert_search_papers($user_lixia, "re:mgbaker", "1 13 17");

// Extrev cannot view R1; PC cannot view R2 identity
save_round_settings(["R1" => ["extrev_view" => 0], "R2" => ["pc_seeblindrev" => -1]]);
Contact::update_rights();

xassert($user_mgbaker->can_view_review($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review($paper17, $rrow17x));
xassert($user_lixia->can_view_review($paper17, $rrow17m));
xassert($user_lixia->can_view_review($paper17, $rrow17h));
xassert($user_lixia->can_view_review($paper17, $rrow17x));
xassert($user_external->can_view_review($paper17, $rrow17m));
xassert(!$user_external->can_view_review($paper17, $rrow17h));
xassert($user_external->can_view_review($paper17, $rrow17x));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17m));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17h));
xassert($user_mgbaker->can_view_review_identity($paper17, $rrow17x));
xassert(!$user_lixia->can_view_review_identity($paper17, $rrow17m));
xassert($user_lixia->can_view_review_identity($paper17, $rrow17h));
xassert(!$user_lixia->can_view_review_identity($paper17, $rrow17x));
xassert($user_external->can_view_review_identity($paper17, $rrow17m));
xassert(!$user_external->can_view_review_identity($paper17, $rrow17h));
xassert($user_external->can_view_review_identity($paper17, $rrow17x));
assert_search_papers($user_chair, "re:mgbaker", "1 13 17");
assert_search_papers($user_lixia, "re:mgbaker", "1");

save_review(17, $user_external, [
    "ovemer" => 1
]);
assert_search_papers($user_chair, "17 ovemer:2<=1", "");
assert_search_papers($user_chair, "17 ovemer:=1<=1", "17");
assert_search_papers($user_chair, "17 ovemer=1<=1", "17");

save_review(17, $user_pdruschel, [
    "ready" => true, "ovemer" => 1, "revexp" => 1
]);
assert_search_papers($user_chair, "17 ovemer:2<=1", "17");
assert_search_papers($user_chair, "17 ovemer:=2<=1", "17");
assert_search_papers($user_chair, "17 ovemer:1<=1", "17");
assert_search_papers($user_chair, "17 ovemer:=1<=1", "");
assert_search_papers($user_chair, "17 ovemer=1<=1", "");

assert_search_papers($user_chair, "ovemer:1..2", "17 18");
assert_search_papers($user_chair, "ovemer:1..3", "1 17 18");
assert_search_papers($user_chair, "ovemer:1–2", "17");
assert_search_papers($user_chair, "ovemer:1-3", "");
assert_search_papers($user_chair, "ovemer:2..1", "17 18");
assert_search_papers($user_chair, "ovemer:3..1", "1 17 18");

// new external reviewer does not get combined email
$Conf->save_setting("round_settings", null);
$Conf->save_setting("extrev_view", 1);
$Conf->save_setting("pcrev_editdelegate", 2);
Contact::update_rights();
MailChecker::clear();

$xqreq = new Qrequest("POST", ["email" => "external2@_.com", "name" => "Jo March", "affiliation" => "Concord"]);
$result = RequestReview_API::requestreview($user_lixia, $xqreq, $paper17);
$result = JsonResult::make($result);
MailChecker::check_db("test06-external2-request17");
xassert($result->content["ok"]);

$user_external2 = $Conf->checked_user_by_email("external2@_.com");
save_review(17, $user_external2, [
    "ready" => true, "ovemer" => 3, "revexp" => 3
]);
MailChecker::check_db("test06-external2-approval17");

save_review(17, $user_lixia, ["ready" => true], fetch_review(17, $user_external2));
MailChecker::check_db("test06-external2-submit17");

// `r` vs. `rout`
assert_search_papers($user_mgbaker, ["t" => "r", "q" => ""], "1 13 17");
assert_search_papers($user_mgbaker, ["t" => "rout", "q" => ""], "13");
assert_search_papers($user_mgbaker, ["t" => "r", "q" => "internet OR datagram"], "13");
assert_search_papers($user_mgbaker, ["t" => "rout", "q" => "internet OR datagram"], "13");

xassert_assign($user_chair, "paper,action,user\n19,review,new-anonymous");
$user_mgbaker->change_review_token($Conf->fetch_ivalue("select reviewToken from PaperReview where paperId=19 and reviewToken!=0"), true);
assert_search_papers($user_mgbaker, ["t" => "r", "q" => ""], "1 13 17 19");
assert_search_papers($user_mgbaker, ["t" => "rout", "q" => ""], "13 19");
assert_search_papers($user_mgbaker, ["t" => "r", "q" => "internet"], "13");
assert_search_papers($user_mgbaker, ["t" => "rout", "q" => "internet"], "13");
assert_search_papers($user_mgbaker, ["t" => "r", "q" => "internet OR datagram"], "13 19");
assert_search_papers($user_mgbaker, ["t" => "rout", "q" => "internet OR datagram"], "13 19");
assert_search_papers($user_mgbaker, "(internet OR datagram) 13 19", "13 19");

// author review visibility
xassert(!$user_mjh->can_view_review($paper17, $rrow17m));
$Conf->save_setting("au_seerev", 2);
xassert($user_mjh->can_view_review($paper17, $rrow17m));
xassert_assign_fail($user_mgbaker, "paper,tag\n17,perm:author-read-review\n");
xassert_assign_fail($user_mjh, "paper,tag\n17,perm:author-read-review\n");
xassert_assign($Admin, "paper,tag\n17,perm:author-read-review#-1\n");
$paper17->invalidate_tags();
xassert(!$user_mjh->can_view_review($paper17, $rrow17m));
$Conf->save_setting("au_seerev", null);
xassert_assign($Admin, "paper,tag\n17,perm:author-read-review#1\n");
$paper17->invalidate_tags();
xassert($user_mjh->can_view_review($paper17, $rrow17m));
xassert_assign($Admin, "paper,tag\n17,perm:author-read-review#clear\n");
$paper17->invalidate_tags();
xassert(!$user_mjh->can_view_review($paper17, $rrow17m));

// paper options
assert_search_papers($user_mgbaker, "has:calories", "1 2 3 4 5");
$sv = SettingValues::make_request($user_chair, [
    "has_options" => 1,
    "optn_1" => "Fudge",
    "optid_1" => 1,
    "optfp_1" => 1,
    "optvt_1" => "numeric"
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "options");
assert_search_papers($user_mgbaker, "has:fudge", "1 2 3 4 5");

$sv = SettingValues::make_request($user_chair, [
    "has_options" => 1,
    "optn_1" => "Fudge",
    "optid_1" => 1,
    "optfp_1" => 1,
    "optvt_1" => "checkbox"
]);
xassert($sv->execute());
xassert_eqq(join(" ", $sv->updated_fields()), "options");
assert_search_papers($user_mgbaker, "has:fudge", "");

xassert_exit();
