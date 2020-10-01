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
use Mineeral\Commands\Player\Money;

use Mineeral\Commands\Staff\Leaderboard;

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

    public const PREFIX = "§3[§6Dyvan§3] §a";

    public function onEnable() : void
    {

        Main::$instance = $this;

        Main::loadLevel();
        Main::getCommands();
        Main::getEvents();
        Main::getEntity();

        $msg = Main::PREFIX . "ServerCore is not operationnal";

        if(Main::getCommands() === true && Main::getEvents() === true && Main::getEntity() === true && Main::loadLevel() === true) $msg = Main::PREFIX . "ServerCore is operational";
        else Main::getInstance()->getServer()->shutdown();

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

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX . " all Levels are loaded");
        return true;

    }

    public static function onConfig(Player $player, string $type)
    {

        switch($type){

            case "ip":
                if(!$player->namedtag->ip) return Main::setConfig($player, $type, $player->getAddress());
                return $player->namedtag->ip;
            break;

            case "rank":
                if(!$player->namedtag->rank) return Main::setConfig($player, $type, "Player");
                return $player->namedtag->rank;
            break;

            case "money":
                if(!$player->namedtag->money) return Main::setConfig($player, $type, 1000);
                return $player->namedtag->money;
            break;

            case "kill":
                if(!$player->namedtag->kill) return Main::setConfig($player, $type, 0);
                return $player->namedtag->kill;
            break;

            case "death":
                if(!$player->namedtag->death) return Main::setConfig($player, $type, 0);
                return $player->namedtag->death;
            break;

            case "ban":
                if(!$player->namedtag->ban) return Main::setConfig($player, $type, 0);
                return $player->namedtag->ban;
            break;

            case "tempban":
                if(!$player->namedtag->tempban) return Main::setConfig($player, $type, 0);
                return $player->namedtag->tempban;
            break;

        }
    }

    public static function setConfig(Player $player, string $type, $value) : bool
    {

        switch($type){

            case "ip":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->ip = new StringTag("IP", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "rank":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->rank = new StringTag("RANK", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "money":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->money = new IntTag("MONEY", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "kill":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->kill = new IntTag("KILL", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "death":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->death = new IntTag("DEATH", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "ban":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->ban = new IntTag("BAN", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "bantemp":
                $nbt = $player->namedtag ?? new CompoundTag("", []);
                $nbt->bantemp = new IntTag("BANTEMP", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

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

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX . " all Commands are loaded");
        return true;

    }

    private static function getEvents() : bool
    {

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerJoin(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerQuit(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerDeath(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerInteract(), Main::getInstance());

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new EntityDamageByEntity(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new ProjectileLaunch(), Main::getInstance());

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Soup(), Main::getInstance());

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX . " all Events are loaded");
        return true;

    }

    /**
     * TODO FIX ERROR
     */

    private static function getEntity() : bool
    {

        /*Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);

        Main::getInstance()->getServer()->getLogger()->info(Main::PREFIX . " all Entity are loaded");*/
        return true;

    }
}
