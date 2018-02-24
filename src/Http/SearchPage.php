<?php


namespace Kitty\Http;


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class SearchPage
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response)
    {
        $categories = [
            'mouth' => [
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
            ],
            'wild' => [
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
            ],
            'secondarycolor' => [
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
            ],
            'patterncolor' => [
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
            ],
            'bodycolor' => [
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
            ],
            'eyetype' => [
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
            ],
            'eyecolor' => [
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
            ],
            'pattern' => [
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
            ],
            'body' => [
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
        ];

        return $this->twig->render($response, 'searchPage.html.twig',
            ['categories' => json_encode($categories)]);
    }
}