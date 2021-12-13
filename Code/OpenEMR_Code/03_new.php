<?php

/*
 * Work/School Note Form new.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Nikolai Vitsyn
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2004-2005 Nikolai Vitsyn
 * @copyright Copyright (c) Open Source Medical Software
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
?>

<html><head>

<?php Header::setupHeader('datetime-picker'); ?>

<script>
// required for textbox date verification
var mypcc = <?php echo js_escape($GLOBALS['phone_country_code']); ?>;
</script>

</head>

<body class="body_top">
<?php echo text(date("Y-m-d", time())); ?>

<form method=post action="<?php echo $rootdir . "/forms/" . $form_name . "/save.php?mode=new";?>" name="my_form" id="my_form">
<input type="hidden" name="csrf_token_form" value="<?php echo attr(CsrfUtils::collectCsrfToken()); ?>" />

<span class="title" style="font-size:2em"><?php echo xlt('COVID Testing'); ?></span><br /><br />

<label for="last_test" style="font-size:1.5em;">Last COVID Test: </label>
<span class="text" name="last_test" id="last_test" style="color:red;font-size:1.5em;"><?php echo xlt('COVID Testing'); ?></span><br />

<label for="procedure_code">Procedure code:</label>
<select name="procedure_code" id="procedure_code">
<option value="19-1"><?php echo xlt('19-1'); ?></option>
</select>

<br />

<label for="test_status">Test status:</label>
<select name="test_status">
<option value="Unassigned"><?php echo xlt('Unassigned'); ?></option>
<option value="Pending"><?php echo xlt('Pending'); ?></option>
<option value="Routed"><?php echo xlt('Routed'); ?></option>
<option value="Complete"><?php echo xlt('Complete'); ?></option>
<option value="Canceled"><?php echo xlt('Canceled'); ?></option>
</select>


<br />
<b><?php echo xlt('Test Notes: if ordering additional test within 24 hour timespan, note reason below'); ?></b>
<br />
<textarea name="test_notes" id="test_notes" rows="4" cols="80"></textarea>
<br />

<?php
// commented out below private field, because no field in database, and causes error.
?>
<!--
<input type="checkbox" name="private" id="private"><label for="private">This note is private</label>
<br />
-->

<br />
<b><?php echo xlt('Signature:'); ?></b>
<br />

<table>
<tr><td>
<?php echo xlt('Doctor:'); ?>
<input type="text" name="doctor" id="doctor" value="<?php echo attr($provider_results["fname"]) . ' ' . attr($provider_results["lname"]); ?>">
</td>

<td>
<span class="text"><?php echo xlt('Date'); ?></span>
   <input type='text' size='10' class='datepicker' name='date_of_signature' id='date_of_signature'
    value='<?php echo attr(date('Y-m-d', time())); ?>'
    title='<?php echo xla('yyyy-mm-dd'); ?>' />
</td>
</tr>
</table>

<div style="margin: 10px;">
<input type="button" class="save" value="    <?php echo xla('Save'); ?>    "> &nbsp;
<input type="button" class="dontsave" value="<?php echo xla('Don\'t Save'); ?>"> &nbsp;
</div>

</form>

</body>

<script>

// jQuery stuff to make the page a little easier to use

$(function () {
    $(".save").click(function() { top.restoreSession(); $('#my_form').submit(); });
    $(".dontsave").click(function() { parent.closeTab(window.name, false); });
    //$("#printform").click(function() { PrintForm(); });

    $('.datepicker').datetimepicker({
        <?php $datetimepicker_timepicker = false; ?>
        <?php $datetimepicker_showseconds = false; ?>
        <?php $datetimepicker_formatInput = false; ?>
        <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
        <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
    });
});

</script>

<script type='text/javascript'>

<?php
    $patient_id = $pid;
    $sqlArray = array();
    $sqlArray[] = $patient_id;
    $sql = "SELECT date FROM v_covid_procedures WHERE pid=?";

    $rslt = sqlStatement($sql, $sqlArray);

    //for ($iter = 0; $row = sqlFetchArray($rslt); $iter++) {
    //    alert($row['lname'] . '^' . $row['fname']);
    //}

    $row = sqlFetchArray($rslt);
    $date = $row['date'];

?>

try {
    document.getElementById('last_test').innerHTML = '<?php echo $date ?>';
}

catch (e) { alert(e + ' ' + e.message); }

</script>

</html>
