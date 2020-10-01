<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

use Mineeral\Main;
use Mineeral\Event\Player\PlayerJoin;

use Mineeral\Event\Entity\EntityDamageByEntity;

class PlayerQuit implements Listener
{

    public function PlayerQuitEvent(PlayerQuitEvent $event) : void 
    {

        $player = $event->getPlayer();
        $time = EntityDamageByEntity::time($player, "get");

        if(isset($time) && time() < $time) $player->kill();
        
        $event->setQuitMessage("");
        Main::getInstance()->getServer()->broadcastPopup(Main::PREFIX_QUIT . $player->getName());

        $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Time.json", Config::JSON);
        Main::setConfig($player, $config, PlayerJoin::getTime($player) - time() + Main::onConfig($player, "time"));

    }
}
