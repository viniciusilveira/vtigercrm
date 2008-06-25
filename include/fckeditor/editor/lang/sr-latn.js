/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: sr-latn.js
 * 	Serbian (Latin) language file.
 * 
 * File Authors:
 * 		Zoran Subic (zoran@tf.zr.ac.yu)
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

ToolbarCollapse		: "Smanji liniju sa alatkama",
ToolbarExpand		: "Proiri liniju sa alatkama",

// Toolbar Items and Context Menu
Save				: "Sa�?uvaj",
NewPage				: "Nova stranica",
Preview				: "Izgled stranice",
Cut					: "Iseci",
Copy				: "Kopiraj",
Paste				: "Zalepi",
PasteText			: "Zalepi kao neformatiran tekst",
PasteWord			: "Zalepi iz Worda",
Print				: "Štampa",
SelectAll			: "Ozna�?i sve",
RemoveFormat		: "Ukloni formatiranje",
InsertLinkLbl		: "Link",
InsertLink			: "Unesi/izmeni link",
RemoveLink			: "Ukloni link",
Anchor				: "Unesi/izmeni sidro",
InsertImageLbl		: "Slika",
InsertImage			: "Unesi/izmeni sliku",
InsertFlashLbl		: "Fleš",
InsertFlash			: "Unesi/izmeni fleš",
InsertTableLbl		: "Tabela",
InsertTable			: "Unesi/izmeni tabelu",
InsertLineLbl		: "Linija",
InsertLine			: "Unesi horizontalnu liniju",
InsertSpecialCharLbl: "Specijalni karakteri",
InsertSpecialChar	: "Unesi specijalni karakter",
InsertSmileyLbl		: "Smajli",
InsertSmiley		: "Unesi smajlija",
About				: "O FCKeditoru",
Bold				: "Podebljano",
Italic				: "Kurziv",
Underline			: "Podvu�?eno",
StrikeThrough		: "Precrtano",
Subscript			: "Indeks",
Superscript			: "Stepen",
LeftJustify			: "Levo ravnanje",
CenterJustify		: "Centriran tekst",
RightJustify		: "Desno ravnanje",
BlockJustify		: "Obostrano ravnanje",
DecreaseIndent		: "Smanji levu marginu",
IncreaseIndent		: "Uvećaj levu marginu",
Undo				: "Poni�ti akciju",
Redo				: "Ponovi akciju",
NumberedListLbl		: "Nabrojiva lista",
NumberedList		: "Unesi/ukloni nabrojivu listu",
BulletedListLbl		: "Nenabrojiva lista",
BulletedList		: "Unesi/ukloni nenabrojivu listu",
ShowTableBorders	: "Prikaži okvir tabele",
ShowDetails			: "Prikaži detalje",
Style				: "Stil",
FontFormat			: "Format",
Font				: "Font",
FontSize			: "Veli�?ina fonta",
TextColor			: "Boja teksta",
BGColor				: "Boja pozadine",
Source				: "K&ocirc;d",
Find				: "Pretraga",
Replace				: "Zamena",
SpellCheck			: "Proveri spelovanje",
UniversalKeyboard	: "Univerzalna tastatura",
PageBreakLbl		: "Page Break",	//MISSING
PageBreak			: "Insert Page Break",	//MISSING

Form			: "Forma",
Checkbox		: "Polje za potvrdu",
RadioButton		: "Radio-dugme",
TextField		: "Tekstualno polje",
Textarea		: "Zona teksta",
HiddenField		: "Skriveno polje",
Button			: "Dugme",
SelectionField	: "Izborno polje",
ImageButton		: "Dugme sa slikom",

