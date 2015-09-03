init battle
{
数据初始化 战斗数值生成 确定战场形式{}
}


战斗 最大循环总单位数量的次数 单位id 战场形式
｛
检查自身状态

确定行动方针｛行动和对象｝

行动｛
处理自身单位状态和对象单位状态
｝
｝

回合结束
｛
确定战场形式｛｝
判定胜负
下一轮行动顺序。
｝

战斗结束{
掉落，经验，人物阵亡
}

Unit｛
Hp
Mhp
AtkAbility{伤害，攻击次数，攻击递减，命中，真实伤害}
DamageResist｛固定值，百分比，回避，魔法减免｝
SkillPower={次数，威力，倍数，抗性}
BuffMagic={次数，威力，抗性，回合数}
PassiveSkill={威力}
MagicAbility｛法伤，治疗量｝
Race
RaceSE{威力（0不会，1一级……）}
Critical{暴击率，暴击倍率}
Speed
BattleState{位置，攻击类型，状态}
}


