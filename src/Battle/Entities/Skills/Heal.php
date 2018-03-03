<?php


namespace Kitty\Battle\Entities\Skills;


class Heal extends BaseSkill
{
    public function __construct()
    {
        parent::__construct('Lick Paws', 0, 20, 0, 0, 0, 5);
    }
}