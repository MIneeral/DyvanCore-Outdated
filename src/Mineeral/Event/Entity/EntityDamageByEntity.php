<?php

namespace Mineeral\Event\Entity;

use pocketmine\Player;

use pocketmine\event\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;

use Mineeral\Main;
use Mineeral\Utils\Config;
use Mineeral\Utils\Rank;

class EntityDamageByEntity implements Listener
{   
    private const TIME = 10;
    public static $cooldown = [];

    public function EntityDamageByEntity(EntityDamageByEntityEvent $ev) : void 
    {

        $ev->setKnockBack(0.4);

        $damager = $event->getDamager();
        $entity = $event->getEntity();

        if($damager instanceof Player && $entity instanceof Player){

            if(isset(Rank::RANK_NAMETAG[Config::onConfig($damager, "rank")])) $damager->setNameTag(Rank::RANK_NAMETAG[Config::onConfig($damager, "rank")] . " §f" . $damager->getName());
            if(isset(Rank::RANK_NAMETAG[Config::onConfig($entity, "rank")])) $entity->setNameTag(Rank::RANK_NAMETAG[Config::onConfig($entity, "rank")] . " §f" . $entity->getName());

            EntityDamageByEntity::time($damager, "set", EntityDamageByEntity::TIME + time());
            EntityDamageByEntity::time($entity, "set", EntityDamageByEntity::TIME + time());

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