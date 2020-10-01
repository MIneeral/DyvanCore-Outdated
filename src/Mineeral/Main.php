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
use Mineeral\Commands\Player\Money;

use Mineeral\Commands\Staff\Leaderboard;

use Mineeral\Event\Player\PlayerCommandPreprocess;
use Mineeral\Event\Player\PlayerJoin;
use Mineeral\Event\Player\PlayerQuit;
use Mineeral\Event\Player\PlayerDeath;
use Mineeral\Event\Player\PlayerInteract;

use Mineeral\Event\Entity\EntityDamageByEntity;
use Mineeral\Event\Entity\ProjectileLaunch;

use Mineeral\Event\Items\Soup;

use Mineeral\Entity\Death;
use Mineeral\Entity\Kill;


class Main extends PluginBase
{

    private static $instance;

    public const PREFIX = "§f[§cDyn§f]";

    public function onEnable() : void
    {

        Main::$instance = $this;

        Main::loadLevel();
        Main::getCommands();
        Main::getEvents();
        Main::getEntity();

        $msg = Main::getPrefix("console") . "ServerCore is not operationnal";

        if(Main::getCommands() === true && Main::getEvents() === true && Main::getEntity() === true && Main::loadLevel() === true) $msg = Main::getPrefix("console") . "ServerCore is operational";
        else Main::getInstance()->getServer()->shutdown();

        Main::getInstance()->getServer()->getLogger()->info($msg);

    }

    public static function getInstance() : Main
    {

        return self::$instance;

    }

    public static function getPrefix(string $type) : string
    {

        switch($type){

            case "console":
                return Main::PREFIX . "§a ";
            break;

            case "important":
                return "§f(§4!§f)§f ";
            break;

            case "good":
                return "§f[§c!§f] ";
            break;

            case "join":
                return "§f[§4+§f]§a ";
            break;

            case "quit":
                return "§f[§4-§f]§4 ";
            break;

            case "kill":
                return Main::PREFIX . "§c»§4 ";
            break;

            default:
                return Main::PREFIX . " ";
            break;

        }
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

        Main::getInstance()->getServer()->getLogger()->info(Main::getPrefix("console") . " all Levels are loaded");
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

        }
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

        Main::getInstance()->getServer()->getCommandMap()->register("feed", new Feed());
        Main::getInstance()->getServer()->getCommandMap()->register("stats", new Stats());
        Main::getInstance()->getServer()->getCommandMap()->register("kit", new Kits());
        Main::getInstance()->getServer()->getCommandMap()->register("td", new TopDeath());
        Main::getInstance()->getServer()->getCommandMap()->register("tk", new TopKill());
        Main::getInstance()->getServer()->getCommandMap()->register("leaderboard", new Leaderboard());
        Main::getInstance()->getServer()->getCommandMap()->register("hub", new Hub());
        Main::getInstance()->getServer()->getCommandMap()->register("spawn", new Spawn());
        Main::getInstance()->getServer()->getCommandMap()->register("money", new Money());

        Main::getInstance()->getServer()->getLogger()->info(Main::getPrefix("console") . " all Commands are loaded");
        return true;

    }

    private static function getEvents() : bool
    {

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerCommandPreprocess(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerJoin(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerQuit(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerDeath(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerInteract(), Main::getInstance());

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new EntityDamageByEntity(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new ProjectileLaunch(), Main::getInstance());

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Soup(), Main::getInstance());

        Main::getInstance()->getServer()->getLogger()->info(Main::getPrefix("console") . " all Events are loaded");
        return true;

    }

    private static function getEntity() : bool
    {

        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);

        Main::getInstance()->getServer()->getLogger()->info(Main::getPrefix("console") . " all Entity are loaded");
        return true;

    }
}
