<?php

namespace Mineeral\Event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Server;

class QuitJoinEvent implements Listener{
    public function PlayerJoinEvent(PlayerJoinEvent $ev){
        $p = $ev->getPlayer();
        $ev->setJoinMessage("");

        if(!$p->hasPlayedBefore()){
            Server::getInstance()->broadcastPopup("§f[§c+§f] §a " . $p->getName());
            $p->getLevel()->broadcastLevelEvent($p->add(0, $p->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);
            $p->sendMessage("§f[§c!§f] Bienvenue sur §4Dyvan§f PvP-Box !");
            } else {
            Server::getInstance()->broadcastPopup("§f[§c+§f] §a " . $p->getName());
            $p->getLevel()->broadcastLevelEvent($p->add(0, $p->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);
        }
    }
    public function PlayerQuitEvent(PlayerQuitEvent $ev){
        $p = $ev->getPlayer();
        $ev->setQuitMessage("");
     Server::getInstance()->broadcastPopup("§f[§c-§f] §4 " . $p->getName());
    }
}
