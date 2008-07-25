/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/



function callRBSearch(searchtype)
{
	for(i=1;i<=26;i++)
    {
		var data_td_id = 'alpha_'+ eval(i);
        getObj(data_td_id).className = 'searchAlph';
    }
    gPopupAlphaSearchUrl = '';
	search_fld_val= $('bas_searchfield').options[$('bas_searchfield').selectedIndex].value;
	search_txt_val=document.basicSearch.search_text.value;
	var urlstring = '';
	if(searchtype == 'Basic')
	{
		urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';
	}
	var selectedmodule = $('select_module').options[$('select_module').selectedIndex].value 
	urlstring += 'selected_module='+selectedmodule;
        	new Ajax.Request(
		'index.php',
		{
			queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:urlstring +'&query=true&module=Recyclebin&action=RecyclebinAjax&file=index&ajax=true&mode=ajax',
			onComplete: function(response) 
			{
				$("status").style.display="none";
                $("modules_datas").innerHTML=response.responseText;
				$("search_ajax").innerHTML = '';
			}
	      }
        );

}
function change_module(pickmodule)
{
	$("status").style.display="inline";
	var module=pickmodule.options[pickmodule.options.selectedIndex].value;
	new Ajax.Request(
                'index.php',
                {
			queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'action=RecyclebinAjax&module=Recyclebin&mode=ajax&file=index&selected_module='+module,
	                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("modules_datas").innerHTML=response.responseText;
					$("searchAcc").innerHTML = $("search_ajax").innerHTML; 
					$("search_ajax").innerHTML = '';
                                }
                }
        );
}

function massRestore()
{
	var select_options = document.getElementsByName('selected_id');
	var x = select_options.length;		
	idstring = "";
	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +","+idstring
				xx++
		}
	}

	if (xx != 0)
	{
		document.getElementById('idlist').value=idstring;
	}
	else
	{
		alert("Please select at least one entity");
		return false;
	}

	var selectmodule = $('selected_module').value;
	if(confirm(alert_arr.MSG_RESTORE_CONFIRMATION + " " + xx + " " + selectmodule + "?"))
	{
		$("status").style.display="inline";
		new Ajax.Request(
       	        'index.php',
               	{queue: {position: 'end', scope: 'command'},
                       	method: 'post',
                        postBody: 'action=RecyclebinAjax&module=Recyclebin&mode=ajax&file=Restoration&idlist='+idstring+'&selectmodule='+selectmodule,
       	                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("modules_datas").innerHTML=response.responseText;
					$("search_ajax").innerHTML = '';
                        }
       	        }
	        );
	}
}

function restore(entityid,select_module)
{
	if(confirm(alert_arr.MSG_RESTORE_CONFIRMATION + " " + select_module + "?"))
	{
		$("status").style.display="inline";
		new Ajax.Request(
			'index.php',
	        {
				queue: {position: 'end', scope: 'command'},
	            method: 'post',
	            postBody: 'action=RecyclebinAjax&module=Recyclebin&mode=ajax&file=Restoration&entityid='+entityid+'&selectmodule='+select_module,
		        onComplete: function(response) {
		            $("status").style.display="none";
		            $("modules_datas").innerHTML=response.responseText;
					$("search_ajax").innerHTML = '';
	            }
			}
		);
	}
}


function getListViewEntries_js(module,url)
{
	$("status").style.display="inline";
	var selectedmodule = $('select_module').options[$('select_module').selectedIndex].value 
	urlstring = '&selected_module='+selectedmodule;
        new Ajax.Request(
        	'index.php',
                {queue: {position: 'end', scope: 'command'},
                	method: 'post',
                        postBody:"module="+module+"&action="+module+"Ajax&file=index&mode=ajax&ajax=true&"+url+urlstring,
						onComplete: function(response) {
                        	$("status").style.display="none";
                            $("modules_datas").innerHTML= response.responseText;
							$("search_ajax").innerHTML = '';
                  		}
                }
        );
}


function alphabetic(module,url,dataid)
{
        for(i=1;i<=26;i++)
        {
                var data_td_id = 'alpha_'+ eval(i);
                getObj(data_td_id).className = 'searchAlph';

        }
	var selectedmodule = $('select_module').options[$('select_module').selectedIndex].value 
	url += '&selected_module='+selectedmodule;
        getObj(dataid).className = 'searchAlphselected';
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
                        postBody:"module="+module+"&action="+module+"Ajax&file=index&mode=ajax&ajax=true&"+url,
			onComplete: function(response) {
				$("status").style.display="none";
                                $("modules_datas").innerHTML=response.responseText;
				$("search_ajax").innerHTML = '';
			}
		}
	);
}

function callEmptyRecyclebin() {
	var oFreezeLayer = document.createElement("DIV");
	oFreezeLayer.id = "rb_freeze";
	oFreezeLayer.className = "small veil";

	if (browser_ie) oFreezeLayer.style.height = (document.body.offsetHeight + (document.body.scrollHeight - document.body.offsetHeight)) + "px";
	else if (browser_nn4 || browser_nn6) oFreezeLayer.style.height = document.body.offsetHeight + "px";

	oFreezeLayer.style.width = "100%";
	document.body.appendChild(oFreezeLayer);
	document.getElementById('rb_empty_conf_id').style.display = 'block';
	hideSelect();
}

function emptyRecyclebin(id) {
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
            postBody:"module=Recyclebin&action=RecyclebinAjax&file=EmptyRecyclebin&mode=ajax&ajax=true",
			onComplete: function(response) {
                $("status").style.display="none";
               	$("modules_datas").innerHTML= response.responseText;
				$("search_ajax").innerHTML = '';
				document.body.removeChild($('rb_freeze'));
			}
		}
	);
	$(id).style.display = 'none';
}
