<?php
/*+********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *********************************************************************************/
if (!defined('VTIGER_UPGRADE')) die('Invalid entry point');

if(defined('VTIGER_UPGRADE')) {
        //Collating all module package updates here
	updateVtlibModule('Import', 'packages/vtiger/mandatory/Import.zip');
	updateVtlibModule('MailManager', 'packages/vtiger/mandatory/MailManager.zip');
	updateVtlibModule('Mobile', 'packages/vtiger/mandatory/Mobile.zip');
        updateVtlibModule('ModTracker', 'packages/vtiger/mandatory/ModTracker.zip');
        updateVtlibModule('ServiceContracts', 'packages/vtiger/mandatory/ServiceContracts.zip');
        updateVtlibModule('Services', 'packages/vtiger/mandatory/Services.zip');
	updateVtlibModule('WSAPP', 'packages/vtiger/mandatory/WSAPP.zip');
        updateVtlibModule('Arabic_ar_ae', 'packages/vtiger/optional/Arabic_ar_ae.zip');
        updateVtlibModule('Assets', 'packages/vtiger/optional/Assets.zip');
        updateVtlibModule('EmailTemplates', 'packages/vtiger/optional/EmailTemplates.zip');
        updateVtlibModule('Google', 'packages/vtiger/optional/Google.zip');
        updateVtlibModule('ModComments', 'packages/vtiger/optional/ModComments.zip');
        updateVtlibModule('Projects', 'packages/vtiger/optional/Projects.zip');
	updateVtlibModule('RecycleBin', 'packages/vtiger/optional/RecycleBin.zip');
	updateVtlibModule('SMSNotifier', "packages/vtiger/optional/SMSNotifier.zip");
        updateVtlibModule("Sweden_sv_se","packages/vtiger/optional/Sweden_sv_se.zip");
	updateVtlibModule("Webforms","packages/vtiger/optional/Webforms.zip");
}
if(defined('INSTALLATION_MODE')) {
		// Set of task to be taken care while specifically in installation mode.
}

global $adb;
//63 started
Migration_Index_View::ExecuteQuery("UPDATE vtiger_field SET masseditable = ? where fieldname = ? and tabid = ?", array('1', 'accountname', getTabid('Accounts')));

$result = $adb->pquery('SELECT taxname FROM vtiger_shippingtaxinfo', array());
$numOfRows = $adb->num_rows($result);
$shippingTaxes = array();
$tabIds = array();

for ($i = 0; $i < $numOfRows; $i++) {
        $shippingTaxName = $adb->query_result($result, $i, 'taxname');
        array_push($shippingTaxes, $shippingTaxName);
}

$modules = getInventoryModules();
$tabIdQuery = 'SELECT tabid FROM vtiger_tab where name IN ('.generateQuestionMarks($modules).')';
$tabIdRes = $adb->pquery($tabIdQuery,$modules);
$num_rows = $adb->num_rows($tabIdRes);
for ($i = 0; $i < $num_rows; $i++) {
$tabIds[] = $adb->query_result($tabIdRes,0,'tabid');
}

$query = 'DELETE FROM vtiger_field WHERE tabid IN (' . generateQuestionMarks($tabIds) . ') AND fieldname IN (' . generateQuestionMarks($shippingTaxes) . ')';
Migration_Index_View::ExecuteQuery($query, array_merge($tabIds, $shippingTaxes));
//63 Ends

//64 started
 $entityModules = Vtiger_Module_Model::getEntityModules();

foreach($entityModules as $moduleModel) {
    $crmInstance = CRMEntity::getInstance($moduleModel->getName());
    $tabId = $moduleModel->getId();
    $defaultRelatedFields = $crmInstance->list_fields_name;
    $updateQuery = 'UPDATE vtiger_field SET summaryfield=1  where tabid=? and fieldname IN ('.generateQuestionMarks($defaultRelatedFields).')';
    Migration_Index_View::ExecuteQuery($updateQuery,  array_merge(array($tabId),$defaultRelatedFields));
}
//64 Ends

//65 started
Migration_Index_View::ExecuteQuery('UPDATE vtiger_currencies SET currency_name = ? where currency_name = ? and currency_code = ?',
					array('Hong Kong, Dollars', 'LvHong Kong, Dollars', 'HKD'));

Migration_Index_View::ExecuteQuery('UPDATE vtiger_currency_info SET currency_name = ? where currency_name = ?',
					array('Hong Kong, Dollars', 'LvHong Kong, Dollars'));

Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET defaultvalue=1 WHERE fieldname = ?',array("filestatus"));

Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_role ADD allowassignedrecordsto INT(2) NOT NULL DEFAULT 1', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_assets MODIFY datesold date', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_assets MODIFY dateinservice date', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_assets MODIFY serialnumber varchar(200)', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_assets MODIFY account int(19)', array());

//65 ends

//66 started
Migration_Index_View::ExecuteQuery('ALTER TABLE com_vtiger_workflowtask_queue ADD COLUMN task_contents text', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE com_vtiger_workflowtask_queue DROP INDEX com_vtiger_workflowtask_queue_idx',array());

Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_mailscanner_ids modify column messageid varchar(512)' , array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_mailscanner_ids add index scanner_message_ids_idx (scannerid, messageid)', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_mailscanner_folders add index folderid_idx (folderid)', array());

Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_leaddetails add index email_idx (email)', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_contactdetails add index email_idx (email)', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_account add index email_idx (email1, email2)', array());

$moduleInstance = Vtiger_Module::getInstance('Users');
$blockInstance = Vtiger_Block::getInstance('LBL_MORE_INFORMATION',$moduleInstance);

$fieldInstance = Vtiger_Field::getInstance('leftpanelhide', $moduleInstance);
if(!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'leftpanelhide';
        $field->label = 'Left Panel Hide';
        $field->column = 'leftpanelhide';
        $field->table = 'vtiger_users';
        $field->uitype = 56;
        $field->typeofdata = 'V~O';
        $field->readonly = 1;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $field->quickcreate = 1;
        $field->defaultvalue = 0;
        $field->columntype = 'VARCHAR(3)';
        $blockInstance->addField($field);
}

Migration_Index_View::ExecuteQuery('UPDATE vtiger_users SET leftpanelhide = ?', array(0));

$Vtiger_Utils_Log = true;
$potentialModule = Vtiger_Module::getInstance('Potentials');
$block = Vtiger_Block::getInstance('LBL_OPPORTUNITY_INFORMATION', $potentialModule);

$relatedToField = Vtiger_Field::getInstance('related_to', $potentialModule);
$relatedToField->unsetRelatedModules(array('Contacts'));
Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET typeofdata = ? WHERE fieldid = ?', array('V~O', $relatedToField->id));

$contactField = Vtiger_Field::getInstance('contact_id', $potentialModule);
if(!$contactField) {
        $contactField = new Vtiger_Field();
        $contactField->name = 'contact_id';
        $contactField->label = 'Contact Name';
        $contactField->uitype = '10';
        $contactField->column = 'contact_id';
        $contactField->table = 'vtiger_potential';
        $contactField->columntype = 'INT(19)';
        $block->addField($contactField);
        $contactField->setRelatedModules(array('Contacts'));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET summaryfield=1 WHERE fieldid = ?', array($contactField->id));
}

$lastPotentialId = 0;
do {
    $result = $adb->pquery("SELECT potentialid ,related_to FROM vtiger_potential WHERE potentialid > ? LIMIT 500",
                    array($lastPotentialId));
    if (!$adb->num_rows($result)) break;

    while ($row = $adb->fetch_array($result)) {
            $relatedTo = $row['related_to'];
            $potentialId = $row['potentialid'];

            $relatedToType = getSalesEntityType($relatedTo);
            if($relatedToType != 'Accounts') {
                    Migration_Index_View::ExecuteQuery('UPDATE vtiger_potential SET contact_id = ?, related_to = null WHERE potentialid = ?',
                                    array($relatedTo, $potentialId));
            }
            if (intval($potentialId) > $lastPotentialId) {
                    $lastPotentialId = intval($row['potentialid']);
            }
            unset($relatedTo);
    }
    unset($result);
} while(true);

$filterResult = $adb->pquery('SELECT * FROM vtiger_cvadvfilter WHERE columnname like ?',
					array('vtiger_potential:related_to:related_to:Potentials_Related_%'));
$rows = $adb->num_rows($filterResult);
for($i=0; $i<$rows; $i++) {
        $cvid = $adb->query_result($filterResult, $i, 'cvid');
        $columnIndex = $adb->query_result($filterResult, $i, 'columnindex');
        $comparator = $adb->query_result($filterResult, $i, 'comparator');
        $value = $adb->query_result($filterResult, $i, 'value');

        Migration_Index_View::ExecuteQuery('UPDATE vtiger_cvadvfilter SET groupid = 2, column_condition = ? WHERE cvid = ?', array('or', $cvid));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_cvadvfilter_grouping SET groupid = 2 WHERE cvid = ?', array($cvid));

        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_cvadvfilter(cvid,columnindex,columnname,comparator,value,groupid,column_condition)
                VALUES(?,?,?,?,?,?,?)', array($cvid, ++$columnIndex,'vtiger_potential:contact_id:contact_id:Potentials_Contact_Name:V',
                        $comparator, $value, 2, ''));
}
unset($filterResult);

$filterColumnList = $adb->pquery('SELECT * FROM vtiger_cvcolumnlist WHERE columnname like ?',
					array('vtiger_potential:related_to:related_to:Potentials_Related_%'));
$filterColumnRows = $adb->num_rows($filterColumnList);
for($j=0; $j<$filterColumnRows; $j++) {
        $cvid = $adb->query_result($filterColumnList, $j, 'cvid');
        $filterResult = $adb->pquery('SELECT MAX(columnindex) AS maxcolumn FROM vtiger_cvcolumnlist WHERE cvid = ?', array($cvid));
        $maxColumnIndex = $adb->query_result($filterResult, 0, 'maxcolumn');
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_cvcolumnlist(cvid,columnindex,columnname) VALUES (?,?,?)', array($cvid, ++$maxColumnIndex,
                'vtiger_potential:contact_id:contact_id:Potentials_Contact_Name:V'));
        unset($filterResult);
}
unset($filterColumnList);

$reportColumnResult = $adb->pquery('SELECT * FROM vtiger_selectcolumn WHERE columnname = ?',
					array('vtiger_potential:related_to:Potentials_Related_To:related_to:V'));
