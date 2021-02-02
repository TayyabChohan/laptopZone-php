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

$response = Pokemon::Card($options)->all();

// $response = $response->toJson();
 
// echo "<pre>";
// print_r($response); 
// echo "</pre>";
// exit;

foreach ($response as $model) {

// echo "<pre>";
// print_r($model->toJson()); 
// echo "</pre>";
// exit;

$model = $model->toJson();
$obj = json_decode($model);
//$model = json_decode($model);


// echo "<pre>";
// print_r($obj); 
// echo "</pre>";
// exit;

$card_name = $obj->name;
var_dump($card_name);exit;

$card_id = $response['id'];
$nationalPokedexNumber = $response['nationalPokedexNumber'];
if(empty($nationalPokedexNumber)){
	$nationalPokedexNumber = "";
}
$hp_type = $response['hp']; //CardType on top right corner of card
if(empty($hp_type)){
	$hp_type = "";
}
$subtype = $response['subtype'];
if(empty($subtype)){
	$subtype = "";
}
$supertype = $response['supertype'];
if(empty($supertype)){
	$supertype = "";
}
$card_number = $response['number'];//CardType on bottom right corner of card
if(empty($card_number)){
	$card_number = "";
}
$artist = $response['artist'];
if(empty($artist)){
	$artist = "";
}
$rarity = $response['rarity'];
if(empty($rarity)){
	$rarity = "";
}
$series = $response['series'];
if(empty($series)){
	$series = "";
}
$set = $response['set'];
if(empty($set)){
	$set = "";
}
$setCode = $response['setCode'];
if(empty($setCode)){
	$setCode = "";
}
$retreatCostColor = $response['retreatCost'][0];
if(empty($retreatCostColor)){
	$retreatCostColor = "";
}
//$retreatCostColor2 = $response['retreatCost'][1];

$card_text = $response['text'][0];
if(empty($card_text)){
	$card_text = "";
}
$attacks_name = $response['attacks'][0]['name'];
if(empty($attacks_name)){
	$attacks_name = "";
}
$attack_text = $response['attacks'][0]['text'];
$attack_text = trim(str_replace("  ", ' ', $attack_text));
$attack_text = str_replace(array("`,′"), "", $attack_text);
$attack_text = str_replace(array("'"), "''", $attack_text);
if(empty($attack_text)){
	$attack_text = "";
}
$attacks_damage = $response['attacks'][0]['damage'];
if(empty($attacks_damage)){
	$attacks_damage = "";
}
$convertedretreatcost = $response['attacks'][0]['convertedEnergyCost']; //convertedretreatCost
if(empty($convertedretreatcost)){
	$convertedretreatcost = "";
}
$attact_cost = $response['attacks'][0]['cost'][0]; //attack cost
if(empty($attact_cost)){
	$attact_cost = "";
}
$weaknessesTypeValue = @$response['weaknesses'][0]['type'].' '.@$response['weaknesses'][0]['value'];
if(empty($weaknessesTypeValue)){
	$weaknessesTypeValue = "";
}
$resistancesTypeValue = @$response['resistances'][0]['type'].' '.@$response['resistances'][0]['value'];
if(empty($resistancesTypeValue)){
	$resistancesTypeValue = "";
}
//$resistancesValue = $response['resistances'][0]['value'];
//$weaknessesValue = $response['weaknesses'][0]['value'];
//var_dump($convertedretreatcost);exit;

$abilityName = $response['ability']['name'];
if(empty($abilityName)){
	$abilityName = "";
}
$abilityText = $response['ability']['text'];
if(empty($abilityText)){
	$abilityText = "";
}
$abilityType = $response['ability']['type'];
if(empty($abilityType)){
	$abilityType = "";
}
$imageUrl = $response['imageUrl'];
if(empty($imageUrl)){
	$imageUrl = "";
}
$imageUrlHiRes = $response['imageUrlHiRes'];
if(empty($imageUrlHiRes)){
	$imageUrlHiRes = "";
}
$ancientTrait = $response['ancientTrait'];
if(empty($ancientTrait)){
	$ancientTrait = "";
}




	$insert_query = "INSERT INTO LZ_POKEMON_CARDS (CARD_NAME, CARD_ID, NATIONALPOKEDEXNUMBER, CARD_TYPES, CARD_SUBTYPE, SUPERTYPE, HP, CARD_NUMBER, ARTIST, RARITY, CARD_SERIES, CARD_SET, SETCODE, RETREATCOST, CONVERTEDRETREATCOST, CARD_TEXT, ATTACKDAMAGE, ATTACKCOST, ATTACKNAME, ATTACKTEXT, WEAKNESSES, RESISTANCES, ANCIENTTRAIT, ABILITYNAME, ABILITYTEXT, ABILITYTYPE, CONTAINS, IMAGEURL, IMAGEURLHIRES, ABILITY, ATTACKS) VALUES('$card_name', '$card_id', $nationalPokedexNumber, '$hp_type', '$subtype', '$supertype', '$hp_type', '$card_number', '$artist', '$rarity', '$series', '$set', '$setCode', '$retreatCostColor', '$convertedretreatcost', '$card_text', '$attacks_damage', '$attact_cost', '$attacks_name', '$attack_text', '$weaknessesTypeValue', '$resistancesTypeValue', '$ancientTrait', '$abilityName', '$abilityText', '$abilityType', '$ancientTrait', '$imageUrl', '$imageUrlHiRes', '$abilityName', null)";
	$query = $this->db->query($insert_query);
	// var_dump($query);exit;
		if($query){
			echo $insert_query;
			echo "Insert successfully.";
		}else{
			echo "Not Inserted";
		}
} //end foreach

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
