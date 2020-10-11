<?php

namespace Mineeral\Constants;

use Mineeral\Constants\Prefix;

interface Event
{

    public const WELCOME = Prefix::GOOD . "Bienvenue sur §4Dyvan§f PvP-Box !";
    public const JOIN = "§f[§4+§f]§a ";
    public const QUIT = "§f[§4-§f]§4 ";
    public const KILL = "§c»§4 ";
    public const NO_SPAM = "§f[§c!§f] §cMerci de ne pas spam de message !";
    public const FIGHT = "§4- §cVous êtes encore en combat !§4 -";

}