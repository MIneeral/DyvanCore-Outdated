<?php

namespace Mineeral\Commands\Player;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Main;

class TopDeath extends Command{

    public function __construct()
    {

        parent::__construct("td", "Permet d'affiché le top des deaths");
        $this->setAliases(["topdeath"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");
        return TopDeath::sendTopDeath($sender);
    }

    public static function sendTopDeath(Player $player)
    {

        $alldeaths = array();

        foreach(Main::onAllConfig() as $p) {

            $player = Main::getInstance()->getServer()->getPlayer($p);
            $alldeaths[$player->getName()] = $player->namedtag->death;

        }

        $top = 1;
        $player->sendMessage(Main::PREFIX_IMPORTANT . "Top §410§f des personnes les plus morts !\n");

        arsort($alldeaths);
        foreach ($alldeaths as $name => $value){
            if($top > 10)break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
