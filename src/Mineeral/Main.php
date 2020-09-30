<?php

namespace Mineeral;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;

use onebone\economyapi\EconomyAPI;

use Commands\Player\Feed;
use Commands\Player\Stats;
use Commands\Player\Kits;
use Commands\Player\TopDeath;
use Commands\Player\TopKill;
use Commands\Player\Hub;
use Commands\Player\Spawn;
use Commands\Player\Money;

use Commands\Staff\Leaderboard;

use Mineeral\Event\Player\PlayerJoin;
use Mineeral\Event\Player\PlayerQuit;
use Mineeral\Event\Player\KnockBack;
use Mineeral\Event\Player\PlayerDeath;
use Mineeral\Event\Blocks\Sign;
use Mineeral\Event\Items\Soup;

use Mineeral\Entity\Death;
use Mineeral\Entity\Kill;


class Main extends PluginBase
{

    private static $instance;

    public function onEnable()
    {
        Main::$instance = $this;
        Main::getInstance()->getServer()->getLogger()->info("ServerCore is operational");
        Main::getCommands();
        Main::getEvents();
        Main::getEntity();

        @mkdir(Main::getInstance()->getDataFolder());
        Main::onConfig("kill");
        Main::onConfig("death");

        Main::getInstance()->getServer()->loadLevel("Arene");
        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);
    }

    public static function getInstance() : Main
    {

        return self::$instance;

    }

    public static function onConfig(string $config) : Config
    {

        switch($config){

            case "kill":
                return new Config(Main::getInstance()->getDataFolder(). "kill.yml", Config::YAML);
            break;

            case "death":
                return new Config(Main::getInstance()->getDataFolder(). "death.yml", Config::YAML);
            break;

        }
    }

    private static function getCommands() : void
    {

        Main::getInstance()->getServer()->getCommandMap()->register("feed", new Feed());
        Main::getInstance()->getServer()->getCommandMap()->register("stats", new Stats());
        Main::getInstance()->getServer()->getCommandMap()->register("kit", new Kits());
        Main::getInstance()->getServer()->getCommandMap()->register("td", new TopDeath());
        Main::getInstance()->getServer()->getCommandMap()->register("tk", new TopKill());
        Main::getInstance()->getServer()->getCommandMap()->register("leaderboard", new Leaderboard());
        Main::getInstance()->getServer()->getCommandMap()->register("hub", new Hub());
        Main::getInstance()->getServer()->getCommandMap()->register("spawn", new Spawn());
        Main::getInstance()->getServer()->getCommandMap()->register("money", new Money());

    }

    private static function getEvents() : void
    {

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerJoin(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerQuit(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new KnockBack(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerDeath(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Sign(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Soup(), Main::getInstance());

    }

    private static function getEntity() : void 
    {

        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);

    }
}
