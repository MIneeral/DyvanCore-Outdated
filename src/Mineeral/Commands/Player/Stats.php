<?php 

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;
use Mineeral\Forms\Form\PlayerForm;

class Stats extends Command{

    public function __construct()
    {
        parent::__construct("stats", "Permet d'affiché tes stats");
        $this->setAliases(["st"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        $rank = Main::onConfig($sender, "rank");
        $money = Main::onConfig($sender, "money");
        $rank_db = new Config(Main::getInstance()->getDataFolder() . "/Infos/Rank.json", Config::JSON);
        $money_db = new Config(Main::getInstance()->getDataFolder() . "/Infos/Money.json", Config::JSON);

        if($sender instanceof Player) PlayerForm::Stats($sender, $rank, $money, $rank_db, $money_db);
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
