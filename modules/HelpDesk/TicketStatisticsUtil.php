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
require_once('include/database/PearDatabase.php');


/**	Function to get the total number of tickets ie.. count of all tickets 
 *	@return int $totTickets - total count of tickets
**/
function getTotalNoofTickets()
{
	global $adb;
	$query = "select count(*) as totalticketcount from troubletickets inner join crmentity on crmentity.crmid=troubletickets.ticketid where crmentity.deleted=0";
	$result = $adb->query($query);
	$totTickets = $adb->query_result($result,0,"totalticketcount");
	return $totTickets;
}

/**     Function to get the total number of tickets which are not Closed
 *      @return int $totTickets - total count of not Closed tickets
**/
function getTotalNoofOpenTickets()
{
	global $adb;
	$query = "select count(*) as totalopenticketcount from troubletickets inner join crmentity on crmentity.crmid=troubletickets.ticketid where crmentity.deleted=0 and troubletickets.status !='Closed'";
	$result = $adb->query($query);
	$totOpenTickets = $adb->query_result($result,0,"totalopenticketcount");
	return $totOpenTickets;
}

/**     Function to get the total number of Closed tickets
 *      @return int $totTickets - total count of Closed tickets
**/
function getTotalNoofClosedTickets()
{
	global $adb;
	$query = "select count(*) as totalclosedticketcount from troubletickets inner join crmentity on crmentity.crmid=troubletickets.ticketid where crmentity.deleted=0 and troubletickets.status ='Closed'";
	$result = $adb->query($query);
	$totClosedTickets = $adb->query_result($result,0,"totalclosedticketcount");
	return $totClosedTickets;
}

/**     Function to get the length of the bar to be displayed for the given value
 *	@param  int $val - the number of tickets value
 *	@param  string $image_path - image path of the bar per theme basis
 *	@param  int $singleUnit - the single bar length value which is calculated as 80/total no. of tickets
 *      @return int $out - the bar length value to be displayed which is calculated based on the $val parameter
**/
function outBar($val,$image_path,$singleUnit) 
{
	$scale = round($val*$singleUnit);
	if($scale < 1 && $scale > 0)
	{
		$scale = 1;
	}
        $out = '<img src='.$image_path.'bl_bar.jpg height=10 width='. $scale .'%>';
        $out .= str_pad($val, (3-strlen(strval($val)))*12 + strlen(strval($val)), "&nbsp;&nbsp;", STR_PAD_LEFT);

	return $out;
}

/**     Function to display the statistics based on the Priority ie., will display all the Priorities and the no. of tickets per Priority
 *      @param  string $image_path - image path of the bar per theme basis
 *      @param  int $singleUnit - the single bar length value which is calculated as 80/total no. of tickets
 *      @return void. 
**/
function showPriorities($image_path, $singleUnit)
{
	global $adb;
	global $mod_strings;
	$prresult = getFromDB("ticketpriorities");
	$noofrows = $adb->num_rows($prresult);
	$prOut = '';

	for($i=0; $i<$noofrows; $i++)
	{
		$priority_val = $adb->query_result($prresult,$i,"ticketpriorities");
		$prOut .= '<tr>';
		if($i == 0)
		{
	        	$prOut .=  '<td class="dataLabel" width="10%" noWrap><div align="left">'.$mod_strings['LBL_PRIORITIES'].'</div></td>';
		}
		else
		{
			
	        	$prOut .=  '<td class="dataLabel" width="10%" noWrap><div align="left"> </div></td>';
		}
          	$prOut .= '<TD  class="dataLabel" width="10%" noWrap ><div align="left">'.$priority_val.'</div></TD>';
		$noofOpenTickets = getTicketCount("Open", $priority_val, "priority");
		$noofClosedTickets = getTicketCount("Closed", $priority_val, "priority"); 
		$noofTotalTickets = getTicketCount("Total", $priority_val, "priority");
		$openOut = outBar($noofOpenTickets, $image_path, $singleUnit); 
		$closeOut = outBar($noofClosedTickets, $image_path, $singleUnit); 
		$totOut = outBar($noofTotalTickets, $image_path, $singleUnit); 
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$openOut.'</div></TD>';
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$closeOut.'</div></TD>';
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$totOut.'</div></TD>';
		$prOut .= '</tr>';
		
	}
	return $prOut;
}

