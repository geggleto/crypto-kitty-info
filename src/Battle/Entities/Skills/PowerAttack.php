<?php


namespace Kitty\Battle\Entities\Skills;


class PowerAttack extends BaseSkill
{
    public function __construct()
    {
        parent::__construct('Pounce', 20, 0, 0, 0, 0, 3);
    }
}