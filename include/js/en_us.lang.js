/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

	
	var alert_arr = {       DELETE:'Are you sure you want to delete the selected ',
                                RECORDS:' records?',
                                SELECT:'Please select at least one entity',
                                DELETE_ACCOUNT:'Deleting this account(s) will remove its related Potentials & Quotes. Are you sure you want to delete the selected ',
                                DELETE_VENDOR:'Deleting this vendor(s) will remove its related Purchase Orders. Are you sure you want to delete the selected ',
                                SELECT_MAILID:'Please Select a mailid',
                                OVERWRITE_EXISTING_ACCOUNT1:'Overwrite the existing address with this selected account(',
                                OVERWRITE_EXISTING_ACCOUNT2:') address details?',
				                OVERWRITE_EXISTING_CONTACT1:'Overwrite the existing address with this selected contact(',
                                OVERWRITE_EXISTING_CONTACT2:') address details?',
                                MISSING_FIELDS:'Missing required fields:',
                                NOT_ALLOWED_TO_EDIT:'you are not allowed to edit this field',
                                NOT_ALLOWED_TO_EDIT_FIELDS:'you are not allowed to edit the field(s)',
                                COLUMNS_CANNOT_BE_EMPTY:'Selected Columns cannot be empty',
                                CANNOT_BE_EMPTY:' cannot be empty',
                                CANNOT_BE_NONE:' cannot be none',
                                ENTER_VALID:'Please enter a valid ',
                                SHOULDBE_LESS:' should be less than ',
                                SHOULDBE_LESS_EQUAL:' should be less than or equal to ',
                                SHOULDBE_EQUAL:' should be equal to ',
                                SHOULDBE_GREATER:' should be greater than ',
                                SHOULDBE_GREATER_EQUAL:' should be greater than or equal to ',
                                INVALID:'Invalid ',
                                EXCEEDS_MAX:' exceeds the maximum limit ',
                                OUT_OF_RANGE:' is out of range',
                                SHOULDNOTBE_EQUAL:' should not be equal to ',
                                PORTAL_PROVIDE_EMAILID:'Portal user should provide email Id for portal login',
                                ADD_CONFIRMATION:'Are you sure you want to add the selected ',
                                ACCOUNTNAME_CANNOT_EMPTY:'AccountName Cannot be Empty',
                                CANT_SELECT_CONTACTS:"You can\'t select related contacts from Lead",
                                LBL_THIS:'This ',
                                DOESNOT_HAVE_MAILIDS:" doesn\'t have any mail ids",
                                ARE_YOU_SURE:'Are you sure?',
                                DOESNOT_HAVE_AN_MAILID:'" '+"doesn\'t have an Email Id",
                                MISSING_REQUIRED_FIELDS:'Missing required fields: ',
                                READONLY:"it\'s readonly",
				SELECT_ATLEAST_ONE_USER:'Please select at least one user',
                                DISABLE_SHARING_CONFIRMATION:'Are you sure you want to disable sharing for selected ',
                                USERS:' user(s) ?',
                                ENDTIME_GREATER_THAN_STARTTIME:'End Time should be greater than Start Time ',
                                FOLLOWUPTIME_GREATER_THAN_STARTTIME:'Followup Time should be greater than End Time ',
                                MISSING_EVENT_NAME:'Missing Event Name',
                                EVENT_TYPE_NOT_SELECTED:'Event Type is not selected',
                                CLOSEDATE_CANNOT_BE_EMPTY:'Close Date field cannot be empty',
                                SITEURL_CANNOT_BE_EMPTY:'Site Url cannot be empty',
                                SITENAME_CANNOT_BE_EMPTY:'Site Name cannot be empty',
                                LISTPRICE_CANNOT_BE_EMPTY:'List Price cannot be empty',
                                INVALID_LIST_PRICE:'Invalid List Price',
                                PROBLEM_ACCESSSING_URL:'Problem accessing url: ',
                                CODE:' Code: ',
                                WISH_TO_QUALIFY_MAIL_AS_CONTACT:'Are you sure you wish to Qualify this Mail as Contact?',
                                SELECT_ATLEAST_ONEMSG_TO_DEL:'Please select at least one message to delete',
                                ERROR:'Error',
                                FIELD_TYPE_NOT_SELECTED:'Field Type is not selected',
                                SPECIAL_CHARACTERS_NOT_ALLOWED:'Special characters are not allowed in Label field',
				SPECIAL_CHARACTERS:'Special characters',
                                NOT_ALLOWED:'are not allowed. Please try with some other values',
                                PICKLIST_CANNOT_BE_EMPTY:'Picklist value cannot be empty',
                                DUPLICATE_VALUES_FOUND:'Duplicate Values found',
                                DUPLICATE_MAPPING_ACCOUNTS:'Duplicate mapping for accounts!!',
                                DUPLICATE_MAPPING_CONTACTS:'Duplicate mapping for Contacts!!',
                                DUPLICATE_MAPPING_POTENTIAL:'Duplicate mapping for Potential!!',
                                ERROR_WHILE_EDITING:'Error while Editing',
                                CURRENCY_CHANGE_INFO:'Currency Changes has been made Successfully',
                                CURRENCY_CONVERSION_INFO:'Are you using Dollar $ as Currency? \n Click OK to remain as $, Cancel to change the currency conversion rate.',
                                THE_EMAILID: "The email id \'",
                                EMAIL_FIELD_INVALID:"\' in the email field is invalid",
                                MISSING_REPORT_NAME:'Missing Report Name',
                                REPORT_NAME_EXISTS:'Report name already exists, try again...',
                                WANT_TO_CHANGE_CONTACT_ADDR:'Do you want to change the addresses of the Contacts related to this Account?',
                                SURE_TO_DELETE:'Are you sure you want to delete ?',
				NO_PRODUCT_SELECTED:'No product is selected. Select at least one Product',
                                VALID_FINAL_PERCENT:'Enter valid Final Discount Percentage',
                                VALID_FINAL_AMOUNT:'Enter valid Final Discount Amount',
                                VALID_SHIPPING_CHARGE:'Enter a valid Shipping & Handling charge',
                                VALID_ADJUSTMENT:'Enter a valid Adjustment',
                                WANT_TO_CONTINUE:'Do you want to Continue?',
                                ENTER_VALID_TAX:'Please enter Valid TAX value',
                                VALID_TAX_NAME:'Enter valid Tax Name',
                                CORRECT_TAX_VALUE:'Enter Correct Tax Value',
                                ENTER_POSITIVE_VALUE:'Please enter positive value',
                                LABEL_SHOULDNOT_EMPTY:'The tax label name should not be empty',
                                NOT_VALID_ENTRY:'is not a valid entry. Please enter correct value',
                                VALID_DISCOUNT_PERCENT:'Enter a valid Discount percentage',
                                VALID_DISCOUNT_AMOUNT:'Enter a valid Discount Amount',
                                SELECT_TEMPLATE_TO_MERGE:'Please select a template to merge',
				SELECTED_MORE_THAN_ONCE:'You have selected the following item(s) more than once.',
				YES:'yes',
                                NO:'no',
                                MAIL:'mail',
				EQUALS:'equals',
				NOT_EQUALS_TO:'not equal to',
				STARTS_WITH:'starts with',
				CONTAINS:'contains',	
				DOES_NOT_CONTAINS:'does not contains',
				LESS_THAN:'less than',
				GREATER_THAN:'greater than',
				LESS_OR_EQUALS:'less or equal',
				GREATER_OR_EQUALS:'greater or equal',

				NO_SPECIAL_CHARS:'Special Characters are not allowed in Invoice String',
				PLS_SELECT_VALID_FILE:'Please select a file with the following extension:\n',
                                NO_SPECIAL:'Special Characters are not allowed',
				NO_QUOTES:'Quotes (\' ") and + symbol are not allowed ',
				IN_PROFILENAME:' in Profile Name',
				IN_GROUPNAME:' in Group Name',
				IN_ROLENAME:' in Role Name',
                                VALID_TAX_PERCENT:'Enter a valid Tax percentage',
                                VALID_SH_TAX:'Enter valid Taxes for shipping and handling ',
				ROLE_DRAG_ERR_MSG:'You cannot move a Parent Node under a Child Node',
				LBL_DEL:'del',
				VALID_DATA :' Enter Valid Data ,Please try again... ',
                                STDFILTER : 'Standard Filters',
                                STARTDATE : 'Start Date',
                                ENDDATE : 'End Date',
                                START_DATE_TIME : 'Start Date & Time',
                                START_TIME : 'Start Time',
                                DATE_SHOULDNOT_PAST :'Current date & time for Activities with status as Planned',
                                TIME_SHOULDNOT_PAST :'Current Time for Activities with status as Planned',
				LBL_AND : 'And',
				LBL_ENTER_VALID_PORT: 'Please enter valid port number',
				IN_USERNAME :' in Username ',
				LBL_ENTER_VALID_NO: 'Please enter valid number',
				LBL_PROVIDE_YES_NO: ' Invalid value.\n Please Provide Yes or No',
				LBL_SELECT_CRITERIA: ' Invalid criteria.\n Please select criteria',
				// Added/Updated for vtiger CRM 5.0.4
				OPPORTUNITYNAME_CANNOT_BE_EMPTY:'Potential Name field cannot be empty',
                		OVERWRITE_EXISTING_ACCOUNT1:'Do you want to Overwrite the existing address with this selected account(',
                		NAME_DESC:' for Folder Name & Description',
                		ENDS_WITH:'ends with',
                		SHARED_EVENT_DEL_MSG:'The User does not have permission to Edit/Delete Shared Event.',
                                                                                                                             

				LBL_WRONG_IMAGE_TYPE: 'Allowed file types for Contacts - jpeg, png, jpg, pjpeg, x-png or gif',
				SELECT_MAIL_MOVE: 'Please select a mail and then move..',
				
				LBL_NOTSEARCH_WITHSEARCH_ALL:'You haven\'t used the search. All the records will be Exported from ',
				LBL_NOTSEARCH_WITHSEARCH_CURRENTPAGE:'You haven\'t searched any thing. But you selected with search & current page options. So the records in the current page will be Exported from ',
				LBL_NO_DATA_SELECTED:'There is no record selected. Select at least one record to Export',
				LBL_SEARCH_WITHOUTSEARCH_ALL:'You have used search option but you have not selected without search & all options.\nYou can click [ok] to export all data or You can click [cancel] and try again with other export criteria',
				STOCK_IS_NOT_ENOUGH : 'Stock is not enough',
				INVALID_QTY : 'Invalid Qty',
				LBL_SEARCH_WITHOUTSEARCH_CURRENTPAGE:'You have used search option but you have not selected without search & currentpage options.\nYou can click [ok] to export current page data or You can click [cancel] and try again with some other export criteria.',
				LBL_SELECT_COLUMN: ' Invalid column.\n Please select column',
				LBL_NOT_ACCESSIBLE : 'Not Accessible',
				LBL_FILENAME_LENGTH_EXCEED_ERR: 'Filename cannot exceed 255 characters',
				LBL_DONT_HAVE_EMAIL_PERMISSION : "You don't have permission for Email field so you can't choose the email id",
				LBL_NO_FEEDS_SELECTED: 'No Feeds Selected',
				LBL_SELECT_PICKLIST:'Please select atleast one value to delete',
				LBL_CANT_REMOVE:'You can\'t remove all the values',

				// Added after 5.0.4 GA
				
				/*For global add/delete in picklist*/
				LBL_GIVE_PICKLIST_VALUE:'Please provide some value for the selected picklist to be replaced',
				LBL_SELECT_ROLE:'Please select atleast one role for which the new values are to be added',
				LBL_ADD_PICKLIST_VALUE:'Please provide atleast one new value to be added',

				ALL_FILTER_CREATION_DENIED:'Cannot create CustomView using name "All", try using different ViewName',

                /* For Duplicate merging feature */
				SAME_GROUPS: 'You have to select the records in the same groups for merging',
				ATLEAST_TWO: 'Select atleast two records for merging',
				MAX_THREE: 'You are allowed to select a maximum of three records',
				//PARENT_RECORD: 'Select a record as parent record',  MergeFields.tpl Line:59
				MAX_RECORDS: 'You are allowed to select a maximum of four records',
				CON_MANDATORY: 'Select the mandatory field Last Name',
				LE_MANDATORY: 'Select the mandatory fields Last Name and Company',
				ACC_MANDATORY: 'Select the mandatory field Account Name',
				PRO_MANDATORY: 'Select the mandatory field Product Name',
				TIC_MANDATORY: 'Select the mandatory field Ticket Title',
				POTEN_MANDATORY: 'Select the mandatory field Potential Name',
				VEN_MANDATORY: 'Select the mandatory field Vendor Name',
				DEL_MANDATORY: 'You are not allowed to delete the mandatory field',
				
				/* For Multi-Currency Support */
				MSG_CHANGE_CURRENCY_REVISE_UNIT_PRICE: 'Unit price of all the Currencies will be revised based on the selected Currency. Are you sure?',
				
				Select_one_record_as_parent_record : 'Select one record as parent record',
				RECURRING_FREQUENCY_NOT_PROVIDED : 'Recurring frequency not provided',
				RECURRING_FREQNECY_NOT_ENABLED : 'Recurring frequency is provided, but recurring is not enabled',
				/* Added for Documents module */
				NO_SPECIAL_CHARS_DOCS:'Special characters like quotes, backslash, + symbol, % and ? are not allowed',
				FOLDER_NAME_TOO_LONG:'Folder name is too long. Try again!',
				FOLDERNAME_EMPTY:'The Folder name cannot be empty',
				DUPLICATE_FOLDER_NAME:'Trying to duplicate an existing folder name. Please try again !',
				FOLDER_DESCRIPTION_TOO_LONG:'Folder description is too long. Try again!',
				NOT_PERMITTED:"You are not permitted to execute this operation.",		
				
				ALL_FILTER_CREATION_DENIED:'Cannot create CustomView using name "All", try using different ViewName',
				OPERATION_DENIED:'You are denied to perform this operation',
				EMAIL_CHECK_MSG: 'Disable portal access to save the email field as blank',
				IS_PARENT : 'This Product has Sub Products, You are not allowed to choose a Parent for this Product',
				
				/*global actions on picklist*/
				PICKLIST_CANNOT_BE_EMPTY: 'Picklist value cannot be empty',
				DUPLICATE_VALUES_FOUND: 'Duplicate Values found',
				LBL_NO_ROLES_SELECTED: 'No roles have been selected, do you wish to continue?',
				LBL_DUPLICATE_FOUND: 'Duplicate entries found for the value ',
				LBL_CANNOT_HAVE_EMPTY_VALUE: 'Cannot have empty value. To delete go back and click on delete button',
				LBL_DUPLICATE_VALUE_EXISTS: 'Duplicate value exists',
				LBL_WANT_TO_DELETE: "This will delete the selected picklist value(s) for all roles. You sure you want to continue? ",
				LBL_DELETE_ALL_WARNING: "You have selected all values to delete. Do you want to continue?",
				LBL_PLEASE_CHANGE_REPLACEMENT: "please change the replacement value; it is also selected for delete",
				
				/*layout Editor changes*/
				BLOCK_NAME_CANNOT_BE_BLANK : 'Block name can not be blank',
				ARE_YOU_SURE_YOU_WANT_TO_DELETE : 'Are you sure you want to delete ?',
				PLEASE_MOVE_THE_FIELDS_TO_ANOTHER_BLOCK : 'Please move the fields to another block',
				ARE_YOU_SURE_YOU_WANT_TO_DELETE_BLOCK : 'Are you sure you want to delete block?',
				LABEL_CANNOT_NOT_EMPTY : 'Label cannot be Emtpy',
				LBL_TYPEALERT_1 : 'Sorry, you cannot map the',
				LBL_WITH : 'with',
				LBL_TYPEALERT_2 : 'data type. Kindly map the same data types.',
				LBL_LENGTHALERT : 'Sorry, you can cannot map fields with different character size. Kindly map the data with same or more character size.',
				LBL_DECIMALALERT : 'Sorry, you can cannot map fields with different decimal places. Kindly map the data with same or more decimal places.',
				FIELD_IS_MANDATORY : 'Mandatory Field',
				FIELD_IS_ACTIVE : 'Field is available for use',
				FIELD_IN_QCREATE : 'Present in Quick Create',
				FIELD_IS_MASSEDITABLE : 'Available for Mass Edit',	
					
				IS_MANDATORY_FIELD : 'is Mandatory Field',
				CLOSEDATE_CANNOT_BE_EMPTY : 'Closing Date cannot be Empty',
				AMOUNT_CANNOT_BE_EMPTY : 'Amount cannot be Empty',
				ARE_YOU_SURE : 'Are You Sure You want to Delete?',
				LABEL_ALREADY_EXISTS : 'Label already exists. Please specify a different Label',
				LENGTH_OUT_OF_RANGE : 'Length of the Block should be less than 50 characters',
				NOT_A_VALID_POTENTIAL_NAME : 'Please insert a proper Potential Name',
				LBL_SELECT_ONE_FILE : 'Please select atleast one File',
				LBL_UNABLE_TO_ADD_FOLDER : 'Unable to add Folder. Please try again.',
				LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE_FOLDER : 'Are you sure you want to delete the folder?',
				LBL_ERROR_WHILE_DELETING_FOLDER : 'Error while deleting the folder.Please try again later.',
				LBL_FILE_CAN_BE_DOWNLOAD : 'File is available for download',
				LBL_DOCUMENT_LOST_INTEGRITY:'This Documents is not available. It will be marked as Inactive',
				LBL_DOCUMENT_NOT_AVAILABLE : 'This Document is not available for Download',
				LBL_FOLDER_SHOULD_BE_EMPTY : 'Folder should be empty to remove it!',
				
				LBL_PLEASE_SELECT_FILE_TO_UPLOAD : 'Please select the file to upload.',
				LBL_ARE_YOU_SURE_TO_MOVE_TO : 'Are you sure you want to move the file(s) to ',
				LBL_FOLDER : ' folder',
				LBL_UNABLE_TO_UPDATE : 'Unable to update! Please try it again.'
								
			};
