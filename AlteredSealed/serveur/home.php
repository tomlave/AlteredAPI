
<script>
function ShowFaction(AX,BR,LY,MU,OR,YZ) {
	document.getElementById("CountAX").innerHTML = AX
	document.getElementById("CountBR").innerHTML = BR
	document.getElementById("CountLY").innerHTML = LY
	document.getElementById("CountMU").innerHTML = MU
	document.getElementById("CountOR").innerHTML = OR
	document.getElementById("CountYZ").innerHTML = YZ
}
</script>
<div class="PAGE">
<div class="Window">

<form action="." method="POST">
	<input class="ButtonCarte" type="submit" name="close" value="Faire un tirage" />
</form>

<div class="FACTION" id="FACTION">
	<div id='FactionAX' class='FactionInfo'>
		<center>
			<img class="imgFaction" src="asset/ui/AXIOM.webp">
			</br>
			<label id="CountAX" class="FactionCount"><b>0</b></label>
		</center>
	</div>
	<div id='FactionBR' class='FactionInfo'>
		<center>
			<img class="imgFaction" src="asset/ui/BRAVOS.webp">
			</br>
			<label id="CountBR" class="FactionCount"><b>0</b></label>
		</center>
	</div>
	<div id='FactionLY' class='FactionInfo'>
		<center>
			<img class="imgFaction" src="asset/ui/LYRA.webp">
			</br>
			<label id="CountLY" class="FactionCount"><b>0</b></label>
		</center>
	</div>
	<div id='FactionMU' class='FactionInfo'>
		<center>
			<img class="imgFaction" src="asset/ui/MUNA.webp">
			</br>
			<label id="CountMU" class="FactionCount"><b>0</b></label>
		</center>
	</div>
	<div id='FactionOR' class='FactionInfo'>
		<center>
			<img class="imgFaction" src="asset/ui/ORDIS.webp">
			</br>
			<label id="CountOR" class="FactionCount"><b>0</b></label>
		</center>
	</div>
	<div id='FactionYZ' class='FactionInfo'>
		<center>
			<img class="imgFaction" src="asset/ui/YZMIR.webp">
			</br>
			<label id="CountYZ" class="FactionCount"><b>0</b></label>
		</center>
	</div>
</div>

<div class="SEALED" id="SEALED">
<?php

$jsonHEROS = file_get_contents('./asset/heros.json');
$jsonCOMMON = file_get_contents('./asset/common.json');
$jsonRARE = file_get_contents('./asset/rare.json');

$HEROS = json_decode($jsonHEROS,true);
$CARTE_COMMON = json_decode($jsonCOMMON,true);
$CARTE_RARE = json_decode($jsonRARE,true);

if(isset($_SESSION["json"])) {
	$DraftJSON = $_SESSION["json"];
 } else {
$DraftJSON = array();

for ($y = 1; $y <= 7; $y++) {
	for ($x = 1; $x <= 9; $x++) {
		shuffle($CARTE_COMMON);
		$DraftJSON[] = $CARTE_COMMON[0];
	}
	for ($x = 1; $x <= 3; $x++) {
		shuffle($CARTE_RARE);
		$DraftJSON[] = $CARTE_RARE[0];
	}
	shuffle($HEROS);
	$DraftJSON[] = $HEROS[0];
}}
sort($DraftJSON);
$_SESSION["json"] = $DraftJSON;
$AX = 0;
$BR = 0;
$LY = 0;
$MU = 0;
$OR = 0;
$YZ = 0;
	for ($z = 0;$z <= count($DraftJSON)-1;$z++){
		if ($DraftJSON[$z][1] == 'AX'){
			$AX = $AX+1;
		}
		if ($DraftJSON[$z][1] == 'BR'){
			$BR = $BR+1;
		}
		if ($DraftJSON[$z][1] == 'LY'){
			$LY = $LY+1;
		}
		if ($DraftJSON[$z][1] == 'MU'){
			$MU = $MU+1;
		}
		if ($DraftJSON[$z][1] == 'OR'){
			$OR = $OR+1;
		}
		if ($DraftJSON[$z][1] == 'YZ'){
			$YZ = $YZ +1;
		}
	echo "<div class='imgAdd' id='SD".$z."' value='".$DraftJSON[$z][0]."'><img onclick='display(".'"asset/TBF/'.$DraftJSON[$z][0].'.png"'.")' class='carte' id='S".$z."' faction='".$DraftJSON[$z][1]."' mana='".$DraftJSON[$z][3]."' src='asset/TBF/".$DraftJSON[$z][0].".png'><button id='SB".$z."' class='ButtonCarte' onclick=swap_sealed(".$z.",".$z.")>Ajouter</button></div>";
	}
