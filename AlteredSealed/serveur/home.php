
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
	<select id='SelectSET' class="ButtonCarte" name="SetSET">
		<option value="TBF">L'Epreuve du Froid</option>
		<option value="BTG">Au-delà des portes</option>
	</select>
	<input class="ButtonCarte" style="top:0rem;" type="submit" name="close" value="Faire un tirage" />
</form>
<div class="STATUS">
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
<div>
	<select class="ButtonFiltre" id="FiltreValue">
		<option value="div_value">Par défaut</option>
		<option value="img_faction">Faction</option>
		<option value="img_mana,asc">Mana asc</option>
		<option value="img_mana,desc">Mana desc</option>
		<option value="img_reserve,asc">Réserve asc</option>
		<option value="img_reserve,desc">Réserve desc</option>
	</select>
</div>
</div>
<div class="SEALED" id="SEALED">
<?php

if(isset($_SESSION["SetSET"])) {
	$SET = $_SESSION['SetSET'];
} else {
	if(isset($_POST['SetSET'])){
		$SET = $_POST['SetSET'];
	} else {
		$SET = 'TBF';
	}
	$_SESSION['SetSET'] = $SET;
}
if(isset($_SESSION["jsonSealed"])) {
	$SealedJSON = $_SESSION["jsonSealed"];
 } else {
$SealedJSON = array();

$jsonHEROS = file_get_contents('./asset/'.$SET.'heros.json');
$jsonCOMMON = file_get_contents('./asset/'.$SET.'common.json');
$jsonRARE = file_get_contents('./asset/'.$SET.'rare.json');

$HEROS = json_decode($jsonHEROS,true);
$CARTE_COMMON = json_decode($jsonCOMMON,true);
$CARTE_RARE = json_decode($jsonRARE,true);

for ($y = 1; $y <= 7; $y++) {
	for ($x = 1; $x <= 9; $x++) {
		shuffle($CARTE_COMMON);
		$SealedJSON[] = $CARTE_COMMON[0];
	}
	for ($x = 1; $x <= 3; $x++) {
		shuffle($CARTE_RARE);
		$SealedJSON[] = $CARTE_RARE[0];
	}
	shuffle($HEROS);
	$SealedJSON[] = $HEROS[0];
}}
sort($SealedJSON);
$_SESSION["jsonSealed"] = $SealedJSON;
$AX = 0;
$BR = 0;
$LY = 0;
$MU = 0;
$OR = 0;
$YZ = 0;
	for ($z = 0;$z <= count($SealedJSON)-1;$z++){
		if ($SealedJSON[$z][1] == 'AX'){
			$AX = $AX+1;
		}
		if ($SealedJSON[$z][1] == 'BR'){
			$BR = $BR+1;
		}
		if ($SealedJSON[$z][1] == 'LY'){
			$LY = $LY+1;
		}
		if ($SealedJSON[$z][1] == 'MU'){
			$MU = $MU+1;
		}
		if ($SealedJSON[$z][1] == 'OR'){
			$OR = $OR+1;
		}
		if ($SealedJSON[$z][1] == 'YZ'){
			$YZ = $YZ +1;
		}
	echo "<div class='imgAdd' id='SD".$z."' faction='".$SealedJSON[$z][1]."' value='".$SealedJSON[$z][5]."' forest='".$SealedJSON[$z][6]."' mountain='".$SealedJSON[$z][7]."' ocean='".$SealedJSON[$z][8]."'><img onclick=".'"display('."'".$SealedJSON[$z][10]."'".')"'." class='carte' id='S".$z."' faction='".$SealedJSON[$z][1]."' mana='".$SealedJSON[$z][3]."' reserve='".$SealedJSON[$z][4]."' src='".$SealedJSON[$z][10]."'><button id='SB".$z."' class='ButtonCarte' onclick=swap_sealed(".$z.",".$z.")><p>Ajouter<p></button></div>";
	}
echo "</div><script>ShowFaction(".$AX.",".$BR.",".$LY.",".$MU.",".$OR.",".$YZ.")</script>";

?>
</div>

