<?php

namespace Mineeral\Event\Block;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

use Mineeral\Main;

class BlockBreak implements Listener
{

    public function BlockBreakEvent(BlockBreakEvent $event) : void 
    {

        if($event->getPlayer()->getLevel()->getName() == "Arene") $event->setCancelled();

    }
}
