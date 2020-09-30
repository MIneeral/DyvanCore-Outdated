<?php 

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;
use Mineeral\Forms\Form\Commands;

use onebone\economyapi\EconomyAPI;

class Stats extends Command{

    public function __construct()
    {
        parent::__construct("stats", "Permet d'affiché tes stats");
        $this->setAliases(["st"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        $rank = Main::onConfig($player, "rank");
        $money = Main::onConfig($player, "money");

        if(!$sender instanceof Player) return $sender->sendMessage("Commande utilisable seulement en jeu !");
            Commands::Stats($sender, $rank, $money);
        return true;
    }
}
