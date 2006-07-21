{*<!--

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

-->*}

<script type="text/javascript" src="include/js/Inventory.js"></script>
<script type="text/javascript" src="include/js/general.js"></script>
<script>
if(!e)
	window.captureEvents(Event.MOUSEMOVE);

//  window.onmousemove= displayCoords;
//  window.onclick = fnRevert;
  
function displayCoords(event,obj,mode,curr_row) 
{ldelim}
	if(mode != 'discount_final')
	{ldelim}
		var curr_productid = document.getElementById("hdnProductId"+curr_row).value;
		if(curr_productid == '')
		{ldelim}
			alert("Please select a Product");
			return false;
		{rdelim}
	{rdelim}

	//Set the Header value for Discount
	if(mode == 'discount')
	{ldelim}
		document.getElementById("discount_div_title"+curr_row).innerHTML = '<b>Set Discount for : '+document.getElementById("productTotal"+curr_row).innerHTML;
	{rdelim}
	else if(mode == 'discount_final')
	{ldelim}
		document.getElementById("discount_div_title_final").innerHTML = '<b>Set Discount for : '+document.getElementById("netTotal").innerHTML;
	{rdelim}

	var move_Element = document.getElementById(obj).style;
	if(!event)
	{ldelim}
		move_Element.left = e.pageX +'px' ;
		move_Element.top = e.pageY + 'px';	
	{rdelim}
	else
	{ldelim}
		move_Element.left = event.clientX +'px' ;
		move_Element.top = event.clientY + 'px';	
	{rdelim}

	move_Element.display = 'block';
{rdelim}
  
	function doNothing(){ldelim}
	{rdelim}
	
	function fnHidePopDiv(obj){ldelim}
		document.getElementById(obj).style.display = 'none';
	{rdelim}
</script>

<!-- Added this file to display and hanld the Product Details in Inventory module  -->

   <tr>
	<td colspan="4" align="left">



