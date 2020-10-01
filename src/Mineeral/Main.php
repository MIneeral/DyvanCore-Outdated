<?php

namespace Mineeral;

use pocketmine\plugin\PluginBase;

use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\utils\Config;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;

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
use Mineeral\Event\Entity\ProjectileLaunch;

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

        Main::loadLevel();
        Main::getCommands();
        Main::getEvents();
        Main::getEntity();

        $msg = Main::PREFIX_CONSOLE . "ServerCore is not operationnal";

        if(Main::getCommands() === true && Main::getEvents() === true && Main::getEntity() === true && Main::loadLevel() === true){
            $msg = Main::PREFIX_CONSOLE . "ServerCore is operational";
        } else {
            Main::getInstance()->getServer()->shutdown();
        }

        Main::getInstance()->getServer()->getLogger()->info($msg);

    }

    public static function getInstance() : Main
    {

        return self::$instance;

    }

    public static function loadLevel() : bool
    {

        foreach(scandir(Main::getInstance()->getServer()->getDataPath() . "/worlds/") as $world){

            if($world !== "." && $world !== ".." ){
                if(!(Main::getInstance()->getServer()->isLevelLoaded($world))){

                    Main::getInstance()->getServer()->loadLevel($world);

                }
            }
        }  

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX_CONSOLE . " all Levels are loaded");
        return true;

    }

    public static function onConfig(Player $player, string $key)
    {

        if(!$player->namedtag->hasTag("info", CompoundTag::class)) Main::setConfig($player, "compound", "info");

        $compound = $player->namedtag->getCompoundTag("info");

        switch($key){

            case "ip":
                if(!$compound->hasTag($key, StringTag::class)) Main::setConfig($player, "string", $key, $player->getAddress());
                return $compound->getTagValue($key, StringTag::class);
            break;

            case "rank":
                if(!$compound->hasTag($key, StringTag::class)) Main::setConfig($player, "string", $key, "Player");
                return $compound->getTagValue($key, StringTag::class);
            break;

            case "money":
                if(!$compound->hasTag($key, IntTag::class)) Main::setConfig($player, "int", $key, 1000);
                return $compound->getTagValue($key, IntTag::class);
            break;

            case "kill":
                if(!$compound->hasTag($key, IntTag::class)) Main::setConfig($player, "int", $key, 0);
                return $compound->getTagValue($key, IntTag::class);
            break;

            case "death":
                if(!$compound->hasTag($key, IntTag::class)) Main::setConfig($player, "int", $key, 0);
                return $compound->getTagValue($key, IntTag::class);
            break;

            case "ban":
                if(!$compound->hasTag($key, IntTag::class)) Main::setConfig($player, "int", $key, 0);
                return $compound->getTagValue($key, IntTag::class);
            break;

            case "tempban":
                if(!$compound->hasTag($key, IntTag::class)) Main::setConfig($player, "int", $key, 0);
                return $compound->getTagValue($key, IntTag::class);
            break;

            case "time":
                if(!$compound->hasTag($key, IntTag::class)) Main::setConfig($player, "int", $key, 0);
                return $compound->getTagValue($key, IntTag::class);
            break;

        }

        return true;

    }

    public static function setConfig(Player $player,string $type, string $key, $value = null) : bool
    {   
        if($key === "info"){

            $player->namedtag->setTag(new CompoundTag($key), false);
            return true;

        } else {

            if(!$player->namedtag->hasTag("info", CompoundTag::class)) Main::setConfig($player, "compound", "info");
            $compound = $player->namedtag->getCompoundTag("info");

            switch($type){
    
                case "string":
                    $compound->setString($key, $value);
                    return true;
                break;
    
                case "int":
                    $compound->setInt($key, $value);
                    return true;
                break;
    
            }

            return true;
            
        }
    }

    public static function onAllConfig() : array 
    {
        $array = array();

        foreach(scandir(Main::getInstance()->getServer()->getDataPath() . "/players/") as $player){

            if($player !== "." && $player !== ".."){

                $p = explode(".", $player);
                array_push($array, $p[0]);

            }
        }

        return $array;
    }


    private static function getCommands() : bool
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

        foreach($commands as $key => $value){

            Main::getInstance()->getServer()->getCommandMap()->register($key, $value);

        }

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX_CONSOLE . " all Commands are loaded");
        return true;

    }

    private static function getEvents() : bool
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
            new ProjectileLaunch(),
        ];

        foreach($events as $event) {

            Main::getInstance()->getServer()->getPluginManager()->registerEvents($event, Main::getInstance());

        }

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX_CONSOLE . " all Events are loaded");
        return true;

    }

    private static function getEntity() : bool
    {
        /*
        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX_CONSOLE . " all Entity are loaded");*/
        return true;

    }
}
