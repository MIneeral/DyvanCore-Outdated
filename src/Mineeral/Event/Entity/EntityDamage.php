<?php

namespace Mineeral\Event\Entity;

use pocketmine\Player;

use pocketmine\event\Listener;

use pocketmine\level\Level;
use pocketmine\level\Position;

use pocketmine\event\entity\EntityDamageEvent;

class EntityDamage implements Listener
{   

    private const POS_X_1 = -26;
    private const POS_Y_1 = 163;
    private const POS_Z_1 = -40;

    private const POS_X_2 = 35;
    private const POS_Y_2 = 115;
    private const POS_Z_2 = 24;

    public function EntityDamage(EntityDamageEvent $ev) : void 
    {
        $level = $event->getEntity()->getLevel()->getName();
        $pos = $event->getEntity()->getPosition();

        if($event->getEntity() instanceof Player) {
            switch($event->getCause()){

                case EntityDamageEvent::CAUSE_FALL:
                    $event->setCancelled();
                break;
    
            }

            if(EntityDamage::getArene($level, $pos, EntityDamage::POS_X_1, EntityDamage::POS_X_2, EntityDamage::POS_Y_1, EntityDamage::POS_Y_2, EntityDamage::POS_Z_1, EntityDamage::POS_Z_2) === true) $event->setCancelled();
        }
    }

    public static function getArene(Level $level, Position $pos, $pos_x_1, $pos_x_2, $pos_y_1, $pos_y_2, $pos_z_1, $pos_z_2) {


        if(EntityDamage::getX($pos->getX(), $pos_x_1, $pos_x_2) === true){
            if(EntityDamage::getY($pos->getY(), $pos_y_1, $pos_y_2) === true){
                if(EntityDamage::getZ($pos->getZ(), $pos_z_1, $pos_z_2) === true){
                    if(EntityDamage::getLevel($level) === true){

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