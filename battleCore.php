<?php


while($round++<100){


/*
	for($i=0;$i<count($unitList);$i++){
		echo $i.'  '.$unitList[$i]->name.' '.$unitList[$i]->state.'<br>';

	}
*/
	for ($i=0; $i < count($unitList); $i++) { //生成先攻
		$unitList[$i]->initiative=rand(0,$unitList[$i]->speed);
	}
	for ($i=0; $i < count($unitList); $i++) { //先攻排序
		for ($j=count($unitList)-1; $j >$i; $j--) { 
			if (($unitList[$j]->initiative)<($unitList[$j-1]->initiative)) {
				$item=$unitList[$j-1];
				$unitList[$j-1]=$unitList[$j];
				$unitList[$j]=$item;
			}
		}
	}

	for ($i=count($unitList)-1; $i >=0 ; $i--) { //每个单位开始行动
		$mover=$unitList[$i];
		echo $i.'  '.$unitList[$i]->name.' '.$unitList[$i]->state.'<br>';

		think($mover);
		if (!$mover->state) {

			continue;
		}
		
		if ($mover->stratagy) {
			skill($mover);
		}
		else{

		}

	}


	for($i=0;$i<count($unitList);$i++){
			//echo '<br>'.$unitList[$i]->name.':'.$unitList[$i]->buff[0]->resist;
			foreach ($unitList[$i]->buff as $k) {
				$k->roundTime?$k->roundTime--:0;
				//echo $k->roundTime;
			}

	}
	echo '<br><br>';

	
	//end round
	
}

?>
