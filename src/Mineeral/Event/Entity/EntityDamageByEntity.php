<?php

namespace Mineeral\Event\Entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;

class EntityDamageByEntity implements Listener
{

    public function onDamage(EntityDamageByEntityEvent $ev) : void 
    {

        $ev->setKnockBack(0.4);

    }
}