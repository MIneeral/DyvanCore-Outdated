<?php

namespace Mineeral\Event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use Mineeral\Main;

class KnockBack implements Listener{
    public function onDamage(EntityDamageByEntityEvent $ev){
        $ev->setKnockBack(0.4);
    }
}