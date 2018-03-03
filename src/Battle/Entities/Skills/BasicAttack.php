<?php


namespace Kitty\Battle\Entities\Skills;

class BasicAttack extends BaseSkill
{
    public function __construct()
    {
        parent::__construct('Claw', 10, 0, 0, 0, 0, 0);
    }
}