<?php

namespace Mineeral;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;

use onebone\economyapi\EconomyAPI;

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

    public function onEnable()
    {

        Main::$instance = $this;
        Main::getInstance()->getServer()->getLogger()->info("ServerCore is operational");
        Main::getCommands();
        Main::getEvents();
        Main::getEntity();
        Main::loadLevel();

        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);

    }

    public static function getInstance() : Main
    {

        return self::$instance;

    }

    public static function loadLevel() 
    {

        foreach(scandir(Main::getInstance()->getServer()->getDataPath() . "/worlds/") as $world){

            if($world !== "." && $world !== ".." ){
                if(!(Main::getInstance()->getServer()->isLevelLoaded($world))){

                    Main::getInstance()->getServer()->loadLevel($world);

                }
            }
        }
    }

    public static function onConfig(Player $player, string $type) : void
    {

        switch($type){

            case "ip":
                if(!$player->getNamedTag()->ip) return Main::setConfig($player, $type, $player->getAddress());
                return $player->getNamedTag()->ip;
            break;

            case "rank":
                if(!$player->getNamedTag()->rank) return Main::setConfig($player, $type, "Player");
                return $player->getNamedTag()->rank;
            break;

            case "money":
                if(!$player->getNamedTag()->money) return Main::setConfig($player, $type, 1000);
                return $player->getNamedTag()->money;
            break;

            case "kill":
                if(!$player->getNamedTag()->kill) return Main::setConfig($player, $type, 0);
                return $player->getNamedTag()->kill;
            break;

            case "death":
                if(!$player->getNamedTag()->death) return Main::setConfig($player, $type, 0);
                return $player->getNamedTag()->death;
            break;

            case "ban":
                if(!$player->getNamedTag()->ban) return Main::setConfig($player, $type, 0);
                return $player->getNamedTag()->ban;
            break;

            case "tempban":
                if(!$player->getNamedTag()->tempban) return Main::setConfig($player, $type, 0);
                return $player->getNamedTag()->tempban;
            break;

        }
    }

    public static function setConfig(Player $player, string $type, $value) : bool
    {

        switch($type){

            case "ip":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->ip = new StringTag("IP", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "rank":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->rank = new StringTag("RANK", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "money":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->money = new IntTag("MONEY", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "kill":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->kill = new IntTag("KILL", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "death":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->death = new IntTag("DEATH", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "ban":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->ban = new IntTag("BAN", $value);
                $player->setNamedTag($nbt);
                return true;
            break;

            case "bantemp":
                $nbt = $player->getNamedTag() ?? new CompoundTag("", []);
                $nbt->bantemp = new IntTag("BANTEMP", $value);
                $player->setNamedTag($nbt);
                return true;
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
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerDeath(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PlayerInteract(), Main::getInstance());

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new EntityDamageByEntity(), Main::getInstance());
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new ProjectileLaunch(), Main::getInstance());

        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Soup(), Main::getInstance());

    }

    private static function getEntity() : void 
    {

        Entity::registerEntity(Kill::class, true);
        Entity::registerEntity(Death::class, true);

    }
}
