<?php 

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;
use Mineeral\Utils\Config;

use Mineeral\Constants\Command;

use Mineeral\Forms\Form\PlayerForm;

class Stats extends Cmd{

    public function __construct()
    {
        parent::__construct("stats", "Permet d'affiché tes stats");
        $this->setAliases(["st"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {

        $rank = Config::onConfig($sender, "rank");
        $money = Config::onConfig($sender, "money");
        $rank_db = new C(Main::getInstance()->getDataFolder() . "/Infos/Rank.json", C::JSON);
        $money_db = new C(Main::getInstance()->getDataFolder() . "/Infos/Money.json", C::JSON);

        if($sender instanceof Player) PlayerForm::Stats($sender, $rank, $money, $rank_db, $money_db);
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;

    }
}
