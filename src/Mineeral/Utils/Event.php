<?php

namespace Mineeral\Utils;

use Mineeral\Main;
use Mineeral\Constants\Prefix;

use Mineeral\Event\Player\PlayerChat;
use Mineeral\Event\Player\PlayerCommandPreprocess;
use Mineeral\Event\Player\PlayerJoin;
use Mineeral\Event\Player\PlayerQuit;
use Mineeral\Event\Player\PlayerDeath;
use Mineeral\Event\Player\PlayerInteract;

use Mineeral\Event\Entity\EntityDamageByEntity;
use Mineeral\Event\Entity\EntityDamage;

class Event implements Prefix
{

    public static function load()
    {

        $events = 
        [
            //Event Player
            new PlayerChat(),
            new PlayerCommandPreprocess(),
            new PlayerJoin(),
            new PlayerQuit(),
            new PlayerDeath(),
            new PlayerInteract(),

            //Event Entity
            new EntityDamageByEntity(),
            new EntityDamage(),
        ];

        $count = 0;

        foreach($events as $event) {

            $count = $count + 1;
            Main::getInstance()->getServer()->getPluginManager()->registerEvents($event, Main::getInstance());

        }

        return Prefix::CONSOLE . " " . $count . " Events are loaded";

    }
}
