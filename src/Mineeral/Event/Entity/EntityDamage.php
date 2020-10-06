<?php

namespace Mineeral\Event\Entity;

use pocketmine\Player;

use pocketmine\event\Listener;

use pocketmine\level\Level;
use pocketmine\level\Position;

use pocketmine\event\entity\EntityDamageEvent;

class EntityDamage implements Listener
{   
    private const LEVEL = "Arene";

    private const POS_X_1 = -26;
    private const POS_Y_1 = 163;
    private const POS_Z_1 = -40;

    private const POS_X_2 = 35;
    private const POS_Y_2 = 115;
    private const POS_Z_2 = 24;

    public function EntityDamage(EntityDamageEvent $event) : void 
    {
        $level = $event->getEntity()->getLevel();
        $pos = $event->getEntity()->getPosition();

        if($event->getEntity() instanceof Player) {
            switch($event->getCause()){

                case EntityDamageEvent::CAUSE_FALL:
                    $event->setCancelled();
                break;
    
            }

            $params = 
            [
                // Level Name
                $level->getName(),
                EntityDamage::LEVEL,
                // InstanceOf Position
                $pos,
                // float
                EntityDamage::POS_X_1,
                EntityDamage::POS_X_2,
                // float
                EntityDamage::POS_Y_1,
                EntityDamage::POS_Y_2,
                // float
                EntityDamage::POS_Z_1,
                EntityDamage::POS_Z_2,
            ];

            if(EntityDamage::getArea(...$params) === true) $event->setCancelled();
        }
    }

    public static function getArea(String $level_1, String $level_2, Position $pos, float $pos_x_1, float $pos_x_2, float $pos_y_1, float $pos_y_2, float $pos_z_1, float $pos_z_2) {

        if(EntityDamage::getX($pos->getX(), $pos_x_1, $pos_x_2) === true){
            if(EntityDamage::getY($pos->getY(), $pos_y_1, $pos_y_2) === true){
                if(EntityDamage::getZ($pos->getZ(), $pos_z_1, $pos_z_2) === true){
                    if(EntityDamage::getLevel($level_1, $level_2) === true){

                        return true;

                    }
                }
            }
        }
        
        return false;
    }

    private static function getX($x, $pos_1, $pos_2) : bool
    {
        if((min($pos_1, $pos_2) <= $x) && (max($pos_1, $pos_2) >= $x)){

          return true;

        } else return false;
    }

    private static function getY($y, $pos_1, $pos_2) : bool
    {
        if((min($pos_1, $pos_2) <= $y) && (max($pos_1, $pos_2) >= $y)){

          return true;

        } else return false;
    }

    private static function getZ($z, $pos_1, $pos_2) : bool
    {
        if((min($pos_1, $pos_2) <= $z) && (max($pos_1, $pos_2) >= $z)){

          return true;

        } else return false;
    }

    private static function getLevel($level, $levels) : bool
    {
        if($level == $level){

          return true;

        } else return false;
    }
}