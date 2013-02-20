<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2010
global $_LANG_;
$_LANG_['iname']="Subiect";
$_LANG_['idesc']="Descriere";
$_LANG_['iimage']="Ataseaza imagine";
$_LANG_['idoc']="Ataseaza document";
$_LANG_['ipriority']="Prioritate";

$_LANG_['lowpriority']="Scazuta";
$_LANG_['normalpriority']="Normala";
$_LANG_['urgent']="Urgent";

$_LANG_['iemail']="Email (pentru raspuns)";
$_LANG_['icontactname']="Nume";

$_LANG_['makecontact']="Contacteaza-ne";

$_LANG_['newsdate']="Data";
$_LANG_['newssubject']="Subiect";
$_LANG_['newsmessage']="Stire";

$_LANG_['viewdetails']="Vezi detalii";
$_LANG_['viewcomments']="Vezi Comentarii";
$_LANG_['addcomment']="Commenteaza";

$_LANG_['emailcontact']="Un vizitator te-a contactat.";
$_LANG_['yourmessageissent']="Mesajul tau a fost trimis.";
$_LANG_['issueraised']="Ai un Ticket nou";
$_LANG_['html_makecontact']="html_makecontact_ro";
$_LANG_['html_issueraised']="html_issueraised_ro";

$_LANG_['logo']="Poza/sigla ta";
$_LANG_['regdate']="Descrierea ta";

$_LANG_['activateaccount']="Activeazat-ti contul";
$_LANG_['rcarequest']="Cerere RCA de pe site";
$_LANG_['cascorequest']="Cerere CASCO de pe site";

$_LANG_['forumcoment']="Comentariu";
$_LANG_['forumviews']="Afisari:";
$_LANG_['forumtopics']="Topics:";
$_LANG_['forumcomments']="Comentarii:";
$_LANG_['forumcreation']="Din ";
$_LANG_['answer']="Comentariu";
$_LANG_['postnewtopic']="Adauga un nou subiect";
$_LANG_['posttopic']="Adauga subiectul";

$_LANG_['contactus']="Contacteaza-ne";
$_LANG_['forgotpassword']="Am uitat parola";

$_LANG_['verifypasswordnotmatched']="Parola de test nu se potriveste";
$_LANG_['newusername']="Nume";
$_LANG_['username']="Nume";
$_LANG_['newuseremail']="Email";
$_LANG_['enterpass']="Parola";

$_LANG_['addtocart']="Adauga in cos";
$_LANG_['updateorremove']="Sterse/Salveaza";
$_LANG_['usercategory']="Categorie";
$_LANG_['selectparent']="Alege nivelul";
$_LANG_['pleaseselect']="Alegeti";
$_LANG_['projectdirectory']="Categorii";
$_LANG_['rights']="Drepturi";
$_LANG_['userrights']="Drepturi";
$_LANG_['contracts']="Contracte";
$_LANG_['clients']="Clienti";
$_LANG_['verifypass']="Verifica Parola";
$_LANG_['antiboterror?']="Va rugam sa reveniti";
$_LANG_['order']="Comanda";

$_LANG_['contactname']="Your Name";
$_LANG_['contactemail']="Email";
$_LANG_['contactphone']="Phone";

$_LANG_['orderposted']="Comanda trimisa.";
$_LANG_['news']="Stiri";
$_LANG_['prodattributes']="Date Tehnice";
$_LANG_['produse']="Produse";
$_LANG_['prodoptions']="Optiuni";
$_LANG_['prodname']="Nume Produs";
$_LANG_['proddirectoryid']="Categoria Principala";
$_LANG_['prodtype']="Categorii";
$_LANG_['prodlink']="Link Extern";
$_LANG_['proddesc']="Descriere";
$_LANG_['prodprice']="Pret";
$_LANG_['prodpricetax']="Pret cu taxe";
$_LANG_['dirname']="Categorie";
$_LANG_['dirparentid']="Parinte";
$_LANG_['dirorder']="Ordine";
$_LANG_['diractivated']="Activata";
$_LANG_['newslink']="Link";
$_LANG_['newscategory']="Categorii";
$_LANG_['prodorder']="Ordine";
$_LANG_['prodquantity']="Stoc";
$_LANG_['newsimg']="Imagine";
$_LANG_['newsimg2']="Imagine secundara";
$_LANG_['newsimg3']="Imagine secundara";
$_LANG_['newsimg4']="Imagine secundara";
$_LANG_['newsimg5']="Imagine secundara";
$_LANG_['newsimg6']="Imagine secundara";
$_LANG_['prodimage']="Imagine";
$_LANG_['prodimage2']="Imagine secundara";
$_LANG_['prodimage3']="Imagine secundara";
$_LANG_['prodimage4']="Imagine secundara";
$_LANG_['prodimage5']="Imagine secundara";
$_LANG_['prodimage6']="Imagine secundara";

$_LANG_['astra']="ASTRA";
$_LANG_['carpatica']="CARPATICA";
$_LANG_['euroins']="EUROINS";
$_LANG_['uniqa']="UNIQA";
$_LANG_['grupama']="GROUPAMA";
$_LANG_['allianz']="ALLIANZ";
$_LANG_['asirom']="ASIROM";
$_LANG_['omniasig']="OMNIASIG";
$_LANG_['platinum']="PLATINUM";
$_LANG_['mondial']="MONDIAL";
$_LANG_['bcrasig']="BCR ASIGURARI";
$_LANG_['generali']="GENERALI";
$_LANG_['ardaf']="ARDAF";
$_LANG_['abc']="ABC ASIGURARI";
$_LANG_['city']="CITY INSURANCE";

if(file_exists("cache/language_".getUserConfig('projectid').".php"))
{
	include("cache/language_".getUserConfig('projectid').".php");
}

?>