// Context Menu
EditLink			: "Izmeni link",
InsertRow			: "Unesi red",
DeleteRows			: "Obriši redove",
InsertColumn		: "Unesi kolonu",
DeleteColumns		: "Obriši kolone",
InsertCell			: "Unesi ćelije",
DeleteCells			: "Obriši ćelije",
MergeCells			: "Spoj celije",
SplitCell			: "Razdvoji celije",
TableDelete			: "Delete Table",	//MISSING
CellProperties		: "Osobine celije",
TableProperties		: "Osobine tabele",
ImageProperties		: "Osobine slike",
FlashProperties		: "Osobine fleša",

AnchorProp			: "Osobine sidra",
ButtonProp			: "Osobine dugmeta",
CheckboxProp		: "Osobine polja za potvrdu",
HiddenFieldProp		: "Osobine skrivenog polja",
RadioButtonProp		: "Osobine radio-dugmeta",
ImageButtonProp		: "Osobine dugmeta sa slikom",
TextFieldProp		: "Osobine tekstualnog polja",
SelectionFieldProp	: "Osobine izbornog polja",
TextareaProp		: "Osobine zone teksta",
FormProp			: "Osobine forme",

FontFormats			: "Normal;Formatirano;Adresa;Naslov 1;Naslov 2;Naslov 3;Naslov 4;Naslov 5;Naslov 6",

// Alerts and Messages
ProcessingXHTML		: "Obradujem XHTML. Malo strpljenja...",
Done				: "Završio",
PasteWordConfirm	: "Tekst koji želite da nalepite kopiran je iz Worda. Da li želite da bude o�?išćen od formata pre lepljenja?",
NotCompatiblePaste	: "Ova komanda je dostupna samo za Internet Explorer od verzije 5.5. Da li želite da nalepim tekst bez �?išćenja?",
UnknownToolbarItem	: "Nepoznata stavka toolbara \"%1\"",
UnknownCommand		: "Nepoznata naredba \"%1\"",
NotImplemented		: "Naredba nije implementirana",
UnknownToolbarSet	: "Toolbar \"%1\" ne postoji",
NoActiveX			: "You browser's security settings could limit some features of the editor. You must enable the option \"Run ActiveX controls and plug-ins\". You may experience errors and notice missing features.",	//MISSING
BrowseServerBlocked : "The resources browser could not be opened. Make sure that all popup blockers are disabled.",	//MISSING
DialogBlocked		: "It was not possible to open the dialog window. Make sure all popup blockers are disabled.",	//MISSING

// Dialogs
DlgBtnOK			: "OK",
DlgBtnCancel		: "Otkaži",
DlgBtnClose			: "Zatvori",
DlgBtnBrowseServer	: "Pretraži server",
DlgAdvancedTag		: "Napredni tagovi",
DlgOpOther			: "&lt;Ostali&gt;",
DlgInfoTab			: "Info",
DlgAlertUrl			: "Molimo Vas, unesite URL",

// General Dialogs Labels
DlgGenNotSet		: "&lt;nije postavljeno&gt;",
DlgGenId			: "Id",
DlgGenLangDir		: "Smer jezika",
DlgGenLangDirLtr	: "S leva na desno (LTR)",
DlgGenLangDirRtl	: "S desna na levo (RTL)",
DlgGenLangCode		: "K&ocirc;d jezika",
DlgGenAccessKey		: "Pristupni taster",
DlgGenName			: "Naziv",
DlgGenTabIndex		: "Tab indeks",
DlgGenLongDescr		: "Pun opis URL",
DlgGenClass			: "Stylesheet klase",
DlgGenTitle			: "Advisory naslov",
DlgGenContType		: "Advisory vrsta sadržaja",
DlgGenLinkCharset	: "Linked Resource Charset",
DlgGenStyle			: "Stil",

