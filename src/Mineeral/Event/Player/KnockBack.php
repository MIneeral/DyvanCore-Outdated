<?php

namespace Mineeral\Event\Player;

use pocketmine\event\entity\EntityDamageByEntityEvent as PlayerDamageByPlayerEvent;
use pocketmine\event\Listener;

class KnockBack implements Listener
{

    public function onDamage(PlayerDamageByPlayerEvent $ev) : void 
    {

        $ev->setKnockBack(0.4);

    }
}