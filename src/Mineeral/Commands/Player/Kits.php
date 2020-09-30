<?php 

namespace Mineeral\Commands\Player;

use pocketmine\command\PluginCommand;
use pocketmine\Server;
use pocketmine\Player;
use Mineeral\Main;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use onebone\economyapi\EconomyAPI;
use pocketmine\item\Item;
use pocketmine\event\Listener;

class Kits extends PluginCommand{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("kit", $plugin);

        $this->plugin = $plugin;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        $api =
Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null){
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
                    $player->sendMessage("§f[§c!§f] Vous venez de prendre le kit §4Basic");
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
                    $player->sendMessage("§f[§c!§f] §4Coming soon..");
                break;
                
                case 2;
                    $player->sendMessage("§f[§c!§f] §4Coming soon..");
                break;

                case 3;
                    $player->sendMessage("§f[§c!§f] §4Coming soon..");
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
        return $form;
    }
}
