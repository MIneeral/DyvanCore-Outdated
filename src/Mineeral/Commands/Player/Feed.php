<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use Mineeral\Main;

class Feed extends Command{

    public function __construct()
    {

        parent::__construct("feed", "Vous permez d'être nourris !");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if(!$sender instanceof Player) return $sender->sendMessage(Main::PREFIX_IMPORTANT .  "Commande utilisable seulement en jeu !");

        $sender->addFood(20);
        $sender->sendPopup(Main::PREFIX_GOOD . "Vous avez bien été nourris§c -");
        $sender->getLevel()->broadcastLevelEvent($sender->add(0, $sender->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_USE);

    }
}
