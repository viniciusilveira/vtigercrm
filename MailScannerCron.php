<?php
/*********************************************************************************
 ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/

require_once('config.inc.php');

/** Verify the script call is from trusted place. */
global $application_unique_key;
if($_REQUEST['app_key'] != $application_unique_key) {
	echo "Access denied!";
	exit;
}

require_once('include/utils/utils.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');

require_once('modules/Settings/MailScanner/core/MailScannerInfo.php');
require_once('modules/Settings/MailScanner/core/MailBox.php');
require_once('modules/Settings/MailScanner/core/MailScanner.php');

/** 
 * Execution of this is based on number of emails and connection to mailserver.
 * So setting infinite timeout.
 */
set_time_limit(0);

/** Turn-off this if not required. */
$debug = true;

/** Pick up the mail scanner for scanning. */
$scannername = $_REQUEST['scannername'];
if(!$scannername) $scannername = 'DEFAULT';
$scannerinfo = new Vtiger_MailScannerInfo($scannername);

/** If the scanner is not enabled, stop. */
if(!$scannerinfo->isvalid) { 
	echo "No active mailbox to scan.";
	exit;
}

echo "Scanning " . $scannerinfo->server . " in progress\n";

/** Start the scanning. */
$scanner = new Vtiger_MailScanner($scannerinfo);
$scanner->debug = $debug;
$scanner->performScanNow();

echo "\nScanning " . $scannerinfo->server . " completed\n";

?>
