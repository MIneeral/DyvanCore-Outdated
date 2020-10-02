<?php

namespace Mineeral;

use pocketmine\plugin\PluginBase;

use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\utils\Config;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Mineeral\Commands\Player\Feed;
use Mineeral\Commands\Player\Stats;
use Mineeral\Commands\Player\Kits;
use Mineeral\Commands\Player\TopDeath;
use Mineeral\Commands\Player\TopKill;
use Mineeral\Commands\Player\Hub;
use Mineeral\Commands\Player\Spawn;

use Mineeral\Commands\Admin\Leaderboard;
use Mineeral\Commands\Admin\Rank;

use Mineeral\Commands\Player\Money\MyMoney;
use Mineeral\Commands\Player\Money\PayMoney;
use Mineeral\Commands\Player\Money\SeeMoney;

use Mineeral\Commands\Admin\Money\GiveMoney;
use Mineeral\Commands\Admin\Money\RemoveMoney;
use Mineeral\Commands\Admin\Money\SetMoney;

use Mineeral\Event\Player\PlayerChat;
use Mineeral\Event\Player\PlayerCommandPreprocess;
use Mineeral\Event\Player\PlayerJoin;
use Mineeral\Event\Player\PlayerQuit;
use Mineeral\Event\Player\PlayerDeath;
use Mineeral\Event\Player\PlayerInteract;

use Mineeral\Event\Entity\EntityDamageByEntity;
use Mineeral\Event\Entity\EntityDamage;

use Mineeral\Entity\Death;
use Mineeral\Entity\Kill;

class Main extends PluginBase
{

    private static $instance;

    public const PREFIX_DEFAULT = "§f[§c!§f] ";
    public const PREFIX_CONSOLE = "§f[§cDyn§f]§a ";

    public const PREFIX_IMPORTANT = Main::PREFIX_DEFAULT . "§f";
    public const PREFIX_GOOD = Main::PREFIX_DEFAULT . "§a";
    public const PREFIX_BAD = Main::PREFIX_DEFAULT . "§c";

    public const PREFIX_JOIN = "§f[§4+§f]§a ";
    public const PREFIX_QUIT = "§f[§4-§f]§4 ";
    public const PREFIX_KILL = "§c»§4 ";

    public function onEnable() : void
    {

        Main::$instance = $this;

        $info = 
        [
            Main::loadLevel(),
            Main::getCommands(),
            Main::getEvents(),
            Main::getEntity(),
            Main::loadServer(),
        ];

        foreach($info as $message){
 
            Main::getInstance()->getServer()->getLogger()->info($message);

        }

        @mkdir(Main::getInstance()->getDataFolder());
        @mkdir(Main::getInstance()->getDataFolder()."/Infos");
        new Config(Main::getInstance()->getDataFolder() ."/Infos/Ip.json", Config::JSON);
        new Config(Main::getInstance()->getDataFolder() ."/Infos/Rank.json", Config::JSON);
        new Config(Main::getInstance()->getDataFolder() ."/Infos/Money.json", Config::JSON);
        new Config(Main::getInstance()->getDataFolder() ."/Infos/Kill.json", Config::JSON);
        new Config(Main::getInstance()->getDataFolder() ."/Infos/Death.json", Config::JSON);
        new Config(Main::getInstance()->getDataFolder() ."/Infos/Ban.json", Config::JSON);

    }

    public static function getInstance() : Main
    {

        return Main::$instance;

    }

    private static function loadServer() : string 
    {

        if(gettype(Main::getCommands()) === "string" && gettype(Main::getEvents()) === "string" && gettype(Main::getEntity()) === "string" && gettype(Main::loadLevel()) === "string"){

            return Main::PREFIX_CONSOLE . "ServerCore is operational";

        } else {

            Main::getInstance()->getServer()->shutdown();
            return Main::PREFIX_CONSOLE . "ServerCore is not operationnal";

        }

    }
    
    private static function loadLevel() : string
    {
        $count = 0;

        foreach(scandir(Main::getInstance()->getServer()->getDataPath() . "/worlds/") as $world){

            if($world !== "." && $world !== ".." ){
                if(!(Main::getInstance()->getServer()->isLevelLoaded($world))){

                    $count = $count + 1;
                    Main::getInstance()->getServer()->loadLevel($world);

                }
            }
        }  

        return Main::PREFIX_CONSOLE . " " . $count . " Levels are loaded";

    }

    private static function getCommands() : string
    {

        $commands = 
        [
            //Command Player
            "feed" => new Feed(),
            "kit" => new Kits(),
            "stats" => new Stats(),
            "tk" => new TopKill(),
            "td" => new TopDeath(),
            "hub" => new Hub(),
            "spawn" => new Spawn(),

            //Command Admin
            "leaderboard" => new Leaderboard(),
            "rank" => new Rank(),

            //Command Money Player
            "money" => new MyMoney(),
            "pay" => new PayMoney(),
            "seemoney" => new SeeMoney(),

            //Command Money Admin
            "givemoney" => new GiveMoney(),
            "removemoney" => new RemoveMoney(),
            "setmoney" => new SetMoney(),
        ];

        $count = 0;

        foreach($commands as $key => $value){
            
            $count = $count + 1;
            Main::getInstance()->getServer()->getCommandMap()->register($key, $value);

        }

        return Main::PREFIX_CONSOLE . " " . $count . " Commands are loaded";

    }

    private static function getEvents() : string
    {

        $events = 
        [
            //Event Player
            new PlayerChat(),
            new PlayerCommandPreprocess(),
            new PlayerJoin(),
            new PlayerQuit(),
            new PlayerDeath(),
            new PlayerInteract(),

            //Event Entity
            new EntityDamageByEntity(),
            new EntityDamage(),
        ];

        $count = 0;

        foreach($events as $event) {

            $count = $count + 1;
            Main::getInstance()->getServer()->getPluginManager()->registerEvents($event, Main::getInstance());

        }

        return Main::PREFIX_CONSOLE . " " . $count . " Events are loaded";

    }

    private static function getEntity() : string
    {
        $entity = 
        [
            //Entity LearderBoard
            Kill::class,
            Death::class,
        ];

        $count = 0;

        foreach($entity as $e) {

            $count = $count + 1;
            Entity::registerEntity($e, true);

        }

        return Main::PREFIX_CONSOLE . " " . $count . " Entity are loaded";

    }

    public static function onConfig(Player $player, string $key)
    {

        switch($key){

            case "ip":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Ip.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, $player->getAddress());
                return $config->get($player->getName());
            break;

            case "rank":
                $config = new Config(Main::getInstance()->getDataFolder() ."/Infos/Rank.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, "Player");
                return $config->get($player->getName());
            break;

            case "money":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Money.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, 1000);
                return $config->get($player->getName());
            break;

            case "kill":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Kill.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, 0);
                return $config->get($player->getName());
            break;

            case "death":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Death.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, 0);
                return $config->get($player->getName());
            break;

            case "ban":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Ban.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, 0);
                return $config->get($player->getName());
            break;

            case "tempban":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/TempBan.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, 0);
                return $config->get($player->getName());
            break;

            case "time":
                $config = new Config(Main::getInstance()->getDataFolder() . "/Infos/Time.json", Config::JSON);
                if(!$config->exists($player->getName())) Main::setConfig($player, $config, 0);
                return $config->get($player->getName());
            break;

        }

        return true;

    }

    public static function setConfig(Player $player, Config $config, $value) : bool
    {   

        $config->set($player->getName(), $value);
        $config->save();
        return true;

    }
}
