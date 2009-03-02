%name VTQL_Parser
//%left EQ LT GT LTE GTE NE IN LIKE.

sql ::= select_statement.
select_statement ::= SELECT(SEL) selectcol_list FRM(F) table_list where_condition order_clause limit_clause end_stmt. { 
if(SEL){
$this->out['select'] = SEL;
}
if(F){
$this->out['from'] = F ;
}
if(SEMI){
$this->out['semi_colon'] = SEMI;
}
if($this->out['select']){
$this->buildSelectStmt($this->out);
}
}
selectcol_list ::= selectcolumn_exp COLUMNNAME(CNAME). { 
$this->out['column_list'][] = CNAME;
}
selectcol_list ::= ASTERISK(A). {
$this->out['column_list'] = A;
}
selectcol_list ::= COUNT PARENOPEN ASTERISK PARENCLOSE. {
$this->out['column_list'] = 'count(*)';
}
selectcolumn_exp ::= selectcol_list COMMA. 
selectcolumn_exp ::= . 
table_list ::= TABLENAME(TNAME). {
if($this->out["column_list"] !=="*" && strcmp($this->out["column_list"],"count(*)") !==0){
if(!in_array("id",$this->out["column_list"])){
	$this->out["column_list"][] = "id";
} 
}
$moduleName = TNAME;
if(!$moduleName){
	$this->syntax_error = true;
	throw new WebServiceException(WebServiceErrorCode::$QUERYSYNTAX, "There is an syntax error in query");
}
$inst = new VtigerCRMObject($moduleName,false);
$inst = $inst->getInstance();
$this->module_instance = $inst;
$this->out['moduleName'] = $moduleName;
$this->out['tableName'] = implode(',',$inst->tab_name);
}
where_condition ::= WHERE(Wh) condition.
where_condition ::= . 
condition ::= expr_set expr(E).
expr_set ::= condition LOGICAL_AND(LAND). {
$this->out['where_condition']['operators'][] = LAND;
}
expr_set ::= condition LOGICAL_OR(LOR). {
$this->out['where_condition']['operators'][] = LOR;
}
expr_set ::= .
expr ::= COLUMNNAME(ECNAME) logical_term valuelist.{
$this->out['columnDone']=true;
$this->out['where_condition']['column_names'][] = ECNAME;
if(strcmp(ECNAME, 'id')===0){
$prev = $this->out['where_condition']['column_values'][sizeof($this->out['where_condition']['column_values'])-1];
if(is_array($prev)){
$new = array();
foreach($prev as $ind=>$val){
$val = trim($val,'\'"');
$value = vtws_getIdComponents($val);
$new[] = $value[1];
}
$this->out['where_condition']['column_values'][sizeof($this->out['where_condition']['column_values'])-1] = $new;
}else{
$prev = trim($prev,'\'"');
$value = vtws_getIdComponents($prev);
if(strcasecmp($this->out['where_condition']['column_operators'][sizeof($this->out['where_condition']['column_operators'])-1],'like')===0){
$value[1] = "'".$value[1]."'";
}
$this->out['where_condition']['column_values'][sizeof($this->out['where_condition']['column_values'])-1] = $value[1];
}
}
}
valuelist ::= PARENOPEN valueref PARENCLOSE.
valuelist ::= valueref.
valueref ::= value_exp VALUE(VAL).{
$length = sizeof($this->out['where_condition']['column_values']);
if(strcasecmp($this->out['where_condition']['column_operators'][$length-1],"in")===0 && $length !==0 && !$this->out['columnDone']){
if(!is_array($this->out['where_condition']['column_values'][$length - 1])){
$prev = $this->out['where_condition']['column_values'][$length - 1];
$this->out['where_condition']['column_values'][$length - 1] = array();
$this->out['where_condition']['column_values'][$length - 1][] = $prev; 
}
$this->out['where_condition']['column_values'][$length - 1][] = VAL;
}else{
$this->out['columnDone'] = false;
$this->out['where_condition']['column_values'][] = VAL;
}
}
value_exp ::= valueref COMMA.
value_exp ::= .
logical_term ::= EQ. {
$this->out['where_condition']['column_operators'][] = '=';
}
logical_term ::= LT. {
$this->out['where_condition']['column_operators'][] = '<';
}
logical_term ::= GT. {
$this->out['where_condition']['column_operators'][] = '>';
}
logical_term ::= LTE. {
$this->out['where_condition']['column_operators'][] = '<=';
}
logical_term ::= GTE. {
$this->out['where_condition']['column_operators'][] = '>=';
}
logical_term ::= NE. {
$this->out['where_condition']['column_operators'][] = '!=';
}
logical_term ::= IN. {
$this->out['where_condition']['column_operators'][] = 'IN';
}
logical_term ::= LIKE. {
$this->out['where_condition']['column_operators'][] = 'LIKE';
}
order_clause ::= ORDERBY column_group clause. 
order_clause ::= . 
column_group ::= column_list .
column_list ::= column_exp COLUMNNAME(CN). {
$this->out['orderby'][] = CN;
}
column_exp ::= column_list COMMA. 
column_exp ::= .
clause ::= ASC.
clause ::= DESC.
clause ::= .
limit_clause ::= LIMIT limit_set. 
limit_clause ::= . 
limit_set ::= VALUE(LV). {
$this->out['limit'][] = LV;
}
limit_set ::= VALUE(LV) COMMA VALUE(LV2). {
$this->out['limit'][] = LV;
$this->out['limit'][] = LV2;
}
end_stmt ::= SEMICOLON(SEMI). {
global $adb;
if(!$this->out['meta']){
$module = $this->out['moduleName'];
$objectMeta = new VtigerCRMObjectMeta(VtigerWebserviceObject::fromName($adb,$module),$this->user);
$this->out['meta'] = $objectMeta;
$meta = $this->out['meta'];
$fieldcol = $meta->getFieldColumnMapping();
$columns = array();
if(strcmp($this->out['column_list'],'*')===0){
$columns = array_values($fieldcol);
}else if( strcmp($this->out['column_list'],'count(*)')!==0){
foreach($this->out['column_list'] as $ind=>$field){
$columns[] = $fieldcol[$field];
}
}
if($this->out['where_condition']){
foreach($this->out['where_condition']['column_names'] as $ind=>$field){
$columns[] = $fieldcol[$field];
}
}
$module = $this->module_instance;
$tables = $this->getTables($this->out, $columns);
if(sizeof($tables)===0){
$tables[] = $module->table_name;
}
if(!in_array("vtiger_crmentity",$tables) && $module != "Users"){
array_push($tables,"vtiger_crmentity");
}
$firstTable = $module->table_name;
$firstIndex = $module->tab_name_index[$firstTable];
foreach($tables as $ind=>$table){
if($module->table_name!=$table){
	if(!isset($module->tab_name_index[$table]) && $table == "vtiger_crmentity"){
		$this->out['defaultJoinConditions'] = $this->out['defaultJoinConditions']." LEFT JOIN $table ON $firstTable.$firstIndex=$table.crmid";
	}else{
		$this->out['defaultJoinConditions'] = $this->out['defaultJoinConditions']." LEFT JOIN $table ON $firstTable.$firstIndex=$table.{$module->tab_name_index[$table]}";
	}
}else{
	$this->out['tableName'] = $table;
}
}
}
/*
$module = $this->module_instance;
foreach($module->tab_name_index as $key=>$val){
ECNAME = $key.$val;
break;
}
*/
}
%include_class {
/*
add this rule to add parenthesis support.
condition ::= PARENOPEN expr_set expr(E) PARENCLOSE.
sample format(for contacts) for generated sql object 
Array ( 
	[column_list] => c4,c3,c2,c1 
	[tableName] => vtiger_crmentity,vtiger_contactdetails,vtiger_contactaddress,vtiger_contactsubdetails,vtiger_contactscf,vtiger_customerdetails 
	[where_condition] => Array ( 
		[column_operators] => Array ( 
			[0] => = 
			[1] => = 
			[2] => = 
			) 
		[column_names] => Array ( 
			[0] => c1 
			[1] => c2 
			[2] => c3 
			) 
		[column_values] => Array ( 
			[0] => 'llet me' 
			[1] => 45 
			[2] => -1 
			) 
		//TO BE DONE
		[grouping] => Array (
			[0] => Array (
				[0] => 1
				[1] => 2
				)
			)
		[operators] => Array ( 
			[0] => and 
			[1] => or 
			)
		)
	[orderby] => Array ( 
		[0] => c4 
		[1] => c5 
		)
	[select] => SELECT 
	[from] => from 
	[semi_colon] => ; 
)*/
	private $out;
	public $lex;
	private $module_inst;
	private $success ;
	private $query ;
	private $error_msg;
	private $syntax_error;
	private $user;
function __construct($user, $lex,$out){
	if(!is_array($out)){
		$out = array();
	}
	$this->out = &$out;
	$this->lex = $lex;
	$this->success = false;
	$this->error_msg ='';
	$this->query = '';
	$this->syntax_error = false;
	$this->user = $user;
}

function __toString(){
	return $this->value."";
}
function buildSelectStmt($sqlDump){
	$meta = $sqlDump['meta'];
	$fieldcol = $meta->getFieldColumnMapping();
	$columnTable = $meta->getColumnTableMapping();
	$this->query = 'SELECT ';
	if(strcmp($sqlDump['column_list'],'*')===0){
		$i=0;
		foreach($fieldcol as $field=>$col){
			if($i===0){
				$this->query = $this->query.$columnTable[$col].'.'.$col;
				$i++;
			}else{
				$this->query = $this->query.','.$columnTable[$col].'.'.$col;
			}
		}
	}else if(strcmp($sqlDump['column_list'],'count(*)')===0){
		$this->query = $this->query." COUNT(*)";
	}else{
		$i=0;
		foreach($sqlDump['column_list'] as $ind=>$field){
			if(!$fieldcol[$field]){
				throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED, "Permission to access '.$field.' attribute denied.");
			}
			if($i===0){
				$this->query = $this->query.$columnTable[$fieldcol[$field]].'.'.$fieldcol[$field];
				$i++;
			}else{
				$this->query = $this->query.','.$columnTable[$fieldcol[$field]].'.'.$fieldcol[$field];
			}
		}
	}
	$this->query = $this->query.' FROM '.$sqlDump['tableName'].$sqlDump['defaultJoinConditions'];
	if($sqlDump['where_condition']){
		if((sizeof($sqlDump['where_condition']['column_names']) == 
		sizeof($sqlDump['where_condition']['column_values'])) && 
		(sizeof($sqlDump['where_condition']['column_operators']) == sizeof($sqlDump['where_condition']['operators'])+1)){
			$this->query = $this->query.' WHERE (';
			$i=0;
			$referenceFields = $meta->getReferenceFieldDetails();
			$ownerFields = $meta->getOwnerFields();
			for(;$i<sizeof($sqlDump['where_condition']['column_values']);++$i){
				if(!$fieldcol[$sqlDump['where_condition']['column_names'][$i]]){
					throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED, "Permission to access ".$sqlDump['where_condition']['column_names'][$i]." attribute denied.");
				}
				$whereField = $sqlDump['where_condition']['column_names'][$i];
				$whereOperator = $sqlDump['where_condition']['column_operators'][$i];
				$whereValue = $sqlDump['where_condition']['column_values'][$i];
				if(in_array($whereField,array_keys($referenceFields))){
					if(is_array($whereValue)){
						foreach($whereValue as $index=>$value){
							if(strpos($value,'x')===false){
								throw new WebServiceException(WebServiceErrorCode::$INVALIDID,"Id specified is incorrect");
							}
						}
						$whereValue = array_map(array($this, 'getReferenceValue'),$whereValue);
					}else if(strpos($whereValue,'x')!==false){
						$whereValue = $this->getReferenceValue($whereValue);
						if(strcasecmp($whereOperator,'like')===0){
							$whereValue = "'".$whereValue."'";
						}
					}else{
						throw new WebServiceException(WebServiceErrorCode::$INVALIDID,"Id specified is incorrect");
					}
				}else if(in_array($whereField,$ownerFields)){
					if(is_array($whereValue)){
						$groupId = array_map(array($this, 'getOwner'),$whereValue);
					}else{
						$groupId = $this->getOwner($whereValue);
						if(strcasecmp($whereOperator,'like')===0){
							$groupId = "'$groupId'";
						}
					}
					$whereValue = $groupId;
				}
				if(is_array($whereValue)){
					$whereValue = "(".implode(',',$whereValue).")";
				}
				$this->query = $this->query.$columnTable[$fieldcol[$whereField]].'.'.
									$fieldcol[$whereField]." ".$whereOperator." ".$whereValue;
				if($i <sizeof($sqlDump['where_condition']['column_values'])-1){
					$this->query = $this->query.' ';
					$this->query = $this->query.$sqlDump['where_condition']['operators'][$i].' ';
				}
			}
		}else{
			throw new WebServiceException(WebServiceErrorCode::$QUERYSYNTAX, "columns data inappropriate");
		}
		$this->query = $this->query.")";
		if($this->out['moduleName'] != "Users"){
			$this->query = $this->query." AND ";
		}
	}else{
		$this->query = $this->query." WHERE ";
	}
	if(strcasecmp('calendar',$this->out['moduleName'])===0){
		$this->query = $this->query."activitytype='Task' AND ";
	}elseif(strcasecmp('events',$this->out['moduleName'])===0){
		$this->query = $this->query."activitytype!='Emails' AND activitytype!='Task' AND ";
	}else if(strcasecmp('emails',$this->out['moduleName'])===0){
		$this->query = $this->query."activitytype='Emails' AND ";
	}
	if($this->out['moduleName'] != "Users"){
		$this->query = $this->query."vtiger_crmentity.deleted=0";
	}
	if(strcasecmp("off",$this->user->is_admin)===0){
		require('user_privileges/user_privileges_'.$this->user->id.'.php');
		require('user_privileges/sharing_privileges_'.$this->user->id.'.php');
		if($profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && 
				$defaultOrgSharingPermission[$meta->getEntityId()] == 3){
			$this->query = $this->query." and (vtiger_crmentity.smownerid in({$this->user->id}) or ".
					"vtiger_crmentity.smownerid in(select vtiger_user2role.userid from vtiger_user2role".
					" inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid ".
					"inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid ".
					"where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%') or ".
					"vtiger_crmentity.smownerid in(".
						"select shareduserid from vtiger_tmp_read_user_sharing_per ".
						"where userid=".$this->user->id." and tabid=".$meta->getEntityId()."))";
		}
	}
	if($sqlDump['orderby']){
		$i=0;
		$this->query = $this->query.' ORDER BY ';
		foreach($sqlDump['orderby'] as $ind=>$field){
			if($i===0){
				$this->query = $this->query.$columnTable[$fieldcol[$field]].".".$fieldcol[$field];
				$i++;
			}else{
				$this->query = $this->query.','.$columnTable[$fieldcol[$field]].".".$fieldcol[$field];
			}
		}
	}
	if($sqlDump['limit']){
		$i=0;
		$offset =false;
		if(sizeof($sqlDump['limit'])>1){
			$offset = true;
		}
		$this->query = $this->query.' LIMIT ';
		foreach($sqlDump['limit'] as $ind=>$field){
			if(!$offset){
				$field = ($field>100)? 100: $field;
			}
			if($i===0){
				$this->query = $this->query.$field;
				$i++;
				$offset = false;
			}else{
				$this->query = $this->query.','.$field;
			}
		}
	}else{
		$this->query = $this->query.' LIMIT 100';
	}
	$this->query = $this->query.';';
}
function getTables($sqlDump,$columns){
	$meta = $sqlDump['meta'];
	$coltable = $meta->getColumnTableMapping();
	$tables = array();
	foreach($columns as $ind=>$col){
		$tables[$coltable[$col]] = $coltable[$col];
	}
	$tables = array_keys($tables);
	return ($tables);
}
function getReferenceValue($whereValue){
	$whereValue = trim($whereValue,'\'"');
	$whereValue = vtws_getIdComponents($whereValue);
	$whereValue = $whereValue[1];
	return $whereValue;	
}
function getOwner($whereValue){
	$whereValue = trim($whereValue,'\'"');
	$whereValue = vtws_getIdComponents($whereValue);
	$whereValue = $whereValue[1];
	return $whereValue;
}
function isSuccess(){
	return $this->success;
}
function getErrorMsg(){
	return $this->error_msg;
}
function getQuery(){
	return $this->query;
}
function getObjectMetaData(){
	return $this->out['meta'];
}
}
//%token_prefix    VTQL_
%declare_class {class VTQL_Parser}
%parse_accept {
		$this->success = true;
	}

%parse_failure {
	if(!$this->syntax_error){
		throw new WebServiceException(WebServiceErrorCode::$QUERYSYNTAX, "Parsing failed");
	}
}

%stack_overflow {
	throw new WebServiceException(WebServiceErrorCode::$QUERYSYNTAX, "Parser stack overflow");
}

%syntax_error {
	$synMsg = "Syntax Error on line " . $this->lex->linenum . ": token '" .$this->lex->value."' ";
	$expect = array();
	foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
		$expect[] = self::$yyTokenName[$token];
	}
	$synMsg =$synMsg.('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN
		. '), expected one of: ' . implode(',', $expect));
	
	throw new WebServiceException(WebServiceErrorCode::$QUERYSYNTAX, $synMsg);
}
