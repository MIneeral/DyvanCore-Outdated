<?php

namespace Mineeral\Event\Items;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;

class Soup implements Listener
{

    public function InteractEvent(PlayerInteractEvent $event) : void 
    {

        $item_id = $event->getItem()->getId();
        $player = $event->getPlayer();
        $inventory = $player->getInventory();

        if($item_id === Item::WHEAT){

            if($player->getHealth() >= 17){

                $inventory->removeItem(Item::get(Item::WHEAT, 0, 1));
                $inventory->addItem(Item::get(281, 0, 1));
                $player->setHealth($player->getHealth() + 3);

            }
        }
    }
}