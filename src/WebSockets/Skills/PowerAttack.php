<?php


namespace Kitty\WebSockets\Skills;


class PowerAttack extends BaseSkill
{
    public function getName()
    {
        return 'Power Attack';
    }

    protected function getDamage($attack, $defense)
    {
        return (int)($attack * 1.5) - (int)($defense/2);
    }
}