<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class TopKill extends Command{

    public function __construct()
    {

        parent::__construct("tk", "Permet d'affiché le top des kills");
        $this->setAliases(["topkill"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if($sender instanceof Player) TopKill::sendTopKill($sender);
        else $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }

    public static function sendTopKill(Player $player)
    {

        $kill = new Config(Main::getInstance()->getDataFolder() . "/Infos/Kill.json", Config::JSON);
        $allkills = $kill->getAll();

        $top = 1;
        $player->sendMessage(Main::PREFIX_IMPORTANT . "Top §410§f des personnes qui ont le tuer de personnes !\n");
        
        arsort($allkills);
        foreach ($allkills as $name => $value){
            if($top > 10) break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
