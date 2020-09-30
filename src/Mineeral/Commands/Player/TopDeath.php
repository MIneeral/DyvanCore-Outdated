<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

use Mineeral\Main;

class TopDeath extends Command{

    public function __construct()
    {

        parent::__construct("td", "Permet d'affiché le top des deaths");
        $this->setAliases(["topdeath"]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) return $sender->sendMessage("Commande utilisable seulement en jeu !");
        return TopDeath::sendTopDeath($sender);
    }

    public static function sendTopDeath(Player $player)
    {

        $config = Main::onConfig("death")->getAll();
        $top = 1;
        $player->sendMessage("§f[§c!§f]§f Top §410§f des personnes les plus morts !\n");

        arsort($config);
        foreach ($config as $name => $value){
            if($top > 10)break;
                $player->sendMessage("§8»§4 #{$top} §c{$name}§f avec §c{$value}§f mort(s)§8 »\n");
                $top ++;
        }
    }
}
