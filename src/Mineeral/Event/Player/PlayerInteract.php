<?php

namespace Mineeral\Event\Player;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\item\Item;

use pocketmine\inventory\Inventory;
use pocketmine\inventory\ArmorInventory;

use Mineeral\Main;
use Mineeral\Constants\Event;

class PlayerInteract implements Listener
{   

    private static $cooldown = array();

    private const TIME_SIGN_POST = 1;
    private const TIME_WHEAT = 0.1;
    private const TIME_ENDER_PEARL = 10;

    public function PlayerInteractEvent(PlayerInteractEvent $event) : void 
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

                /**
                 * TODO Fix ENDER_PEARL because it's glitch
                 */
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

        $diamond_sword = Item::get(Item::DIAMOND_SWORD, 0, 1);
        $wheat = Item::get(Item::WHEAT, 0, 64);
        $golden_apple = Item::get(Item::GOLDEN_APPLE, 0, 8);
        $ender_pearl = Item::get(Item::ENDER_PEARL,0,16);
        $diamond_helmet = Item::get(Item::DIAMOND_HELMET, 0, 1);
        $diamond_chestplate = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
        $diamond_leggings = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
        $diamond_boots = Item::get(Item::DIAMOND_BOOTS, 0, 1);
    
        $inventory->addItem($diamond_sword);
        $inventory->addItem($wheat);
        $inventory->setItem(7, $golden_apple);
        $inventory->setItem(8, $ender_pearl);

        $armor->setHelmet($diamond_helmet);
        $armor->setChestplate($diamond_chestplate);
        $armor->setLeggings($diamond_leggings);
        $armor->setBoots($diamond_boots);

        $player->sendMessage(Event::BASIC_KIT);

    }

    private static function onHeal(Player $player, Inventory $inventory) : void 
    {

        $inventory->removeItem(Item::get(Item::WHEAT, 0, 1));
        $inventory->addItem(Item::get(281, 0, 1));
        $player->setHealth($player->getHealth() + 2);
        $player->sendPopup("§c+2");

    }
}
