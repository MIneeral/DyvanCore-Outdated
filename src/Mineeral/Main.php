<?php

namespace Mineeral;

use Mineeral\Entity\Death;
use Mineeral\Entity\Kill;
use Mineeral\Event\PlayerDeath;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase
{

    public $kill;
    public $death;
    private static $instance;

    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->getServer()->getLogger()->info("ServerCore is operational");
        $this->kill = new Config($this->getDataFolder(). "kill.yml", Config::YAML);
        $this->death = new Config($this->getDataFolder(). "death.yml", Config::YAML);
       $this->getServer()->getPluginManager()->registerEvents(new Event\QuitJoinEvent(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Event\KnockBack(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerDeath($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Event\Blocks\Sign(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Event\Items\Soup(), $this);
        $this->getServer()->getCommandMap()->register("feed", new Commands\Player\Feed($this));
        $this->getServer()->getCommandMap()->register("stats", new Commands\Player\Stats($this));
        $this->getServer()->getCommandMap()->register("kit", new Commands\Player\Kits($this));
        $this->getServer()->getCommandMap()->register("leaderboard", new Commands\Staff\Leaderboard($this));
        $this->getServer()->getCommandMap()->register("td", new Commands\Player\TopDeath($this));
        $this->getServer()->getCommandMap()->register("tk", new Commands\Player\TopKill($this));
        self::$instance = $this;
        $this->getServer()->loadLevel("Arene");
        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);
    }
   public function onDisable()
{
        $this->kill->save();
        $this->death->save();

    }
   public static function getInstance(){
        return self::$instance;
    }
    public function onCommand(CommandSender $player, Command $cmd, string $label, array $args) : bool{
        switch($cmd->getName()){
            case "spawn":
                $player->teleport($this->getServer()->getLevelByName("Arene")->getSafeSpawn());
                $player->sendMessage("§f[§c!§f] Vous avez bien était téléporter au spawn");
                break;
            case "hub":
                $player->teleport($this->getServer()->getLevelByName("Arene")->getSafeSpawn());
                $player->sendMessage("§f[§c!§f] Vous avez bien était téléporter au lobby");
                break;
            case "money":
                $money = EconomyAPI::getInstance()->myMoney($player);
                $player->sendMessage("§f[§c!§f] Vous avez §4" . $money . "");
                break;
        }
        return true;
    }
}
