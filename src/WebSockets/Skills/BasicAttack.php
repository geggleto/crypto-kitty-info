<?php


namespace Kitty\WebSockets\Skills;


class BasicAttack extends BaseSkill
{

    public function getName()
    {
        return 'Basic Attack';
    }

    public function getDamage($attack, $defense)
    {
        return $attack - (int)($defense/2);
    }
}