$reportColumnRows = $adb->num_rows($reportColumnResult);

for($k=0; $k<$reportColumnRows; $k++) {
        $reportId = $adb->query_result($reportColumnResult, $k, 'queryid');
        $filterResult = $adb->pquery('SELECT MAX(columnindex) AS maxcolumn FROM vtiger_selectcolumn WHERE queryid = ?', array($reportId));
        $maxColumnIndex = $adb->query_result($filterResult, 0, 'maxcolumn');
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_selectcolumn(queryid,columnindex,columnname) VALUES (?,?,?)', array($reportId,
                ++$maxColumnIndex, 'vtiger_potential:contact_id:Potentials_Contact_Name:contact_id:V'));
        unset($filterResult);
}
unset($reportColumnResult);

$filterResult = $adb->pquery('SELECT * FROM vtiger_relcriteria WHERE columnname = ?',array('vtiger_potential:related_to:Potentials_Related_To:related_to:V'));
$rows = $adb->num_rows($filterResult);
for($i=0; $i<$rows; $i++) {

        $reportId = $adb->query_result($filterResult, $i, 'queryid');
        $columnIndex = $adb->query_result($filterResult, $i, 'columnindex');
        $comparator = $adb->query_result($filterResult, $i, 'comparator');
        $value = $adb->query_result($filterResult, $i, 'value');

        Migration_Index_View::ExecuteQuery('UPDATE vtiger_relcriteria SET groupid = 2, column_condition = ? WHERE queryid = ?', array('or', $reportId));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_relcriteria_grouping SET groupid = 2 WHERE queryid = ?', array($reportId));

        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_relcriteria(queryid,columnindex,columnname,comparator,value,groupid,column_condition)
                VALUES(?,?,?,?,?,?,?)', array($reportId, ++$columnIndex,'vtiger_potential:contact_id:Potentials_Contact_Name:contact_id:V',
                        $comparator, $value, 2, ''));
}
unset($filterResult);

$ticketsModule = Vtiger_Module::getInstance('HelpDesk');
$ticketsBlock = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $ticketsModule);

$relatedToField = Vtiger_Field::getInstance('parent_id', $ticketsModule);
Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET uitype = 10 WHERE fieldid = ?', array($relatedToField->id));
$relatedToField->setRelatedModules(array('Accounts'));

$contactField = Vtiger_Field::getInstance('contact_id', $ticketsModule);
if(!$contactField) {
        $contactField = new Vtiger_Field();
        $contactField->name = 'contact_id';
        $contactField->label = 'Contact Name';
        $contactField->table = 'vtiger_troubletickets';
        $contactField->column = 'contact_id';
        $contactField->columntype = 'INT(19)';
        $contactField->uitype = '10';
        $ticketsBlock->addField($contactField);

        $contactField->setRelatedModules(array('Contacts'));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET summaryfield = 1 WHERE fieldid = ?', array($contactField->id));
}

$lastTicketId = 0;
do {
        $ticketsResult = $adb->pquery("SELECT ticketid ,parent_id FROM vtiger_troubletickets WHERE ticketid > ?
                                                LIMIT 500", array($lastTicketId));
        if (!$adb->num_rows($ticketsResult)) break;

        while ($row = $adb->fetch_array($ticketsResult)) {
                $parent = $row['parent_id'];
                $ticketId = $row['ticketid'];

                $parentType = getSalesEntityType($parent);
                if($parentType != 'Accounts') {
                        Migration_Index_View::ExecuteQuery('UPDATE vtiger_troubletickets SET contact_id = ?, parent_id = null WHERE ticketid = ?',
                                        array($parent, $ticketId));
                }
                if (intval($ticketId) > $lastTicketId) {
                        $lastTicketId = intval($row['ticketid']);
                }
                unset($parent);
        }
        unset($ticketsResult);
} while(true);

$ticketFilterResult = $adb->pquery('SELECT * FROM vtiger_cvadvfilter WHERE columnname like ?',array('vtiger_troubletickets:parent_id:parent_id:HelpDesk_Related%'));
$rows = $adb->num_rows($ticketFilterResult);
for($i=0; $i<$rows; $i++) {
        $cvid = $adb->query_result($ticketFilterResult, $i, 'cvid');
        $columnIndex = $adb->query_result($ticketFilterResult, $i, 'columnindex');
        $comparator = $adb->query_result($ticketFilterResult, $i, 'comparator');
        $value = $adb->query_result($ticketFilterResult, $i, 'value');

        Migration_Index_View::ExecuteQuery('UPDATE vtiger_cvadvfilter SET groupid = 2, column_condition = ? WHERE cvid = ?', array('or', $cvid));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_cvadvfilter_grouping SET groupid = 2 WHERE cvid = ?', array($cvid));

        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_cvadvfilter(cvid,columnindex,columnname,comparator,value,groupid,column_condition)
                VALUES(?,?,?,?,?,?,?)', array($cvid, ++$columnIndex,'vtiger_troubletickets:contact_id:contact_id:HelpDesk_Contact_Name:V',
                        $comparator, $value, 2, ''));
}
unset($ticketFilterResult);

$filterColumnList = $adb->pquery('SELECT * FROM vtiger_cvcolumnlist WHERE columnname like ?',
                array('vtiger_troubletickets:parent_id:parent_id:HelpDesk_Related_%'));
$filterColumnRows = $adb->num_rows($filterColumnList);
for($j=0; $j<$filterColumnRows; $j++) {
        $cvid = $adb->query_result($filterColumnList, $j, 'cvid');
        $filterResult = $adb->pquery('SELECT MAX(columnindex) AS maxcolumn FROM vtiger_cvcolumnlist WHERE cvid = ?', array($cvid));
        $maxColumnIndex = $adb->query_result($filterResult, 0, 'maxcolumn');
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_cvcolumnlist(cvid,columnindex,columnname) VALUES (?,?,?)', array($cvid, ++$maxColumnIndex,
                'vtiger_troubletickets:contact_id:contact_id:HelpDesk_Contact_Name:V'));
        unset($filterResult);
}
unset($filterColumnList);

$reportColumnResult = $adb->pquery('SELECT * FROM vtiger_selectcolumn WHERE columnname like ?',
                array('vtiger_troubletickets:parent_id:HelpDesk_Related_To:parent_id%'));
$reportColumnRows = $adb->num_rows($reportColumnResult);
for($k=0; $k<$reportColumnRows; $k++) {
        $reportId = $adb->query_result($reportColumnResult, $k, 'queryid');
        $filterResult = $adb->pquery('SELECT MAX(columnindex) AS maxcolumn FROM vtiger_selectcolumn WHERE queryid = ?', array($reportId));
        $maxColumnIndex = $adb->query_result($filterResult, 0, 'maxcolumn');
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_selectcolumn(queryid,columnindex,columnname) VALUES (?,?,?)', array($reportId,
                ++$maxColumnIndex, 'vtiger_troubletickets:contact_id:HelpDesk_Contact_Name:contact_id:V'));
        unset($filterResult);
}
unset($reportColumnResult);


$filterResult = $adb->pquery('SELECT * FROM vtiger_relcriteria WHERE columnname like ?',
                                        array('vtiger_troubletickets:parent_id:HelpDesk_Related_To:parent_id%'));
$rows = $adb->num_rows($filterResult);
for($i=0; $i<$rows; $i++) {
        $reportId = $adb->query_result($filterResult, $i, 'queryid');
        $columnIndex = $adb->query_result($filterResult, $i, 'columnindex');
        $comparator = $adb->query_result($filterResult, $i, 'comparator');
        $value = $adb->query_result($filterResult, $i, 'value');

        Migration_Index_View::ExecuteQuery('UPDATE vtiger_relcriteria SET groupid = 2, column_condition = ? WHERE queryid = ?', array('or', $reportId));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_relcriteria_grouping SET groupid = 2 WHERE queryid = ?', array($reportId));

        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_relcriteria(queryid,columnindex,columnname,comparator,value,groupid,column_condition)
                VALUES(?,?,?,?,?,?,?)', array($reportId, ++$columnIndex,'vtiger_troubletickets:contact_id:HelpDesk_Contact_Name:contact_id:V',
                        $comparator, $value, 2, ''));
}
unset($filterResult);

//66 ended

//67 starts
//67 ended

//68 starts
//68 ends

//69 starts
//69 ends

//70 starts
$checkQuery = 'SELECT 1 FROM vtiger_currencies  WHERE currency_name=?';
$checkResult = $adb->pquery($checkQuery,array('Iraqi Dinar'));
if($adb->num_rows($checkResult) <= 0) {
    //Inserting Currency Iraqi Dinar to vtiger_currencies
    Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies VALUES ('.$adb->getUniqueID("vtiger_currencies").',"Iraqi Dinar","IQD","ID")',array());
}

$potentialModule = Vtiger_Module::getInstance('Potentials');
$potentialTabId = getTabid('Potentials');

$contactField = Vtiger_Field::getInstance('contact_id', $potentialModule);
$relatedToField = Vtiger_Field::getInstance('related_to', $potentialModule);

$result = $adb->pquery('SELECT sequence,block FROM vtiger_field WHERE fieldid = ? and tabid = ?', array($relatedToField->id, $potentialTabId));
$relatedToFieldSequence = $adb->query_result($result, 0, 'sequence');
$relatedToFieldBlock = $adb->query_result($result, 0, 'block');

Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET sequence = sequence+1 WHERE sequence > ? and tabid = ? and block = ?', array($relatedToFieldSequence, $potentialTabId, $relatedToFieldBlock));
Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET sequence = ? WHERE fieldid = ?', array($relatedToFieldSequence+1, $contactField->id));

$ticketsModule = Vtiger_Module::getInstance('HelpDesk');
$ticketsTabId = getTabid('HelpDesk');

$contactField = Vtiger_Field::getInstance('contact_id', $ticketsModule);
$relatedToField = Vtiger_Field::getInstance('parent_id', $ticketsModule);

$result = $adb->pquery('SELECT sequence,block FROM vtiger_field WHERE fieldid = ? and tabid = ?', array($relatedToField->id, $ticketsTabId));
$relatedToFieldSequence = $adb->query_result($result, 0, 'sequence');
$relatedToFieldBlock = $adb->query_result($result, 0, 'block');

Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET sequence = sequence+1 WHERE sequence > ? and tabid = ? and block = ?', array($relatedToFieldSequence, $ticketsTabId, $relatedToFieldBlock));
Migration_Index_View::ExecuteQuery('UPDATE vtiger_field SET sequence = ? WHERE fieldid = ?', array($relatedToFieldSequence+1, $contactField->id));

