<?php

use Pokemon\Pokemon;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Change 'verify' option to true to fix the following error:
 *
 * Fatal error: Uncaught exception 'GuzzleHttp\Exception\ConnectException' with message
 * 'cURL error 35: Unknown SSL protocol error in connection to api.pokemontcg.io:-9838
 * (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)'
 */
$options = ['verify' => false];

/**
 * Get a single card
 */
//$response = Pokemon::Card($options)->find('xy7-54');

//$response = Pokemon::Card($options)->all();
// $i = 0;

for($i=0; $i<=1000; $i++){


$cards = Pokemon::Card($options)->where([
    'page'     => $i,
    'pageSize' => 1000
])->all();
// $response = $response->toJson();
 
// echo "<pre>";
// print_r($response); 
// echo "</pre>";
// exit;

foreach ($cards as $model) {

// echo "<pre>";
// print_r($model->toJson()); 
// echo "</pre>";
// exit;

$model = $model->toJson();
$obj = json_decode($model);
//$model = json_decode($model);

$card_name = @$obj->name;
$card_name = trim(str_replace("  ", ' ', $card_name));
$card_name = str_replace(array("`,′"), "", $card_name);
$card_name = str_replace(array("'"), "''", $card_name);
if(empty($card_name)){
	$card_name = "";
}
//var_dump($card_name);exit;

$card_id = @$obj->id;
$card_id = trim(str_replace("  ", ' ', $card_id));
$card_id = str_replace(array("`,′"), "", $card_id);
$card_id = str_replace(array("'"), "''", $card_id);
if(empty($card_id)){
	$card_id = "";
}
$nationalPokedexNumber = $obj->nationalPokedexNumber;
$nationalPokedexNumber = trim(str_replace("  ", ' ', $nationalPokedexNumber));
$nationalPokedexNumber = str_replace(array("`,′"), "", $nationalPokedexNumber);
$nationalPokedexNumber = str_replace(array("'"), "''", $nationalPokedexNumber);
if(empty($nationalPokedexNumber)){
	$nationalPokedexNumber = "";
}
$hp_type = @$obj->hp; //CardType on top right corner of card
$hp_type = trim(str_replace("  ", ' ', $hp_type));
$hp_type = str_replace(array("`,′"), "", $hp_type);
$hp_type = str_replace(array("'"), "''", $hp_type);
if(empty($hp_type)){
	$hp_type = "";
}
$subtype = @$obj->subtype;
$subtype = trim(str_replace("  ", ' ', $subtype));
$subtype = str_replace(array("`,′"), "", $subtype);
$subtype = str_replace(array("'"), "''", $subtype);
if(empty($subtype)){
	$subtype = "";
}
$supertype = @$obj->supertype;
$supertype = trim(str_replace("  ", ' ', $supertype));
$supertype = str_replace(array("`,′"), "", $supertype);
$supertype = str_replace(array("'"), "''", $supertype);
if(empty($supertype)){
	$supertype = "";
}
$card_number = @$obj->number;//CardType on bottom right corner of card
$card_number = trim(str_replace("  ", ' ', $card_number));
$card_number = str_replace(array("`,′"), "", $card_number);
$card_number = str_replace(array("'"), "''", $card_number);
if(empty($card_number)){
	$card_number = "";
}
$artist = @$obj->artist;
$artist = trim(str_replace("  ", ' ', $artist));
$artist = str_replace(array("`,′"), "", $artist);
$artist = str_replace(array("'"), "''", $artist);
if(empty($artist)){
	$artist = "";
}
$rarity = @$obj->rarity;
$rarity = trim(str_replace("  ", ' ', $rarity));
$rarity = str_replace(array("`,′"), "", $rarity);
$rarity = str_replace(array("'"), "''", $rarity);
if(empty($rarity)){
	$rarity = "";
}
$series = @$obj->series;
$series = trim(str_replace("  ", ' ', $series));
$series = str_replace(array("`,′"), "", $series);
$series = str_replace(array("'"), "''", $series);
if(empty($series)){
	$series = "";
}
$set = @$obj->set;
$set = trim(str_replace("  ", ' ', $set));
$set = str_replace(array("`,′"), "", $set);
$set = str_replace(array("'"), "''", $set);
if(empty($set)){
	$set = "";
}
$setCode = @$obj->setCode;
$setCode = trim(str_replace("  ", ' ', $setCode));
$setCode = str_replace(array("`,′"), "", $setCode);
$setCode = str_replace(array("'"), "''", $setCode);
if(empty($setCode)){
	$setCode = "";
}
$retreatCostColor = @$obj->retreatCost[0];
$retreatCostColor = trim(str_replace("  ", ' ', $retreatCostColor));
$retreatCostColor = str_replace(array("`,′"), "", $retreatCostColor);
$retreatCostColor = str_replace(array("'"), "''", $retreatCostColor);
if(empty($retreatCostColor)){
	$retreatCostColor = "";
}

//$retreatCostColor2 = $obj->retreatCost'][1];

$card_text = @$obj->text[0];
//var_dump($card_text); exit;
$card_text = trim(str_replace("  ", ' ', $card_text));
$card_text = str_replace(array("`,′"), "", $card_text);
$card_text = str_replace(array("'"), "''", $card_text);
if(empty($card_text)){
	$card_text = "";
}
//var_dump($card_text);
$attacks_name = @$obj->attacks[0]->name;
$attacks_name = trim(str_replace("  ", ' ', $attacks_name));
$attacks_name = str_replace(array("`,′"), "", $attacks_name);
$attacks_name = str_replace(array("'"), "''", $attacks_name);
if(empty($attacks_name)){
	$attacks_name = "";
}
//var_dump($attacks_name);exit;
$attack_text = @$obj->attacks[0]->text;
$attack_text = trim(str_replace("  ", ' ', $attack_text));
$attack_text = str_replace(array("`,′"), "", $attack_text);
$attack_text = str_replace(array("'"), "''", $attack_text);
if(empty($attack_text)){
	$attack_text = "";
}
$attacks_damage = @$obj->attacks[0]->damage;
$attacks_damage = trim(str_replace("  ", ' ', $attacks_damage));
$attacks_damage = str_replace(array("`,′"), "", $attacks_damage);
$attacks_damage = str_replace(array("'"), "''", $attacks_damage);
if(empty($attacks_damage)){
	$attacks_damage = "";
}
$convertedretreatcost = @$obj->attacks[0]->convertedEnergyCost; //convertedretreatCost
$convertedretreatcost = trim(str_replace("  ", ' ', $convertedretreatcost));
$convertedretreatcost = str_replace(array("`,′"), "", $convertedretreatcost);
$convertedretreatcost = str_replace(array("'"), "''", $convertedretreatcost);
if(empty($convertedretreatcost)){
	$convertedretreatcost = "";
}
$attact_cost = @$obj->attacks[0]->cost[0]; //attack cost
$attact_cost = trim(str_replace("  ", ' ', $attact_cost));
$attact_cost = str_replace(array("`,′"), "", $attact_cost);
$attact_cost = str_replace(array("'"), "''", $attact_cost);
if(empty($attact_cost)){
	$attact_cost = "";
}
$weaknessesTypeValue = @$obj->weaknesses[0]->type.' '.@$obj->weaknesses[0]->value;
$weaknessesTypeValue = trim(str_replace("  ", ' ', $weaknessesTypeValue));
$weaknessesTypeValue = str_replace(array("`,′"), "", $weaknessesTypeValue);
$weaknessesTypeValue = str_replace(array("'"), "''", $weaknessesTypeValue);
if(empty($weaknessesTypeValue)){
	$weaknessesTypeValue = "";
}
$resistancesTypeValue = @$obj->resistances[0]->type.' '.@$obj->resistances[0]->value;
$resistancesTypeValue = trim(str_replace("  ", ' ', $resistancesTypeValue));
$resistancesTypeValue = str_replace(array("`,′"), "", $resistancesTypeValue);
$resistancesTypeValue = str_replace(array("'"), "''", $resistancesTypeValue);
if(empty($resistancesTypeValue)){
	$resistancesTypeValue = "";
}
//$resistancesValue = $obj->resistances'][0]['value'];
//$weaknessesValue = $obj->weaknesses'][0]['value'];
//var_dump($convertedretreatcost);exit;

$abilityName = @$obj->ability->name;

$abilityName = trim(str_replace("  ", ' ', $abilityName));
$abilityName = str_replace(array("`,′"), "", $abilityName);
$abilityName = str_replace(array("'"), "''", $abilityName);
if(empty($abilityName)){
	$abilityName = "";
}
//var_dump($abilityName);exit;
$abilityText = @$obj->ability->text;
$abilityText = trim(str_replace("  ", ' ', $abilityText));
$abilityText = str_replace(array("`,′"), "", $abilityText);
$abilityText = str_replace(array("'"), "''", $abilityText);
if(empty($abilityText)){
	$abilityText = "";
}
//var_dump($abilityText);exit;
$abilityType = @$obj->ability->type;
$abilityType = trim(str_replace("  ", ' ', $abilityType));
$abilityType = str_replace(array("`,′"), "", $abilityType);
$abilityType = str_replace(array("'"), "''", $abilityType);
if(empty($abilityType)){
	$abilityType = "";
}
$imageUrl = @$obj->imageUrl;
$imageUrl = trim(str_replace("  ", ' ', $imageUrl));
$imageUrl = str_replace(array("`,′"), "", $imageUrl);
$imageUrl = str_replace(array("'"), "''", $imageUrl);
if(empty($imageUrl)){
	$imageUrl = "";
}
$imageUrlHiRes = @$obj->imageUrlHiRes;
$imageUrlHiRes = trim(str_replace("  ", ' ', $imageUrlHiRes));
$imageUrlHiRes = str_replace(array("`,′"), "", $imageUrlHiRes);
$imageUrlHiRes = str_replace(array("'"), "''", $imageUrlHiRes);
if(empty($imageUrlHiRes)){
	$imageUrlHiRes = "";
}
$ancientTrait = @$obj->ancientTrait;
// $ancientTrait = trim(str_replace("  ", ' ', $ancientTrait));
// $ancientTrait = str_replace(array("`,′"), "", $ancientTrait);
// $ancientTrait = str_replace(array("'"), "''", $ancientTrait);
if(empty($ancientTrait)){
	$ancientTrait = "";
}



	$insert_query = "INSERT INTO LZ_POKEMON_CARDS (CARD_NAME, CARD_ID, NATIONALPOKEDEXNUMBER, CARD_TYPES, CARD_SUBTYPE, SUPERTYPE, HP, CARD_NUMBER, ARTIST, RARITY, CARD_SERIES, CARD_SET, SETCODE, RETREATCOST, CONVERTEDRETREATCOST, CARD_TEXT, ATTACKDAMAGE, ATTACKCOST, ATTACKNAME, ATTACKTEXT, WEAKNESSES, RESISTANCES, ANCIENTTRAIT, ABILITYNAME, ABILITYTEXT, ABILITYTYPE, CONTAINS, IMAGEURL, IMAGEURLHIRES, ABILITY, ATTACKS) VALUES('$card_name', '$card_id', '$nationalPokedexNumber', '$hp_type', '$subtype', '$supertype', '$hp_type', '$card_number', '$artist', '$rarity', '$series', '$set', '$setCode', '$retreatCostColor', '$convertedretreatcost', '$card_text', '$attacks_damage', '$attact_cost', '$attacks_name', '$attack_text', '$weaknessesTypeValue', '$resistancesTypeValue', '$ancientTrait', '$abilityName', '$abilityText', '$abilityType', '$ancientTrait', '$imageUrl', '$imageUrlHiRes', '$abilityName', null)";
	$query = $this->db->query($insert_query);
	// var_dump($query);exit;
		if($query){
			echo $insert_query;
			echo "Insert successfully.";
		}else{
			echo "Not Inserted";
		}
} //end foreach


}//end for loop

