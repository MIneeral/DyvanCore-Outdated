<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use pocketmine\item\Item;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use  Mineeral\Main;

class PlayerForm
{

    private const NO_MONEY = Main::PREFIX_BAD . "Vous n'avez pas assez d'argent pour ameliorer votre rank !";
    private const COMMING_SOON = Main::PREFIX_BAD . "Coming soon..";
    private const UP = " §fqui vient d'améloirer son rank à ";
    private const MAX_UP = Main::PREFIX_IMPORTANT . "Vous avez déjà un rank très haut !";
    private const WELL_DONE = "§c-§4 Bravo §c-";

    public static function Kits(Player $player) : bool
    {

        $form = new SimpleForm(function (Player $player, int $data = null){

            $result = $data;

            if($result === null){
                return true;
            }

            switch($result){
                case 0;
                    $sword1 = Item::get(276, 0, 1);
                    $soup1 = Item::get(Item::WHEAT, 0, 64);
                    $gapple = Item::get(322, 0, 8);
                    $pearl = Item::get(Item::ENDER_PEARL,0,16);
                    $helmet1 = Item::get(310, 0, 1);
                    $chestplate1 = Item::get(311, 0, 1);
                    $leggings1 = Item::get(312, 0, 1);
                    $boots1 = Item::get(313, 0, 1);
                    $player->sendMessage(Main::PREFIX_GOOD . "Vous venez de prendre le kit §4Basic");
                    $player->getInventory()->clearAll();
                    $player->getArmorInventory()->clearAll();
                    $player->getInventory()->addItem($sword1);
                    $player->getInventory()->addItem($soup1);
                    $player->getInventory()->setItem(7, $gapple);
                    $player->getInventory()->setItem(8, $pearl);
                    $player->getArmorInventory()->setHelmet($helmet1);
                    $player->getArmorInventory()->setChestplate($chestplate1);
                    $player->getArmorInventory()->setLeggings($leggings1);
                    $player->getArmorInventory()->setBoots($boots1);
                break;

                case 1;
                    $player->sendMessage(PlayerForm::COMMING_SOON);
                break;
                
                case 2;
                    $player->sendMessage(PlayerForm::COMMING_SOON);
                break;

                case 3;
                    $player->sendMessage(PlayerForm::COMMING_SOON);
                break;
            }
        });

        $form->setTitle("§c- §fKits§c-");
        $form->setContent("§c» §fVoici les différents Kits disponibles");
        $form->addButton("§7Basic\n§e[Joueur]", 0, "textures/items/gold_sword");
        $form->addButton("§7Superior\n§d[Saturne]", 0, "textures/items/iron_sword");
        $form->addButton("§7Mythical\n§5[Saturne+]", 0, "textures/items/diamond_sword");
        $form->addButton("§7Legendary\n§9[Eris]", 0, "textures/items/netherite_sword");
        $form->sendToPlayer($player);

        return true;
        
    }

    public static function Stats(Player $player, $rank, $money) : bool 
    {

        $form = new SimpleForm(function (Player $player, int $data = null) use ($rank, $money){

            $result = $data;

            if($result === null){
                return true;
            }

            switch($result){
                case 0:
                    switch($rank) {
                        case "Player":
                            if($money >= 10000){

                                Main::setConfig($player, "money", Main::onConfig($player, "money") - 10000);
                                Main::setConfig($player, "rank", "Saturne");
                                Main::getInstance()->getServer()->broadcastMessage(Main::PREFIX_IMPORTANT . "Bravo à §4" . $player->getName() . PlayerForm::UP . "§dSaturne§f !");
                                $player->sendTitle(PlayerForm::WELL_DONE);
                                $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                                return true;
    
                            } else {
    
                                $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                                $player->sendMessage(PlayerForm::NO_MONEY);
                                return true;
    
                            }
                        break;

                        case "Saturne":
                            if($money >= 30000){
                                Main::setConfig($player, "money", Main::onConfig($player, "money") - 30000);
                                Main::setConfig($player, "rank", "Saturne-Plus");
                                Main::getInstance()->getServer()->broadcastMessage(Main::PREFIX_IMPORTANT . "Bravo à §4" . $player->getName() .  PlayerForm::UP . "§5Saturne+§f !");
                                $player->sendTitle(PlayerForm::WELL_DONE);
                                $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                                return true;
                            } else {
                                $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                                $player->sendMessage(PlayerForm::NO_MONEY);
                                return true;
                            }
                        break;

                        case "Saturne-Plus":
                            if($money >= 50000){
                                Main::setConfig($player, "money", Main::onConfig($player, "money") - 50000);
                                Main::setConfig($player, "rank", "Eris");
                                Main::getInstance()->getServer()->broadcastMessage(Main::PREFIX_IMPORTANT . "§fBravo à §4" . $player->getName() .  PlayerForm::UP . "§9Eris§f !");
                                $player->sendTitle(PlayerForm::WELL_DONE);
                                $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                                return true;
                            } else {
                                $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_FALL);
                                $player->sendMessage(PlayerForm::NO_MONEY);
                                return true;
                            }
                        break;

                        default:
                            $player->sendMessage(PlayerForm::MAX_UP);
                            return true;
                        break;
                    }
                break;

                case 1;
                break;
            }
        });

        $form->setTitle("§c- §fStats §c-");
        $form->setContent("§fVotre rank actuel est:§4 " . $rank . "\n§fVous avez: §4" . $money . "\n§fUn kill = §410\n§c» §fVoici les prix des ranks payants\n\n§fSaturne: §410000\n§fSaturne+:§4 30000\n§fEris:§4 50000\n\n§c» §fVous pouvez aussi en payer un depuis la boutique disponible sur le Discord : §bhttps://discord.gg/cGPvEmu");
        $form->addButton("Améliorer son rank\n§c(" . $rank . ")", 0);
        $form->sendToPlayer($player);

        return true;

    }

}