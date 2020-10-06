<?php

namespace Mineeral;

use pocketmine\plugin\PluginBase;

use Mineeral\Constants\Prefix;

use Mineeral\Utils\Command;
use Mineeral\Utils\Config;
use Mineeral\Utils\Entity;
use Mineeral\Utils\Event;
use Mineeral\Utils\Level;

class Main extends PluginBase implements Prefix
{

    private static $instance;

    public function onEnable() : void
    {

        Main::$instance = $this;

        $info = 
        [
            Level::load(),
            Command::load(),
            Event::load(),
            Entity::load(),
            Config::load(),
            Main::loadServer(),
        ];

        foreach($info as $message){
 
            Main::getInstance()->getServer()->getLogger()->info($message);

        }
    }

    public static function getInstance() : Main
    {

        return Main::$instance;

    }

    private static function loadServer() : string 
    {

        if(gettype(Level::load()) === "string" && gettype(Command::load()) === "string" 
        && gettype(Event::load()) === "string" && gettype(Entity::load()) === "string" 
        && gettype(Config::load()) === "string") return Prefix::CONSOLE . "ServerCore is operational";
        else {

            Main::getInstance()->getServer()->shutdown();
            return Prefix::CONSOLE . "ServerCore is not operationnal";

        }
    }
}
