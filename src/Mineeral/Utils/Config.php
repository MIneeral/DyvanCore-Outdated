<?php

namespace Mineeral\Utils;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use Mineeral\Main;
use Mineeral\Constants\Prefix;

class Config implements Prefix
{
    /**
     * @return string
     */
    public static function load() : string
    {

        @mkdir(Main::getInstance()->getDataFolder());
        @mkdir(Main::getInstance()->getDataFolder()."/Infos");

        $commands = 
        [
            new C(Main::getInstance()->getDataFolder() ."/Infos/Ip.json", C::JSON),
            new C(Main::getInstance()->getDataFolder() ."/Infos/Rank.json", C::JSON),
            new C(Main::getInstance()->getDataFolder() ."/Infos/Money.json", C::JSON),
            new C(Main::getInstance()->getDataFolder() ."/Infos/Kill.json", C::JSON),
            new C(Main::getInstance()->getDataFolder() ."/Infos/Death.json", C::JSON),
            new C(Main::getInstance()->getDataFolder() ."/Infos/Ban.json", C::JSON),
        ];

        $count = 0;

        foreach($commands as $config){
            
            $count = $count + 1;
            $config;

        }

        return PREFIX::CONSOLE . " " . $count . " Config are loaded";

    }

    public static function onConfig(Player $player, string $key)
    {

        $keys = 
        [
            "ip" =>
            [
                "file" => "Ip",
                "default" => $player->getAddress(),
            ],

            "rank" =>
            [
                "file" => "Rank",
                "default" => "Player",
            ],

            "money" =>
            [
                "file" => "Money",
                "default" => 1000,
            ],

            "kill" =>
            [
                "file" => "Kill",
                "default" => 0,
            ],

            "death" =>
            [
                "file" => "Death",
                "default" => 0,
            ],

            "ban" =>
            [
                "file" => "Ban",
                "default" => 0,
            ],

            "tempban" =>
            [
                "file" => "TempBan",
                "default" => 0,
            ],

            "time" =>
            [
                "file" => "Time",
                "default" => 0,
            ],
        ];

        if(isset($keys[$key])){

            $k = $keys[$key];
            $config = new C(Main::getInstance()->getDataFolder() . "/Infos/" . $k["file"] . ".json", C::JSON);
            if(!$config->exists($player->getName())) Config::setConfig($player, $config, $k["default"]);
            return $config->get($player->getName());

        } else return false;
    }

    public static function setConfig(Player $player, C $config, $value) : bool
    {   
        if($player instanceof Player && $value !== null) {

            $config->set($player->getName(), $value);
            $config->save();
            return true;

        } else return false;
    }
}
