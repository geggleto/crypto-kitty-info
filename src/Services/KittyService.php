<?php


namespace Kitty\Services;

use function array_map;
use GuzzleHttp\Client;
use PDO;
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

    public function __construct(PDO $PDO, Client $client)
    {
        $this->PDO = $PDO;
        $this->client = $client;
        // \o/ we have Binary DNA

        $this->kai =$this->kai = [
            4 => [
                'label' => 'Mouth',
                'codes' => [
                    '1' => 'whixtensions',
                    '2' => 'wasntme',
                    '3' => 'wuvme',
                    '4' => 'gerbil',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => 'beard',
                    'a' => 'pouty',
                    'b' => 'saycheese',
                    'c' => 'grim',
                    'd' => 'd',
                    'e' => 'e',
                    'f' => 'happygokitty',
                    'g' => 'soserious',
                    'h' => 'cheeky',
                    'i' => 'starstruck',
                    'j' => 'j',
                    'k' => 'k',
                    'm' => 'dali',
                    'n' => 'grimace',
                    'o' => 'o',
                    'p' => 'tongue',
                    'q' => 'yokel',
                    'r' => 'r',
                    's' => 'neckbeard',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            5 => [
                'label' => 'Wild',
                'codes' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    'a' => 'a',
                    'b' => 'b',
                    'c' => 'c',
                    'd' => 'd',
                    'e' => 'e',
                    'f' => 'f',
                    'g' => 'g',
                    'h' => 'h',
                    'i' => 'elk',
                    'j' => 'j',
                    'k' => 'trioculus',
                    'm' => 'm',
                    'n' => 'n',
                    'o' => 'o',
                    'p' => 'p',
                    'q' => 'q',
                    'r' => 'r',
                    's' => 's',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            6 => [
                'label' => 'Sec Color',
                'codes' => [
                    '1' => 'belleblue',
                    '2' => 'sandalwood',
                    '3' => 'peach',
                    '4' => 'icy',
                    '5' => 'granitegrey',
                    '6' => '6',
                    '7' => 'kittencream',
                    '8' => 'emeraldgreen',
                    '9' => '9',
                    'a' => 'a',
                    'b' => 'purplehaze',
                    'c' => 'c',
                    'd' => 'azaleablush',
                    'e' => 'e',
                    'f' => 'morningglory',
                    'g' => 'g',
                    'h' => 'daffodil',
                    'i' => 'flamingo',
                    'j' => 'j',
                    'k' => 'bloodred',
                    'm' => 'm',
                    'n' => 'n',
                    'o' => 'o',
                    'p' => 'p',
                    'q' => 'seafoam',
                    'r' => 'r',
                    's' => 's',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            7 => [
                'label' => 'Pattern Color',
                'codes' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => 'egyptiankohl',
                    '4' => '4',
                    '5' => 'lilac',
                    '6' => 'apricot',
                    '7' => 'royalpurple',
                    '8' => '8',
                    '9' => 'swampgreen',
                    'a' => 'violet',
                    'b' => 'scarlet',
                    'c' => 'barkbrown',
                    'd' => 'coffee',
                    'e' => 'lemonade',
                    'f' => 'chocolate',
                    'g' => 'g',
                    'h' => 'h',
                    'i' => 'i',
                    'j' => 'turtleback',
                    'k' => 'k',
                    'm' => 'wolfgrey',
                    'n' => 'cerulian',
                    'o' => 'skyblue',
                    'p' => 'p',
                    'q' => 'q',
                    'r' => 'r',
                    's' => 'royalblue',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            8 => [
                'label' => 'Body Color',
                'codes' => [
                    '1' => 'shadowgrey',
                    '2' => 'salmon',
                    '3' => '3',
                    '4' => 'orangesoda',
                    '5' => 'cottoncandy',
                    '6' => 'mauveover',
                    '7' => 'aquamarine',
                    '8' => 'nachocheez',
                    '9' => '9',
                    'a' => 'a',
                    'b' => 'greymatter',
                    'c' => 'c',
                    'd' => 'd',
                    'e' => 'e',
                    'f' => 'hintomint',
                    'g' => 'bananacream',
                    'h' => 'cloudwhite',
                    'i' => 'i',
                    'j' => 'oldlace',
                    'k' => 'koala',
                    'm' => 'm',
                    'n' => 'n',
                    'o' => 'o',
                    'p' => 'verdigris',
                    'q' => 'q',
                    'r' => 'onyx',
                    's' => 's',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            9 => [
                'label' => 'Eye Type',
                'codes' => [
                    '1' => '1',
                    '2' => 'wonky',
                    '3' => 'serpent',
                    '4' => 'googly',
                    '5' => 'otaku',
                    '6' => 'simple',
                    '7' => 'crazy',
                    '8' => 'thicccbrowz',
                    '9' => '9',
                    'a' => 'a',
                    'b' => 'baddate',
                    'c' => 'c',
                    'd' => 'chronic',
                    'e' => 'slyboots',
                    'f' => 'f',
                    'g' => 'stunned',
                    'h' => 'h',
                    'i' => 'alien',
                    'j' => 'fabulous',
                    'k' => 'raisedbrow',
                    'm' => 'm',
                    'n' => 'n',
                    'o' => 'sass',
                    'p' => 'p',
                    'q' => 'q',
                    'r' => 'wingtips',
                    's' => 's',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            10 => [
                'label' => 'Eye Color',
                'codes' => [
                    '1' => 'thundergrey',
                    '2' => 'gold',
                    '3' => 'topaz',
                    '4' => 'mintgreen',
                    '5' => '5',
                    '6' => 'sizzurp',
                    '7' => 'chestnut',
                    '8' => 'strawberry',
                    '9' => 'sapphire',
                    'a' => 'forgetmenot',
                    'b' => 'b',
                    'c' => 'coralsunrise',
                    'd' => 'd',
                    'e' => 'e',
                    'f' => 'f',
                    'g' => 'g',
                    'h' => 'pumpkin',
                    'i' => 'limegreen',
                    'j' => 'j',
                    'k' => 'bubblegum',
                    'm' => 'twilightsparkle',
                    'n' => 'n',
                    'o' => 'o',
                    'p' => 'p',
                    'q' => 'babypuke',
                    'r' => 'r',
                    's' => 's',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            11 => [
                'label' => 'Pattern',
                'codes' => [
                    '1' => '1',
                    '2' => 'tiger',
                    '3' => '3',
                    '4' => 'ganado',
                    '5' => '5',
                    '6' => 'camo',
                    '7' => '7',
                    '8' => 'spangled',
                    '9' => 'calicool',
                    'a' => 'luckystripe',
                    'b' => 'amur',
                    'c' => 'jaguar',
                    'd' => 'spock',
                    'e' => 'e',
                    'f' => 'totesbasic_f',
                    'g' => 'totesbasic_g',
                    'h' => 'h',
                    'i' => 'i',
                    'j' => 'j',
                    'k' => 'k',
                    'm' => 'tigerpunk',
                    'n' => 'henna',
                    'o' => 'o',
                    'p' => 'totesbasic_p',
                    'q' => 'q',
                    'r' => 'r',
                    's' => 'hotrod',
                    't' => 't',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ],
            12 => [
                'label' => 'Body',
                'codes' => [
                    '1' => 'savannah',
                    '2' => 'selkirk',
                    '3' => '3',
                    '4' => 'birman',
                    '5' => '5',
                    '6' => 'bobtail',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    'a' => 'cymric',
                    'b' => 'chartreux',
                    'c' => 'himalayan',
                    'd' => 'munchkin',
                    'e' => 'sphynx',
                    'f' => 'ragamuffin',
                    'g' => 'ragdoll',
                    'h' => 'norwegianforest',
                    'i' => 'i',
                    'j' => 'j',
                    'k' => 'k',
                    'm' => 'm',
                    'n' => 'mainecoon',
                    'o' => 'laperm',
                    'p' => 'persian',
                    'q' => 'q',
                    'r' => 'r',
                    's' => 's',
                    't' => 'manx',
                    'u' => 'u',
                    'v' => 'v',
                    'w' => 'w',
                    'x' => 'x'
                ]
            ]
        ];
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
        $statement = $this->PDO->prepare('select `genes_kai` as `dna` from kitties where `id` = ?');

        $statement->execute([$kitten]);

        $kitten = $statement->fetch(PDO::FETCH_ASSOC);

        return [
            'dna' => $kitten['dna'],
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

        do {
            $client = new Client();

            //https://api.cryptokitties.co/kitties?owner_wallet_address=0xcecddbe88359f6ecebe90b42643b002543f27fe9&offset=12
            $response = $client->get('https://api.cryptokitties.co/kitties?owner_wallet_address=' . $address . '&offset=' . $offset);
            $body     = json_decode($response->getBody()->__toString(), true);

            $total   = $body['total'];
            $limit   = $body['limit']; // 12
            $offset  = $body['offset'];
            $kitties = $body['kitties'];

            foreach ($kitties as $kitty) {
                $list[] = $kitty['id'];
            }

            $offset += $limit;

            usleep(500000);

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

    //Get Sale Info
    public static function getSaleInfo($kittenId)
    {
        $hexId = dechex($kittenId);

        while (strlen($hexId) < 8) {
            $hexId = '0'.$hexId;
        }

        $client = new Client();

        $response = $client->get('https://api.infura.io/v1/jsonrpc/mainnet/eth_call?params='. json_encode([["to"=>"0xb1690c08e213a35ed9bab7b318de14420fb57d8c", "data"=>"0x78bd793500000000000000000000000000000000000000000000000000000000".$hexId],"latest"]));

        $json = json_decode($response->getBody()->__toString(), true);

        return (strlen($json['result']) > 8);
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
        $queryString = 'select id from kitties where ';

        $filters = [];
        $values = [];

        foreach ($params as $param => $value) {
            if ($param='gen') {
                $filters[] = $this->getGenFilter();
            } else if ($param='genU') {
                $filters[] = $this->getGenUpFilter();
            } else if ($param='genD') {
                $filters[] = $this->getGenDownFilter();
            } else if ($param='body') {
                $filters[] = $this->getBodyFilter();
            } else if ($param='bodyColor') {
                $filters[] = $this->getBodyColorFilter();
            } else if ($param='pattern') {
                $filters[] = $this->getPatternFilter();
            } else if ($param='eyeColor') {
                $filters[] = $this->getEyeColorFilter();
            } else if ($param='eyeShape') {
                $filters[] = $this->getEyeShapeFilter();
            } else if ($param='highlightColor') {
                $filters[] = $this->getHighlightColorFilter();
            } else if ($param='accentColor') {
                $filters[] = $this->getAccentColorFilter();
            } else if ($param='wild') {
                $filters[] = $this->getWildFilter();
            } else if ($param='mouth') {
                $filters[] = $this->getMouthFilter();
            } else {
                continue;
            }

            if (strlen($value) === 4) {
                $values[] = str_replace('*','_', $value);
            } else {
                throw new \InvalidArgumentException('Values must be 4 kai codes');
            }
        }

        $statement = $this->PDO->prepare($queryString . implode(' AND ', $filters) . ' LIMIT 25');
        $statement->execute($values);

        return $statement->fetchAll();
    }

    protected function getGenFilter() {
        return 'gen = ?';
    }

    protected function getGenUpFilter() {
        return 'gen => ?';
    }

    protected function getGenDownFilter() {
        return 'gen =< ?';
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

    public function writeCsv(array $ids, Response $response, $filename = 'profile.php') {
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

    public function writeCsvWithSales(array $ids, Response $response, $filename = 'profile.php') {
        $result = [];

        //$response = $response->write('kittyId,mouth,,,,wild,,,,seccolor,,,,patcolor,,,,bodycolor,,,,eyetype,,,,eyecolor,,,,pattern,,,,body,,,,'."\n");
        $response = $response->write('kittyId,Gen,Sale,Fur,,,,Pattern,,,,Eye Color,,,,Eye Shape,,,,Base Color,,,,Highlight Color,,,,Accent Color,,,,Wild,,,,Mouth,,,,'."\n");

        foreach ($ids as $id) {

            $kitty = $this->getKittyGen($id);

            $result[$id] = $this->getPrettyDnaKitten($id);

            $forSale = self::getSaleInfo($id);

            $isItForSale = $forSale ? 'Yes' : 'No';

            $response->write($id.','.$kitty['gen'].','.$isItForSale);

            $dna = array_map(function ($dna) {
                return implode(',', $dna);
            }, $result[$id]);

            $response = $response->write(implode(',', $dna)."\n");
        }

        return $response
            ->withHeader('Content-Type', 'text/csv')
            ->withHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');

    }
}