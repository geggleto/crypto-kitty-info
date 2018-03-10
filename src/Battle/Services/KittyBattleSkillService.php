<?php


namespace Kitty\Battle\Services;


use Kitty\Battle\Entities\Skills\BaseSkill;
use PDO;

class KittyBattleSkillService
{
    public function __construct()
    {
        $this->skills = [];

        //Cause the consumer can be running for hours w/o a connection
        //Then MYSQL goes away and boom the consumer dies and the whole system breaks :D
        $this->pdo = new PDO('mysql:host='.getenv('MYSQL_HOST').';dbname='.getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statment = $this->pdo->query('select * from kitty_skills');

        while ($skillRow = $statment->fetch(PDO::FETCH_ASSOC))
        {
            $skill = BaseSkill::makeFromRow($skillRow);

            $this->addSkill($skill);
        }
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