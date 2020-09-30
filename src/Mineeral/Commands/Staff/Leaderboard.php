<?php

namespace Mineeral\Commands\Staff;

use Mineeral\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\Player;

class Leaderboard extends PluginCommand{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("leaderboard", $plugin);
        $this->setAliases(["leaderboard"]);
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player)return $sender->sendMessage("Commande utilisable seulement en jeu !");
        if(!$sender->hasPermission("staff.leaderboard"))return $sender->sendMessage("§4[!]§f Vous n'avez pas la permission d'utiliser cette commande !");
        if(!isset($args[0]))return $sender->sendMessage("§4[!] §fVous devez préciser lequel (§akill§f/§adeath§f)");
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
        return true;
    }
}
