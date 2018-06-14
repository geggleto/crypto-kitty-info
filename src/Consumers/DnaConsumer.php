<?php


namespace Kitty\Consumers;


use Kitty\Services\KittyService;
use Monolog\Logger;

class DnaConsumer implements ConsumerInterface
{
    const ROUTING_KEY = 'get_contract_dna';

    private $statement;

    /**
     * @var \PDO
     */
    private $PDO;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * DnaConsumer constructor.
     *
     * @param \PDO   $PDO
     * @param Logger $logger
     */
    public function __construct(\PDO $PDO, Logger $logger)
    {
        $this->PDO = $PDO;
        $this->statement = $this->PDO->prepare('update kitties set genes_hex = ?, genes_bin = ?, genes_kai =? where id = ?');
        $this->logger = $logger;
    }

    public function __invoke(array $args)
    {
        $id = $args['kittyId'];
        try {
            $dna = KittyService::getDnaFromContract($id);

            return $this->statement->execute([$dna['hex'], $dna['bin'], $dna['kai'], $id]);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());

            return false;
        }
    }

    public function getRoutingKey()
    {
        return self::ROUTING_KEY;
    }

}