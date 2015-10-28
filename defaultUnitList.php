<?php

class unit{
	public $name;//单位名称
	public $side;//单位阵营 0 玩家 1 怪物
	public $class;//职业 0 杂兵
	public $initiative;//最终先攻值
	public $level;
	public $race;//种族 1 人类
	public $hp;//当前血量
	public $mhp;//最大血量
	public $speed;//速度，即先攻

	//战斗状态
	public $position=0;//位置 0 第一排 1 第二排
	public $attackType=0;//攻击方式 0 近战 1 远程
	public $state=1;//状态 1 活着 0 死了
	public $actionPolicy='1';
	public $stratagy=0;

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
	public $passiveSkill;//被动技能
	public $buff;//持续效果以及回合数

	//纯数组
	public $spellStrength;//法术强度 治疗量
	public $ranseSE;//对种族特效

	public function __construct(){

		$this->decay=array('1','0.5');
		//初始化14个技能
		for($i=0;$i<14;$i++){
			$this->skillPower[$i]=new skillPower();
		}
		//初始化4个被动
		for($i=0;$i<4;$i++){
			$this->passiveSkill[$i]=new passiveSkill(0);
		}
		//初始化8个buff
		for($i=0;$i<8;$i++){
			$this->buff[$i]=new buff(0,0,0);
		}
		$this->spellStrength=array(0,0);//直接标明法强和治疗
		$this->ranseSE=array(0,0,0,0);//直接写入意味不明的数字，具体参与计算时要查表

	}

	public function HPrate(){//显示血量百分比
		return $this->hp/($this->mhp);
	}
}


//unit数组单元子类 主动技能
class skillPower{
	public $store=0;//技能次数 就是法术位
	public $level=0;//技能威力 就是法术等级
	public $times=1;//技能倍数 就是法术极效
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
	public $roundTime=0;//剩余时间
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
$unitList=array();
$battleReport=array();
$player=array();
$computer=array();
$round=0;


for ($i=0; $i < 8; $i++) {
	$unitList[$i]=new unit();
	if ($i<4) {
		$unitList[$i]->name='村民'.$i;//单位名称
		$unitList[$i]->side=0;//单位阵营

	}
	else{
		$unitList[$i]->name='兽人'.($i-4);//单位名称
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

$unitList[2]->skillPower[1]->level=1;
$unitList[2]->skillPower[1]->store=1;
$unitList[2]->skillPower[2]->level=1;
$unitList[2]->skillPower[2]->store=1;
$unitList[2]->skillPower[4]->level=1;
$unitList[2]->skillPower[4]->store=1;

for($i=0;$i<count($unitList);$i++){
	if ($unitList[$i]->side==1) {
		$player[count($player)]=$unitList[$i];
	}
	else {
		$computer[count($computer)]=$unitList[$i];
	}
}

$unitList[4]->state=0;
$unitList[4]->buff[0]->roundTime=12;

?>
