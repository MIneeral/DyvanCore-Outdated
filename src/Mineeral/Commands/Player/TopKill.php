<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;

use Mineeral\Constants\Prefix;

class TopKill extends Cmd{

    public function __construct()
    {

        parent::__construct("tk", "Permet d'affiché le top des kills");
        $this->setAliases(["topkill"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) TopKill::sendTopKill($sender);
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;

    }

    public static function sendTopKill(Player $player)
    {

        $kill = new C(Main::getInstance()->getDataFolder() . "/Infos/Kill.json", C::JSON);
        $allkills = $kill->getAll();

        $top = 1;
        $player->sendMessage(Prefix::IMPORTANT . "Top §410§f des personnes avec le plus de kill(s) !\n");
        
        arsort($allkills);
        foreach ($allkills as $name => $value){
            if($top > 10) break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
