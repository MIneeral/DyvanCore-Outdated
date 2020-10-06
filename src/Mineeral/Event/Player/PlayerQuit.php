<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\utils\C;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Message;
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
        Main::getInstance()->getServer()->broadcastPopup(Message::QUIT . $player->getName());

        $config = new C(Main::getInstance()->getDataFolder() . "/Infos/Time.json", C::JSON);
        Config::setConfig($player, $config, PlayerJoin::getTime($player) - time() + Config::onConfig($player, "time"));

    }
}
