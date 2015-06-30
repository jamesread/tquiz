<?php

$suits = array('Clubs', 'Diamonds', 'Hearts', 'Spades');
$cards = array();

foreach ($suits as $suit) {
	for ($i = 1; $i <= 13; $i++) {
		$value = $i;
		switch ($i) {
			case '1': $value = 'A'; break;
			case '11'; $value = 'J'; break;
			case '12'; $value = 'Q'; break;
			case '13'; $value = 'K'; break;
		}

		$cards[] = array('suite' => $suit, 'value' => $value);
	}
}

shuffle($cards);

foreach ($cards as $card) {
	echo $card['value'] . ' ' . $card['suite'] . "\n";
}

?>