<div class="Window" >
	<center>
		<button class='ButtonUI' onclick='exporter()'>Exporter</button>
		<button class='ButtonUI' onclick='playdeck()'>Tester le deck</button>
	</center>
	</br>
	<div class="DECK_STATUE">
	<div class="FACTION_DECK">
		<img class="imgFactionDeck" id="FactionDeckAX" src="asset/ui/AXIOM.webp">
		<img class="imgFactionDeck" id="FactionDeckBR" src="asset/ui/BRAVOS.webp">
		<img class="imgFactionDeck" id="FactionDeckLY" src="asset/ui/LYRA.webp">
		<img class="imgFactionDeck" id="FactionDeckMU" src="asset/ui/MUNA.webp">
		<img class="imgFactionDeck" id="FactionDeckOR" src="asset/ui/ORDIS.webp">
		<img class="imgFactionDeck" id="FactionDeckYZ" src="asset/ui/YZMIR.webp">
	</div>
	<div class="STASTISTIQUES">
		<div class="FOREST">
			<hgroup>
				<span class="LandValue" id="ForestID">0</span>
				<h6 class="LandName">Forêt</h6>
			</hgroup>
			<img class="imgAttributs" src="asset/ui/forest.svg">
		</div>
		<div class="MONTAGNE">
			<hgroup>
				<span class="LandValue" id="MountainID">0</span>
				<h6 class="LandName">Montagne</h6>
			</hgroup>
			<img class="imgAttributs" src="asset/ui/mountain.svg">
		</div>
		<div class="OCEAN">
			<hgroup>
				<span class="LandValue" id="OceanID">0</span>
				<h6 class="LandName">Ocean</h6>
			</hgroup>
			<img class="imgAttributs" src="asset/ui/water.svg">
		</div>
	</div>
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
function playdeck() {
	var escape = '%0A'
	var espace = '%20'
	var deck_test = ""
	const DeckTeck = []
	// const ExportDeck = []
	for (let h = 0; h <= 7; h++){
		for (let i = 3; i < document.getElementById('hand'+h).childNodes.length; i++) {
			var deckList = document.getElementById('hand'+h).childNodes[i].getAttribute('value')
			DeckTeck.push([deckList,1])
		}
	}
	DeckTeck.sort()

	// TESTING SECTION
	for (var i = 0; i < DeckTeck.length; i = i + count) {
		count = 1;
		test = [];
		test.push(DeckTeck[i][0]);
		for (var j = i + 1; j < DeckTeck.length; j++) {
			if (DeckTeck[i][0] === DeckTeck[j][0]){
				count++;
				test.push(DeckTeck[j][1]);
			}
		}
		deck_test = deck_test+escape+count+espace+DeckTeck[i][0]
	}
	window.open('https://exalts-table.com/deck-test/link/?decklist='+deck_test)
}
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
	new_div.setAttribute('value',object_div.getAttribute('value'))
	new_div.setAttribute('faction',image.getAttribute('faction'))
	new_div.setAttribute('forest',object_div.getAttribute('forest'))
	new_div.setAttribute('mountain',object_div.getAttribute('mountain'))
	new_div.setAttribute('ocean',object_div.getAttribute('ocean'))
	new_img.setAttribute('class','carte')
	new_img.setAttribute('faction',image.getAttribute('faction'))
	new_img.setAttribute('mana',mana)
	new_img.setAttribute('reserve',image.getAttribute('reserve'))
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
	test_faction()
	test_attribue()
	session_send(id,id_button)
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
	new_div.setAttribute('forest',object_div.getAttribute('forest'))
	new_div.setAttribute('mountain',object_div.getAttribute('mountain'))
	new_div.setAttribute('ocean',object_div.getAttribute('ocean'))
	new_img.setAttribute('class','carte')
	new_img.setAttribute('faction',image.getAttribute('faction'))
	new_img.setAttribute('mana',mana)
	new_img.setAttribute('reserve',image.getAttribute('reserve'))
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
	test_faction()
	test_attribue()
	session_undo(id,id_button)
}
function reload(value) {
	var container = document.getElementById("count");
	var newValue = parseInt(container.getAttribute('value'))+parseInt(value)
	container.setAttribute('value',newValue)
	container.innerHTML = newValue;
}
session_load()
function session_load() {
	const SELECT = document.getElementById("SelectSET")
	for(var i=0;i<SELECT.options.length;i++){
		if (SELECT.options[i].innerHTML == '<?php echo $SET; ?>') {
			SELECT.selectedIndex = i;
			break;
		}
	}
	if (sessionStorage.getItem("DECK") == null) {
		sessionStorage.DECK = []
	} else {
		var DeckSession = sessionStorage.getItem("DECK").split(",")
		var DECK = chunk(DeckSession,2)
		for (i = 0; i < DECK.length ;i++ ) {
			if (DECK[i][0] !== ""){
				var id = DECK[i][0]
				var id_button = DECK[i][1]
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
				new_div.setAttribute('value',object_div.getAttribute('value'))
				new_div.setAttribute('faction',image.getAttribute('faction'))
				new_div.setAttribute('forest',object_div.getAttribute('forest'))
				new_div.setAttribute('mountain',object_div.getAttribute('mountain'))
				new_div.setAttribute('ocean',object_div.getAttribute('ocean'))
				new_img.setAttribute('class','carte')
				new_img.setAttribute('faction',image.getAttribute('faction'))
				new_img.setAttribute('mana',mana)
				new_img.setAttribute('reserve',image.getAttribute('reserve'))
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
				test_faction()
				test_attribue()
			}
		}
	}
}
function session_send(id,id_button) {
	var DeckSession = sessionStorage.getItem("DECK").split(",")
	if (DeckSession == "") {
		sessionStorage.setItem("DECK",[id,id_button])
	} else {
		sessionStorage.setItem("DECK",DeckSession+","+[id,id_button])
	}
}

