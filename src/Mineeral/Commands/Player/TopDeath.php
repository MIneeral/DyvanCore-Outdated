<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\Config as C;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandSender;

use Mineeral\Main;

use Mineeral\Constants\Prefix;
use Mineeral\Constants\Command;

class TopDeath extends Cmd{

    public function __construct()
    {

        parent::__construct("td", "Permet d'affiché le top des deaths");
        $this->setAliases(["topdeath"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) TopDeath::sendTopDeath($sender);
        else $sender->sendMessage(Command::ONLY_GAME);

        return true;
    }

    public static function sendTopDeath(Player $player)
    {
        
        $death = new C(Main::getInstance()->getDataFolder() . "/Infos/Death.json", C::JSON);
        $alldeaths = $death->getAll();

        $top = 1;
        $player->sendMessage(Prefix::IMPORTANT . "Top §410§f des personnes les plus mort(s) !\n");

        arsort($alldeaths);
        foreach ($alldeaths as $name => $value){
            if($top > 10)break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
