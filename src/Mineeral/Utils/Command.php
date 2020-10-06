<?php

namespace Mineeral\Utils;

use Mineeral\Main;
use Mineeral\Constants\Prefix;

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

class Command implements Prefix
{

    public static function load()
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

        return Prefix::CONSOLE . " " . $count . " Commands are loaded";
    }
}
