<?php
return [
	"home" => [
		"controller" => "HomeController",
		"method" => "index"
	],
	"search" => [
		"controller" => "SearchController",
		"method" => "getMatches"
	],
	"login" => [
		"controller" => "UserController",
		"method" => "index"
	],
	"logout" => [
		"controller" => "UserController",
		"method" => "logout"
	],
	"logAs" => [
		"controller" => "UserController",
		"method" => "logAs"
	],
	"login/authenticate" => [
		"controller" => "UserController",
		"method" => "authenticate"
	],
	"login/authenticateAs" => [
		"controller" => "UserController",
		"method" => "authenticateAs"
	],
	"register" => [
		"controller" => "UserController",
		"method" => "register"
	],
	"bestiary" => [
		"controller" => "MonsterController",
		"method" => "userDisplayer"
	],
	"bestiaryManager/addMonster" => [
		"controller" => "MonsterController",
		"method" => "addMonster"
	],
	"bestiaryManager/updateMonster" => [
		"controller" => "MonsterController",
		"method" => "updateMonster"
	],
	"bestiaryManager/deleteMonster" => [
		"controller" => "MonsterController",
		"method" => "deleteMonster"
	],
	"bestiaryManager/addRank" => [
		"controller" => "RankController",
		"method" => "addRank"
	],
	"bestiaryManager/deleteRanks" => [
		"controller" => "RankController",
		"method" => "deleteRanks"
	],
	"bestiaryManager/updateRankOrder" => [
		"controller" => "RankController",
		"method" => "updateRankOrder"
	],
	"bestiaryManager/addSkill" => [
		"controller" => "SkillController",
		"method" => "addSkill"
	],
	"bestiaryManager/editSkillName" => [
		"controller" => "SkillController",
		"method" => "editSkillName"
	],
	"bestiaryManager/deleteSkills" => [
		"controller" => "SkillController",
		"method" => "deleteSkills"
	],
	"bestiaryManager/addType" => [
		"controller" => "TypeController",
		"method" => "addType"
	],
	"bestiaryManager/editTypeName" => [
		"controller" => "TypeController",
		"method" => "editTypeName"
	],
	"bestiaryManager/deleteTypes" => [
		"controller" => "TypeController",
		"method" => "deleteTypes"
	],
	"bestiaryManager" => [
		"controller" => "MonsterController",
		"method" => "adminDisplayer"
	],
	"bestiaryManager/getMonster" => [
		"controller" => "MonsterController",
		"method" => "getMonsterByID"
	],
	"slideshowManager" => [
		"controller" => "SlideshowController",
		"method" => "adminDisplayer"
	],
	"slideshowManager/getBestiary" => [
		"controller" => "MonsterController",
		"method" => "getBestiary"
	],
	"bestiary/getBestiary" => [
		"controller" => "MonsterController",
		"method" => "getBestiary"
	],
	"slideshowManager/addSlide" => [
		"controller" => "SlideshowController",
		"method" => "addSlide"
	],
	"slideshowManager/deleteSlide" => [
		"controller" => "SlideshowController",
		"method" => "deleteSlide"
	],
	"habitats/getAreaHabitats" => [
		"controller" => "HabitatController",
		"method" => "getAreaHabitats"
	],
	"skills/getTypeSkills" => [
		"controller" => "SkillController",
		"method" => "getTypeSkills"
	],
	"glossary" => [
		"controller" => "GlossaryController",
		"method" => "userDisplayer"
	],
	"glossaryManager" => [
		"controller" => "GlossaryController",
		"method" => "adminDisplayer"
	],
	"glossaryManager/addGlossaryWord" => [
		"controller" => "GlossaryController",
		"method" => "addWord"
	],
	"glossaryManager/editGlossaryWord" => [
		"controller" => "GlossaryController",
		"method" => "editGlossaryWord"
	],
	"glossaryManager/deleteGlossaryWords" => [
		"controller" => "GlossaryController",
		"method" => "deleteWords"
	],
	"areas" => [
		"controller" => "AreaController",
		"method" => "userDisplayer"
	],
	"areasManager" => [
		"controller" => "AreaController",
		"method" => "adminDisplayer"
	],
	"areasManager/addHabitat" => [
		"controller" => "HabitatController",
		"method" => "addHabitat"
	],
	"areasManager/getHabitat" => [
		"controller" => "HabitatController",
		"method" => "getHabitat"
	],
	"areasManager/updateHabitat" => [
		"controller" => "HabitatController",
		"method" => "updateHabitat"
	],
	"areasManager/deleteHabitat" => [
		"controller" => "HabitatController",
		"method" => "deleteHabitat"
	],
	"areasManager/addSafePlace" => [
		"controller" => "SafePlaceController",
		"method" => "addSafePlace"
	],
	"areasManager/getSafePlace" => [
		"controller" => "SafePlaceController",
		"method" => "getSafePlace"
	],
	"areasManager/updateSafePlace" => [
		"controller" => "SafePlaceController",
		"method" => "updateSafePlace"
	],
	"areasManager/deleteSafePlace" => [
		"controller" => "SafePlaceController",
		"method" => "deleteSafePlace"
	],
	"areas/getPlacesByAreaID" => [
		"controller" => "AreaController",
		"method" => "getPlacesByAreaID"
	],
];