<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable" id="proTab">
   <tr>
	<td colspan="5" class="detailedViewHeader">
		<b>{$APP.LBL_PRODUCT_DETAILS}</b>
	</td>
	<td class="detailedViewHeader" align="right">
		<b>{$APP.LBL_TAX_MODE}</b>
	</td>
	<td class="detailedViewHeader">
		<select id="taxtype" name="taxtype" onchange="decideTaxDiv(this);">
			<OPTION value="individual" selected>Individual</OPTION>
			<OPTION value="group">Group</OPTION>
		</select>
	</td>
   </tr>


   <!-- Header for the Product Details -->
   <tr>
	<td width=5% valign="top" class="small crmTableColHeading" align="right"><b>{$APP.LBL_TOOLS}</b></td>
	<td width=40% class="small crmTableColHeading"><font color='red'>*</font><b>{$APP.LBL_PRODUCT_NAME}</b></td>
	<td width=10% class="small crmTableColHeading"><b>{$APP.LBL_QTY_IN_STOCK}</b></td>
	<td width=10% class="small crmTableColHeading"><b>{$APP.LBL_QTY}</b></td>
	<td width=10% class="small crmTableColHeading" align="right"><b>{$APP.LBL_LIST_PRICE}</b></td>
	<td width=12% nowrap class="small crmTableColHeading" align="right"><b>{$APP.LBL_TOTAL}</b></td>
	<td width=13% valign="top" class="small crmTableColHeading" align="right"><b>{$APP.LBL_NET_PRICE}</b></td>
   </tr>
   <!-- Product Details First row - Starts -->
   <tr valign="top" id="row1">

	<!-- row1, column1 - delete link-->
	<td  class="crmTableRow small lineOnTop">&nbsp;
		<input type="hidden" id="hdnRowStatus1" name="hdnRowStatus1">
	</td>

	<!-- row1, column1 - Product Name-->
	<td class="crmTableRow small lineOnTop">
		<table width="100%"  border="0" cellspacing="0" cellpadding="1">
		   <tr>
			<td class="small">
				<input type="text" id="productName1" name="productName1" class="small" style="width:70%" value="{$PRODUCT_NAME}" readonly />
				<input type="hidden" id="hdnProductId1" name="hdnProductId1" value="{$PRODUCT_ID}">
				<img src="{$IMAGE_PATH}search.gif" style="cursor: pointer;" align="absmiddle" onclick="productPickList(this,'{$MODULE}',1)" />
			</td>
		   </tr>
		   <tr>
			<td class="small" id="setComment">
				<textarea id="comment1" name="comment1" class=small style="width:70%;height:40px"></textarea>
				<br>
				[<a href="javascript:;" onclick="getObj('comment1').value='';";>{$APP.LBL_CLEAR_COMMENT}</a>]
			</td>
		   </tr>
		</table>
	</td>
	<!-- row1, column2 - Quantity in Stock -->
	<td id="qtyInStock1" class="crmTableRow small lineOnTop" >{$QTY_IN_STOCK}</td>
	<!-- row1, column 3 - Quantity -->
	<td class="crmTableRow small lineOnTop">
		<input id="qty1" name="qty1" type="text" class="small " style="width:50px" onfocus="this.className='detailedViewTextBoxOn'" onBlur="FindDuplicate(); settotalnoofrows(); calcTotal(this); loadTaxes_Ajax(this);" value=""/>
	</td>
	<!-- row1, column 4 - List Price, Discount, Total After Discount and Tax -->
	<td class="crmTableRow small lineOnTop" align="right">
		<table width="100%" cellpadding="0" cellspacing="0">
		   <tr>
			<td align="right">
				<input id="listPrice1" name="listPrice1" value="{$UNIT_PRICE}" type="text" class="small " style="width:70px" onBlur="FindDuplicate(); settotalnoofrows(); calcTotal(this)"/>&nbsp;<img src="{$IMAGE_PATH}pricebook.gif" onclick="priceBookPickList(this,1)">
			</td>
		   </tr>
		   <tr>
			<td align="right" style="padding:5px;" nowrap>
				(-)&nbsp;<b><a href="javascript:doNothing();" onClick="displayCoords(event,'discount_div1','discount','1')" >{$APP.LBL_DISCOUNT}</a> : </b>
				<!-- Popup Discount DIV -->
				<div class="discountUI" id="discount_div1">
					<input type="hidden" id="discount_type1" name="discount_type1" value="">
					<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small">
					   <tr>
						<td id="discount_div_title1" nowrap align="left" ></td>
						<td align="right"><img src="{$IMAGE_PATH}close.gif" border="0" onClick="fnHidePopDiv('discount_div1')" style="cursor:pointer;"></td>
					   </tr>
					   <tr>
						<td align="left" class="lineOnTop"><input type="radio" name="discount1" checked onclick="setDiscount(this,1)">&nbsp; {$APP.LBL_ZERO_DISCOUNT}</td>
						<td class="lineOnTop">&nbsp;</td>
					   </tr>
					   <tr>
						<td align="left"><input type="radio" name="discount1" onclick="setDiscount(this,1)">&nbsp; % {$APP.LBL_OF_PRICE}</td>
						<td align="right"><input type="text" class="small" size="2" id="discount_percentage1" name="discount_percentage1" value="0" style="visibility:hidden" onBlur="setDiscount(this,1)">&nbsp;%</td>
					   </tr>
					   <tr>
						<td align="left" nowrap><input type="radio" name="discount1" onclick="setDiscount(this,1)">&nbsp;{$APP.LBL_DIRECT_PRICE_REDUCTION}</td>
						<td align="right"><input type="text" id="discount_amount1" name="discount_amount1" size="5" value="0" style="visibility:hidden" onBlur="setDiscount(this,1)"></td>
					   </tr>
					</table>
				</div>
				<!-- End Div -->
			</td>
		   </tr>
		   <tr>
			<td align="right" style="padding:5px;" nowrap>
				<b>{$APP.LBL_TOTAL_AFTER_DISCOUNT} :</b>
			</td>
		   </tr>
		   <tr id="individual_tax_row1" class="TaxShow">
			<td align="right" style="padding:5px;" nowrap>
				(+)&nbsp;<b><a href="javascript:doNothing();" onClick="displayCoords(event,'tax_div1','tax','1')" >{$APP.LBL_TAX} </a> : </b>
				<!-- Pop Div For TAX -->
				<div class="discountUI" id="tax_div1">
				</div>
				<!-- End Popup Div -->
			</td>
		   </tr>
		</table> 
	</td>
	<!-- row1, column 5 - Product Total -->
	<td class="crmTableRow small lineOnTop" align="right">
		<table width="100%" cellpadding="5" cellspacing="0">
		   <tr>
			<td id="productTotal1" align="right">&nbsp;</td>
		   </tr>
		   <tr>
			<td id="discountTotal1" align="right">0.00</td>
		   </tr>
		   <tr>
			<td id="totalAfterDiscount1" align="right">&nbsp;</td>
		   </tr>
		   <tr>
			<td id="taxTotal1" align="right">0.00</td>
		   </tr>
		</table>
	</td>
	<!-- row1, column 6 - Net Price -->
	<td id="netPrice1"  valign="bottom" class="crmTableRow small lineOnTop" align="right"><b>&nbsp;</b></td>
   </tr>
   <!-- Product Details First row - Ends -->
</table>

