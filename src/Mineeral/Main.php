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

        if(gettype(Main::getCommands()) === "string" && gettype(Main::getEvents()) === "string" && gettype(Main::getEntity()) === "string" && gettype(Main::loadLevel()) === "string"){

            return Prefix::CONSOLE . "ServerCore is operational";

        } else {

            Main::getInstance()->getServer()->shutdown();
            return Prefix::CONSOLE . "ServerCore is not operationnal";

        }

    }
}
