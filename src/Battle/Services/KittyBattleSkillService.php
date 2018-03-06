<?php


namespace Kitty\Battle\Services;


use Kitty\Battle\Entities\Skills\BaseSkill;

class KittyBattleSkillService
{
    public function __construct()
    {
        $this->skills = [];
    }

    /**
     * @param BaseSkill $baseSkill
     */
    public function addSkill(BaseSkill $baseSkill)
    {
        $this->skills[$baseSkill->getId()] = $baseSkill;
    }

    /**
     * @param $id
     *
     * @return BaseSkill
     */
    public function get($id)
    {
        return $this->skills[$id];
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function has($id)
    {
        return isset($this->skills[$id]);
    }
}