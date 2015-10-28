<?php


function think($mover){
	$skillFlag=0;
	$mover->stratagy=0;
	foreach ($mover->skillPower as $skill) { 
		if($skill->store){
			$mover->stratagy=1;
		}
	}

}

function skill($caster){
	global $player,$computer;
	for (;;) { 
		$skill=rand(0,count($caster->skillPower)-1);
		if ($caster->skillPower[$skill]->level&&$caster->skillPower[$skill]->store) {
			break;
		}
	}

	$target=target($caster);
	switch ($skill) {
		case 0:
		case 1:
		case 2:
			if ($caster->skillPower[$skill]->level<5) {
				$target=target($caster);
				$harm=rand(1,100)
				*$caster->skillPower[$skill]->level
				*($caster->skillPower[$skill]->times)
				*(rand(0,100)/100>$caster->rate?1:$caster->criticalTimes)
				+$caster->realDamage;
				$target->hp-=$harm-$target->magicResist>0?$harm-$target->magicResist:0;
				
			}
			else{
				$otherSide=$player->side==$$caster->side?$computer:$player;

			}
			
			break;
		//buff
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
			$target=target($caster,1);
			$target->buff[$skill-3]->level=$caster->skillPower[$skill]->level;
			$target->buff[$skill-3]->roundTime=$caster->skillPower[$skill]->level;
			break;
		case 8:
		case 9:
		case 10:

		
		default:
			# code...
			break;
	}


}

function attack($a){
}

function target($a,$b=0){
	global $player,$computer;
	if ($a->side^$b) {
		$otherSide=$computer;
	}
	else{
		$otherSide=$player;
	}

	for ($i=0;$i<1000;$i++) {
		$target=$otherSide[rand(0,count($otherSide)-1)];
		if ($target->hp>0) {
			break;
		}
	}
	return $target;
}

?>