// Image Dialog
DlgImgTitle			: "Osobine slika",
DlgImgInfoTab		: "Info slike",
DlgImgBtnUpload		: "Pošalji na server",
DlgImgURL			: "URL",
DlgImgUpload		: "Pošalji",
DlgImgAlt			: "Alternativni tekst",
DlgImgWidth			: "Širina",
DlgImgHeight		: "Visina",
DlgImgLockRatio		: "Zaklju�?aj odnos",
DlgBtnResetSize		: "Resetuj veli�?inu",
DlgImgBorder		: "Okvir",
DlgImgHSpace		: "HSpace",
DlgImgVSpace		: "VSpace",
DlgImgAlign			: "Ravnanje",
DlgImgAlignLeft		: "Levo",
DlgImgAlignAbsBottom: "Abs dole",
DlgImgAlignAbsMiddle: "Abs sredina",
DlgImgAlignBaseline	: "Bazno",
DlgImgAlignBottom	: "Dole",
DlgImgAlignMiddle	: "Sredina",
DlgImgAlignRight	: "Desno",
DlgImgAlignTextTop	: "Vrh teksta",
DlgImgAlignTop		: "Vrh",
DlgImgPreview		: "Izgled",
DlgImgAlertUrl		: "Unesite URL slike",
DlgImgLinkTab		: "Link",

// Flash Dialog
DlgFlashTitle		: "Osobine fleša",
DlgFlashChkPlay		: "Automatski start",
DlgFlashChkLoop		: "Ponavljaj",
DlgFlashChkMenu		: "Uklju�?i fleš meni",
DlgFlashScale		: "Skaliraj",
DlgFlashScaleAll	: "Prikaži sve",
DlgFlashScaleNoBorder	: "Bez ivice",
DlgFlashScaleFit	: "Popuni površinu",

// Link Dialog
DlgLnkWindowTitle	: "Link",
DlgLnkInfoTab		: "Link Info",
DlgLnkTargetTab		: "Meta",

DlgLnkType			: "Vrsta linka",
DlgLnkTypeURL		: "URL",
DlgLnkTypeAnchor	: "Sidro na ovoj stranici",
DlgLnkTypeEMail		: "E-Mail",
DlgLnkProto			: "Protokol",
DlgLnkProtoOther	: "&lt;drugo&gt;",
DlgLnkURL			: "URL",
DlgLnkAnchorSel		: "Odaberi sidro",
DlgLnkAnchorByName	: "Po nazivu sidra",
DlgLnkAnchorById	: "Po Id-ju elementa",
DlgLnkNoAnchors		: "&lt;Nema dostupnih sidra&gt;",
DlgLnkEMail			: "E-Mail adresa",
DlgLnkEMailSubject	: "Naslov",
DlgLnkEMailBody		: "Sadržaj poruke",
DlgLnkUpload		: "Pošalji",
DlgLnkBtnUpload		: "Pošalji na server",

DlgLnkTarget		: "Meta",
DlgLnkTargetFrame	: "&lt;okvir&gt;",
DlgLnkTargetPopup	: "&lt;popup prozor&gt;",
DlgLnkTargetBlank	: "Novi prozor (_blank)",
DlgLnkTargetParent	: "Roditeljski prozor (_parent)",
DlgLnkTargetSelf	: "Isti prozor (_self)",
DlgLnkTargetTop		: "Prozor na vrhu (_top)",
DlgLnkTargetFrameName	: "Naziv odredišnog frejma",
DlgLnkPopWinName	: "Naziv popup prozora",
DlgLnkPopWinFeat	: "Mogućnosti popup prozora",
DlgLnkPopResize		: "Promenljiva velicina",
DlgLnkPopLocation	: "Lokacija",
DlgLnkPopMenu		: "Kontekstni meni",
DlgLnkPopScroll		: "Scroll bar",
DlgLnkPopStatus		: "Statusna linija",
DlgLnkPopToolbar	: "Toolbar",
DlgLnkPopFullScrn	: "Prikaz preko celog ekrana (IE)",
DlgLnkPopDependent	: "Zavisno (Netscape)",
DlgLnkPopWidth		: "Širina",
DlgLnkPopHeight		: "Visina",
DlgLnkPopLeft		: "Od leve ivice ekrana (px)",
DlgLnkPopTop		: "Od vrha ekrana (px)",