function session_undo(id,id_button) {
	var DeckSession = sessionStorage.getItem("DECK").split(",")
	var DECK = chunk(DeckSession,2)
	for (i = 0; i < DECK.length ;i++ ) {
		if(id == DECK[i][0]) {
			DECK.splice(i,1)
		}
	}
	sessionStorage.setItem("DECK",DECK)
}
function chunk(arr, chunkSize) {
  if (chunkSize <= 0) throw "Invalid chunk size";
  var R = [];
  for (var i=0,len=arr.length; i<len; i+=chunkSize)
    R.push(arr.slice(i,i+chunkSize));
  return R;
}
function test_attribue() {
	var countAttribueDeck = {'forest':0,'mountain':0,'ocean':0}
	for (let h = 0; h <= 7; h++){
		for (let i = 3; i < document.getElementById('hand'+h).childNodes.length; i++) {
			countAttribueDeck['forest'] = countAttribueDeck['forest']+parseInt(document.getElementById('hand'+h).childNodes[i].getAttribute('forest'))
			countAttribueDeck['mountain'] = countAttribueDeck['mountain']+parseInt(document.getElementById('hand'+h).childNodes[i].getAttribute('mountain'))
			countAttribueDeck['ocean'] = countAttribueDeck['ocean']+parseInt(document.getElementById('hand'+h).childNodes[i].getAttribute('ocean'))
		}
	}
	document.getElementById('ForestID').innerHTML = countAttribueDeck['forest']
	document.getElementById('MountainID').innerHTML = countAttribueDeck['mountain']
	document.getElementById('OceanID').innerHTML = countAttribueDeck['ocean']
}
function test_faction() {
	var countFactionDeck = {'AX':0,'BR':0,'LY':0,'MU':0,'OR':0,'YZ':0}
	for (let h = 0; h <= 7; h++){
		for (let i = 3; i < document.getElementById('hand'+h).childNodes.length; i++) {
			var CarteFaction = document.getElementById('hand'+h).childNodes[i].getAttribute('faction')
			 countFactionDeck[CarteFaction] = countFactionDeck[CarteFaction]+1
		}
	}
	if (countFactionDeck['AX'] >= 1) {
		document.getElementById('FactionDeckAX').setAttribute('style','filter: grayscale(0%);')
	} else {
		document.getElementById('FactionDeckAX').setAttribute('style','filter: grayscale(100%);')
	}
	if (countFactionDeck['BR'] >= 1) {
		document.getElementById('FactionDeckBR').setAttribute('style','filter: grayscale(0%);')
	} else {
		document.getElementById('FactionDeckBR').setAttribute('style','filter: grayscale(100%);')
	}
	if (countFactionDeck['LY'] >= 1) {
		document.getElementById('FactionDeckLY').setAttribute('style','filter: grayscale(0%);')
	} else {
		document.getElementById('FactionDeckLY').setAttribute('style','filter: grayscale(100%);')
	}
	if (countFactionDeck['MU'] >= 1) {
		document.getElementById('FactionDeckMU').setAttribute('style','filter: grayscale(0%);')
	} else {
		document.getElementById('FactionDeckMU').setAttribute('style','filter: grayscale(100%);')
	}
	if (countFactionDeck['OR'] >= 1) {
		document.getElementById('FactionDeckOR').setAttribute('style','filter: grayscale(0%);')
	} else {
		document.getElementById('FactionDeckOR').setAttribute('style','filter: grayscale(100%);')
	}
	if (countFactionDeck['YZ'] >= 1) {
		document.getElementById('FactionDeckYZ').setAttribute('style','filter: grayscale(0%);')
	} else {
		document.getElementById('FactionDeckYZ').setAttribute('style','filter: grayscale(100%);')
	}
	// console.log(countFactionDeck)
}
document.getElementById("FiltreValue").onchange = filtre;
function filtre() {
	const SEALED = document.getElementById('SEALED')
	var CountSealed = SEALED.childNodes.length-2
	var Carte = {}
	const AllCarte = []
	for (let h = 0; h <= CountSealed+1; h++){
		if (SEALED.childNodes[h].nodeType != 3) {
			var div_id = SEALED.childNodes[h].getAttribute('id')
			var div_value = SEALED.childNodes[h].getAttribute('value')
			var div_faction = SEALED.childNodes[h].getAttribute('faction')
			var div_forest = SEALED.childNodes[h].getAttribute('forest')
			var div_mountain = SEALED.childNodes[h].getAttribute('mountain')
			var div_ocean = SEALED.childNodes[h].getAttribute('ocean')
			var img_onclick = (SEALED.childNodes[h].childNodes[0].getAttribute('onclick'))
			var img_id = (SEALED.childNodes[h].childNodes[0].getAttribute('id'))
			var img_faction = (SEALED.childNodes[h].childNodes[0].getAttribute('faction'))
			var img_mana = (SEALED.childNodes[h].childNodes[0].getAttribute('mana'))
			var img_reserve = (SEALED.childNodes[h].childNodes[0].getAttribute('reserve'))
			var img_src = (SEALED.childNodes[h].childNodes[0].getAttribute('src'))
			var but_id = SEALED.childNodes[h].childNodes[1].getAttribute('id')
			var but_onclick = SEALED.childNodes[h].childNodes[1].getAttribute('onclick')
			Carte = {div_id,div_value,div_faction,div_forest,div_mountain,div_ocean,img_onclick,img_id,img_faction,img_mana,img_reserve,img_src,but_id,but_onclick}
			AllCarte.push(Carte)
		}
	}

	var ValueFiltre = (document.getElementById("FiltreValue").value)
	if ((ValueFiltre.split(",")).length <= 2) {
		var sortType = ValueFiltre.split(",")[1]
		ValueFiltre = ValueFiltre.split(",")[0]
		if (sortType == "desc") {
			AllCarte.sort((a, b) => (a[ValueFiltre] < b[ValueFiltre]) ? 1 : ((b[ValueFiltre] < a[ValueFiltre]) ? -1 : 0))
		} else {
			AllCarte.sort((a, b) => (a[ValueFiltre] > b[ValueFiltre]) ? 1 : ((b[ValueFiltre] > a[ValueFiltre]) ? -1 : 0))
		}
	} else {
		AllCarte.sort((a, b) => (a[ValueFiltre] > b[ValueFiltre]) ? 1 : ((b[ValueFiltre] > a[ValueFiltre]) ? -1 : 0))
	}
	for (let h = 0; h <= AllCarte.length-1; h++){
		document.getElementById(AllCarte[h]['div_id']).remove()
		const new_div = document.createElement('div')
		const new_img = document.createElement('img')
		const new_button = document.createElement('button')
		const new_text_button = document.createTextNode('Ajouter')
		new_div.setAttribute('class','imgAdd')
		new_div.setAttribute('id',AllCarte[h]['div_id'])
		new_div.setAttribute('value',AllCarte[h]['div_value'])
		new_div.setAttribute('faction',AllCarte[h]['div_faction'])
		new_div.setAttribute('forest',AllCarte[h]['div_forest'])
		new_div.setAttribute('mountain',AllCarte[h]['div_mountain'])
		new_div.setAttribute('ocean',AllCarte[h]['div_ocean'])
		new_img.setAttribute('class','carte')
		new_img.setAttribute('faction',AllCarte[h]['img_faction'])
		new_img.setAttribute('mana',AllCarte[h]['img_mana'])
		new_img.setAttribute('reserve',AllCarte[h]['img_reserve'])
		new_img.setAttribute('id',AllCarte[h]['img_id'])
		new_img.setAttribute('onclick',AllCarte[h]['img_onclick'])
		new_img.setAttribute('src',AllCarte[h]['img_src'])
		new_button.setAttribute('onclick',AllCarte[h]['but_onclick'])
		new_button.setAttribute('class','ButtonCarte')
		new_button.setAttribute('id',AllCarte[h]['but_id'])
		new_button.appendChild(new_text_button)
		new_div.appendChild(new_img)
		new_div.appendChild(new_button)
		SEALED.insertBefore(new_div,SEALED.childNodes[h])
	}
}
function exporter(message) {
	var message_txt = ''
	const DeckTeck = []
	// const ExportDeck = []
	for (let h = 0; h <= 7; h++){
		for (let i = 3; i < document.getElementById('hand'+h).childNodes.length; i++) {
			var deckList = document.getElementById('hand'+h).childNodes[i].getAttribute('value')
			DeckTeck.push([deckList,1])
		}
	}
	DeckTeck.sort()

	// TESTING SECTION
	for (var i = 0; i < DeckTeck.length; i = i + count) {
		count = 1;
		test = [];
		test.push(DeckTeck[i][0]);
		for (var j = i + 1; j < DeckTeck.length; j++) {
			if (DeckTeck[i][0] === DeckTeck[j][0]){
				count++;
				test.push(DeckTeck[j][1]);
			}
		}
		message_txt = message_txt+'\n'+count+" "+DeckTeck[i][0]
	}
	alert(message_txt);
}

</script>

<div class="scolling" id="vue_asset" onclick=shadow() style="display: none;">
<center><img class="imageView" id="vue_carte" src=""></center>
</div>
