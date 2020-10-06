<?php

namespace Mineeral\Constants;

use Mineeral\Constants\Prefix;

interface Event
{

    public const WELCOME = Prefix::PREFIX_GOOD . "Bienvenue sur §4Dyvan§f PvP-Box !";
    public const JOIN = "§f[§4+§f]§a ";
    public const QUIT = "§f[§4-§f]§4 ";
    public const KILL = "§c»§4 ";
    public const NO_SPAM = Prefix::PREFIX_BAD . "Merci de ne pas spam de message !";
    public const FIGHT = Prefix::PREFIX_IMPORTANT . "Vous êtes encore en combat !";

}