DlnLnkMsgNoUrl		: "Unesite URL linka",
DlnLnkMsgNoEMail	: "Otkucajte adresu elektronske pote",
DlnLnkMsgNoAnchor	: "Odaberite sidro",

// Color Dialog
DlgColorTitle		: "Odaberite boju",
DlgColorBtnClear	: "Obriši",
DlgColorHighlight	: "Posvetli",
DlgColorSelected	: "Odaberi",

// Smiley Dialog
DlgSmileyTitle		: "Unesi smajlija",

// Special Character Dialog
DlgSpecialCharTitle	: "Odaberite specijalni karakter",

// Table Dialog
DlgTableTitle		: "Osobine tabele",
DlgTableRows		: "Redova",
DlgTableColumns		: "Kolona",
DlgTableBorder		: "Veli�?ina okvira",
DlgTableAlign		: "Ravnanje",
DlgTableAlignNotSet	: "&lt;nije postavljeno&gt;",
DlgTableAlignLeft	: "Levo",
DlgTableAlignCenter	: "Sredina",
DlgTableAlignRight	: "Desno",
DlgTableWidth		: "Širina",
DlgTableWidthPx		: "piksela",
DlgTableWidthPc		: "procenata",
DlgTableHeight		: "Visina",
DlgTableCellSpace	: "Ćelijski prostor",
DlgTableCellPad		: "Razmak ćelija",
DlgTableCaption		: "Naslov tabele",
DlgTableSummary		: "Summary",	//MISSING

// Table Cell Dialog
DlgCellTitle		: "Osobine ćelije",
DlgCellWidth		: "Širina",
DlgCellWidthPx		: "piksela",
DlgCellWidthPc		: "procenata",
DlgCellHeight		: "Visina",
DlgCellWordWrap		: "Deljenje re�?i",
DlgCellWordWrapNotSet	: "&lt;nije postavljeno&gt;",
DlgCellWordWrapYes	: "Da",
DlgCellWordWrapNo	: "Ne",
DlgCellHorAlign		: "Vodoravno ravnanje",
DlgCellHorAlignNotSet	: "&lt;nije postavljeno&gt;",
DlgCellHorAlignLeft	: "Levo",
DlgCellHorAlignCenter	: "Sredina",
DlgCellHorAlignRight: "Desno",
DlgCellVerAlign		: "Vertikalno ravnanje",
DlgCellVerAlignNotSet	: "&lt;nije postavljeno&gt;",
DlgCellVerAlignTop	: "Gornje",
DlgCellVerAlignMiddle	: "Sredina",
DlgCellVerAlignBottom	: "Donje",
DlgCellVerAlignBaseline	: "Bazno",
DlgCellRowSpan		: "Spajanje redova",
DlgCellCollSpan		: "Spajanje kolona",
DlgCellBackColor	: "Boja pozadine",
DlgCellBorderColor	: "Boja okvira",
DlgCellBtnSelect	: "Odaberi...",

// Find Dialog
DlgFindTitle		: "Pronađi",
DlgFindFindBtn		: "Pronađi",
DlgFindNotFoundMsg	: "Traženi tekst nije pronađen.",

// Replace Dialog
DlgReplaceTitle			: "Zameni",
DlgReplaceFindLbl		: "Pronadi:",
DlgReplaceReplaceLbl	: "Zameni sa:",
DlgReplaceCaseChk		: "Razlikuj mala i velika slova",
DlgReplaceReplaceBtn	: "Zameni",
DlgReplaceReplAllBtn	: "Zameni sve",
DlgReplaceWordChk		: "Uporedi cele reci",

