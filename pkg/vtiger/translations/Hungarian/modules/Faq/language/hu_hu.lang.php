<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************
 * $Header:  \modules\Faq\language\hu_hu.lang.php - 12:06 2011.11.11. $
 * Description:  Defines the Hungarian language pack for the Faq module vtiger 5.3.x
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Istvan Holbok,  e-mail: holbok@gmail.com , mobil: +3670-3420900 , Skype: holboki
 ********************************************************************************/ 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'TudásTár',
'LBL_MODULE_TITLE'=>'TudásTár: Kezdőlap',
'LBL_SEARCH_FORM_TITLE'=>'TudásTár Keresés',
'LBL_LIST_FORM_TITLE'=>'TudásTár Lista',
'LBL_NEW_FORM_TITLE'=>'Új TudásTár',
'LBL_MEMBER_ORG_FORM_TITLE'=>'Szervezeti tagság',

'LBL_LIST_ACCOUNT_NAME'=>'TudásTár neve',
'LBL_LIST_CITY'=>'Város',
'LBL_LIST_WEBSITE'=>'Weboldal',
'LBL_LIST_STATE'=>'Állam/megye',
'LBL_LIST_PHONE'=>'Telefon',
'LBL_LIST_EMAIL_ADDRESS'=>'Email cím',
'LBL_LIST_CONTACT_NAME'=>'Kapcsolat neve',
'LBL_FAQ_INFORMATION'=>'TudásTár adatai',

//DON'T CONVERT THESE THEY ARE MAPPINGS
'db_name' => 'LBL_LIST_ACCOUNT_NAME',
'db_website' => 'LBL_LIST_WEBSITE',
'db_billing_address_city' => 'LBL_LIST_CITY',

//END DON'T CONVERT

'LBL_ACCOUNT'=>'TudásTár:',
'LBL_ACCOUNT_NAME'=>'TudásTár neve:',
'LBL_PHONE'=>'Telefon:',
'LBL_WEBSITE'=>'Weboldal:',
'LBL_FAX'=>'Fax:',
'LBL_TICKER_SYMBOL'=>'Tőzsdei rövidítés:',
'LBL_OTHER_PHONE'=>'Telefon, másik:',
'LBL_ANY_PHONE'=>'Telefon, bármilyen:',
'LBL_MEMBER_OF'=>'Tagja:',
'LBL_EMAIL'=>'Email:',
'LBL_EMPLOYEES'=>'Alkalmazottak:',
'LBL_OTHER_EMAIL_ADDRESS'=>'Email cím, másik:',
'LBL_ANY_EMAIL'=>'Email cím, bármilyen:',
'LBL_OWNERSHIP'=>'Tulajdonviszonyok:',
'LBL_RATING'=>'Értekelés:',
'LBL_INDUSTRY'=>'Iparág:',
'LBL_SIC_CODE'=>'TEÁOR:',
'LBL_TYPE'=>'Típus:',
'LBL_ANNUAL_REVENUE'=>'Éves forgalom:',
'LBL_ADDRESS_INFORMATION'=>'Cím adatok',
'LBL_ACCOUNT_INFORMATION'=>'Cég adatok',
'LBL_BILLING_ADDRESS'=>'Számlázási cím:',
'LBL_SHIPPING_ADDRESS'=>'Szállítási cím:',
'LBL_ANY_ADDRESS'=>'Bármilyen cím:',
'LBL_CITY'=>'Város:',
'LBL_STATE'=>'Állam/megye:',
'LBL_POSTAL_CODE'=>'Irányítószám:',
'LBL_COUNTRY'=>'Ország:',
'LBL_DESCRIPTION_INFORMATION'=>'Leíró Információ',
'LBL_DESCRIPTION'=>'Leírás:',
'NTC_COPY_BILLING_ADDRESS'=>'Számlázási cím másolása a szállítási címbe',
'NTC_COPY_SHIPPING_ADDRESS'=>'Szállítási cím másolása a számlázási címbe',
'NTC_REMOVE_MEMBER_ORG_CONFIRMATION'=>'Biztos vagy abban, hogy ezt a rekorodot mint tagszervezetet törölni akarod?',
'LBL_DUPLICATE'=>'Lehetséges TudásTár Duplikáció',
'MSG_DUPLICATE' => 'Ennek a tételnek a létrehozása valószínűleg duplikálni fog egy már létező tételt a rendszerben. Kiválaszthatsz egy már létező tételt a listáról innen alább, vagy kattinthatsz az Új TudásTár gombra, hogy folytasd a TudásTár létrehozását a már bevitt adatokkal.',

'LBL_INVITEE'=>'Kapcsolatok',
'ERR_DELETE_RECORD'=>"Adj meg egy rekord azonosítót a VTiger-fiók törléséhez",

'LBL_SELECT_ACCOUNT'=>'TudásTár kiválasztása',
'LBL_GENERAL_INFORMATION'=>'Általános Információ',

//for v4 release added
'LBL_NEW_POTENTIAL'=>'Új Lehetőség',
'LBL_POTENTIAL_TITLE'=>'Lehetőségek',

'LBL_NEW_TASK'=>'Új Feladat',
'LBL_TASK_TITLE'=>'Feladatok',
'LBL_NEW_CALL'=>'Új Hívás',
'LBL_CALL_TITLE'=>'Hívások',
'LBL_NEW_MEETING'=>'Új Megbeszélés',
'LBL_MEETING_TITLE'=>'Megbeszélések',
'LBL_NEW_EMAIL'=>'Új Email',
'LBL_EMAIL_TITLE'=>'Emailek',
'LBL_NEW_CONTACT'=>'Új Kapcsolat',
'LBL_CONTACT_TITLE'=>'Kapcsolatok',

//Added for 4GA Release
'Category'=>'Kategória',
'Related To'=>'Kapcsolódik',
'Question'=>'Kérdés',
'Answer'=>'Válasz',
'Comments'=>'Megjegyzések',
'LBL_COMMENTS'=>'Megjegyzések',//give the same value given to the above string 'Comments'
'Created Time'=>'Létrehozva',
'Modified Time'=>'Módosítva',

//Added vtiger_fields after 4.2 alpha
'LBL_TICKETS'=>'Ügyfélszolgáltai Jegyek',
'LBL_FAQ'=>'TudásTár',
'Product Name'=>'Termék neve',
'FAQ Id'=>'TudásTár AZ',
'Add Comment'=>'Megjegyzést Hozzáad',
'LBL_ADD_COMMENT'=>'Megjegyzést Hozzáad',//give the same value given to the above string 'Add Comment'
'LBL_COMMENT_INFORMATION'=>'Megjegyzés Információ',
'Status'=>'Állapot',

//Added on 10-12-2005
'LBL_QUESTION'=>'Kérdés',
'LBL_CATEGORY'=>'Kategória',
'LBL_MY_FAQ'=>'Az aktuális TudásTár',

//Added for existing Picklist Entries

'General'=>'Általános',

'Draft'=>'Vázlat',
'Reviewed'=>'Felülvizsgált',
'Published'=>'Közzétett',
'Obsolete'=>'Elavult',
			
// Module Sequence Numbering
'Faq No' => 'TudásTár No.',
// END

);

?>
