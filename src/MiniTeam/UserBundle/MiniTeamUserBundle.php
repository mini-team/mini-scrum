<?php

namespace MiniTeam\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MiniTeamUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
