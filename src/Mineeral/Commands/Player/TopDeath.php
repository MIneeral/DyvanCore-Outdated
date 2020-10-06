<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;
use Mineeral\Utils\Message;

class TopDeath extends Command{

    public function __construct()
    {

        parent::__construct("td", "Permet d'affiché le top des deaths");
        $this->setAliases(["topdeath"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) TopDeath::sendTopDeath($sender);
        else $sender->sendMessage(Message::ONLY_GAME);

        return true;
    }

    public static function sendTopDeath(Player $player)
    {
        
        $death = new C(Main::getInstance()->getDataFolder() . "/Infos/Death.json", C::JSON);
        $alldeaths = $death->getAll();

        $top = 1;
        $player->sendMessage(Message::PREFIX_IMPORTANT . "Top §410§f des personnes les plus mort(s) !\n");

        arsort($alldeaths);
        foreach ($alldeaths as $name => $value){
            if($top > 10)break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
