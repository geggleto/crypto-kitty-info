<?php


namespace Kitty\WebSockets\Skills;


class Heal extends BaseSkill
{
    public function getName()
    {
        return 'Power Attack';
    }

    protected function getDamage($attack, $defense)
    {
        return $attack*2;
    }
}