echo "<script>ShowFaction(".$AX.",".$BR.",".$LY.",".$MU.",".$OR.",".$YZ.")</script>";

?>
</div>
</div>

<div class="Window" >
	<center><button class='ButtonCarte' onclick='exporter()'>Exporter</button></center>
	</br>
	<div class="FACTION_DECK">
		<img class="imgFactionDeck" id="FactionDeckAX" src="asset/ui/AXIOM.webp">
		<img class="imgFactionDeck" id="FactionDeckBR" src="asset/ui/BRAVOS.webp">
		<img class="imgFactionDeck" id="FactionDeckLY" src="asset/ui/LYRA.webp">
		<img class="imgFactionDeck" id="FactionDeckMU" src="asset/ui/MUNA.webp">
		<img class="imgFactionDeck" id="FactionDeckOR" src="asset/ui/ORDIS.webp">
		<img class="imgFactionDeck" id="FactionDeckYZ" src="asset/ui/YZMIR.webp">
	</div>
	<center><div class="deck_count"><label>le deck contient: </label><label id="count" value="0">0</label></center>
	<div class="DECK">

	<div id='hand0' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/x.svg"></center>
	</div>
	<div id='hand1' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/1.svg"></center>
	</div>
	<div id='hand2' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/2.svg"></center>
	</div>
	<div id='hand3' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/3.svg"></center>
	</div>
	<div id='hand4' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/4.svg"></center>
	</div>
	<div id='hand5' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/5.svg"></center>
	</div>
	<div id='hand6' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/6.svg"></center>
	</div>
	<div id='hand7' class='ManaCost'>
		<center><img class="imgHand" src="asset/ui/7.svg"></center>
	</div>

	</div>
</div>

</div>

