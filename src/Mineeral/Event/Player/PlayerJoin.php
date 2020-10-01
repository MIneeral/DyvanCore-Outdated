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
            $player->sendMessage("§f[§4!§f] Bienvenue sur §4Dyvan§f PvP-Box !");
            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);

            $nbt = $player->getNamedTag() ?? new CompoundTag("", []);

            $nbt->ip = new StringTag("IP", $player->getAddress());
            $nbt->rank = new StringTag("RANK", "Player");
            $nbt->money = new IntTag("MONEY", 1000);
            $nbt->kill = new IntTag("KILL", 0);
            $nbt->death = new IntTag("DEATH", 0);
            $nbt->ban = new IntTag("BAN", 0);
            $nbt->bantemp = new IntTag("BANTEMP", 0);

            $player->setNamedTag($nbt);

        } else {

            Main::getInstance()->getServer()->broadcastPopup("§f[§4+§f] §a " . $player->getName());
            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_GHAST_SHOOT);

        }
    }
}
