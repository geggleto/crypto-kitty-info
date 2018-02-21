<?php


namespace Kitty\Consumers;


use Kitty\Services\KittyService;

class DnaConsumer implements ConsumerInterface
{
    const ROUTING_KEY = 'get_contract_dna';

    private $statement;

    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
        $this->statement = $this->PDO->prepare('update kitties set genes_hex = ?, genes_bin = ?, genes_kai =? where id = ?');
    }

    public function __invoke(array $args)
    {
        $id = $args['kittyId'];
        try {
            $dna = KittyService::getDnaFromContract($id);

            return $this->statement->execute([$dna['hex'], $dna['bin'], $dna['kai'], $id]);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getRoutingKey()
    {
        return self::ROUTING_KEY;
    }

}