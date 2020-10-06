<?php

namespace Mineeral\Constants;

use Mineeral\Constants\Prefix;

interface Form
{

    // Kit
    public const BASIC_KIT = Prefix::PREFIX_IMPORTANT . "Vous venez de prendre le kit §4Basic";
    public const COMMING_SOON = Prefix::PREFIX_BAD . "Coming soon..";
    // Rank
    public const WELL_DONE = "§c-§4 Bravo §c-";
    public const NO_MONEY_RANK = Prefix::PREFIX_BAD . "Vous n'avez pas assez d'argent pour ameliorer votre rank !";
    public const RANK_UP = " §fqui vient d'améloirer son rank à ";
    public const MAX_UP = Prefix::PREFIX_IMPORTANT . "Vous avez déjà un rank très haut !";

}