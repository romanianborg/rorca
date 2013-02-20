<?php
global $def;
$def=array();

//$def['furt partial fara urme de efractie']='021';
$def['Acte de vandalism']='03';
$def['pierderea cheilor']='07';
$def['Avariere elemente vitrate']="11";
$def['Regres RCA']='12';
$def['Pagube produse numai anvelopelor prin taiere sau intepare']='031';
//$def['Pagube produse numai Jantelor']='032';
//$def['Pagube produse numai capacelor de roti']='033';
$def['Patrunderea vehiculului in locuri inundate']='04';
$def['Circulatia vehiculului in afara drumurilor publice']='05';
$def['Aspiratia apei in motor']='06';
//$def['reintregirea automata a sumei asigurate']='08';
$def['Utilizarea autovehiculului ca instalatie de lucru']="10";
$def['Conducere alte persoane']="13";
$def['Avarii provocate de marfurile transportate']='14';
$def['Daune cu regres service']='15';
$def['Asistenta rutiera extinsa']='16';
$def['Auto la schimb']='17';
$def['Avarii fara accidente (<b>exclude</b> riscul de avarii din accidente la OMNIASIG)']='09';

global $legs;
$legs=array();
//01 avarii
//02 furt
$legs['astra']['03']='i_bifa_02';
$legs['omniasig']['03']='i_bifa_03';
$legs['uniqa']['03']='i_bifa_01';
$legs['generali']['03']='i_bifa_01';
$legs['euroins']['03']='i_bifa_02';
$legs['asirom']['03']='';

$legs['astra']['031']='i_bifa_02';
$legs['omniasig']['031']='i_bifa_031';
$legs['uniqa']['031']='';
$legs['generali']['031']='';
$legs['euroins']['031']='i_bifa_02';
$legs['asirom']['031']='';

$legs['astra']['04']='';
$legs['omniasig']['04']='';
$legs['uniqa']['04']='i_bifa_01';
$legs['generali']['04']='i_bifa_04';
$legs['euroins']['04']='';
$legs['asirom']['04']='i_bifa_04';

$legs['astra']['05']='i_bifa_05';
$legs['omniasig']['05']='i_bifa_05';
$legs['uniqa']['05']='i_bifa_01';
$legs['generali']['05']='';
$legs['euroins']['05']='';
$legs['asirom']['05']='';

$legs['astra']['06']='i_bifa_06';
$legs['omniasig']['06']='i_bifa_06';
$legs['uniqa']['06']='';
$legs['generali']['06']='i_bifa_06';
$legs['euroins']['06']='';
$legs['asirom']['06']='i_bifa_06';

$legs['astra']['07']='i_bifa_07';
$legs['omniasig']['07']='i_bifa_02';
$legs['uniqa']['07']='i_bifa_01';
$legs['generali']['07']='i_bifa_07';
$legs['euroins']['07']='i_bifa_02';
$legs['asirom']['07']='i_bifa_02';

$legs['omniasig']['09']='i_bifa_09';

$legs['omniasig']['10']='i_bifa_10';

$legs['astra']['11']='i_bifa_02';
$legs['omniasig']['11']='i_bifa_11';
$legs['uniqa']['11']='i_bifa_01';
$legs['generali']['11']='i_bifa_01';
$legs['euroins']['11']='i_bifa_02';
$legs['asirom']['11']='';

$legs['astra']['12']='i_bifa_01';
$legs['omniasig']['12']='i_bifa_12';
$legs['uniqa']['12']='i_bifa_01';

$legs['astra']['13']='i_bifa_01';
$legs['omniasig']['13']='i_bifa_13';
$legs['uniqa']['13']='i_bifa_01';
$legs['generali']['13']='i_bifa_01';
$legs['euroins']['13']='i_bifa_01';
$legs['asirom']['13']='i_bifa_01';

$legs['omniasig']['14']='i_bifa_14';
$legs['uniqa']['14']='i_bifa_01';

$legs['omniasig']['15']='i_bifa_15';

$legs['omniasig']['16']='i_bifa_16';
$legs['astra']['16']='i_bifa_16';
$legs['asirom']['16']='i_bifa_16';
$legs['uniqa']['16']='i_bifa_16';
$legs['generali']['16']='i_bifa_16';
$legs['euroins']['16']='i_bifa_16';

$legs['asirom']['17']='i_bifa_17';

?>
