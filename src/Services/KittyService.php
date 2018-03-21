<?php


namespace Kitty\Services;

use function array_map;
use function bindec;
use GuzzleHttp\Client;
use Kitty\Search\KittySearch;
use Monolog\Logger;
use PDO;
use function pow;
use function sleep;
use Slim\Http\Response;
use function substr;
use function urlencode;
use function usleep;
use function var_dump;

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

    private $kai;

    private static $kaiLookup = [
        '00000' => '1',
        '00001' => '2',
        '00010' => '3',
        '00011' => '4',
        '00100' => '5',
        '00101' => '6',
        '00110' => '7',
        '00111' => '8',
        '01000' => '9',
        '01001' => 'a',
        '01010' => 'b',
        '01011' => 'c',
        '01100' => 'd',
        '01101' => 'e',
        '01110' => 'f',
        '01111' => 'g',
        '10000' => 'h',
        '10001' => 'i',
        '10010' => 'j',
        '10011' => 'k',
        '10100' => 'm',
        '10101' => 'n',
        '10110' => 'o',
        '10111' => 'p',
        '11000' => 'q',
        '11001' => 'r',
        '11010' => 's',
        '11011' => 't',
        '11100' => 'u',
        '11101' => 'v',
        '11110' => 'w',
        '11111' => 'x'
    ];
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var KittySearch
     */
    private $kittySearch;

    public function __construct(PDO $PDO, Client $client, Logger $logger, KittySearch $kittySearch)
    {
        $this->PDO = $PDO;
        $this->client = $client;
        $this->logger = $logger;

        // \o/ we have Binary DNA

        $this->kai = $kittySearch->getFormatedMegaArray();

        $this->kittySearch = $kittySearch;
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

    public function findKitten($kitten)
    {
        $statement = $this->PDO->prepare('select `genes_kai` as `dna`, gen from kitties where `id` = ?');

        $statement->execute([$kitten]);

        $kitten = $statement->fetch(PDO::FETCH_ASSOC);

        return [
            'dna' => $kitten['dna'],
            'gen' => $kitten['gen'],
            'body' => substr($kitten['dna'], 44, 4),
            'pattern' => substr($kitten['dna'], 40, 4),
            'eyecolor' => substr($kitten['dna'], 36, 4),
            'eyetype' => substr($kitten['dna'], 32, 4),
            'bodycolor' => substr($kitten['dna'], 28, 4),
            'patterncolor' => substr($kitten['dna'], 24, 4),
            'secondarycolor' => substr($kitten['dna'], 20, 4),
            'wild' => substr($kitten['dna'], 16, 4),
            'mouth' => substr($kitten['dna'], 12, 4)
        ];

    }

    public static function getDnaFromContract($kittenId)
    {
        $hexId = dechex($kittenId);

        while (strlen($hexId) < 8) {
            $hexId = '0'.$hexId;
        }

        $client = new Client();

        $response = $client->get('https://api.infura.io/v1/jsonrpc/mainnet/eth_call?params='. json_encode([["to"=>"0x06012c8cf97BEaD5deAe237070F9587f8E7A266d", "data"=>"0xe98b7f4d00000000000000000000000000000000000000000000000000000000".$hexId],"latest"]));

        $json = json_decode($response->getBody()->__toString(), true);

        $hexDna = substr($json['result'], - 64);

        $binDna = self::hexToBin($hexDna);

        $kai = self::binToKai($binDna);


        return [
            'hex' => $hexDna,
            'bin' => $binDna,
            'kai' => $kai
        ];
    }

    protected static function hexToBin($hexDna) {
        $binDna = '';

        for($x=0; $x<64; $x++) {
            if ($hexDna[$x] == '0')
                $binDna .= '0000';
            if ($hexDna[$x] == '1')
                $binDna .= '0001';
            if ($hexDna[$x] == '2')
                $binDna .= '0010';
            if ($hexDna[$x] == '3')
                $binDna .= '0011';
            if ($hexDna[$x] == '4')
                $binDna .= '0100';
            if ($hexDna[$x] == '5')
                $binDna .= '0101';
            if ($hexDna[$x] == '6')
                $binDna .= '0110';
            if ($hexDna[$x] == '7')
                $binDna .= '0111';
            if ($hexDna[$x] == '8')
                $binDna .= '1000';
            if ($hexDna[$x] == '9')
                $binDna .= '1001';
            if (strtoupper($hexDna[$x]) == 'A')
                $binDna .= '1010';
            if (strtoupper($hexDna[$x]) == 'B')
                $binDna .= '1011';
            if (strtoupper($hexDna[$x]) == 'C')
                $binDna .= '1100';
            if (strtoupper($hexDna[$x]) == 'D')
                $binDna .= '1101';
            if (strtoupper($hexDna[$x]) == 'E')
                $binDna .= '1110';
            if (strtoupper($hexDna[$x]) == 'F')
                $binDna .= '1111';
        }

        return $binDna;
    }

    protected static function binToKai($binDna) {
        $kai = '';
        for ($x=1; $x<=48;$x++) {
            $letter = self::kaiLookup(substr($binDna, strlen($binDna)-(5 * $x), 5));
            $kai = $letter . $kai;
        }

        return $kai;
    }

    protected static function kaiLookup($binary) {
        return self::$kaiLookup[$binary];
    }

    public static function getAllKittiesOnProfile($address)
    {
        $list = [];
        $offset = 0;

        $client = new Client();

        do {

            try {
                //https://api.cryptokitties.co/kitties?owner_wallet_address=0xcecddbe88359f6ecebe90b42643b002543f27fe9&offset=12
                $response = $client->get('https://api.cryptokitties.co/kitties?limit=20&owner_wallet_address=' . $address . '&offset=' . $offset);
                $body     = json_decode($response->getBody()->__toString(), true);

                $total   = $body['total'];
                $limit   = $body['limit']; // 20 :)
                $offset  = $body['offset'];
                $kitties = $body['kitties'];

                foreach ($kitties as $kitty) {
                    $list[] = $kitty['id'];
                }

                $offset += $limit;
            } catch (\Exception $exception) {

            }

            sleep(1);

        } while($offset <= $total);

        return $list;
    }

    public function getPrettyDnaKitten($kittenId)
    {
        $result = $this->findKitten($kittenId);

        $categories = [
            'mouth' => 4,
            'wild' => 5,
            'secondarycolor' => 6,
            'patterncolor' => 7,
            'bodycolor' => 8,
            'eyetype' => 9,
            'eyecolor' => 10,
            'pattern' => 11,
            'body' => 12
        ];

        foreach ($categories as $category => $index) {
            $dna = $result[$category];

            $d0 = $this->kai[$index]['codes'][$dna[3]];
            $r1 = $this->kai[$index]['codes'][$dna[2]];
            $r2 = $this->kai[$index]['codes'][$dna[1]];
            $r3 = $this->kai[$index]['codes'][$dna[0]];

            $result[$category] = [
                'D0' => $d0,
                'R1' => $r1,
                'R2' => $r2,
                'R3' => $r3
            ];
        }

        return $result;
    }

    public function getKittyGen($kittyId)
    {
        $statement = $this->PDO->prepare('select `gen` from kitties where `id` = ?');

        $statement->execute([$kittyId]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $kittenId
     *
     * Returns the ETH amount if there is a sale
     *
     * @return bool|float|int
     */
    public static function getSaleInfo($kittenId)
    {
        $hexId = dechex($kittenId);

        while (strlen($hexId) < 8) {
            $hexId = '0'.$hexId;
        }

        $client = new Client();

        $response = $client->get('https://api.infura.io/v1/jsonrpc/mainnet/eth_call?params='. json_encode([["to"=>"0xb1690c08e213a35ed9bab7b318de14420fb57d8c", "data"=>"0xc55d0f5600000000000000000000000000000000000000000000000000000000".$hexId],"latest"]));
        $json = json_decode($response->getBody()->__toString(), true);

        return ($json['result'] !== '0x')? number_format(hexdec(substr($json['result'],1+16*3)) / 10**18, 4) :false;
    }

    //Get Sale Info
    public static function getMultipleSaleInfo(array $kittens)
    {
        $out = [];
        foreach ($kittens as $kitten) {
            $out[] = self::getSaleInfo($kitten);
            usleep(200000);
        }

        return $out;
    }

    public function findKittiesFromArray(array $params) {
        //Query Builder
        $queryString = "select id, gen, json_extract(kitty, '$.is_fancy') as `fancy` from kitties where ";

        $filters = [];
        $values = [];

        foreach ($params as $param => $value) {
            if ($param=='gen') {
                $filters[] = $this->getGenFilter();
            } else if ($param=='genU') {
                $filters[] = $this->getGenUpFilter();
            } else if ($param=='genD') {
                $filters[] = $this->getGenDownFilter();
            } else if ($param=='fur') {
                $filters[] = $this->getBodyFilter();
            } else if ($param=='baseColor') {
                $filters[] = $this->getBodyColorFilter();
            } else if ($param=='pattern') {
                $filters[] = $this->getPatternFilter();
            } else if ($param=='eyeColor') {
                $filters[] = $this->getEyeColorFilter();
            } else if ($param=='eyeShape') {
                $filters[] = $this->getEyeShapeFilter();
            } else if ($param=='highlightColor') {
                $filters[] = $this->getHighlightColorFilter();
            } else if ($param=='accentColor') {
                $filters[] = $this->getAccentColorFilter();
            } else if ($param=='wild') {
                $filters[] = $this->getWildFilter();
            } else if ($param=='mouth') {
                $filters[] = $this->getMouthFilter();
            } else if ($param=='no_fancy') {
                $filters[] = $this->getNoFancyFilter();
            } else {
                continue;
            }

            if ($param === 'gen' || $param === 'genD' || $param === 'genU') {
                $values[] = $value;
            } else if (strlen($value) === 4) {
                $values[] = str_replace('*','_', $value);
            } else {
                throw new \InvalidArgumentException('Values must be 4 kai codes');
            }
        }

        $query = $queryString . implode(' AND ', $filters) . ' LIMIT 500';

        //$this->logger->addDebug('Searching DB');
        //$this->logger->addDebug($query);
        //$this->logger->addDebug($values);

//        var_dump($query);
//        var_dump($values);

        $statement = $this->PDO->prepare($query);
        $statement->execute($values);

        //$this->logger->addDebug('Done Search');

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getGenFilter() {
        return 'gen = ?';
    }

    protected function getGenUpFilter() {
        return 'gen <= ?';
    }

    protected function getGenDownFilter() {
        return 'gen <= ?';
    }

    protected function getNoFancyFilter() {
        return "json_extract(kitty, '$.is_fancy') = ?";
    }

    protected function getBodyFilter() {
        return 'substr(genes_kai, 45) LIKE ?';
    }

    protected function getPatternFilter() {
        return 'substr(genes_kai, 41,4) LIKE ?';
    }

    protected function getEyeColorFilter() {
        return 'substr(genes_kai, 37,4) LIKE ?';
    }
    protected function getEyeShapeFilter() {
        return 'substr(genes_kai, 33,4) LIKE ?';
    }

    protected function getBodyColorFilter() {
        return 'substr(genes_kai, 29,4) LIKE ?';
    }

    protected function getHighlightColorFilter() {
        return 'substr(genes_kai, 25,4) LIKE ?';
    }

    protected function getAccentColorFilter() {
        return 'substr(genes_kai, 21,4) LIKE ?';
    }

    protected function getWildFilter() {
        return 'substr(genes_kai, 17,4) LIKE ?';
    }

    protected function getMouthFilter() {
        return 'substr(genes_kai, 13,4) LIKE ?';
    }

    public function writeCsv(array $ids, Response $response, $filename = 'profile.csv') {
        $result = [];

        //$response = $response->write('kittyId,mouth,,,,wild,,,,seccolor,,,,patcolor,,,,bodycolor,,,,eyetype,,,,eyecolor,,,,pattern,,,,body,,,,'."\n");
        $response = $response->write('kittyId,Gen,Fur,,,,Pattern,,,,Eye Color,,,,Eye Shape,,,,Base Color,,,,Highlight Color,,,,Accent Color,,,,Wild,,,,Mouth,,,,'."\n");

        foreach ($ids as $id) {

            $kitty = $this->getKittyGen($id);

            $result[$id] = $this->getPrettyDnaKitten($id);

            $response->write($id.','.$kitty['gen']);

            $dna = array_map(function ($dna) {
                return implode(',', $dna);
            }, $result[$id]);

            $response = $response->write(implode(',', $dna)."\n");
        }

        return $response
            ->withHeader('Content-Type', 'text/csv')
            ->withHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');

    }

    public function getKittyTable(array $ids, $onsale = false, $price = false) {
        $result = [];

        foreach ($ids as $idResult) {

            $id = $idResult['id'];
            $gen = $idResult['gen'];
            $fancy = $idResult['fancy'];

            $forSale = self::getSaleInfo($id);

            $isItForSale = $forSale ? 'Yes' : 'No';

            //If we want on-sale and it is for sale... or we don't want sale
            if ( ($onsale && $forSale) || !$onsale) {

                $result[$id] = $this->getPrettyDnaKitten($id);
                $result[$id]['id'] = $id;
                $result[$id]['gen'] = $gen;
                $result[$id]['forSale'] = $isItForSale;
                $result[$id]['fancy'] = $fancy;
                $result[$id]['price'] = $forSale;
            }

            if (count($result) === 200) {
                break;
            }
        }

        return $result;
    }

    public function processKitty($id)
    {
        $statement = $this->PDO->prepare('select `id`, substr(genes_kai, 9,4) as `attack_iv`, substr(genes_kai, 5,4) as `defense_iv`, substr(genes_kai, 17,4) as `heal_iv` from kitties where id = ?');

        $statement->execute([$id]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calcIv($kaiCode) {
        $base = 35;

        return 5 + ( ($base + bindec($this->kaiToBin($kaiCode[3])) + bindec($this->kaiToBin($kaiCode[2])/2)) / 100);
    }

    public function kaiToBin($kaiCode)
    {
        foreach ($this->kai as $bin => $kai) {
            if ($kaiCode == $kai) {
                return $bin;
            }
        }

        return '00000';
    }

    /**
     * @return array
     */
    public function getKai(): array
    {
        return $this->kai;
    }


}