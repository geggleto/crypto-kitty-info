<?php


namespace Kitty\Services;


use GuzzleHttp\Client;
use PDO;

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

        $stmt = $this->PDO->prepare('insert into kitties (kitty, id) VALUES(?, ?);');
        $stmt->execute([$kittyBody, $kittyId]);

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

        $row = json_decode($kittyBody, true);

        $diamond = 0;
        $gold = 0;
        $amethyst = 0;
        $lapis = 0;
        $mewtations = [];

        if (!empty($row['enhanced_cattributes'])) {

            $cat_attr = json_decode($row['enhanced_cattributes'], true);

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
}