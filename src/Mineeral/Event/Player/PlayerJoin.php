<?php

namespace Mineeral\Event\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;

class PlayerJoin implements Listener
{

    public function PlayerJoinEvent(PlayerJoinEvent $ev) : void 
    {

        $player = $ev->getPlayer();
        $ev->setJoinMessage("");

        if(!$player->hasPlayedBefore()){

            Main::getInstance()->getServer()->broadcastPopup("§f[§c+§f] §a " . $player->getName());
            $player->sendMessage("§f[§c!§f] Bienvenue sur §4Dyvan§f PvP-Box !");
            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);

        } else {

            Main::getInstance()->getServer()->broadcastPopup("§f[§c+§f] §a " . $player->getName());
            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);

        }
    }
}