//print_r($id);
//$item = $response->Item;
//$i = 0;
// foreach ($response as $model) {

// 	print_r($model);

// }

// print_r($response->toArray());
// print_r($response->toJson());

/**
 * Get all cards
 */
//$response = Pokemon::Card($options)->all();
//foreach ($response as $model) {
//    print_r($model->toArray());
//    print_r($model->toJson());
//}

/**
 * Get Shaymin-EX cards
 */
//$response = Pokemon::Card($options)->where(['name' => 'shaymin'])->where(['subtype' => 'EX'])->all();
//$response = Pokemon::Card($options)->where(['name' => 'shaymin', 'subtype' => 'EX'])->all();
//foreach ($response as $model) {
//    print_r($model->toArray());
//    print_r($model->toJson());
//}

/**
 * Get Vs Seeker cards
 */
//$response = Pokemon::Card($options)->where(['name' => 'vs seeker'])->all();
//foreach ($response as $model) {
//    print_r($model->toArray());
//    print_r($model->toJson());
//}

/**
 * Get a single set
 */
//$response = Pokemon::Set($options)->find('xy11');
//print_r($response->toArray());
//print_r($response->toJson());

/**
 * Get all sets
 */
//$response = Pokemon::Set($options)->all();
//foreach ($response as $model) {
//    print_r($model->toArray());
//    print_r($model->toJson());
//}

/**
 * Get all types
 */
//$response = Pokemon::Type($options)->all();
//print_r($response);

/**
 * Get all supertypes
 */
//$response = Pokemon::Supertype($options)->all();
//print_r($response);

/**
 * Get all subtypes
 */
//$response = Pokemon::Subtype($options)->all();
//print_r($response);