$checkQuery = 'SELECT 1 FROM vtiger_currencies  WHERE currency_name=?';
$checkResult = $adb->pquery($checkQuery,array('Maldivian Ruffiya'));
if($adb->num_rows($checkResult) <= 0) {
    //Inserting Currency Iraqi Dinar to vtiger_currencies
    Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies VALUES ('.$adb->getUniqueID("vtiger_currencies").',"Maldivian Ruffiya","MVR","MVR")',array());
}

echo '<br>'.'ContactName Field sequence updated in Potentials and Tickets module'.'<br>'; 

$result = $adb->pquery('SELECT count(*) AS count FROM vtiger_emailtemplates', array());
Migration_Index_View::ExecuteQuery('UPDATE vtiger_emailtemplates_seq SET id = ?', array(1 + ((int)$adb->query_result($result, 0, 'count'))));

//70 ends

//71 starts
//71 ends

//72 starts
//72 ends

//73 starts
$query = 'SELECT 1 FROM vtiger_currencies WHERE currency_name=?';
$result = $adb->pquery($query, array('Sudanese Pound'));
if($adb->num_rows($result) <= 0){
    //Inserting Currency Sudanese Pound to vtiger_currencies
    Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies (currencyid,currency_name,currency_code,currency_symbol) VALUES ('.$adb->getUniqueID("vtiger_currencies").',"Sudanese Pound","SDG","£")',array());
    Vtiger_Utils::AddColumn('vtiger_mailmanager_mailattachments', 'cid', 'VARCHAR(100)');
}
//73 ends

//74 starts
$usersInstance = Vtiger_Module::getInstance('Users');
$blockInstance = Vtiger_Block::getInstance('LBL_MORE_INFORMATION', $usersInstance);
$usersRowHeightField = Vtiger_Field::getInstance('rowheight', $usersInstance);

if (!$usersRowHeightField) {
    $field = new Vtiger_Field();
    $field->name = 'rowheight';
    $field->label = 'Row Height';
    $field->table = 'vtiger_users';
    $field->uitype = 16;
    $field->typeofdata = 'V~O';
    $field->readonly = 1;
    $field->displaytype = 1;
    $field->masseditable = 1;
    $field->quickcreate = 1;
    $field->columntype = 'VARCHAR(10)';
    $field->defaultvalue = 'medium';
    $blockInstance->addField($field);

    $field->setPicklistValues(array('wide', 'medium', 'narrow'));
    echo '<br> Rowheight Field added in Users Module';
}

$moduleName = 'HelpDesk';

