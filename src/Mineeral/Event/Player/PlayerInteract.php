<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\item\Item;

use pocketmine\inventory\Inventory;
use pocketmine\inventory\ArmorInventory;

use Mineeral\Main;

class PlayerInteract implements Listener
{   

    private static $cooldown = array();

    private const TIME_SIGN_POST = 1;
    private const TIME_WHEAT = 0.1;
    private const TIME_ENDER_PEARL = 10;

    public function onInteract(PlayerInteractEvent $event) : void 
    {

        $block_id = $event->getBlock()->getId();
        $item_id = $event->getItem()->getId();
        $player = $event->getPlayer();
        $inventory = $player->getInventory();
        $armor = $player->getArmorInventory();

        if($block_id === Item::SIGN_POST){
            if(!isset(PlayerInteract::$cooldown[$player->getName()])) {

                PlayerInteract::onSign($player, $inventory, $armor);
                PlayerInteract::$cooldown[$player->getName()] = time() + PlayerInteract::TIME_SIGN_POST;

            } else if (time() > PlayerInteract::$cooldown[$player->getName()]){

                PlayerInteract::onSign($player, $inventory, $armor);
                PlayerInteract::$cooldown[$player->getName()] = time() + PlayerInteract::TIME_SIGN_POST;

            }
        } else {

            switch($item_id){

                case Item::WHEAT:
                    if($player->getHealth() >= 18){
                        if(!isset(PlayerInteract::$cooldown[$player->getName()])) {
        
                            PlayerInteract::onHeal($player, $inventory);
                            PlayerInteract::$cooldown[$player->getName()] = time() + PlayerInteract::TIME_WHEAT;
            
                        } else if (time() > PlayerInteract::$cooldown[$player->getName()]){
            
                            PlayerInteract::onHeal($player, $inventory);
                            PlayerInteract::$cooldown[$player->getName()] = time() + PlayerInteract::TIME_WHEAT;
            
                        }
                    }
                break;

                case Item::ENDER_PEARL:
                    if(isset(PlayerInteract::$cooldown[$player->getName()]) && time() < PlayerInteract::$cooldown[$player->getName()]) {
    
                        $event->setCancelled();
        
                    } else {
        
                        PlayerInteract::$cooldown[$player->getName()] = time() + PlayerInteract::TIME_ENDER_PEARL;
        
                    }
                break;
                
            }
        }
    }

    private static function onSign(Player $player, Inventory $inventory, ArmorInventory $armor) : void 
    {

        $inventory->clearAll();
        $armor->clearAll();

        $sword1 = Item::get(276, 0, 1);
        $soup1 = Item::get(Item::WHEAT, 0, 64);
        $gapple = Item::get(322, 0, 8);
        $pearl = Item::get(Item::ENDER_PEARL,0,16);
        $helmet1 = Item::get(310, 0, 1);
        $chestplate1 = Item::get(311, 0, 1);
        $leggings1 = Item::get(312, 0, 1);
        $boots1 = Item::get(313, 0, 1);
    
        $inventory->addItem($sword1);
        $inventory->addItem($soup1);
        $inventory->addItem($soup1);
        $inventory->setItem(7, $gapple);
        $inventory->setItem(8, $pearl);

        $armor->setHelmet($helmet1);
        $armor->setChestplate($chestplate1);
        $armor->setLeggings($leggings1);
        $armor->setBoots($boots1);

        $player->sendMessage(Main::PREFIX_IMPORTANT . "Vous venez de prendre le kit §4Basic§f !");

    }

    private static function onHeal(Player $player, Inventory $inventory) : void 
    {

        $inventory->removeItem(Item::get(Item::WHEAT, 0, 1));
        $inventory->addItem(Item::get(281, 0, 1));
        $player->setHealth($player->getHealth() + 2);
        $player->sendPopup("§c+2");

    }
}
