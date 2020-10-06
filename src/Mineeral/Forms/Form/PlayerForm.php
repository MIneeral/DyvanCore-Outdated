<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\item\Item;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Rank;
use Mineeral\Constants\Form;

class PlayerForm
{

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
                    $player->sendMessage(Form::BASIC_KIT);
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

                default:
                    $player->sendMessage(Form::COMMING_SOON);
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

    public static function Stats(Player $player, $rank, $money, C $rank_db, C $money_db) : bool 
    {

        $form = new SimpleForm(function (Player $player, int $data = null) use ($rank, $money, $rank_db, $money_db){

            $result = $data;

            if($result === null){
                return true;
            }

            switch($result){
                case 0:
                    if(in_array($rank, Rank::RANK_UP)){

                        $r = Rank::RANK_UP[$rank];

                        Config::setConfig($player, $money_db, Config::onConfig($player, "money") - $r["money"]);
                        Config::setConfig($player, $rank_db, $r["rank"]);
                        Main::getInstance()->getServer()->broadcastMessage(Form::PREFIX_IMPORTANT . "Bravo à §4" . $player->getName() . Form::UP . $r["prefix"] . "§f !");
                        $player->sendTitle(Form::WELL_DONE);
                        $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                        return true;

                    } else {

                        $player->sendMessage(Form::MAX_UP);
                        return true;

                    }
                break;

                case 1;
                break;
            }
        });

        $msg = "\n\n";

        foreach($ranks as $key => $value){

            $msg = $msg . "§f" . $value["rank"] . ": §7" . $value["money"] . "\n";

        }

        $form->setTitle("§8- §fStats §8-");
        $form->setContent("§fRank: §7" . $rank . "\n§fKills: §7" . Config::onConfig($player, "kill") . "\n§fDeaths: §7" . Config::onConfig($player, "death") . "\n§fMoney: §7" . $money . "\n\n§8» §fVoici les prix des ranks payants:" . $msg . "\n§8» §fRappel 1 kill est égal à §710\n");
        $form->addButton("Améliorer\n" . Rank::RANK_TEXT[$rank], 0, "textures/blocks/netherite_block");
        $form->sendToPlayer($player);

        return true;

    }

}