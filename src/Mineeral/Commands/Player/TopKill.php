<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class TopKill extends Command{

    public function __construct()
    {

        parent::__construct("tk", "Permet d'affiché le top des kills");
        $this->setAliases(["topkill"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage(Main::getPrefix("important") . "Commande utilisable seulement en jeu !");
        return TopKill::sendTopKill($sender);
    }

    public static function sendTopKill(Player $player)
    {

        $allkills = array();

        foreach(Main::onAllConfig() as $p) {

            $player = Main::getInstance()->getServer()->getPlayer($p);
            $allkills[$player->getName()] = $player->namedtag->kill;

        }

        $top = 1;
        $player->sendMessage(Main::getPrefix("important") . "Top §410§f des personnes qui ont le tuer de personnes !\n");
        
        arsort($allkills);
        foreach ($allkills as $name => $value){
            if($top > 10) break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