//Start: Moving Entity methods of Comments to Workflows
$result = $adb->pquery('SELECT DISTINCT workflow_id FROM com_vtiger_workflowtasks WHERE workflow_id IN
                                (SELECT workflow_id FROM com_vtiger_workflows WHERE module_name IN (?) AND defaultworkflow = ?)
                                AND task LIKE ?', array('ModComments', 1, '%VTEntityMethodTask%'));
$numOfRows = $adb->num_rows($result);

for($i=0; $i<$numOfRows; $i++) {
        $wfs = new VTWorkflowManager($adb);
        $workflowModel = $wfs->retrieve($adb->query_result($result, $i, 'workflow_id'));
        $workflowModel->filtersavedinnew = 6;
        $workflowModel->executionCondition = 3;
        $workflowModel->moduleName = $moduleName;

        $newWorkflowModel = $wfs->newWorkflow($moduleName);
        $workflowProperties = get_object_vars($workflowModel);
        foreach ($workflowProperties as $workflowPropertyName => $workflowPropertyValue) {
                $newWorkflowModel->$workflowPropertyName = $workflowPropertyValue;
        }

        $newConditions = array(
                        array('fieldname' => '_VT_add_comment',
                                'operation' => 'is added',
                                'value' => '',
                                'valuetype' => 'rawtext',
                                'joincondition' => '',
                                'groupjoin' => 'and',
                                'groupid' => '0')
                        );

        $tm = new VTTaskManager($adb);
        $tasks = $tm->getTasksForWorkflow($workflowModel->id);
        foreach ($tasks as $task) {
                $properties = get_object_vars($task);
                $emailTask = new VTEmailTask();
                $emailTask->executeImmediately = 0;
                $emailTask->summary = $properties['summary'];
                $emailTask->active = $properties['active'];

                switch($properties['methodName']) {
                    case 'CustomerCommentFromPortal' :
                            $tm->deleteTask($task->id);

                            $newWorkflowConditions = $newConditions;
                            $newWorkflowConditions[] = array(
                                            'fieldname' => 'from_portal',
                                            'operation' => 'is',
                                            'value' => '1',
                                            'valuetype' => 'rawtext',
                                            'joincondition' => '',
                                            'groupjoin' => 'and',
                                            'groupid' => '0'
                            );

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->test = Zend_Json::encode($newWorkflowConditions);
                            $newWorkflowModel->description = 'Comment Added From Portal : Send Email to Record Owner';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Comment Added From Portal : Send Email to Record Owner';
                            $emailTask->fromEmail = '$(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname)&lt;$(contact_id : (Contacts) email)&gt;';
                            $emailTask->recepient = ',$(assigned_user_id : (Users) email1)';
                            $emailTask->subject = 'Respond to Ticket ID## $(general : (__VtigerMeta__) recordId) ## in Customer Portal - URGENT';
                            $emailTask->content = 'Dear $(assigned_user_id : (Users) last_name) $(assigned_user_id : (Users) first_name),<br><br>
                                                            Customer has provided the following additional information to your reply:<br><br>
                                                            <b>$lastComment</b><br><br>
                                                            Kindly respond to above ticket at the earliest.<br><br>
                                                            Regards<br>Support Administrator';
                            $tm->saveTask($emailTask);
                            break;


                    case 'TicketOwnerComments' :
                            $tm->deleteTask($task->id);

                            $newConditions[] = array(
                                            'fieldname' => 'from_portal',
                                            'operation' => 'is',
                                            'value' => '0',
                                            'valuetype' => 'rawtext',
                                            'joincondition' => '',
                                            'groupjoin' => 'and',
                                            'groupid' => '0'
                            );

                            $newWorkflowConditions = $newConditions;
                            $newWorkflowConditions[] = array(
                                            'fieldname' => '(contact_id : (Contacts) emailoptout)',
                                            'operation' => 'is',
                                            'value' => '0',
                                            'valuetype' => 'rawtext',
                                            'joincondition' => 'and',
                                            'groupjoin' => 'and',
                                            'groupid' => '0'
                            );
                             $portalCondition = array(
                                            array( 'fieldname' => '(contact_id : (Contacts) portal)',
                                                    'operation' => 'is',
                                                    'value' => '0',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => 'and',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                            );

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->test = Zend_Json::encode(array_merge($portalCondition, $newWorkflowConditions));
                            $newWorkflowModel->description = 'Comment Added From CRM : Send Email to Contact, where Contact is not a Portal User';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Comment Added From CRM : Send Email to Contact, where Contact is not a Portal User';
                            $emailTask->fromEmail =  '$(general : (__VtigerMeta__) supportName)&lt;$(general : (__VtigerMeta__) supportEmailId)&gt;';
                            $emailTask->recepient = ',$(contact_id : (Contacts) email)';
                            $emailTask->subject = '$ticket_no [ Ticket Id : $(general : (__VtigerMeta__) recordId) ] $ticket_title';
                            $emailTask->content = 'Dear $(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname),<br><br>
                                                    The Ticket is replied the details are :<br><br>
                                                    Ticket No : $ticket_no<br>
                                                    Status : $ticketstatus<br>
                                                    Category : $ticketcategories<br>
                                                    Severity : $ticketseverities<br>
                                                    Priority : $ticketpriorities<br><br>
                                                    Description : <br>$description<br><br>
                                                    Solution : <br>$solution<br>
                                                    The comments are : <br>
                                                    $allComments<br><br>
                                                    Regards<br>Support Administrator';
                            $tm->saveTask($emailTask);

                            $portalCondition = array(
                                            array( 'fieldname' => '(contact_id : (Contacts) portal)',
                                                    'operation' => 'is',
                                                    'value' => '1',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => 'and',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                            );

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->test = Zend_Json::encode(array_merge($portalCondition, $newWorkflowConditions));
                            $newWorkflowModel->description = 'Comment Added From CRM : Send Email to Contact, where Contact is Portal User';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Comment Added From CRM : Send Email to Contact, where Contact is Portal User';
                            $emailTask->content = 'Ticket No : $ticket_no<br>
                                                    Ticket Id : $(general : (__VtigerMeta__) recordId)<br>
                                                    Subject : $ticket_title<br><br>
                                                    Dear $(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname),<br><br>
                                                    There is a reply to <b>$ticket_title</b> in the "Customer Portal" at VTiger.
                                                    You can use the following link to view the replies made:<br>
                                                    <a href="$(general : (__VtigerMeta__) portaldetailviewurl)">Ticket Details</a><br><br>
                                                    Thanks<br>$(general : (__VtigerMeta__) supportName)';
                            $tm->saveTask($emailTask);

                            $newConditions[] = array(
                                            'fieldname' => '(parent_id : (Accounts) emailoptout)',
                                            'operation' => 'is',
                                            'value' => '0',
                                            'valuetype' => 'rawtext',
                                            'joincondition' => 'and',
                                            'groupjoin' => 'and',
                                            'groupid' => '0'
                            );

                            $workflowModel->test = Zend_Json::encode($newConditions);
                            $workflowModel->description = 'Comment Added From CRM : Send Email to Organization';
                            $wfs->save($workflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $workflowModel->id;
                            $emailTask->summary = 'Comment Added From CRM : Send Email to Organization';
                            $emailTask->recepient = ',$(parent_id : (Accounts) email1),';
                            $emailTask->content = 'Ticket ID : $(general : (__VtigerMeta__) recordId)<br>Ticket Title : $ticket_title<br><br>
                                                    Dear $(parent_id : (Accounts) accountname),<br><br>
                                                    The Ticket is replied the details are :<br><br>
                                                    Ticket No : $ticket_no<br>
                                                    Status : $ticketstatus<br>
                                                    Category : $ticketcategories<br>
                                                    Severity : $ticketseverities<br>
                                                    Priority : $ticketpriorities<br><br>
                                                    Description : <br>$description<br><br>
                                                    Solution : <br>$solution<br>
                                                    The comments are : <br>
                                                    $allComments<br><br>
                                                    Regards<br>Support Administrator';
                        $tm->saveTask($emailTask);

                        break;
                }   
}
}
echo '<br>SuccessFully Done For Comments<br>';
//End: Moved Entity methods of Comments to Workflows

//Start: Moving Entity methods of Tickets to Workflows
$result = $adb->pquery('SELECT DISTINCT workflow_id FROM com_vtiger_workflowtasks WHERE workflow_id IN
                                (SELECT workflow_id FROM com_vtiger_workflows WHERE module_name IN (?) AND defaultworkflow = ?)
                                AND task LIKE ?', array($moduleName, 1, '%VTEntityMethodTask%'));
$numOfRows = $adb->num_rows($result);

for($i=0; $i<$numOfRows; $i++) {
    $wfs = new VTWorkflowManager($adb);
    $workflowModel = $wfs->retrieve($adb->query_result($result, $i, 'workflow_id'));
    $workflowModel->filtersavedinnew = 6;

    $tm = new VTTaskManager($adb);
    $tasks = $tm->getTasksForWorkflow($workflowModel->id);
    foreach ($tasks as $task) {
        $properties = get_object_vars($task);

        $emailTask = new VTEmailTask();
        $emailTask->executeImmediately = 0;
        $emailTask->summary = $properties['summary'];
        $emailTask->active = $properties['active'];
        switch($properties['methodName']) {
            case 'NotifyOnPortalTicketCreation' :
                    $conditions = Zend_Json::decode($workflowModel->test);
                    $oldCondtions = array();

                            if(!empty($conditions)) {
                                    $previousConditionGroupId = 0;
                                    foreach($conditions as $condition) {

                                            $fieldName = $condition['fieldname'];
                                            $fieldNameContents = explode(' ', $fieldName);
                                            if (count($fieldNameContents) > 1) {
                                                    $fieldName = '('. $fieldName .')';
                                            }

                                            $groupId = $condition['groupid'];
                                            if (!$groupId) {
                                                    $groupId = 0;
                                            }

                                            $groupCondition = 'or';
                                            if ($groupId === $previousConditionGroupId || count($conditions) === 1) {
                                                    $groupCondition = 'and';
                                            }

                                            $joinCondition = 'or';
                                            if (isset ($condition['joincondition'])) {
                                                    $joinCondition = $condition['joincondition'];
                                            } elseif($groupId === 0) {
                                                    $joinCondition = 'and';
                                            }

                                            $value = $condition['value'];
                                            switch ($value) {
                                                    case 'false:boolean'	: $value = 0;	break;
                                                    case 'true:boolean'		: $value = 1;	break;
                                                    default                     : $value;	break;
                                            }

                                            $oldCondtions[] = array(
                                                            'fieldname' => $fieldName,
                                                            'operation' => $condition['operation'],
                                                            'value' => $value,
                                                            'valuetype' => 'rawtext',
                                                            'joincondition' => $joinCondition,
                                                            'groupjoin' => $groupCondition,
                                                            'groupid' => $groupId
                                            );
                                            $previousConditionGroupId = $groupId;
                                    }
                            }
                    $newConditions = array(
                                    array('fieldname' => 'from_portal',
                                                    'operation' => 'is',
                                                    'value' => '1',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => '',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                    );
                    $newConditions = array_merge($oldCondtions, $newConditions);

                    $workflowModel->test = Zend_Json::encode($newConditions);
                    $workflowModel->description = 'Ticket Creation From Portal : Send Email to Record Owner and Contact';
                    $wfs->save($workflowModel);

                    $emailTask->id = '';
                    $emailTask->workflowId = $properties['workflowId'];
                    $emailTask->summary = 'Notify Record Owner when Ticket is created from Portal';
                    $emailTask->fromEmail =  '$(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname)&lt;$(general : (__VtigerMeta__) supportEmailId)&gt;';
                    $emailTask->recepient = ',$(assigned_user_id : (Users) email1)';
                    $emailTask->subject =  '[From Portal] $ticket_no [ Ticket Id : $(general : (__VtigerMeta__) recordId) ] $ticket_title';
                    $emailTask->content = 'Ticket No : $ticket_no<br>
                                              Ticket ID : $(general : (__VtigerMeta__) recordId)<br>
                                              Ticket Title : $ticket_title<br><br>
                                              $description';
                    $tm->saveTask($emailTask);

                    $emailTask->id = $properties['id'];
                    $emailTask->summary = 'Notify Related Contact when Ticket is created from Portal';
                    $emailTask->fromEmail =  '$(general : (__VtigerMeta__) supportName)&lt;$(general : (__VtigerMeta__) supportEmailId)&gt;';
                    $emailTask->recepient = ',$(contact_id : (Contacts) email)';

                    $tm->saveTask($emailTask);
                    break;
                case 'NotifyOnPortalTicketComment'	:
                            $tm->deleteTask($properties['id']);
                            Migration_Index_View::ExecuteQuery('DELETE FROM com_vtiger_workflows WHERE workflow_id = ?', array($workflowModel->id));
                            break;
                
                case 'NotifyParentOnTicketChange'	:
                            $newWorkflowModel = $wfs->newWorkflow($workflowModel->moduleName);
                            $workflowProperties = get_object_vars($workflowModel);
                            foreach ($workflowProperties as $workflowPropertyName => $workflowPropertyValue) {
                                    $newWorkflowModel->$workflowPropertyName = $workflowPropertyValue;
                            }

                            $conditions = Zend_Json::decode($newWorkflowModel->test);
                            $oldCondtions = array();

                            if(!empty($conditions)) {
                                    $previousConditionGroupId = 0;
                                    foreach($conditions as $condition) {

                                            $fieldName = $condition['fieldname'];
                                            $fieldNameContents = explode(' ', $fieldName);
                                            if (count($fieldNameContents) > 1) {
                                                    $fieldName = '('. $fieldName .')';
                                            }

                                            $groupId = $condition['groupid'];
                                            if (!$groupId) {
                                                    $groupId = 0;
                                            }

                                            $groupCondition = 'or';
                                            if ($groupId === $previousConditionGroupId || count($conditions) === 1) {
                                                    $groupCondition = 'and';
                                            }

                                            $joinCondition = 'or';
                                            if (isset ($condition['joincondition'])) {
                                                    $joinCondition = $condition['joincondition'];
                                            } elseif($groupId === 0) {
                                                    $joinCondition = 'and';
                                            }

                                            $value = $condition['value'];
                                            switch ($value) {
                                                    case 'false:boolean'	: $value = 0;	break;
                                                    case 'true:boolean'		: $value = 1;	break;
                                                    default                     : $value;	break;
                                            }

                                            $oldCondtions[] = array(
                                                            'fieldname' => $fieldName,
                                                            'operation' => $condition['operation'],
                                                            'value' => $value,
                                                            'valuetype' => 'rawtext',
                                                            'joincondition' => $joinCondition,
                                                            'groupjoin' => $groupCondition,
                                                            'groupid' => $groupId
                                            );
                                            $previousConditionGroupId = $groupId;
                                    }
                            }
                            $newConditions = array(
                                            array('fieldname' => 'ticketstatus',
                                                            'operation' => 'has changed to',
                                                            'value' => 'Closed',
                                                            'valuetype' => 'rawtext',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1'),
                                            array('fieldname' => 'solution',
                                                            'operation' => 'has changed',
                                                            'value' => '',
                                                            'valuetype' => '',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1'),
                                            array('fieldname' => 'description',
                                                            'operation' => 'has changed',
                                                            'value' => '',
                                                            'valuetype' => '',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1')
                            );
                            $newConditions = array_merge($oldCondtions, $newConditions);

                            $newAccountCondition = array(
                                            array('fieldname' => '(parent_id : (Accounts) emailoptout)',
                                                    'operation' => 'is',
                                                    'value' => '0',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => 'and',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                            );
                            $newWorkflowConditions = array_merge($newAccountCondition, $newConditions);

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->test = Zend_Json::encode($newWorkflowConditions);
                            $newWorkflowModel->description = 'Send Email to Organization on Ticket Update';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->summary = 'Send Email to Organization on Ticket Update';
                            $emailTask->fromEmail = '$(general : (__VtigerMeta__) supportName)&lt;$(general : (__VtigerMeta__) supportEmailId)&gt;';
                            $emailTask->recepient = ',$(parent_id : (Accounts) email1)';
                            $emailTask->subject = '$ticket_no [ Ticket Id : $(general : (__VtigerMeta__) recordId) ] $ticket_title';
                            $emailTask->content = 'Ticket ID : $(general : (__VtigerMeta__) recordId)<br>Ticket Title : $ticket_title<br><br>
                                                            Dear $(parent_id : (Accounts) accountname),<br><br>
                                                            The Ticket is replied the details are :<br><br>
                                                            Ticket No : $ticket_no<br>
                                                            Status : $ticketstatus<br>
                                                            Category : $ticketcategories<br>
                                                            Severity : $ticketseverities<br>
                                                            Priority : $ticketpriorities<br><br>
                                                            Description : <br>$description<br><br>
                                                            Solution : <br>$solution<br>
                                                            The comments are : <br>
                                                            $allComments<br><br>
                                                            Regards<br>Support Administrator';

                            $emailTask->workflowId = $newWorkflowModel->id;
                            $tm->saveTask($emailTask);

                            $portalCondition = array(
                                            array('fieldname' => 'from_portal',
                                                    'operation' => 'is',
                                                    'value' => '0',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => '',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                            );

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->executionCondition = 1;
                            $newWorkflowModel->test = Zend_Json::encode(array_merge($newAccountCondition, $portalCondition));
                            $newWorkflowModel->description = 'Ticket Creation From CRM : Send Email to Organization';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Ticket Creation From CRM : Send Email to Organization';
                            $tm->saveTask($emailTask);

                            $newContactCondition = array(
                                            array('fieldname' => '(contact_id : (Contacts) emailoptout)',
                                                    'operation' => 'is',
                                                    'value' => '0',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => 'and',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                            );
                            $newConditions = array_merge($newContactCondition, $newConditions);

                            $workflowModel->test = Zend_Json::encode($newConditions);
                            $workflowModel->description = 'Send Email to Contact on Ticket Update';
                            $wfs->save($workflowModel);

                            $emailTask->id = $properties['id'];
                            $emailTask->workflowId = $properties['workflowId'];
                            $emailTask->summary = 'Send Email to Contact on Ticket Update';
                            $emailTask->recepient = ',$(contact_id : (Contacts) email)';
                            $emailTask->content = 'Ticket ID : $(general : (__VtigerMeta__) recordId)<br>Ticket Title : $ticket_title<br><br>
                                                            Dear $(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname),<br><br>
                                                            The Ticket is replied the details are :<br><br>
                                                            Ticket No : $ticket_no<br>
                                                            Status : $ticketstatus<br>
                                                            Category : $ticketcategories<br>
                                                            Severity : $ticketseverities<br>
                                                            Priority : $ticketpriorities<br><br>
                                                            Description : <br>$description<br><br>
                                                            Solution : <br>$solution<br>
                                                            The comments are : <br>
                                                            $allComments<br><br>
                                                            Regards<br>Support Administrator';

                            $tm->saveTask($emailTask);

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->executionCondition = 1;
                            $newWorkflowModel->test = Zend_Json::encode(array_merge($newContactCondition, $portalCondition));
                            $newWorkflowModel->description = 'Ticket Creation From CRM : Send Email to Contact';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Ticket Creation From CRM : Send Email to Contact';
                            $tm->saveTask($emailTask);
                            break;


                    case 'NotifyOwnerOnTicketChange'	:
                            $tm->deleteTask($task->id);

                            $newWorkflowModel = $wfs->newWorkflow($workflowModel->moduleName);
                            $workflowProperties = get_object_vars($workflowModel);
                            foreach ($workflowProperties as $workflowPropertyName => $workflowPropertyValue) {
                                    $newWorkflowModel->$workflowPropertyName = $workflowPropertyValue;
                            }

                            $conditions = Zend_Json::decode($newWorkflowModel->test);
                            $oldCondtions = array();

                            if(!empty($conditions)) {
                                    $previousConditionGroupId = 0;
                                    foreach($conditions as $condition) {

                                            $fieldName = $condition['fieldname'];
                                            $fieldNameContents = explode(' ', $fieldName);
                                            if (count($fieldNameContents) > 1) {
                                                    $fieldName = '('. $fieldName .')';
                                            }

                                            $groupId = $condition['groupid'];
                                            if (!$groupId) {
                                                    $groupId = 0;
                                            }

                                            $groupCondition = 'or';
                                            if ($groupId === $previousConditionGroupId || count($conditions) === 1) {
                                                    $groupCondition = 'and';
                                            }

                                            $joinCondition = 'or';
                                            if (isset ($condition['joincondition'])) {
                                                    $joinCondition = $condition['joincondition'];
                                            } elseif($groupId === 0) {
                                                    $joinCondition = 'and';
                                            }

                                            $value = $condition['value'];
                                            switch ($value) {
                                                    case 'false:boolean'	: $value = 0;	break;
                                                    case 'true:boolean'		: $value = 1;	break;
                                                    default                     : $value;	break;
                                            }

                                            $oldCondtions[] = array(
                                                            'fieldname' => $fieldName,
                                                            'operation' => $condition['operation'],
                                                            'value' => $value,
                                                            'valuetype' => 'rawtext',
                                                            'joincondition' => $joinCondition,
                                                            'groupjoin' => $groupCondition,
                                                            'groupid' => $groupId
                                            );
                                            $previousConditionGroupId = $groupId;
                                    }
                            }
                            $newConditions = array(
                                            array('fieldname' => 'ticketstatus',
                                                            'operation' => 'has changed to',
                                                            'value' => 'Closed',
                                                            'valuetype' => 'rawtext',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1'),
                                            array('fieldname' => 'solution',
                                                            'operation' => 'has changed',
                                                            'value' => '',
                                                            'valuetype' => '',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1'),
                                            array('fieldname' => 'assigned_user_id',
                                                            'operation' => 'has changed',
                                                            'value' => '',
                                                            'valuetype' => '',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1'),
                                            array('fieldname' => 'description',
                                                            'operation' => 'has changed',
                                                            'value' => '',
                                                            'valuetype' => '',
                                                            'joincondition' => 'or',
                                                            'groupjoin' => 'and',
                                                            'groupid' => '1')

                            );
                            $newConditions = array_merge($oldCondtions, $newConditions);

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->test = Zend_Json::encode($newConditions);
                            $newWorkflowModel->description = 'Send Email to Record Owner on Ticket Update';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Send Email to Record Owner on Ticket Update';
                            $emailTask->fromEmail = '$(general : (__VtigerMeta__) supportName)&lt;$(general : (__VtigerMeta__) supportEmailId)&gt;';
                            $emailTask->recepient = ',$(assigned_user_id : (Users) email1)';
                            $emailTask->subject =  'Ticket Number : $ticket_no $ticket_title';
                            $emailTask->content = 'Ticket ID : $(general : (__VtigerMeta__) recordId)<br>Ticket Title : $ticket_title<br><br>
                                                            Dear $(assigned_user_id : (Users) last_name) $(assigned_user_id : (Users) first_name),<br><br>
                                                            The Ticket is replied the details are :<br><br>
                                                            Ticket No : $ticket_no<br>
                                                            Status : $ticketstatus<br>
                                                            Category : $ticketcategories<br>
                                                            Severity : $ticketseverities<br>
                                                            Priority : $ticketpriorities<br><br>
                                                            Description : <br>$description<br><br>
                                                            Solution : <br>$solution
                                                            $allComments<br><br>
                                                            Regards<br>Support Administrator';
                            $emailTask->id = '';
                            $tm->saveTask($emailTask);

                            $portalCondition = array(
                                            array('fieldname' => 'from_portal',
                                                    'operation' => 'is',
                                                    'value' => '0',
                                                    'valuetype' => 'rawtext',
                                                    'joincondition' => '',
                                                    'groupjoin' => 'and',
                                                    'groupid' => '0')
                            );

                            unset($newWorkflowModel->id);
                            $newWorkflowModel->executionCondition = 1;
                            $newWorkflowModel->test = Zend_Json::encode($portalCondition);
                            $newWorkflowModel->description = 'Ticket Creation From CRM : Send Email to Record Owner';
                            $wfs->save($newWorkflowModel);

                            $emailTask->id = '';
                            $emailTask->workflowId = $newWorkflowModel->id;
                            $emailTask->summary = 'Ticket Creation From CRM : Send Email to Record Owner';
                            $tm->saveTask($emailTask);
                            break;
            }
    }
}
echo '<br>SuccessFully Done For Tickets<br>';
//End: Moved Entity methods of Tickets to Workflows

$em = new VTEventsManager($adb);
$em->registerHandler('vtiger.entity.aftersave', 'modules/ModComments/ModCommentsHandler.php', 'ModCommentsHandler');

//Updating empty blocklabels of email module
$result = $adb->pquery('SELECT blockid FROM vtiger_blocks where tabid = ? AND (blocklabel is NULL OR blocklabel = "")', array(getTabid('Emails')));
$numOfRows = $adb->num_rows($result);

$query = 'UPDATE vtiger_blocks SET blocklabel = CASE blockid ';
for($i=0; $i<$numOfRows; $i++) {
        $blockId = $adb->query_result($result, $i, 'blockid');
        $blockLabel = 'Emails_Block'.($i+1);
        $query .= "WHEN $blockId THEN '$blockLabel' ";
}
$query .= 'ELSE blocklabel END';
Migration_Index_View::ExecuteQuery($query,array());

echo 'Block labels are updated for Emails module';


$result = $adb->pquery('SELECT task_id FROM com_vtiger_workflowtasks WHERE workflow_id IN 
                                                                (SELECT workflow_id FROM com_vtiger_workflows WHERE module_name IN (?, ?)) 
                                                                AND task LIKE ?', array('Calendar', 'Events', '%$(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname)%')); 
$numOfRows = $adb->num_rows($result); 

for($i=0; $i<$numOfRows; $i++) { 
        $tm = new VTTaskManager($adb); 
        $task = $tm->retrieveTask($adb->query_result($result, $i, 'task_id')); 

        $emailTask = new VTEmailTask(); 
        $properties = get_object_vars($task); 
        foreach ($properties as $propertyName => $propertyValue) { 
                $propertyValue = str_replace('$date_start  $time_start ( $(general : (__VtigerMeta__) usertimezone) ) ', '$date_start', $propertyValue); 
                $propertyValue = str_replace('$due_date  $time_end ( $(general : (__VtigerMeta__) usertimezone) )', '$due_date', $propertyValue); 
                $propertyValue = str_replace('$due_date ( $(general : (__VtigerMeta__) usertimezone) )', '$due_date', $propertyValue); 
                $propertyValue = str_replace('$(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname)', '$contact_id', $propertyValue); 
                $emailTask->$propertyName = $propertyValue; 
        } 

        $tm->saveTask($emailTask); 
} 
echo '<br>Successfully Done<br>'; 

//74 ends

//75 starts
$result = $adb->pquery('SELECT 1 FROM vtiger_currencies WHERE currency_name = ?', array('Ugandan Shilling'));
if(!$adb->num_rows($result)) {
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies (currencyid, currency_name, currency_code, currency_symbol) VALUES(?, ?, ?, ?)',
                        array($adb->getUniqueID('vtiger_currencies'), 'Ugandan Shilling', 'UGX', 'Sh'));
}

$em = new VTEventsManager($adb);
$em->registerHandler('vtiger.picklist.afterrename', 'modules/Settings/Picklist/handlers/PickListHandler.php', 'PickListHandler');
$em->registerHandler('vtiger.picklist.afterdelete', 'modules/Settings/Picklist/handlers/PickListHandler.php', 'PickListHandler');
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_inventoryproductrel MODIFY comment varchar(500)', array());

$module = Vtiger_Module::getInstance('Accounts');
$module->addLink('DETAILVIEWSIDEBARWIDGET', 'Google Map', 'module=Google&view=Map&mode=showMap&viewtype=detail', '', '', '');
        
//create new table for feedback on removing old version
$adb->query("CREATE TABLE IF NOT EXISTS vtiger_feedback (userid INT(19), dontshow VARCHAR(19) default false);");

//75 ends

//76 starts
$moduleInstance = Vtiger_Module::getInstance('Calendar');
$fieldInstance = Vtiger_Field::getInstance('activitytype',$moduleInstance);

$fieldInstance->setPicklistValues(array('Mobile Call'));
//76 ends

//77 starts
$sql = "ALTER TABLE vtiger_products MODIFY productname VARCHAR( 100 )";
Migration_Index_View::ExecuteQuery($sql,array());
echo "<br>Updated to varchar(100) for productname";

$result = $adb->pquery('SELECT 1 FROM vtiger_currencies WHERE currency_name = ?', array('CFA Franc BCEAO'));
    if(!$adb->num_rows($result)) {
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies (currencyid, currency_name, currency_code, currency_symbol) VALUES(?, ?, ?, ?)',
            array($adb->getUniqueID('vtiger_currencies'), 'CFA Franc BCEAO', 'XOF', 'CFA'));
    }
$result = $adb->pquery('SELECT 1 FROM vtiger_currencies WHERE currency_name = ?', array('CFA Franc BEAC'));
    if(!$adb->num_rows($result)) {
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies (currencyid, currency_name, currency_code, currency_symbol) VALUES(?, ?, ?, ?)',
            array($adb->getUniqueID('vtiger_currencies'), 'CFA Franc BEAC', 'XAF', 'CFA'));
    }    
echo "<br>Added CFA Franc BCEAO and CFA Franc BEAC currencies";

$sql = "ALTER TABLE vtiger_loginhistory MODIFY user_name VARCHAR( 255 )";
Migration_Index_View::ExecuteQuery($sql,array());

$sql = "UPDATE vtiger_activitytype SET presence = '0' WHERE activitytype ='Mobile Call'";
Migration_Index_View::ExecuteQuery($sql,array());
//77 ends(Some function addGroupTaxTemplatesForQuotesAndPurchaseOrder)

//78 starts
//78 ends

//79 starts
Migration_Index_View::ExecuteQuery("CREATE TABLE IF NOT EXISTS vtiger_shareduserinfo
						(userid INT(19) NOT NULL default 0, shareduserid INT(19) NOT NULL default 0,
						color VARCHAR(50), visible INT(19) default 1);");

Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_mailscanner_rules ADD assigned_to INT(10), ADD cc VARCHAR(255), ADD bcc VARCHAR(255)', array());
$assignedToId = Users::getActiveAdminId();
Migration_Index_View::ExecuteQuery("UPDATE vtiger_mailscanner_rules SET assigned_to=?", array($assignedToId));
echo "<br> Adding assigned to, cc, bcc fields for mail scanner rules";


//Schema changes for vtiger_troubletickets hours & days column
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_troubletickets MODIFY hours decimal(25,8)', array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_troubletickets MODIFY days decimal(25,8)', array());

Migration_Index_View::ExecuteQuery("UPDATE vtiger_field SET defaultvalue=? WHERE tablename=? and fieldname=?", array('1', 'vtiger_pricebook', 'active'));
echo "<br> updated default value for pricebooks active";

$relationId = $adb->getUniqueID('vtiger_relatedlists');
$contactTabId = getTabid('Contacts');
$vendorTabId = getTabId('Vendors');
$actions = 'SELECT';

$query = 'SELECT max(sequence) as maxsequence FROM vtiger_relatedlists where tabid = ?';
$result = $adb->pquery($query, array($contactTabId));
$sequence = $adb->query_result($result, 0 ,'maxsequence');

$query = 'INSERT INTO vtiger_relatedlists VALUES(?,?,?,?,?,?,?,?)';
$result = Migration_Index_View::ExecuteQuery($query, array($relationId, $contactTabId,$vendorTabId,'get_vendors',($sequence+1),'Vendors',0,$actions));

//Schema changes for vtiger_troubletickets hours & days column
Migration_Index_View::ExecuteQuery('UPDATE vtiger_field set typeofdata=? WHERE fieldname IN(?,?) AND tablename = ?', array('N~O', 'hours', 'days', 'vtiger_troubletickets'));

//79 ends

//80 starts
//Added recurring enddate column for events,to vtiger_recurringevents table
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_recurringevents ADD COLUMN recurringenddate date', array());
echo "added field recurring enddate to vtiger_recurringevents to save untill date of repeat events";

//80 ends

//81 starts
//81 ends

//82 starts
Migration_Index_View::ExecuteQuery("ALTER TABLE vtiger_mailscanner CHANGE timezone time_zone VARCHAR(10)", array());
echo "<br>Changed timezone column name for mail scanner";

//82 ends

//83 starts
$result = $adb->pquery('SELECT task_id FROM com_vtiger_workflowtasks WHERE workflow_id IN
                        (SELECT workflow_id FROM com_vtiger_workflows WHERE module_name IN (?, ?))
                        AND task LIKE ?', array('Calendar', 'Events', '%VTSendNotificationTask%'));
$numOfRowas = $adb->num_rows($result);
for ($i = 0; $i < $numOfRows; $i++) {
        $tm = new VTTaskManager($adb);
        $task = $tm->retrieveTask($adb->query_result($result, $i, 'task_id'));

        $emailTask = new VTEmailTask();
        $properties = get_object_vars($task);
        foreach ($properties as $propertyName => $propertyValue) {
                $propertyValue = str_replace('$date_start  $time_start ( $(general : (__VtigerMeta__) usertimezone) ) ', '$date_start', $propertyValue);
                $propertyValue = str_replace('$due_date  $time_end ( $(general : (__VtigerMeta__) usertimezone) )', '$due_date', $propertyValue);
                $propertyValue = str_replace('$due_date ( $(general : (__VtigerMeta__) usertimezone) )', '$due_date', $propertyValue);
                $propertyValue = str_replace('$(contact_id : (Contacts) lastname) $(contact_id : (Contacts) firstname)', '$contact_id', $propertyValue);
                $emailTask->$propertyName = $propertyValue;
        }

        $tm->saveTask($emailTask);
}
echo '<br>Successfully Done<br>';

//83 ends

//84 starts
$query = "ALTER table vtiger_relcriteria modify comparator varchar(20)";
Migration_Index_View::ExecuteQuery($query, array());

//To copy imagename saved in vtiger_attachments for products and contacts into respectively base table
//to support filters on imagename field
$productIdSql = 'SELECT productid,name FROM vtiger_seattachmentsrel INNER JOIN vtiger_attachments ON
                                        vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid INNER JOIN vtiger_products ON
                                        vtiger_products.productid = vtiger_seattachmentsrel.crmid';
$productIds = $adb->pquery($productIdSql,array());
$numOfRows = $adb->num_rows($productIds);

$productImageMap = array();
for ($i = 0; $i < $numOfRows; $i++) {
        $productId = $adb->query_result($productIds, $i, "productid");
        $imageName = decode_html($adb->query_result($productIds, $i, "name"));
        if(!empty($productImageMap[$productId])){
                array_push($productImageMap[$productId], $imageName);
        }elseif(empty($productImageMap[$productId])){
                $productImageMap[$productId] = array($imageName);
        }
}
foreach ($productImageMap as $productId => $imageNames) {
        $implodedNames = implode(",", $imageNames);
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_products SET imagename = ? WHERE productid = ?',array($implodedNames,$productId));
}
echo 'updating image information for products table is completed';

$ContactIdSql = 'SELECT contactid,name FROM vtiger_seattachmentsrel INNER JOIN vtiger_attachments ON
                                        vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid INNER JOIN vtiger_contactdetails ON
                                        vtiger_contactdetails.contactid = vtiger_seattachmentsrel.crmid';
$contactIds = $adb->pquery($ContactIdSql,array());
$numOfRows = $adb->num_rows($contactIds);

for ($i = 0; $i < $numOfRows; $i++) {
        $contactId = $adb->query_result($contactIds, $i, "contactid");
        $imageName = decode_html($adb->query_result($contactIds, $i, "name"));
        Migration_Index_View::ExecuteQuery('UPDATE vtiger_contactdetails SET imagename = ? WHERE contactid = ?',array($imageName,$contactId));
}
echo 'updating image information for contacts table is completed';

//Updating actions for PriceBooks related list in Products and Services
$productsTabId = getTabId('Products');

Migration_Index_View::ExecuteQuery("UPDATE vtiger_relatedlists SET actions=? WHERE label=? and tabid=? ",array('ADD,SELECT', 'PriceBooks', $productsTabId));
echo '<br>Updated PriceBooks related list actions for products and services';

$adb->pquery("CREATE TABLE IF NOT EXISTS vtiger_schedulereports(
            reportid INT(10),
            scheduleid INT(3),
            recipients TEXT,
            schdate VARCHAR(20),
            schtime TIME,
            schdayoftheweek VARCHAR(100),
            schdayofthemonth VARCHAR(100),
            schannualdates VARCHAR(500),
            specificemails VARCHAR(500),
            next_trigger_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
            ENGINE=InnoDB DEFAULT CHARSET=utf8;", array());

Vtiger_Cron::register('ScheduleReports', 'cron/modules/Reports/ScheduleReports.service', 900);

Migration_Index_View::ExecuteQuery('UPDATE vtiger_cron_task set description = ?  where name = "ScheduleReports" ', array("Recommended frequency for ScheduleReports is 15 mins"));
Migration_Index_View::ExecuteQuery('UPDATE vtiger_cron_task set module = ? where name = "ScheduleReports" ', array("Reports"));
echo '<br>Enabled Scheduled reports feature';

/**
* To add defaulteventstatus and defaultactivitytype fields to Users Module
* Save 2 clicks usability feature
*/
require_once 'vtlib/Vtiger/Module.php';
$module = Vtiger_Module::getInstance('Users');
  if ($module) {
      $blockInstance = Vtiger_Block::getInstance('LBL_CALENDAR_SETTINGS', $module);
      if ($blockInstance) {
          $desField = Vtiger_Field::getInstance('defaulteventstatus', $module);
          if(!$desField) {
          $fieldInstance = new Vtiger_Field();
          $fieldInstance->name = 'defaulteventstatus';
          $fieldInstance->label = 'Default Event Status';
          $fieldInstance->uitype = 15;
          $fieldInstance->column = $fieldInstance->name;
          $fieldInstance->columntype = 'VARCHAR(50)';
          $fieldInstance->typeofdata = 'V~O';
          $blockInstance->addField($fieldInstance);
          $fieldInstance->setPicklistValues(Array('Planned','Held','Not Held'));
          }
          $datField = Vtiger_Field::getInstance('defaultactivitytype', $module);
          if(!$datField) {
          $fieldInstance1 = new Vtiger_Field();
          $fieldInstance1->name = 'defaultactivitytype';
          $fieldInstance1->label = 'Default Activity Type';
          $fieldInstance1->uitype = 15;
          $fieldInstance1->column = $fieldInstance1->name;
          $fieldInstance1->columntype = 'VARCHAR(50)';
          $fieldInstance1->typeofdata = 'V~O';
          $blockInstance->addField($fieldInstance1);
          $fieldInstance1->setPicklistValues(Array('Call','Meeting'));
          }
      }
  }
  echo 'Default status and activitytype field created';
//84 ends
  
//85 starts
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_account ALTER isconvertedfromlead SET DEFAULT ?', array('0'));
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_contactdetails ALTER isconvertedfromlead SET DEFAULT ?', array('0'));
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_potential ALTER isconvertedfromlead SET DEFAULT ?', array('0'));
Migration_Index_View::ExecuteQuery('Update vtiger_account SET isconvertedfromlead = ? where isconvertedfromlead is NULL',array('0'));
Migration_Index_View::ExecuteQuery('Update vtiger_contactdetails SET isconvertedfromlead = ? where isconvertedfromlead is NULL',array('0'));
Migration_Index_View::ExecuteQuery('Update vtiger_potential SET isconvertedfromlead = ? where isconvertedfromlead is NULL',array('0'));

//85 ends

//86 starts
//Duplicate of 85 script
//86 ends

//87 starts
$result = $adb->pquery('SELECT 1 FROM vtiger_currencies WHERE currency_name = ?', array('Haiti, Gourde'));
if(!$adb->num_rows($result)) {
                    Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies (currencyid, currency_name, currency_code, currency_symbol) VALUES(?, ?, ?, ?)',
                    array($adb->getUniqueID('vtiger_currencies'), 'Haiti, Gourde', 'HTG', 'G'));
}
//87 ends   

//88 starts
Migration_Index_View::ExecuteQuery("UPDATE vtiger_currencies SET currency_symbol=? WHERE currency_code=?", array('₹','INR'));
Migration_Index_View::ExecuteQuery("UPDATE vtiger_currency_info SET currency_symbol=? WHERE currency_code=?", array('₹','INR'));

Migration_Index_View::ExecuteQuery('UPDATE vtiger_projecttaskstatus set presence = 0 where projecttaskstatus in (?,?,?,?,?)',
                    array('Open','In Progress','Completed','Deferred','Canceled'));
echo '<br> made projecttaskstatus picklist values as non editable';

//88 ends

//89 starts
//89 ends

//90 starts
//Updating User fields Sequence
$userFields = array('user_name', 'email1', 'first_name', 'last_name', 'user_password', 'confirm_password', 'is_admin', 'roleid',
                                        'lead_view', 'status', 'end_hour', 'is_owner',
                                        'dayoftheweek', 'start_hour', 'date_format', 'hour_format', 'time_zone', 'activity_view', 'callduration',
                                        'othereventduration', 'defaulteventstatus', 'defaultactivitytype', 'reminder_interval', 'calendarsharedtype',);
$sequence = 0;
$usersTabId = getTabId('Users');
$blockIds = array();
$blockIds[] = getBlockId($usersTabId, 'LBL_USERLOGIN_ROLE');
$blockIds[] = getBlockId($usersTabId, 'LBL_CALENDAR_SETTINGS');

$updateQuery = "UPDATE vtiger_field SET sequence = CASE fieldname ";
foreach($userFields as $fieldName) {
        if($fieldName == 'dayoftheweek') {
                $sequence = 0;
        }
        $updateQuery .= " WHEN '$fieldName' THEN  ". ++$sequence ;
}
$updateQuery .= " END WHERE tabid = $usersTabId AND block IN (". generateQuestionMarks($blockIds) .")";

Migration_Index_View::ExecuteQuery($updateQuery, $blockIds);

echo "<br>User Fields Sequence Updated";

// updating Emails module in sharing access rules
$EmailsTabId = getTabId('Emails');
$query = "SELECT tabid FROM vtiger_def_org_share";
$result = $adb->pquery($query, array());
$resultCount = $adb->num_rows($result);
$exist = false;
for($i=0; $i<$resultCount;$i++){
        $tabid = $adb->query_result($result,  $i,  'tabid');
        if($tabid == $EmailsTabId){
                $exist = true;
                echo 'Emails Sharing Access entry already exist';
                break;
        }
}

if(!$exist){
        $ruleid = $adb->getUniqueID('vtiger_def_org_share');
        $shareaccessquery = "INSERT INTO vtiger_def_org_share VALUES(?,?,?,?)";
        $result = Migration_Index_View::ExecuteQuery($shareaccessquery, array($ruleid, $EmailsTabId, 2, 0));
        echo 'Emails Sharing Access entry is added';
}
//90 ends

//91 starts
$pathToFile = "layouts/vlayout/modules/Products/PopupContents.tpl";
shell_exec("rm -rf $pathToFile");
echo "Removed Products PopupContents.tpl";
echo "<br>";

$pathToFile = "layouts/vlayout/modules/Products/PopupEntries.tpl";
shell_exec("rm -rf $pathToFile");
echo "Removed Products PopupEntries.tpl";
echo "<br>";
//91 ends

//92 starts
$result = $adb->pquery('SELECT max(templateid) AS maxtemplateid FROM vtiger_emailtemplates', array());
Migration_Index_View::ExecuteQuery('UPDATE vtiger_emailtemplates_seq SET id = ?', array(1 + ((int)$adb->query_result($result, 0, 'maxtemplateid'))));

 $result = $adb->pquery("SELECT 1 FROM vtiger_eventhandlers WHERE event_name=? AND handler_class=?",
                                    array('vtiger.entity.aftersave','Vtiger_RecordLabelUpdater_Handler'));
if($adb->num_rows($result) <= 0) {
    $lastMaxCRMId = 0;
    do {
        $rs = $adb->pquery("SELECT crmid,setype FROM vtiger_crmentity WHERE crmid > ? LIMIT 500", array($lastMaxCRMId));
        if (!$adb->num_rows($rs)) {
            break;
        }

        while ($row = $adb->fetch_array($rs)) {
            $imageType = stripos($row['setype'], 'image');
            $attachmentType = stripos($row['setype'], 'attachment');

            /**
             * TODO: Optimize underlying API to cache re-usable data, for speedy data.
             */
            if($attachmentType || $imageType) {
                $labelInfo = $row['setype'];
            } else {
                $labelInfo = getEntityName($row['setype'], array(intval($row['crmid'])));
            }

            if ($labelInfo) {
                $label = html_entity_decode($labelInfo[$row['crmid']],ENT_QUOTES);

                Migration_Index_View::ExecuteQuery('UPDATE vtiger_crmentity SET label=? WHERE crmid=? AND setype=?',
                            array($label, $row['crmid'], $row['setype']));
            }

            if (intval($row['crmid']) > $lastMaxCRMId) {
                $lastMaxCRMId = intval($row['crmid']);
            }
        }
        $rs = null;
        unset($rs);
    } while(true);

    $homeModule = Vtiger_Module::getInstance('Home');
    Vtiger_Event::register($homeModule, 'vtiger.entity.aftersave', 'Vtiger_RecordLabelUpdater_Handler', 'modules/Vtiger/handlers/RecordLabelUpdater.php');
                echo "Record Update Handler was updated successfully";
}
// To update the Campaign related status value in database as in language file
$updateQuery = "update vtiger_campaignrelstatus set campaignrelstatus=? where campaignrelstatus=?";
Migration_Index_View::ExecuteQuery($updateQuery,array('Contacted - Unsuccessful' , 'Contected - Unsuccessful'));
echo 'Campaign related status value is updated';
//92 ends

//93 starts
//93 ends

//94 starts
$result = $adb->pquery('SELECT 1 FROM vtiger_currencies WHERE currency_name = ?', array('Libya, Dinar'));
if(!$adb->num_rows($result)) {
        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_currencies (currencyid, currency_name, currency_code, currency_symbol) VALUES(?, ?, ?, ?)',
        array($adb->getUniqueID('vtiger_currencies'), 'Libya, Dinar', 'LYD', 'LYD'));
}

//Start: Customer - Feature #17656 Allow users to add/remove date format with the date fields in workflow send mail task.
$fieldResult = $adb->pquery('SELECT fieldname, name, typeofdata FROM vtiger_field
                                INNER JOIN vtiger_tab ON vtiger_tab.tabid = vtiger_field.tabid WHERE typeofdata LIKE ?', array('D%'));

$dateFieldsList = $dateTimeFieldsList = array();
while ($rowData = $adb->fetch_array($fieldResult)) {
        $moduleName = $rowData['name'];
        $fieldName = $rowData['fieldname'];

        $pos = stripos($rowData['typeofdata'], 'DT');
        if ($pos !== false) {
                $dateTimeFieldsList[$moduleName][$fieldName] = $fieldName;
        } else {
                $dateFieldsList[$moduleName][$fieldName] = $fieldName;
        }
}
unset($dateFieldsList['Events']['due_date']);
$dateTimeFieldsList['Events']['due_date'] = 'due_date';

$dateFields = array();
foreach ($dateFieldsList as $moduleName => $fieldNamesList) {
        $dateFields = array_merge($dateFields, $fieldNamesList);
}

$dateTimeFields = array();
foreach ($dateTimeFieldsList as $moduleName => $fieldNamesList) {
        $dateTimeFields = array_merge($dateTimeFields, $fieldNamesList);
}

$taskIdsList = array();
$result = $adb->pquery('SELECT task_id, module_name FROM com_vtiger_workflowtasks
                        INNER JOIN com_vtiger_workflows ON com_vtiger_workflows.workflow_id = com_vtiger_workflowtasks.workflow_id
                        WHERE task LIKE ?', array('%VTEmailTask%'));
while ($rowData = $adb->fetch_array($result)) {
        $taskIdsList[$rowData['task_id']] = $rowData['module_name'];
}

$dateFormat = '($_DATE_FORMAT_)';
$timeZone = '($(general : (__VtigerMeta__) usertimezone))';
foreach ($taskIdsList as $taskId => $taskModuleName) {
        $tm = new VTTaskManager($adb);
        $task = $tm->retrieveTask($taskId);

        $emailTask = new VTEmailTask();
        $properties = get_object_vars($task);
        foreach ($properties as $propertyName => $propertyValue) {
                $propertyValue = str_replace('$(general : (__VtigerMeta__) date)', "(general : (__VtigerMeta__) date) $dateFormat", $propertyValue);

                foreach ($dateFields as $fieldName) {
                        if ($taskModuleName === 'Events' && $fieldName === 'due_date') {
                                continue;
                        }
                        $propertyValue = str_replace("$$fieldName", "$$fieldName $dateFormat", $propertyValue);
                }

                foreach ($dateTimeFields as $fieldName) {
                        if ($taskModuleName === 'Calendar' && $fieldName === 'due_date') {
                                continue;
                        }
                        $propertyValue = str_replace("$$fieldName", "$$fieldName $timeZone", $propertyValue);
                }

                foreach ($dateFieldsList as $moduleName => $fieldNamesList) {
                        foreach ($fieldNamesList as $fieldName) {
                                $propertyValue = str_replace("($moduleName) $fieldName)", "($moduleName) $fieldName) $dateFormat", $propertyValue);
                        }
                }
                foreach ($dateTimeFieldsList as $moduleName => $fieldNamesList) {
                        foreach ($fieldNamesList as $fieldName) {
                                $propertyValue = str_replace("($moduleName) $fieldName)", "($moduleName) $fieldName) $timeZone", $propertyValue);
                        }
                }
                $emailTask->$propertyName = $propertyValue;
        }
        $tm->saveTask($emailTask);
}



global $root_directory;

// To update vtiger_modcomments table for permormance issue
$datatypeQuery = "ALTER TABLE vtiger_modcomments MODIFY COLUMN related_to int(19)";
$dtresult = Migration_Index_View::ExecuteQuery($datatypeQuery, array());
if($dtresult){
echo 'ModComments related_to field Datatype updated';
}else{
echo 'Failed to update Modcomments Datatype';
}
echo '</br>';
$indexQuery = "ALTER TABLE vtiger_modcomments ADD INDEX relatedto_idx (related_to)";
$indexResult = Migration_Index_View::ExecuteQuery($indexQuery, array());
if($indexResult){
echo 'Index added on ModComments';
}else{
echo 'Failed to add index on ModComments';
}
// End

$maxActionIdResult = $adb->pquery('SELECT MAX(actionid) AS maxid FROM vtiger_actionmapping', array());
$maxActionId = $adb->query_result($maxActionIdResult, 0, 'maxid');
Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_actionmapping(actionid, actionname, securitycheck) VALUES(?,?,?)', array($maxActionId+1 ,'Print', '0'));
echo "<br> added print to vtiger_actionnmapping";
$module = Vtiger_Module_Model::getInstance('Reports');
$module->enableTools(Array('Print', 'Export'));
echo "<br> enabled Print and export";

Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_webforms ADD captcha INT(1) NOT NULL DEFAULT 0',array());

//94 ends

//95 starts
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_webforms MODIFY COLUMN description TEXT',array());
require_once 'vtlib/Vtiger/Module.php';
$module = Vtiger_Module::getInstance('Users');
if ($module) {
    $blockInstance = Vtiger_Block::getInstance('LBL_CALENDAR_SETTINGS', $module);
    if ($blockInstance) {
        $hideCompletedField = Vtiger_Field::getInstance('hidecompletedevents', $module);
        if(!$hideCompletedField){
            $fieldInstance = new Vtiger_Field();
            $fieldInstance->name = 'hidecompletedevents';
            $fieldInstance->label = 'LBL_HIDE_COMPLETED_EVENTS';
            $fieldInstance->uitype = 56;
            $fieldInstance->column = $fieldInstance->name;
            $fieldInstance->columntype = 'INT';
            $fieldInstance->typeofdata = 'C~O';
            $fieldInstance->diplaytype = '1';
            $fieldInstance->defaultvalue = '0';
            $blockInstance->addField($fieldInstance);
            echo '<br>Hide/Show, completed/held, events/todo FIELD ADDED IN USERS';
        }
    }
}

$entityModulesModels = Vtiger_Module_Model::getEntityModules();
$modules = array();
if($entityModulesModels){
    foreach($entityModulesModels as $model){
       $modules[] =  $model->getName();
    }
}

foreach($modules as $module){
    $moduleInstance = Vtiger_Module::getInstance($module);
    if($moduleInstance){
        $result = Migration_Index_View::ExecuteQuery("select blocklabel from vtiger_blocks where tabid=? and sequence = ?", array($moduleInstance->id, 1));
        $block = $adb->query_result($result,0,'blocklabel');
        if($block){
            $blockInstance = Vtiger_Block::getInstance($block, $moduleInstance);
            $field = new Vtiger_Field();
            $field->name = 'created_user_id';
            $field->label = 'Created By';
            $field->table = 'vtiger_crmentity';
            $field->column = 'smcreatorid';
            $field->uitype = 53;
            $field->typeofdata = 'V~O';
            $field->displaytype= 2;
            $field->quickcreate = 3;
            $field->masseditable = 0;
            $blockInstance->addField($field);
            echo "Creator field added for $module";
            echo '<br>';
        }
    }else{
        echo "Unable to find $module instance";
        echo '<br>';
    }
}
Migration_Index_View::ExecuteQuery("UPDATE vtiger_field SET presence=0 WHERE fieldname='unit_price' and columnname='unit_price'", array());
Migration_Index_View::ExecuteQuery("ALTER TABLE vtiger_portal ADD createdtime datetime", array());

$adb->query("CREATE TABLE IF NOT EXISTS vtiger_calendar_default_activitytypes (id INT(19), module VARCHAR(50), fieldname VARCHAR(50), defaultcolor VARCHAR(50));");

$result = Migration_Index_View::ExecuteQuery('SELECT * FROM vtiger_calendar_default_activitytypes', array());
if ($adb->num_rows($result) <= 0) {
        $calendarViewTypes = array('Events' => array('Events'=>'#17309A'),
                                                        'Calendar' => array('Tasks'=>'#3A87AD'),
                                                        'Potentials' => array('Potentials'=>'#AA6705'),
                                                        'Contacts' => array('support_end_date'=>'#953B39',
                                                                                                'birthday'=>'#545252'),
                                                        'Invoice' => array('Invoice'=>'#87865D'),
                                                        'Project' => array('Project'=>'#C71585'),
                                                        'ProjectTask' => array('Project Task'=>'#006400'),
                                                );

        foreach($calendarViewTypes as $module=>$viewInfo) {
                foreach($viewInfo as $fieldname=>$color) {
                        Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_calendar_default_activitytypes (id, module, fieldname, defaultcolor) VALUES (?,?,?,?)', array($adb->getUniqueID('vtiger_calendar_default_activitytypes'), $module, $fieldname, $color));
                }
        }
        echo '<br>Default Calendar view types added to the table.<br>';
}
$adb->query("CREATE TABLE IF NOT EXISTS vtiger_calendar_user_activitytypes (id INT(19), defaultid INT(19), userid INT(19), color VARCHAR(50), visible INT(19) default 1);");

$result = Migration_Index_View::ExecuteQuery('SELECT * FROM vtiger_calendar_user_activitytypes', array());
if ($adb->num_rows($result) <= 0) {
    $queryResult = Migration_Index_View::ExecuteQuery('SELECT id, defaultcolor FROM vtiger_calendar_default_activitytypes', array());
    $numRows = $adb->num_rows($queryResult);
    for ($i = 0; $i < $numRows; $i++) {
            $row = $adb->query_result_rowdata($queryResult, $i);
            $activityIds[$row['id']] = $row['defaultcolor'];
    }

    $allUsers = Users_Record_Model::getAll(true);
    foreach($allUsers as $userId=>$userModel) {
            foreach($activityIds as $activityId=>$color) {
                   Migration_Index_View::ExecuteQuery('INSERT INTO vtiger_calendar_user_activitytypes (id, defaultid, userid, color) VALUES (?,?,?,?)', array($adb->getUniqueID('vtiger_calendar_user_activitytypes'), $activityId, $userId, $color));
            }
    }
    echo '<br>Default Calendar view types added to the table for all existing users';
}

Migration_Index_View::ExecuteQuery("UPDATE vtiger_field SET quickcreate = ? WHERE tabid = 8 AND (fieldname = ? OR fieldname = ?);", array(0,"filename","filelocationtype"));

/*Distribute leads equally using roundrobin (webforms)*/
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_webforms ADD roundrobin INT(1) NOT NULL DEFAULT 0',array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_webforms ADD roundrobin_userid VARCHAR(256)',array());
Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_webforms ADD roundrobin_logic INT NOT NULL DEFAULT 0',array());
echo '<br> Added Roundrobin fields for webforms';


//95 ends

//96 starts
    $entityModulesModels = Vtiger_Module_Model::getEntityModules();
    $fieldNameToDelete = 'created_user_id';
    if($entityModulesModels){
        foreach($entityModulesModels as $moduleInstance){
            if($moduleInstance){
                $module = $moduleInstance->name;
                $fieldInstance = Vtiger_Field::getInstance($fieldNameToDelete,$moduleInstance);
                if($fieldInstance){
                    $fieldInstance->delete();
                    echo "<br>";
                    echo "For $module created by is removed";
                }else{
                    echo "<br>";
                    echo "For $module created by is not there";
                }

            }else{
                echo "Unable to find $module instance";
                echo '<br>';
            }
        }
    }
//96 ends
    
//97 starts
    $adb = PearDatabase::getInstance();
    $handlers = array('modules/FieldFormulas/VTFieldFormulasEventHandler.inc');
    Migration_Index_View::ExecuteQuery('DELETE FROM vtiger_eventhandlers WHERE handler_path IN ('.generateQuestionMarks($handlers) .')', $handlers);

    //delete modtracker detail view links
    Migration_Index_View::ExecuteQuery('DELETE FROM vtiger_links WHERE linktype = ? AND handler_class = ? AND linkurl like "javascript:ModTrackerCommon.showhistory%"',
                    array('DETAILVIEWBASIC', 'ModTracker'));

    //Added New field in mailmanager
    Migration_Index_View::ExecuteQuery('ALTER TABLE vtiger_mail_accounts ADD COLUMN sent_folder VARCHAR(50)', array());
    echo '<br>selected folder field added in mailmanager.<br>';
    
//97 ends