<?php

namespace Mineeral\Forms\Form;

use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\item\Item;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Forms\FormAPI\CustomForm;
use Mineeral\Forms\FormAPI\ModalForm;
use Mineeral\Forms\FormAPI\SimpleForm;

use Mineeral\Main;
use Mineeral\Event\Player\PlayerChat;

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
                    $player->sendMessage(Main::PREFIX_IMPORTANT . "Vous venez de prendre le kit §4Basic");
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

    public static function Stats(Player $player, $rank, $money, Config $rank_db, Config $money_db) : bool 
    {
        $ranks = 
        [
            "Player" => 
            [
                "rank" => "Saturne",
                "money" => 10000,
                "prefix" => "§dSaturne"
            ],

            "Saturne" => 
            [
                "rank" => "Saturne-Plus",
                "money" => 30000,
                "prefix" => "§5Saturne+"
            ],

            "Saturne-Plus" => 
            [
                "rank" => "Eris",
                "money" => 50000,
                "prefix" => "§9Eris"
            ],

        ];

        $form = new SimpleForm(function (Player $player, int $data = null) use ($rank, $ranks, $money, $rank_db, $money_db){

            $result = $data;

            if($result === null){
                return true;
            }

            switch($result){
                case 0:
                    if(in_array($rank, $ranks)){

                        $r = $ranks[$rank];

                        Main::setConfig($player, $money_db, Main::onConfig($player, "money") - $r["money"]);
                        Main::setConfig($player, $rank_db, $r["rank"]);
                        Main::getInstance()->getServer()->broadcastMessage(Main::PREFIX_IMPORTANT . "Bravo à §4" . $player->getName() . PlayerForm::UP . $r["prefix"] . "§f !");
                        $player->sendTitle(PlayerForm::WELL_DONE);
                        $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_TOTEM);
                        return true;

                    } else {

                        $player->sendMessage(PlayerForm::MAX_UP);
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
        $form->setContent("§fRank: §7" . $rank . "\n§fKills: §7" . Main::onConfig($player, "kill") . "\n§fDeaths: §7" . Main::onConfig($player, "death") . "\n§fMoney: §7" . $money . "\n\n§8» §fVoici les prix des ranks payants:" . $msg . "\n§8» §fRappel 1 kill est égal à §710\n");
        $form->addButton("Améliorer\n" . PlayerChat::RANKS[$rank], 0, "textures/blocks/netherite_block");
        $form->sendToPlayer($player);

        return true;

    }

}