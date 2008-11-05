<?php

require_once('Smarty_setup.php');
require_once('user_privileges/default_module_view.php');
require_once("modules/$currentModule/$currentModule.php");

global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

$tool_buttons = Button_Check($currentModule);

$focus = new $currentModule();
$smarty = new vtigerCRM_Smarty();

$record = $_REQUEST['record'];
$isduplicate = $_REQUEST['isDuplicate'];
$tabid = getTabid($currentModule);

if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}
if($isduplicate == 'true') $focus->id = '';

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);

$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
// TODO: Update Single Module Instance name here.
$smarty->assign('SINGLE_MOD', $currentModule); 
$smarty->assign('CATEGORY', $category);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('THEME', $theme);
$smarty->assign('ID', $focus->id);
$smarty->assign('MODE', $focus->mode);

$smarty->assign('NAME', $focus->column_fields[$focus->def_detailview_recname]);
$smarty->assign('UPDATEINFO',updateInfo($focus->id));

$smarty->assign('IS_REL_LIST',isPresentRelatedLists($currentModule));

$validationArray = split_validationdataArray(getDBValidationData($focus->tab_name, $tabid));
$smarty->assign('VALIDATION_DATA_FIELDNAME',$data['fieldname']);
$smarty->assign('VALIDATION_DATA_FIELDDATATYPE',$data['datatype']);
$smarty->assign('VALIDATION_DATA_FIELDLABEL',$data['fieldlabel']);

$smarty->assign('EDIT_PERMISSION', isPermitted($currentModule, 'EditView', $record));
$smarty->assign('CHECK', $tool_buttons);

$smarty->assign('IS_REL_LIST', isPresentRelatedLists($currentModule));
$smarty->assign('SinglePane_View', $singlepane_view);

if($singlepane_view == 'true') {
	$related_array = getRelatedLists($currentModule,$focus);
	$smarty->assign("RELATEDLISTS", $related_array);
}

if(isPermitted($currentModule, 'EditView', $record) == 'yes')
	$smarty->assign('EDIT_DUPLICATE', 'permitted');
if(isPermitted($currentModule, 'Delete', $record) == 'yes')
	$smarty->assign('DELETE', 'permitted');

$smarty->assign('BLOCKS', getBlocks($currentModule,'detail_view','',$focus->column_fields));

$smarty->display('DetailView.tpl');

?>