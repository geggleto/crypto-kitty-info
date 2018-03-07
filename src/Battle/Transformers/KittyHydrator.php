<?php


namespace Kitty\Battle\Transformers;


use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Services\KittyBattleSkillService;
use Psr\Log\LoggerInterface;

class KittyHydrator
{
    /**
     * @var KittyBattleSkillService
     */
    private $kittyBattleSkillService;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        KittyBattleSkillService $kittyBattleSkillService, LoggerInterface $logger
    )
    {
        $this->kittyBattleSkillService = $kittyBattleSkillService;
        $this->logger = $logger;
    }

    /**
     * @param $kittyString
     *
     * @return Kitty
     */
    public function hydrate($kittyString)
    {
        $this->logger->debug('Hydrating Kitty: ' . $kittyString);

        $kittyArray = json_decode($kittyString, true);

        $kitty = Kitty::makeKittyFromArray($kittyArray);

        $kitty->setSkill1($this->kittyBattleSkillService->get($kittyArray['skill1']));
        $kitty->setSkill2($this->kittyBattleSkillService->get($kittyArray['skill2']));
        $kitty->setSkill3($this->kittyBattleSkillService->get($kittyArray['skill3']));

        return $kitty;
    }
}