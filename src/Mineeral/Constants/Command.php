<?php

namespace Mineeral\Constants;

use Mineeral\Constants\Prefix;

interface Command
{

    // All
    public const ONLY_GAME = Prefix::IMPORTANT . "Commande utilisable seulement en jeu !";
    public const NO_PERM = Prefix::IMPORTANT . "Vous n'avez pas la permission d'utiliser cette commande !";
    public const NO_PLAYER = Prefix::IMPORTANT . "Le joueur n'existe pas !";
    // Feed
    public const FEED = Prefix::GOOD . "Vous avez bien été nourris§c -";
    // Teleport
    public const TELEPORT = Prefix::GOOD . "Vous avez bien était téléporter ";

}