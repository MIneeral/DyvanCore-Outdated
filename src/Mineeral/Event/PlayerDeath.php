<?php

namespace Mineeral\Event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use Mineeral\Main;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use onebone\economyapi\EconomyAPI;

class PlayerDeath implements Listener{

    private $plugin;

    public function __construct(Main $plugin){
    $this->plugin = $plugin;
    }

    public function PlayerDeath(PlayerDeathEvent $event){
    $event->setDrops([]);
    $player = $event->getPlayer();
    $name = $player->getName();
    $cause = $player->getLastDamageCause()->getCause();
    if($cause == EntityDamageEvent::CAUSE_ENTITY_ATTACK){
    $damager = $player->getLastDamageCause()->getDamager();
    if($damager instanceof Player) {
    $dname = $damager->getName();
    $event->setDeathMessage("§c» §4" . $name . " §fa été tué par§4 ". $dname);
    $player->teleport($this->getServer()->getLevelByName("Arene")->getSafeSpawn());
    EconomyAPI::getInstance()->addMoney($damager, "10");
    $damager->setHealth(20);
    $this->plugin->kill->set($dname, $this->plugin->kill->get($dname)+1);
            }
        }
$this->plugin->death->set($name, $this->plugin->death->get($name)+1);
    }
}
