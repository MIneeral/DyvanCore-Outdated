<?php

namespace Mineeral\Event\Entity;

use pocketmine\Player;

use pocketmine\event\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;

class EntityDamageByEntity implements Listener
{   
    private const TIME = 10;
    public static $cooldown = [];

    public function EntityDamageByEntity(EntityDamageByEntityEvent $ev) : void 
    {

        $ev->setKnockBack(0.4);

        if($event->getDamager() instanceof Player && $event->getEntity() instanceof Player){

            EntityDamageByEntity::time($event->getDamager(), "set", EntityDamageByEntity::TIME + time());
            EntityDamageByEntity::time($event->getEntity(), "set", EntityDamageByEntity::TIME + time());

        }
    }

    public static function time(Player $player, string $type, int $time = 0) : int
    {
        switch($type){
            case "set":
                return EntityDamageByEntity::$cooldown[$player->getName()] = $time;
            break;
            case "get":
                if(!isset(EntityDamageByEntity::$cooldown[$player->getName()])) return 0;
                EntityDamageByEntity::$cooldown[$player->getName()];
                return 1;
            break;
            case "del":
                unset(EntityDamageByEntity::$cooldown[$player->getName()]);
                return 1;
            break;
        }
    }
}