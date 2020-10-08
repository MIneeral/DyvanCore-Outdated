<?php

namespace Mineeral\Utils;

use Mineeral\Main;
use Mineeral\Constants\Prefix;

use Mineeral\Event\Block\BlockBreak;
use Mineeral\Event\Block\BlockPlace;

use Mineeral\Event\Entity\EntityDamageByEntity;
use Mineeral\Event\Entity\EntityDamage;

use Mineeral\Event\Player\PlayerChat;
use Mineeral\Event\Player\PlayerCommandPreprocess;
use Mineeral\Event\Player\PlayerDeath;
use Mineeral\Event\Player\PlayerInteract;
use Mineeral\Event\Player\PlayerJoin;
use Mineeral\Event\Player\PlayerQuit;

class Event implements Prefix
{
    /**
     * @return string
     */
    public static function load()
    {

        $events = 
        [
            // Event Block
            new BlockBreak(),
            new BlockPlace(),

            // Event Entity
            new EntityDamageByEntity(),
            new EntityDamage(),

            // Event Player
            new PlayerChat(),
            new PlayerCommandPreprocess(),
            new PlayerDeath(),
            new PlayerInteract(),
            new PlayerJoin(),
            new PlayerQuit(),
        ];

        $count = 0;

        foreach($events as $event) {

            $count = $count + 1;
            Main::getInstance()->getServer()->getPluginManager()->registerEvents($event, Main::getInstance());

        }

        return Prefix::CONSOLE . " " . $count . " Events are loaded";

    }
}
