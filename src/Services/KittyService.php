<?php


namespace Kitty\Services;

use GuzzleHttp\Client;
use PDO;
use function urlencode;
use BitWasp\Buffertools\Buffer;

class KittyService
{
    /**
     * @var PDO
     */
    private $PDO;
    /**
     * @var Client
     */
    private $client;

    public function __construct(PDO $PDO, Client $client)
    {
        $this->PDO = $PDO;
        $this->client = $client;
    }

    public function updateKittyFromApi($kittyId)
    {
        $kittyBody = $this->getKittyFromApi($kittyId);

        if (!$kittyBody) {
            return false;
        }

        $stmt = $this->PDO->prepare('update kitties set kitty = ? where id = ? LIMIT 1;');

        return $stmt->execute([$kittyBody, $kittyId]);
    }

    public function insertKitty($kittyId)
    {
        $kittyBody = $this->getKittyFromApi($kittyId);

        if (!$kittyBody) {
            return false;
        }

        $row = json_decode($kittyBody, true);


        $stmt = $this->PDO->prepare('insert into kitties (kitty, id, gen) VALUES(?, ?, ?);');
        $stmt->execute([$kittyBody, $kittyId, $row['generation']]);

        //Stats
        $updateStatement = $this->PDO->prepare('
  update kitties 
  set 
    diamond_jewel_count = ?, 
    gilded_jewel_count = ?, 
    amethyst_jewel_count = ?, 
    lapis_jewel_count = ?, 
    mewtations = ? 
    where `id` = ? LIMIT 1;');


        $diamond = 0;
        $gold = 0;
        $amethyst = 0;
        $lapis = 0;
        $mewtations = [];

        if (!empty($row['enhanced_cattributes'])) {

            $cat_attr = $row['enhanced_cattributes'];

            foreach ($cat_attr as $cat) {

                if ($cat['position'] == -1) { //Skip
                    continue;
                }

                if ($cat['position'] == 1) {
                    $diamond++;

                    if ($cat['kittyId'] == $row['id']) {
                        $mewtations[] = [
                            $cat['description'] => 'diamond'
                        ];
                    }

                } else if ($cat['position'] <= 10) {
                    $gold++;
                    if ($cat['kittyId'] == $row['id']) {
                        $mewtations[] = [
                            $cat['description'] => 'gold'
                        ];
                    }
                } else if ($cat['position'] <= 100) {
                    $amethyst++;
                    if ($cat['kittyId'] == $row['id']) {
                        $mewtations[] = [
                            $cat['description'] => 'amethyst'
                        ];
                    }
                } else if ($cat['position'] <= 500) {
                    $lapis++;
                    if ($cat['kittyId'] == $row['id']) {
                        $mewtations[] = [
                            $cat['description'] => 'lapis'
                        ];
                    }
                }
            }

            $attributes = [
                $diamond,
                $gold,
                $amethyst,
                $lapis,
                json_encode($mewtations),
                $row['id']
            ];

            $updateStatement->execute($attributes);
        }


        return true;
    }

    protected function getKittyFromApi($kittyId) {
        try {
            $response = $this->client->get('https://api.cryptokitties.co/kitties/' . (int)$kittyId);

            return $response->getBody()->__toString();
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getMaximumKittyFromContract()
    {

        try {
            $response = $this->client->get('https://api.infura.io/v1/jsonrpc/mainnet/eth_call?params=' . urlencode('[{"to":"0x06012c8cf97BEaD5deAe237070F9587f8E7A266d", "data":"0x18160ddd"},"latest"]'));

            $json = json_decode($response->getBody()->__toString(), true);

            return hexdec(substr($json['result'], strlen($json['result'])-10));
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getMaxInDb()
    {
        $statement = $this->PDO->query('select max(id) as `max` from kitties;');
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['max'];
    }

    public function findBody($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 45) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findPattern($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 41,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findEyeColor($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 37,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findEyeType($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 33,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBodyColor($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 29,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findPatternColour($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 25,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findSecondaryColour($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 21,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWild($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 17,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findMouth($kai = '')
    {
        $statement = $this->PDO->prepare('select `id`, `gen` from kitties where substr(genes_kai, 13,4) = ?');

        $statement->execute([$kai]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}