<script>
function display(asset) {
	const vue_carte = document.getElementById("vue_carte")
	const vue_asset = document.getElementById("vue_asset")
	vue_asset.setAttribute('style',"")
	vue_carte.setAttribute('src',asset)
}
function shadow() {
	const vue_asset = document.getElementById("vue_asset")
	vue_asset.setAttribute('style',"display:none;")
}
function swap_sealed(id,id_button) {
	const object_div = document.getElementById("SD"+id)
	const image = document.getElementById("S"+id)
	const faction = document.getElementById("Count"+image.getAttribute('faction'))
	faction.innerHTML = parseInt(faction.innerHTML)-1
	var mana = image.getAttribute('mana')
	if (mana >= 7) {
		mana = '7'
	}
	const element = document.getElementById("hand"+mana)
	const new_div = document.createElement('div')
	const new_img = document.createElement('img')
	const new_button = document.createElement('button')
	const new_text_button = document.createTextNode('Supprimer')
	new_div.setAttribute('class','imgAdd')
	new_div.setAttribute('id','DD'+id)
	console.log((element.childNodes.length)-2)
	 // if(element.childNodes.length-2 >= 2) {
		  // new_div.setAttribute('style','top:-'+0.75*(element.childNodes.length-2)+'rem;position:relative;')
	  // }
	new_div.setAttribute('value',object_div.getAttribute('value'))
	new_div.setAttribute('faction',image.getAttribute('faction'))
	new_img.setAttribute('class','carte')
	new_img.setAttribute('faction',image.getAttribute('faction'))
	new_img.setAttribute('mana',mana)
	new_img.setAttribute('id',"D"+id)
	new_img.setAttribute('onclick','display("'+image.getAttribute('src')+'")')
	new_img.setAttribute('src',image.getAttribute('src'))
	new_button.setAttribute('onclick','swap_deck('+id+','+id_button+')')
	new_button.setAttribute('class','ButtonCarte')
	new_button.setAttribute('id','DB'+id_button)
	new_button.appendChild(new_text_button)
	new_div.appendChild(new_img)
	new_div.appendChild(new_button)
	element.appendChild(new_div)
	object_div.remove()
	reload(+1)
}
function swap_deck(id,id_button) {
	const object_div = document.getElementById("DD"+id)
	const image = document.getElementById("D"+id)
	const faction = document.getElementById("Count"+image.getAttribute('faction'))
	faction.innerHTML = parseInt(faction.innerHTML)+1
	var mana = image.getAttribute('mana')
	if (mana >= 7) {
		mana = '7'
	}
	const element = document.getElementById("SEALED")
	const new_div = document.createElement('div')
	const new_img = document.createElement('img')
	const new_button = document.createElement('button')
	const new_text_button = document.createTextNode('Ajouter')
	new_div.setAttribute('class','imgAdd')
	new_div.setAttribute('id','SD'+id)
	new_div.setAttribute('value',object_div.getAttribute('value'))
	new_div.setAttribute('faction',image.getAttribute('faction'))
	new_img.setAttribute('class','carte')
	new_img.setAttribute('faction',image.getAttribute('faction'))
	new_img.setAttribute('mana',mana)
	new_img.setAttribute('id',"S"+id)
	new_img.setAttribute('onclick','display("'+image.getAttribute('src')+'")')
	new_img.setAttribute('src',image.getAttribute('src'))
	new_button.setAttribute('onclick','swap_sealed('+id+','+id_button+')')
	new_button.setAttribute('class','ButtonCarte')
	new_button.setAttribute('id','SB'+id_button)
	new_button.appendChild(new_text_button)
	new_div.appendChild(new_img)
	new_div.appendChild(new_button)
	element.insertBefore(new_div,element.childNodes[id+1])
	object_div.remove()
	reload(-1)
}
function reload(value) {
	var container = document.getElementById("count");
	var newValue = parseInt(container.getAttribute('value'))+parseInt(value)
	container.setAttribute('value',newValue)
	container.innerHTML = newValue;

}
function test_faction() {
	var countFactionDeck = {'AX':0,'BR':0,'LY':0,'MU':0,'OR':0,'YZ':0}
	for (let h = 0; h <= 7; h++){
		for (let i = 3; i < document.getElementById('hand'+h).childNodes.length; i++) {
			var CarteFaction = document.getElementById('hand'+h).childNodes[i].getAttribute('faction')
			 countFactionDeck[CarteFaction] = countFactionDeck[CarteFaction]+1
		}
	}
	if (countFactionDeck['AX'] <= 1) {
		document.getElementById['FactionDeckAX'].setAttribute('style','filter: grayscale(0%)')
	}
	console.log(countFactionDeck)
}
function exporter(message) {
	test_faction()
	var message_txt = ''
	for (let h = 0; h <= 7; h++){
		for (let i = 3; i < document.getElementById('hand'+h).childNodes.length; i++) {
			var deckList = document.getElementById('hand'+h).childNodes[i].getAttribute('value')
			 message_txt = message_txt+'\n'+deckList
		}
	}
	window.alert(message_txt);
}

</script>

<div class="scolling" id="vue_asset" onclick=shadow() style="display: none;">
<center><img class="imageView" id="vue_carte" src="asset/TBF/TBF-004-F-FR.png"></center>
</div>
