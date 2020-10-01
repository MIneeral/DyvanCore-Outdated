<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\item\Item;

use pocketmine\inventory\Inventory;

use Mineeral\Main;

class PlayerInteract implements Listener
{   

    private static $cooldown = array();

    public function onInteract(PlayerInteractEvent $event) : void 
    {

        $block_id = $event->getBlock()->getId();
        $item_id = $event->getItem()->getId();
        $player = $event->getPlayer();
        $inventory = $player->getInventory();

        if($item_id === Item::WHEAT){
            if($player->getHealth() >= 17){

                if(!isset(PlayerInteract::$cooldown[$player->getName()])) {

                    $inventory->removeItem(Item::get(Item::WHEAT, 0, 1));
                    $inventory->addItem(Item::get(281, 0, 1));
                    $player->setHealth($player->getHealth() + 3);
                    $player->sendPopup("+3");
                    PlayerInteract::$cooldown[$player->getName()] = time() + 0.3;
    
                } else if (time() > PlayerInteract::$cooldown[$player->getName()]){
    
                    unset(PlayerInteract::$cooldown[$player->getName()]);
                    $inventory->removeItem(Item::get(Item::WHEAT, 0, 1));
                    $inventory->addItem(Item::get(281, 0, 1));
                    $player->setHealth($player->getHealth() + 3);
                    PlayerInteract::$cooldown[$player->getName()] = time() + 0.3;
    
                }
            }
        } else if($block_id === Item::SIGN_POST){

            if(!isset(PlayerInteract::$cooldown[$player->getName()])) {

                PlayerInteract::onSign($player);
                PlayerInteract::$cooldown[$player->getName()] = time() + 1;

            } else if (time() > PlayerInteract::$cooldown[$player->getName()]){

                unset(PlayerInteract::$cooldown[$player->getName()]);
                PlayerInteract::onSign($player);
                PlayerInteract::$cooldown[$player->getName()] = time() + 1;

            }
        }
    }

    private static function onSign(Player $player) : void 
    {

        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();

        $sword1 = Item::get(276, 0, 1);
        $soup1 = Item::get(Item::WHEAT, 0, 64);
        $gapple = Item::get(322, 0, 8);
        $pearl = Item::get(Item::ENDER_PEARL,0,16);
        $helmet1 = Item::get(310, 0, 1);
        $chestplate1 = Item::get(311, 0, 1);
        $leggings1 = Item::get(312, 0, 1);
        $boots1 = Item::get(313, 0, 1);
    
        $player->getInventory()->addItem($sword1);
        $player->getInventory()->addItem($soup1);
        $player->getInventory()->setItem(7, $gapple);
        $player->getInventory()->setItem(8, $pearl);

        $player->getArmorInventory()->setHelmet($helmet1);
        $player->getArmorInventory()->setChestplate($chestplate1);
        $player->getArmorInventory()->setLeggings($leggings1);
        $player->getArmorInventory()->setBoots($boots1);

        $player->sendMessage(Main::PREFIX_GOOD . "Vous venez de prendre le kit §4Basic");

    }
}
