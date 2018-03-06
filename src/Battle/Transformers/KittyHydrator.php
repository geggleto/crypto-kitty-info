<?php


namespace Kitty\Battle\Transformers;


use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Services\KittyBattleSkillService;

class KittyHydrator
{
    /**
     * @var KittyBattleSkillService
     */
    private $kittyBattleSkillService;

    public function __construct(KittyBattleSkillService $kittyBattleSkillService)
    {
        $this->kittyBattleSkillService = $kittyBattleSkillService;
    }

    /**
     * @param array $kittyArray
     *
     * @return Kitty
     */
    public function __invoke(array $kittyArray)
    {
        $kitty = Kitty::makeKittyFromArray($kittyArray);

        $kitty->setSkill1($this->kittyBattleSkillService->get($kitty['skill1']));
        $kitty->setSkill2($this->kittyBattleSkillService->get($kitty['skill2']));
        $kitty->setSkill3($this->kittyBattleSkillService->get($kitty['skill3']));

        return $kitty;
    }
}