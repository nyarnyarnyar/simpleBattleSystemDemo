<?php
class unit{
	public $name;//单位名称
	public $side;//单位阵营
	public $class;//职业
	public $rance;//种族
	public $hp;//当前血量
	public $mhp;//最大血量
	public $speed;//速度，即先攻

	public $battleState;//战斗状态
	public $atkAbility;//攻击能力
	public $critical;//暴击
	public $damageResist;//防御能力

	public $skillPower;//主动技能	
	public $passiveSkill;//被动威力
	public $buff;//持续效果以及回合数

	public $spellStrength;//法术强度 治疗量
	public $ranseSE;//对种族特效

	public function __construct(){
		$this->battleState=new battleState();
		$this->atkAbility=new atkAbility();
		$this->critical=new critical();
		$this->damageResist=new damageResist();

		$this->skillPower=array();//需要另行写入数组单元
		$this->passiveSkill=array();//同上
		$this->buff=array();//同上
		
		$this->spellStrength=array();//直接标明法强和治疗
		$this->ranseSE=array();//直接写入意味不明的数字，具体参与计算时要查表

	}

	public function HPrate(){//显示血量百分比
		return $this->healthPoint/$this->healthPointUpper;
	}
}

//unit子类 战斗状态
class battleState{
	public $position;
	public $attackType;
	public $state;
}
//unit子类 攻击能力
class atkAbility{
	public $damage;//伤害
	public $hitRate;//命中
	public $time;//次数
	public $decay=array();//攻击衰减
	public $realDamage;//真实伤害
}
//unit子类 暴击能力
class critical{
	public $rate;//暴击率
	public $time;//暴击倍率
}
//unit子类 防御能力
class damageResist{
	public $resist;//防御
	public $resistRate;//比例防御
	public $dodge;//闪避
	public $magicResist;//法抗
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


//include 'initializeAttr.php';

$npc=new unit();
$npc->name='123456';
$npc->side='player';
$npc->class='commoner';
$npc->rance='human';
$npc->hp=$npc->mahp=100;
$npc->speed=12;

$npc->battleState->position='front';
$npc->battleState->attackType='bayonet';
$npc->battleState->state='live';

$npc->atkAbility->damage=10;
$npc->atkAbility->hitRate=10;
$npc->atkAbility->time=1;
$npc->atkAbility->decay=array();
$npc->atkAbility->realDamage=0;

$npc->critical->rate=0.01;
$npc->critical->time=2;

$npc->damageResist->resist=4;
$npc->damageResist->resistRate=0.05;
$npc->damageResist->dodge=5;
$npc->damageResist->magicResist=1;

//导入14个技能
for($i=0;$i<14;$i++){
	$npc->skillPower[$i]=new skillPower(0,0,0);
}
//导入8个buff与debuf
for($i=0;$i<8;$i++){
	$npc->buff[$i]=new buff(0,0,0);
}
//导入4个被动
for($i=0;$i<4;$i++){
	$npc->passiveSkill[$i]=new passiveSkill(0);
}


$npc->spellStrength[0]=0;
$npc->spellStrength[1]=0;

for($i=0;$i<4;$i++){
	$npc->ranseSE[$i]=0;
}

var_dump(get_object_vars($npc));

/*
function initialize($type,$name){
	switch ($type) {
		case '0'://怪物
			
			break;
		case '1'://玩家

			break;
		
		default:
			# code...
			break;
	}
}
*/
?>
