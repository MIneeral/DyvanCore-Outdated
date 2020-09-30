<?php 

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use pocketmine\item\Item;

use onebone\economyapi\EconomyAPI;

use Mineeral\Main;

class Kits extends Command{

    public function __construct()
    {

        parent::__construct("kit", "Permet d'affiché les kits");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        $api = Main::getInstance()->getServer()->getPluginManager()->getPlugin("FormAPI");

        $form = $api->createSimpleForm(function (Player $sender, int $data = null){

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
                    $sender->sendMessage("§f[§c!§f] Vous venez de prendre le kit §4Basic");
                    $sender->getInventory()->clearAll();
                    $sender->getArmorInventory()->clearAll();
                    $sender->getInventory()->addItem($sword1);
                    $sender->getInventory()->addItem($soup1);
                    $sender->getInventory()->setItem(7, $gapple);
                    $sender->getInventory()->setItem(8, $pearl);
                    $sender->getArmorInventory()->setHelmet($helmet1);
                    $sender->getArmorInventory()->setChestplate($chestplate1);
                    $sender->getArmorInventory()->setLeggings($leggings1);
                    $sender->getArmorInventory()->setBoots($boots1);
                break;

                case 1;
                    $sender->sendMessage("§f[§c!§f] §4Coming soon..");
                break;
                
                case 2;
                    $sender->sendMessage("§f[§c!§f] §4Coming soon..");
                break;

                case 3;
                    $sender->sendMessage("§f[§c!§f] §4Coming soon..");
                break;
            }
        });

        $form->setTitle("§c- §fKits§c-");
        $form->setContent("§c» §fVoici les différents Kits disponibles");

        $form->addButton("§7Basic\n§e[Joueur]", 0, "textures/items/gold_sword");
        $form->addButton("§7Superior\n§d[Saturne]", 0, "textures/items/iron_sword");
        $form->addButton("§7Mythical\n§5[Saturne+]", 0, "textures/items/diamond_sword");
        $form->addButton("§7Legendary\n§9[Eris]", 0, "textures/items/netherite_sword");

        $form->sendToPlayer($sender);

        return true;

    }
}