<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable">
   <!-- Add Product Button -->
   <tr>
	<td colspan="3">
		{if $MODULE eq 'Quotes' || $MODULE eq 'SalesOrder' || $MODULE eq 'Invoice'}
			<input type="button" name="Button" class="small" value="{$APP.LBL_ADD_PRODUCT}" onclick="fnAddProductRow('{$MODULE}');" />
		{else}
			<input type="button" name="Button" class="small" value="{$APP.LBL_ADD_PRODUCT}" onclick="fnAddProductRow('{$MODULE}');" />
		{/if}
	</td>
   </tr>



   <!-- Product Details Final Total Discount, Tax and Shipping&Hanling  - Starts -->
   <tr valign="top">
	<td width="88%" class="crmTableRow small lineOnTop" align="right"><b>{$APP.LBL_NET_TOTAL}</b></td>
	<td width="12%" id="netTotal" class="crmTableRow small lineOnTop" align="right"><b>&nbsp;</b></td>
   </tr>

   <tr valign="top">
	<td class="crmTableRow small lineOnTop" align="right">
		(-)&nbsp;<b><a href="javascript:doNothing();" onClick="displayCoords(event,'discount_div_final','discount_final','1')">{$APP.LBL_DISCOUNT}</a>
		<!-- Popup Discount DIV -->
		<div class="discountUI" id="discount_div_final">
			<input type="hidden" id="discount_type_final" name="discount_type_final" value="">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small">
			   <tr>
				<td id="discount_div_title_final" nowrap align="left" ></td>
				<td align="right"><img src="{$IMAGE_PATH}close.gif" border="0" onClick="fnHidePopDiv('discount_div_final')" style="cursor:pointer;"></td>
			   </tr>
			   <tr>
				<td align="left" class="lineOnTop"><input type="radio" name="discount" checked onclick="setDiscount(this,'_final')">&nbsp; {$APP.LBL_ZERO_DISCOUNT}</td>
				<td class="lineOnTop">&nbsp;</td>
			   </tr>
			   <tr>
				<td align="left"><input type="radio" name="discount" onclick="setDiscount(this,'_final')">&nbsp; % {$APP.LBL_OF_PRICE}</td>
				<td align="right"><input type="text" class="small" size="2" id="discount_percentage_final" name="discount_percentage_final" value="0" style="visibility:hidden" onBlur="setDiscount(this,'_final')">&nbsp;%</td>
			   </tr>
			   <tr>
				<td align="left" nowrap><input type="radio" name="discount" onclick="setDiscount(this,'_final')">&nbsp;{$APP.LBL_DIRECT_PRICE_REDUCTION}</td>
				<td align="right"><input type="text" id="discount_amount_final" name="discount_amount_final" size="5" value="0" style="visibility:hidden" onBlur="setDiscount(this,'_final')"></td>
			   </tr>
			</table>
		</div>
		<!-- End Div -->
	</td>
	<td id="discount_final" class="crmTableRow small lineOnTop" align="right">0.00</td>
   </tr>

   <tr id="group_tax_row" valign="top" class="TaxHide">
	<td class="crmTableRow small lineOnTop" align="right">(+)&nbsp;<b><a href="#">{$APP.LBL_TAX}</a></td>
	<td id="tax_final" class="crmTableRow small lineOnTop" align="right">0.00</td>
   </tr>
   <tr valign="top">
	<td class="crmTableRow small" align="right">
		(+)&nbsp;<b>{$APP.LBL_SHIPPING_AND_HANDLING_CHARGES} </b>
	</td>
	<td class="crmTableRow small" align="right">
		<input id="shipping_handling_charge" name="shipping_handling_charge" type="text" class="small" style="width:40px" align="right" value="0.00">
	</td>
   </tr>
   <tr valign="top">
	<td class="crmTableRow small" align="right">
		(+)&nbsp;<b><a href="#">{$APP.LBL_TAX_FOR_SHIPPING_AND_HANDLING} </a></b>
	</td>
	<td id="shipping_handling_tax" class="crmTableRow small" align="right">0.00</td>
   </tr>
   <tr valign="top">
	<td class="crmTableRow small" align="right">
		{$APP.LBL_ADJUSTMENT}
		<select name="adjustmentType" class=small>
			<option value="+">Add</option>
			<option value="-">Deduct</option>
		</select>
	</td>
	<td class="crmTableRow small" align="right">
		<input id="adjustment" name="adjustment" type="text" class="small" style="width:40px" align="right" value="0.00">
	</td>
   </tr>
   <tr valign="top">
	<td class="crmTableRow big lineOnTop" align="right"><b>{$APP.LBL_GRAND_TOTAL}</b></td>
	<td id="grandTotal" name="grandTotal" class="crmTableRow big lineOnTop" align="right">&nbsp;</td>
   </tr>
</table>
		<input type="hidden" name="totalProductCount" id="totalProductCount" value="">




	</td>
   </tr>




