<?php

namespace Mineeral\Event\Block;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;

use Mineeral\Main;

class BlockPlace implements Listener
{

    public function BlockPlaceEvent(BlockPlaceEvent $event) : void 
    {

        if($event->getPlayer()->getLevel()->getName() == "Arene") $event->setCancelled();

    }
}
