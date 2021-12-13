<?php

/*
 * Work/School Note Form view.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Nikolai Vitsyn
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2004-2005 Nikolai Vitsyn
 * @copyright Copyright (c) 2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */



require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc");

use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Core\Header;

formHeader("Form: note");
$returnurl = 'encounter_top.php';
$provider_results = sqlQuery("select fname, lname from users where username=?", array($_SESSION["authUser"]));

/* name of this form */
$form_name = "covid_testing";

// get the record from the database
if ($_GET['id'] != "") {
    $obj = formFetch("form_" . $form_name, $_GET["id"]);
}

/* remove the time-of-day from the date fields */
if ($obj['date_of_signature'] != "") {
    $dateparts = explode(" ", $obj['date_of_signature']);
    $obj['date_of_signature'] = $dateparts[0];
}
?>
<html><head>

<?php Header::setupHeader('datetime-picker'); ?>

<script>
// required for textbox date verification
var mypcc = <?php echo js_escape($GLOBALS['phone_country_code']); ?>;

function PrintForm() {
    newwin = window.open(<?php echo js_escape($rootdir . "/forms/" . $form_name . "/print.php?id=" . urlencode($_GET["id"])); ?>,"mywin");
}

</script>

</head>
<body class="body_top">

<form method=post action="<?php echo $rootdir . "/forms/" . $form_name . "/save.php?mode=update&id=" . attr_url($_GET["id"]);?>" name="my_form" id="my_form">
<input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />

<span class="title"><?php echo xlt('COVID Testing'); ?></span><br /><br />

<label for="procedure_code">Procedure code:</label>
<select name="procedure_code" id="procedure_code">
<option value="19-1" <?php if ($obj['procedure_code'] == "19-1") {
    echo " SELECTED";
                          } ?>><?php echo xlt('19-1'); ?></option>
</select>

<br />

<label for="test_status">Test status:</label>
<select name="test_status">
<option value="Unassigned" <?php if ($obj['test_status'] == "Unassigned") {
    echo " SELECTED";
                          } ?>><?php echo xlt('Unassigned'); ?></option>
<option value="Pending" <?php if ($obj['test_status'] == "Pending") {
    echo " SELECTED";
                            } ?>><?php echo xlt('Pending'); ?></option>
<option value="Routed" <?php if ($obj['test_status'] == "Routed") {
    echo " SELECTED";
                            } ?>><?php echo xlt('Routed'); ?></option>
<option value="Complete" <?php if ($obj['test_status'] == "Complete") {
    echo " SELECTED";
                            } ?>><?php echo xlt('Complete'); ?></option>
<option value="Canceled" <?php if ($obj['test_status'] == "Canceled") {
    echo " SELECTED";
                            } ?>><?php echo xlt('Canceled'); ?></option>							
</select>
<br />
<b><?php echo xlt('Test Notes:'); ?></b>
<br />
<textarea name="test_notes" id="test_notes" cols ="67" rows="4"><?php echo text($obj["test_notes"]);?></textarea>
<br /> <br />

<table>
<tr><td>
<span class=text><?php echo xlt('Doctor:'); ?> </span><input type="text" name="doctor" value="<?php echo attr($obj["doctor"]);?>">
</td><td>
<span class="text"><?php echo xlt('Date'); ?></span>
   <input type='text' size='10' class='datepicker' name='date_of_signature' id='date_of_signature'
    value='<?php echo attr($obj['date_of_signature']); ?>'
    title='<?php echo xla('yyyy-mm-dd'); ?>' />
</td></tr>
</table>

<div style="margin: 10px;">
<input type="button" class="save" value="    <?php echo xla('Save'); ?>    "> &nbsp;
<input type="button" class="dontsave" value="<?php echo xla('Don\'t Save'); ?>"> &nbsp;
<input type="button" class="printform" value="<?php echo xla('View Printable Version'); ?>"> &nbsp;
</div>

</form>

</body>

<script>

// jQuery stuff to make the page a little easier to use

$(function () {
    $(".save").click(function() { top.restoreSession(); $("#my_form").submit(); });
    $(".dontsave").click(function() { parent.closeTab(window.name, false); });
    $(".printform").click(function() { PrintForm(); });

    // disable the Print ability if the form has changed
    // this forces the user to save their changes prior to printing
    $("#img_date_of_signature").click(function() { $(".printform").attr("disabled","disabled"); });
    $("input").keydown(function() { $(".printform").attr("disabled","disabled"); });
    $("select").change(function() { $(".printform").attr("disabled","disabled"); });
    $("textarea").keydown(function() { $(".printform").attr("disabled","disabled"); });

    $('.datepicker').datetimepicker({
        <?php $datetimepicker_timepicker = false; ?>
        <?php $datetimepicker_showseconds = false; ?>
        <?php $datetimepicker_formatInput = false; ?>
        <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
        <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
    });
});

</script>

</html>