// Paste Operations / Dialog
PasteErrorPaste	: "Sigurnosna podešavanja Vašeg pretraživa�?a ne dozvoljavaju operacije automatskog lepljenja teksta. Molimo Vas da koristite pre�?icu sa tastature (Ctrl+V).",
PasteErrorCut	: "Sigurnosna podešavanja Vašeg pretraživa�?a ne dozvoljavaju operacije automatskog isecanja teksta. Molimo Vas da koristite pre�?icu sa tastature (Ctrl+X).",
PasteErrorCopy	: "Sigurnosna podešavanja Vašeg pretraživa�?a ne dozvoljavaju operacije automatskog kopiranja teksta. Molimo Vas da koristite pre�?icu sa tastature (Ctrl+C).",

PasteAsText		: "Zalepi kao �?ist tekst",
PasteFromWord	: "Zalepi iz Worda",

DlgPasteMsg2	: "Molimo Vas da zalepite unutar donje povrine koristeći tastaturnu pre�?icu (<STRONG>Ctrl+V</STRONG>) i da pritisnete <STRONG>OK</STRONG>.",
DlgPasteIgnoreFont		: "Ignoriši definicije fontova",
DlgPasteRemoveStyles	: "Ukloni definicije stilova",
DlgPasteCleanBox		: "Obriši sve",


// Color Picker
ColorAutomatic	: "Automatski",
ColorMoreColors	: "Više boja...",

// Document Properties
DocProps		: "Osobine dokumenta",

// Anchor Dialog
DlgAnchorTitle		: "Osobine sidra",
DlgAnchorName		: "Ime sidra",
DlgAnchorErrorName	: "Unesite ime sidra",

// Speller Pages Dialog
DlgSpellNotInDic		: "Nije u re�?niku",
DlgSpellChangeTo		: "Izmeni",
DlgSpellBtnIgnore		: "Ignoriši",
DlgSpellBtnIgnoreAll	: "Ignoriši sve",
DlgSpellBtnReplace		: "Zameni",
DlgSpellBtnReplaceAll	: "Zameni sve",
DlgSpellBtnUndo			: "Vrati akciju",
DlgSpellNoSuggestions	: "- Bez sugestija -",
DlgSpellProgress		: "Provera spelovanja u toku...",
DlgSpellNoMispell		: "Provera spelovanja završena: greške nisu pronadene",
DlgSpellNoChanges		: "Provera spelovanja završena: Nije izmenjena nijedna rec",
DlgSpellOneChange		: "Provera spelovanja završena: Izmenjena je jedna re�?",
DlgSpellManyChanges		: "Provera spelovanja završena: %1 re�?(i) je izmenjeno",

IeSpellDownload			: "Provera spelovanja nije instalirana. Da li želite da je skinete sa Interneta?",

// Button Dialog
DlgButtonText	: "Tekst (vrednost)",
DlgButtonType	: "Tip",

// Checkbox and Radio Button Dialogs
DlgCheckboxName		: "Naziv",
DlgCheckboxValue	: "Vrednost",
DlgCheckboxSelected	: "Ozna�?eno",

// Form Dialog
DlgFormName		: "Naziv",
DlgFormAction	: "Akcija",
DlgFormMethod	: "Metoda",

// Select Field Dialog
DlgSelectName		: "Naziv",
DlgSelectValue		: "Vrednost",
DlgSelectSize		: "Veli�?ina",
DlgSelectLines		: "linija",
DlgSelectChkMulti	: "Dozvoli višestruku selekciju",
DlgSelectOpAvail	: "Dostupne opcije",
DlgSelectOpText		: "Tekst",
DlgSelectOpValue	: "Vrednost",
DlgSelectBtnAdd		: "Dodaj",
DlgSelectBtnModify	: "Izmeni",
DlgSelectBtnUp		: "Gore",
DlgSelectBtnDown	: "Dole",
DlgSelectBtnSetValue : "Podesi kao ozna�?enu vrednost",
DlgSelectBtnDelete	: "Obriši",

// Textarea Dialog
DlgTextareaName	: "Naziv",
DlgTextareaCols	: "Broj kolona",
DlgTextareaRows	: "Broj redova",

