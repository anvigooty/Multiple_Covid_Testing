<?php

/*
 * Work/School Note Form print.php
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

use OpenEMR\Core\Header;

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
<title><?php echo "COVID Testing"?></title>

<?php Header::setupHeader(); ?>

</head>
<body class="body_top">

<form method=post action="">
<span class="title"><?php echo xlt('COVID Testing'); ?></span><br /><br />
<?php echo xlt('Printed'); ?> <?php echo text(dateformat()); ?>
<br /><br />

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
<div style="border: 1px solid black; padding: 5px; margin: 5px;"><?php echo text($obj["test_notes"]);?></div>
<br /><br />

<table>
<tr><td>
<span class=text><?php echo xlt('Doctor:'); ?> </span><input type=text name="doctor" value="<?php echo attr($obj["doctor"]);?>">
</td><td>
<span class="text"><?php echo xlt('Date'); ?></span>
   <input type='text' size='10' name='date_of_signature' id='date_of_signature'
    value='<?php echo attr($obj['date_of_signature']); ?>'
    />
</td></tr>
</table>

</form>

</body>

<script>
// jQuery stuff to make the page a little easier to use

$(function () {
    var win = top.printLogPrint ? top : opener.top;
    win.printLogPrint(window);
});

</script>

</html>
