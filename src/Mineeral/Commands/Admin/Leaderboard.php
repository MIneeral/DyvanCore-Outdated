<?php

namespace Mineeral\Commands\Admin;

use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\level\Position;

use Mineeral\Main;

class Leaderboard extends Command{

    public function __construct()
    {
        parent::__construct("leaderboard", "Permet de faire spawn le leaderboard !");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {

            if(!$sender->isOp()) return $sender->sendMessage(Main::PREFIX_IMPORTANT . "Vous n'avez pas la permission d'utiliser cette commande !");
            if(!isset($args[0])) return $sender->sendMessage(Main::PREFIX_IMPORTANT . "Vous devez préciser lequel (§akill§f/§adeath§f)");
            if(strtolower($args[0]) == "kill"){

                $position = new Position($sender->x, $sender->y+1.5, $sender->z, $sender->level);
                $nbt = Entity::createBaseNBT($position, null, 1.0, 1.0);
                $leaderboard = Entity::createEntity("Kill", $sender->level, $nbt);
                $leaderboard->spawnToAll();

            }
            if(strtolower($args[0]) == "death"){

                $position = new Position($sender->x, $sender->y+1.5, $sender->z, $sender->level);
                $nbt = Entity::createBaseNBT($position, null, 1.0, 1.0);
                $leaderboard = Entity::createEntity("Death", $sender->level, $nbt);
                $leaderboard->spawnToAll();

            }

        } else return $sender->sendMessage(Main::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !");

        return true;

    }
}