// Text Field Dialog
DlgTextName			: "Naziv",
DlgTextValue		: "Vrednost",
DlgTextCharWidth	: "Širina (karaktera)",
DlgTextMaxChars		: "Maksimalno karaktera",
DlgTextType			: "Tip",
DlgTextTypeText		: "Tekst",
DlgTextTypePass		: "Lozinka",

// Hidden Field Dialog
DlgHiddenName	: "Naziv",
DlgHiddenValue	: "Vrednost",

// Bulleted List Dialog
BulletedListProp	: "Osobine nenabrojive liste",
NumberedListProp	: "Osobine nabrojive liste",
DlgLstType			: "Tip",
DlgLstTypeCircle	: "Krug",
DlgLstTypeDisc		: "Disc",	//MISSING
DlgLstTypeSquare	: "Kvadrat",
DlgLstTypeNumbers	: "Brojevi (1, 2, 3)",
DlgLstTypeLCase		: "mala slova (a, b, c)",
DlgLstTypeUCase		: "VELIKA slova (A, B, C)",
DlgLstTypeSRoman	: "Male rimske cifre (i, ii, iii)",
DlgLstTypeLRoman	: "Velike rimske cifre (I, II, III)",

// Document Properties Dialog
DlgDocGeneralTab	: "Opšte osobine",
DlgDocBackTab		: "Pozadina",
DlgDocColorsTab		: "Boje i margine",
DlgDocMetaTab		: "Metapodaci",

DlgDocPageTitle		: "Naslov stranice",
DlgDocLangDir		: "Smer jezika",
DlgDocLangDirLTR	: "Sleva nadesno (LTR)",
DlgDocLangDirRTL	: "Zdesna nalevo (RTL)",
DlgDocLangCode		: "Šifra jezika",
DlgDocCharSet		: "Kodiranje skupa karaktera",
DlgDocCharSetOther	: "Ostala kodiranja skupa karaktera",

DlgDocDocType		: "Zaglavlje tipa dokumenta",
DlgDocDocTypeOther	: "Ostala zaglavlja tipa dokumenta",
DlgDocIncXHTML		: "Ukljuci XHTML deklaracije",
DlgDocBgColor		: "Boja pozadine",
DlgDocBgImage		: "URL pozadinske slike",
DlgDocBgNoScroll	: "Fiksirana pozadina",
DlgDocCText			: "Tekst",
DlgDocCLink			: "Link",
DlgDocCVisited		: "Posećeni link",
DlgDocCActive		: "Aktivni link",
DlgDocMargins		: "Margine stranice",
DlgDocMaTop			: "Gornja",
DlgDocMaLeft		: "Leva",
DlgDocMaRight		: "Desna",
DlgDocMaBottom		: "Donja",
DlgDocMeIndex		: "Klju�?ne reci za indeksiranje dokumenta (razdvojene zarezima)",
DlgDocMeDescr		: "Opis dokumenta",
DlgDocMeAuthor		: "Autor",
DlgDocMeCopy		: "Autorska prava",
DlgDocPreview		: "Izgled stranice",

// Templates Dialog
Templates			: "Obrasci",
DlgTemplatesTitle	: "Obrasci za sadržaj",
DlgTemplatesSelMsg	: "Molimo Vas da odaberete obrazac koji ce biti primenjen na stranicu (trenutni sadržaj ce biti obrisan):",
DlgTemplatesLoading	: "U�?itavam listu obrazaca. Malo strpljenja...",
DlgTemplatesNoTpl	: "(Nema definisanih obrazaca)",

// About Dialog
DlgAboutAboutTab	: "O editoru",
DlgAboutBrowserInfoTab	: "Informacije o pretraživacu",
DlgAboutVersion		: "verzija",
DlgAboutLicense		: "Licencirano pod uslovima GNU Lesser General Public License",
DlgAboutInfo		: "Za više informacija posetite"
}