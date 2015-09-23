<?php
class unit{
	public $name;//单位名称
	public $side;//单位阵营 0 玩家 1 怪物
	public $class;//职业 0 杂兵
	public $level;
	public $race;//种族 1 人类
	public $hp;//当前血量
	public $mhp;//最大血量
	public $speed;//速度，即先攻

	//战斗状态
	public $position=0;//位置 0 第一排 1 第二排
	public $attackType=0;//攻击方式 0 近战 1 远程
	public $state=1;//状态 1 活着 0 死了

	//攻击能力
	public $damage;//伤害
	public $hitRate;//命中
	public $times=1;//次数
	public $decay;//攻击衰减
	public $realDamage=0;//真实伤害

	//暴击
	public $rate=0.01;//暴击率
	public $criticalTimes=2;//暴击倍率

	//防御能力
	public $resist=0;//防御
	public $resistRate=0;//比例防御
	public $dodge=0;//闪避
	public $magicResist=0;//法抗

	//类中类
	public $skillPower;//主动技能	
	public $passiveSkill;//被动威力
	public $buff;//持续效果以及回合数

	//纯数组
	public $spellStrength;//法术强度 治疗量
	public $ranseSE;//对种族特效

	public $initiative;//先攻

	public function __construct(){

		$this->decay=array('1','0.5');
		//初始化14个技能
		for($i=0;$i<14;$i++){
			$this->skillPower[$i]=new skillPower(0,0,0);
		}
		//初始化4个被动
		for($i=0;$i<4;$i++){
			$npc->passiveSkill[$i]=new passiveSkill(0);
		}
		//初始化8个buff
		for($i=0;$i<8;$i++){
			$npc->buff[$i]=new buff(0,0,0);
		}
		$this->spellStrength=array(0,0);//直接标明法强和治疗
		$this->ranseSE=array(0,0,0,0);//直接写入意味不明的数字，具体参与计算时要查表

	}

	public function HPrate(){//显示血量百分比
		return $this->healthPoint/$this->healthPointUpper;
	}
}


//unit数组单元子类 主动技能
class skillPower{
	public $store;//技能次数 就是法术位
	public $level;//技能威力 就是法术等级
	public $times;//技能倍数 就是法术极效
	public function __construct($store,$level,$times){
		$this->store=$store;
		$this->level=$level;
		$this->times=$times;
	}
}
//unit数组单元子类 被动技能
class passiveSkill{
	public $level;//被动技能等级
	public function __construct($level){
		$this->level=$level;
	}
}
//unit数组单元子类 buff效果
class buff{
	public $resist;//抵抗
	public $level;//等级强度
	public $roundTime;//剩余时间
	public function __construct($resist,$level,$roundTime){
		$this->resist=$resist;
		$this->level=$level;
		$this->roundTime=$roundTime;
	}
}


//战报
class battleReport{
	public $title;
	public $content;
	function __construct($title,$content){
		$this->title=$title;
		$this->content=$content;
	}
}

/**
测试用桩模块 初始化单位
*/
$battleReport=array();

$unitList=array();
for ($i=0; $i < 8; $i++) { 
	$unitList[$i]=new unit();
	if ($i<4) {
		$unitList[$i]->name='村民'.$i;//单位名称
		$unitList[$i]->side=0;//单位阵营

	}
	else{
		$unitList[$i]->name='哥布林'.$i;//单位名称
		$unitList[$i]->side=1;//单位阵营

	}
	$unitList[$i]->class=0;//职业
	$unitList[$i]->level=1;//等级
	$unitList[$i]->race=1;//种族
	$unitList[$i]->mhp=$unitList[$i]->hp=100;//当前血量
	$unitList[$i]->dodge=5;//闪避
	$unitList[$i]->speed=10;//速度，即先攻
	$unitList[$i]->damage=10;//伤害
	$unitList[$i]->hitRate=10;//命中
}

for ($i=0; $i < count($unitList); $i++) { 
	$navigateList[$i]=&$unitList[$i];
}
/**
桩模块结束
*/

$round=0;//回合数
//战斗过程
while ( $round++<20) {
	$battleReport[count($battleReport)]=new battleReport('round',"$round<br>");
	for ($i=0; $i < count($unitList); $i++) { 
		$battleReport[count($battleReport)]=new battleReport('navigate',$navigateList[$i]->name.":".$navigateList[$i]->hp."/".$navigateList[$i]->mhp);
	}
	//产生先攻值
	for ($i=0; $i < count($unitList); $i++) { 
		$unitList[$i]->initiative=rand(0,$unitList[$i]->speed);
	}
	//先攻排序
	for ($i=0; $i < count($unitList)-1; $i++) {
		for ($j=0; $j < count($unitList)-$i; $j++) { 
			if(($unitList[$j]->initiative)<($unitList[$j+1]->initiative)){
				$temp=$unitList[$j];
				$unitList[$j]=$unitList[$j+1];
				$unitList[$j+1]=$temp;
			}
		}
	}

	//遍历已排序的UL，完成整个战斗流程
	for ($i=0; $i < count($unitList); $i++) { 
		if(!$unitList[$i]->state){//行动者死亡，跳过
			continue;
		}
		//选择目标
		for(;;){
			$p=rand(0,count($unitList)-1);
			if($unitList[$p]->state&&$unitList[$i]->side!=$unitList[$p]->side){//目标未死亡并且与行动者阵营不同
				$target=$unitList[$p];
				break;
			}
		}

		attack($unitList[$i],$target);
		if ($target->hp<=0) {
			$target->state=0;//你已经死了
			$battleReport[count($battleReport)]=new battleReport('down',"$target->name die");
		}
		if(checkSide(0)||checkSide(1)){
		break;
		}
	}
	if(checkSide(0)||checkSide(1)){
	$battleReport[count($battleReport)]=new battleReport('end',"battle end");
	$battleReport[count($battleReport)]=new battleReport('winner',checkSide(1)?'computer is the winner':'player is the winner');

	break;
	}
}
//test battleReport echo
for ($i=0; $i < count($battleReport); $i++) { 
	echo $battleReport[$i]->content."<br>";
}

function attack($a,$t){
	global $battleReport;
	if(rand(0,$a->hitRate)>$t->dodge){//命中
		$damage=$a->damage*(1-$t->resistRate)-$t->resist+$a->realDamage;
		if($damage>0){
			$t->hp-=$damage;
			$content=$a->name."对".$t->name."造成了".$damage."点伤害";
			$battleReport[count($battleReport)]=new battleReport('action',$content);
		}
		else{
			$content=$a->name."未能对".$t->name."造成伤害";
			$battleReport[count($battleReport)]=new battleReport('action',$content);
		}
	}
	else{
		$content=$a->name."没有击中".$t->name;
		$battleReport[count($battleReport)]=new battleReport('action',$content);
	}
}
function checkSide($swift){
	global $unitList;
	//先假定这个阵营死绝了
	$result=1;
	//遍历
	for ($i=0; $i < count($unitList); $i++) { 
		if ($unitList[$i]->side==$swift&&$unitList[$i]->state) {//该阵营有一个活人
			$result=0;
		}
	}
	return $result;//返回1 真死绝了 返回0 没死绝
}




?>
