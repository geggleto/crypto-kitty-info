<?php


namespace Kitty\Http;


use Kitty\Services\KittyService;
use Slim\Http\Request;
use Slim\Http\Response;
use function strlen;

class DnaController
{
    private $kai;

    /**
     * @var KittyService
     */
    private $kittyService;

    public function __construct(KittyService $kittyService)
    {
        $this->kittyService = $kittyService;
        $this->kai =[
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

    public function searchBody($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findBody($code));
    }

    public function searchPattern($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findPattern($code));
    }

    public function searchEyeColor($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findEyeColor($code));
    }

    public function searchEyeType($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findEyeType($code));
    }

    public function searchBodyColor($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findBodyColor($code));
    }

    public function searchPatternColor($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findPatternColour($code));
    }

    public function searchSecondaryColour($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findSecondaryColour($code));
    }

    public function searchWild($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findWild($code));
    }

    public function searchMouth($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findMouth($code));
    }

    public function searchForKitten($kittenId, Request $request, Response $response) {
        return $response->withJson($this->kittyService->findKitten($kittenId));
    }

    public function searchForKittenPretty($kittenId, Request $request, Response $response) {
        $result = $this->kittyService->findKitten($kittenId);

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

        return $response->withJson($result);
    }


}