/**     Function to display the statistics based on the Category ie., will display all the Categories and the no. of tickets per Category
 *      @param  string $image_path - image path of the bar per theme basis
 *      @param  int $singleUnit - the single bar length value which is calculated as 80/total no. of tickets
 *      @return void.
**/
function showCategories($image_path, $singleUnit)
{
	global $adb;
	global $mod_strings;
	$prresult = getFromDB("ticketcategories");
	$noofrows = $adb->num_rows($prresult);
	$prOut = '';

	for($i=0; $i<$noofrows; $i++)
	{
		$priority_val = $adb->query_result($prresult,$i,"ticketcategories");
		$prOut .= '<tr>';
		if($i == 0)
		{
	        	$prOut .=  '<td class="dataLabel" width="10%" noWrap><div align="left">'.$mod_strings['LBL_CATEGORIES'].'</div></td>';
		}
		else
		{
			
	        	$prOut .=  '<td class="dataLabel" width="10%" noWrap><div align="left"> </div></td>';
		}	
          	$prOut .= '<TD  class="dataLabel" width="10%" noWrap ><div align="left">'.$priority_val.'</div></TD>';
		$noofOpenTickets = getTicketCount("Open", $priority_val, "category");
		$noofClosedTickets = getTicketCount("Closed", $priority_val, "category"); 
		$noofTotalTickets = getTicketCount("Total", $priority_val, "category");
		$openOut = outBar($noofOpenTickets, $image_path, $singleUnit); 
		$closeOut = outBar($noofClosedTickets, $image_path, $singleUnit); 
		$totOut = outBar($noofTotalTickets, $image_path, $singleUnit); 
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$openOut.'</div></TD>';
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$closeOut.'</div></TD>';
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$totOut.'</div></TD>';
		$prOut .= '</tr>';
		
	}
	return $prOut;
		
	
}

/**     Function to display the statistics based on the Users ie., will display all the users and the no. of tickets per user
 *      @param  string $image_path - image path of the bar per theme basis
 *      @param  int $singleUnit - the single bar length value which is calculated as 80/total no. of tickets
 *      @return void.
**/
function showUserBased($image_path, $singleUnit)
{
	global $adb;
	global $mod_strings;
	$prresult = getFromDB("users");
	$noofrows = $adb->num_rows($prresult);
	$prOut = '';

	for($i=0; $i<$noofrows; $i++)
	{
		$priority_val = $adb->query_result($prresult,$i,"id");
		$user_name = $adb->query_result($prresult,$i,"user_name");
		$prOut .= '<tr>';
		if($i == 0)
		{
	        	$prOut .=  '<td class="dataLabel" width="10%" noWrap><div align="left">'.$mod_strings['LBL_SUPPORTERS'].'</div></td>';
		}
		else
		{
			
	        	$prOut .=  '<td class="dataLabel" width="10%" noWrap><div align="left"> </div></td>';
		}	
          	$prOut .= '<TD  class="dataLabel" width="10%" noWrap ><div align="left">'.$user_name.'</div></TD>';
		$noofOpenTickets = getTicketCount("Open", $priority_val, "smownerid");
		$noofClosedTickets = getTicketCount("Closed", $priority_val, "smownerid"); 
		$noofTotalTickets = getTicketCount("Total", $priority_val, "smownerid");
		$openOut = outBar($noofOpenTickets, $image_path, $singleUnit); 
		$closeOut = outBar($noofClosedTickets, $image_path, $singleUnit); 
		$totOut = outBar($noofTotalTickets, $image_path, $singleUnit); 
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$openOut.'</div></TD>';
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$closeOut.'</div></TD>';
          	$prOut .= '<TD  width="25%" noWrap ><div align="left">'.$totOut.'</div></TD>';
		$prOut .= '</tr>';
		
	}
	return $prOut;
		
	
}

/**     Function to retrieve all values from the table which is passed as the parameter
 *      @param  string $tableName - table name in which we want to get the result
 *      @return result $result - the result of the query "select * from $tableName" will be return
**/
function getFromDB($tableName)
{
	global $adb;
	$query = "select * from ".$tableName;
	$result = $adb->query($query);
	return $result;
}

/**     Function to get the number of tickets based on the User or Priority or Category which is passed as a parameter
 *      @param  string $mode - the status of the ticket ie., Open or Closed. if Total then all tickets count will be retrieved
 *      @param  string $priority_val - the value based on which we get tickets ie., id of the user or ticketcategories or ticketpriorities
 *      @param  int $critColName - smownerid or category or priority which is the fieldname of the table in which we check $priority_val
 *      @return void.
**/
function getTicketCount($mode, $priority_val, $critColName)
{
	if($critColName == "smownerid")
	{
		$table_name = 'crmentity';
	}
	else
	{
		$table_name = 'troubletickets';
	}
	global $adb;
	if($mode == 'Open')
	{
		$query = "select count(*) as count from troubletickets inner join crmentity on crmentity.crmid=troubletickets.ticketid where crmentity.deleted=0  and ".$table_name.".".$critColName."='".$priority_val."' and troubletickets.status !='Closed'";
		
	}
	elseif($mode == 'Closed')
	{
		$query = "select count(*) as count from troubletickets inner join crmentity on crmentity.crmid=troubletickets.ticketid where crmentity.deleted=0 and ".$table_name.".".$critColName."='".$priority_val."' and troubletickets.status ='Closed'";
	}
	elseif($mode == 'Total')
	{
		$query = "select count(*) as count from troubletickets inner join crmentity on crmentity.crmid=troubletickets.ticketid where crmentity.deleted=0 and ".$table_name.".".$critColName."='".$priority_val."' and deleted='0'";
	}
	$result = $adb->query($query);
	$nooftickets = $adb->query_result($result,0,"count");
	return $nooftickets;
}


?>
