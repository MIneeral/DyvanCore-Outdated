<?php

namespace Mineeral\Event\Items;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use Mineeral\Main;

class Soup implements Listener{
    public function InteractEvent(PlayerInteractEvent $event){
        $item = $event->getItem();
        $player = $event->getPlayer();
        if($item->getId() == Item::WHEAT){
            if($player->getHealth() == 17){
            } else {
                $player->getInventory()->removeItem(Item::get(Item::WHEAT, 0, 1));
                $player->getInventory()->addItem(Item::get(281, 0, 1));
                $player->setHealth($player->getHealth()+3);
            }
        }
    }
}