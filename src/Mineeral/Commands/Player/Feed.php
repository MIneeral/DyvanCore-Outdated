<?php

namespace Mineeral\Commands\Player;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Mineeral\Main;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class Feed extends PluginCommand{

    private $plugin;

    public function __construct(Main $plugin){
        parent::__construct("feed", $plugin);
        $this->plugin = $plugin;
    }
    public function execute(CommandSender $player, string $commandLabel, array $args){
            $player->addFood(20);
            $player->sendPopup("§c-§f Vous avez bien été nourris§c -");
            $player->getLevel()->broadcastLevelEvent($player->add(0, $player->getEyeHeight()), LevelEventPacket::EVENT_SOUND_ANVIL_USE);
        }
}
