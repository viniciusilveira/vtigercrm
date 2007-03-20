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
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
<br>
	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
			<form action="index.php" method="post" name="index" id="form">
			<input type="hidden" name="module" value="Settings">
			<input type="hidden" name="parenttab" value="{$PARENTTAB}">
			<input type="hidden" name="action" value="index">
			<input type="hidden" name="record" value="{$ID}">
			<tr>
				<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}currency.gif" alt="{$MOD.LBL_USERS}" width="48" height="48" border=0 title="{$MOD.LBL_USERS}"></td>
				<td class="heading2" valign="bottom" ><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > <a href="index.php?module=Settings&action=CurrencyListView&parenttab=Settings">{$MOD.LBL_CURRENCY_SETTINGS}</a> > {$MOD.LBL_VIEWING} &quot;{$CURRENCY_NAME}&quot; </b></td>
			</tr>
			<tr>
				<td valign=top class="small">{$MOD.LBL_CURRENCY_DESCRIPTION}</td>
			</tr>
			</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_SETTINGS} {$APP.LBL_FOR} &quot;{$CURRENCY_NAME}&quot;  </strong></td>
						<td class="small" align=right>
							<input type="submit" class="crmButton small edit" value="Edit" onclick="this.form.action.value='CurrencyEditView'; this.form.parentab.value='Settings'; this.form.record.value='{$ID}'">
						</td>
					</tr>
					</table>
					
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
			<tr>
			<td class="small" valign=top >
			<table width="100%"  border="0" cellspacing="0" cellpadding="5">
                          <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_CURRENCY_NAME}</strong></td>
                            <td width="80%" class="small cellText"><strong>{$CURRENCY_NAME}</strong></td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_CURRENCY_CODE}</strong></td>
                            <td class="small cellText">{$CURRENCY_CODE}</td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_CURRENCY_SYMBOL}</strong></td>
                            <td class="small cellText">{$CURRENCY_SYMBOL}</td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_CURRENCY_CRATE}</strong><br>({$MOD.LBL_BASE_CURRENCY})</td>

                            <td class="small cellText">{$CONVERSION_RATE}</td>
                          </tr>
                          <tr>
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_CURRENCY_STATUS}</strong></td>
                            <td class="small cellText">{$CURRENCY_STATUS}</td>
                          </tr>
                        </table>
						
						</td>
					  </tr>
					</table>
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
					  <td class="small" nowrap align=right><a href="#top">{$MOD.LBL_SCROLL}</a></td>
					</tr>
					</table>
				</td>
				</tr>
				</table>
			
			
			
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</form>
	</table>
		
	</div>
</td>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
   </tr>
</tbody>
</table>

