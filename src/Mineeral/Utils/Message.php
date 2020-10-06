<?php

namespace Mineeral\Utils;

use pocketmine\Player;

use  Mineeral\Main;

class Message
{
    // PREFIX
    public const PREFIX_DEFAULT = "§f[§c!§f] ";
    public const PREFIX_CONSOLE = "§f[§cDyn§f]§a ";
    public const PREFIX_IMPORTANT = Message::PREFIX_DEFAULT . "§f";
    public const PREFIX_GOOD = Message::PREFIX_DEFAULT . "§a";
    public const PREFIX_BAD = Message::PREFIX_DEFAULT . "§c";

    // COMMAND
    // All
    public const ONLY_GAME = Message::PREFIX_IMPORTANT . "Commande utilisable seulement en jeu !";
    public const NO_PERM = Message::PREFIX_IMPORTANT . "Vous n'avez pas la permission d'utiliser cette commande !";
    public const NO_PLAYER = Message::PREFIX_IMPORTANT . "Le joueur n'existe pas !";
    // Feed
    public const FEED = Message::PREFIX_GOOD . "Vous avez bien été nourris§c -";
    // Teleport
    public const TELEPORT = Message::PREFIX_GOOD . "Vous avez bien était téléporter ";

    // Event
    public const WELCOME = Message::PREFIX_GOOD . "Bienvenue sur §4Dyvan§f PvP-Box !";
    public const JOIN = "§f[§4+§f]§a ";
    public const QUIT = "§f[§4-§f]§4 ";
    public const KILL = "§c»§4 ";
    public const NO_SPAM = Message::PREFIX_BAD . "Merci de ne pas spam de message !";
    public const FIGHT = Message::PREFIX_IMPORTANT . "Vous êtes encore en combat !";

    // FORM
    // Kit
    public const BASIC_KIT = Message::PREFIX_IMPORTANT . "Vous venez de prendre le kit §4Basic";
    public const COMMING_SOON = Message::PREFIX_BAD . "Coming soon..";
    // Rank
    public const WELL_DONE = "§c-§4 Bravo §c-";
    public const NO_MONEY_RANK = Message::PREFIX_BAD . "Vous n'avez pas assez d'argent pour ameliorer votre rank !";
    public const RANK_UP = " §fqui vient d'améloirer son rank à ";
    public const MAX_UP = Message::PREFIX_IMPORTANT . "Vous avez déjà un rank très haut !";

}
