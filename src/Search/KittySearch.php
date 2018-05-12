<?php


namespace Kitty\Search;


use function array_keys;
use function explode;

/**
 * Class KittySearch
 *
 * Ideally this will power an API
 *
 *
 *
 * @package Kitty\Search
 */
class KittySearch
{
    private $furKai;
    private $patternKai;
    private $eyeColorKai;
    private $eyeShapeKai;
    private $baseColorKai;
    private $highlightColorKai;
    private $accentColorKai;
    private $wildKai;
    private $mouthKai;
    private $unknownKai;
    private $mysteryKai;
    private $secretKai;

    private $kaiTranslation;

    private $fur;
    private $pattern;
    private $eyeColor;
    private $eyeShape;
    private $baseColor;
    private $highlightColor;
    private $accentColor;
    private $wild;
    private $mouth;
    private $secret;
    private $unknown;
    private $mystery;
    
    
    private $RfurKai;
    private $RpatternKai;
    private $ReyeColorKai;
    private $ReyeShapeKai;
    private $RbaseColorKai;
    private $RhighlightColorKai;
    private $RaccentColorKai;
    private $RwildKai;
    private $RmouthKai;

    private $RsecretKai;
    private $RunknownKai;
    private $RmysteryKai;
    
    public function __construct()
    {
        $this->fur = explode("\n", 'savannah
selkirk
02
birman
koladiviya
bobtail
06
pixiebob
08
cymric
chartreux
himalayan
munchkin
sphynx
ragamuffin
ragdoll
norwegianforest
17
highlander
19
20
mainecoon
laperm
persian
24
25
26
manx
28
29
30');

        $this->pattern = explode("\n", '00
tiger
rascal
ganado
leopard
camo
06
spangled
calicool
luckystripe
amur
jaguar
spock
13
totesbasic_f
totesbasic_g
16
thunderstruck
dippedcone
19
tigerpunk
henna
22
totesbasic_p
24
25
hotrod
27
28
29
30');


        $this->eyeColor = explode("\n", 'thundergrey
gold
topaz
mintgreen
04
sizzurp
chestnut
strawberry
sapphire
forgetmenot
10
coralsunrise
12
doridnudibranch
parakeet
cyan
pumpkin
limegreen
18
bubblegum
twilightsparkle
21
22
eclipse
babypuke
25
26
27
28
29
30');

        $this->eyeShape = explode("\n", 'swarley
wonky
serpent
googly
otaku
simple
crazy
thicccbrowz
caffeine
09
baddate
11
chronic
slyboots
wiley
stunned
chameleon
alien
fabulous
raisedbrow
20
21
sass
sweetmeloncakes
oceanid
wingtips
26
buzzed
bornwithit
29
30');

        $this->baseColor = explode("\n", 'shadowgrey
salmon
02
orangesoda
cottoncandy
mauveover
aquamarine
nachocheez
harbourfog
cinderella
greymatter
11
12
dragonfruit
hintomint
bananacream
cloudwhite
17
oldlace
koala
lavender
21
22
verdigris
24
onyx
26
27
28
29
30');

        $this->highlightColor = explode("\n", '00
springcrocus
egyptiankohl
poisonberry
lilac
apricot
royalpurple
07
swampgreen
violet
scarlet
barkbrown
coffee
lemonade
chocolate
butterscotch
16
safetyvest
turtleback
19
wolfgrey
cerulian
skyblue
garnet
24
25
royalblue
mertail
28
pearl
30');

        $this->accentColor = explode("\n", 'belleblue
sandalwood
peach
icy
granitegrey
05
kittencream
emeraldgreen
08
shale
purplehaze
11
azaleablush
missmuffet
morningglory
frosting
daffodil
flamingo
18
bloodred
20
21
periwinkle
patrickstarfish
seafoam
25
26
mintmacaron
28
29
30');

        $this->wild = explode("\n", 'wild_1
wild_2
wild_3
wild_4
wild_5
wild_6
wild_7
wild_8
wild_9
wild_a
wild_b
wild_c
wild_d
wild_e
wild_f
wild_g
wild_h
elk
wild_j
trioculus
daemonwings
wild_n
wild_o
daemonhorns
wild_q
wild_r
wild_s
wild_t
wild_u
wild_v
wild_x');

        $this->mouth = explode("\n", 'whixtensions
wasntme
wuvme
gerbil
04
05
belch
07
beard
pouty
saycheese
grim
12
13
happygokitty
soserious
cheeky
starstruck
18
19
dali
grimace
22
tongue
yokel
25
neckbeard
27
28
29
30');

        $this->secret = explode("\n", 'secret_1
secret_2
secret_3
secret_4
secret_5
secret_6
secret_7
secret_8
secret_9
secret_a
secret_b
secret_c
secret_d
secret_e
secret_f
secret_g
secret_h
secret_i
secret_j
secret_k
secret_m
secret_n
secret_o
secret_p
secret_q
secret_r
secret_s
secret_t
secret_u
secret_v
secret_x');

        $this->mystery = explode("\n", 'mystery_1
mystery_2
mystery_3
mystery_4
mystery_5
mystery_6
mystery_7
mystery_8
mystery_9
mystery_a
mystery_b
mystery_c
mystery_d
mystery_e
mystery_f
mystery_g
salty
mystery_i
mystery_j
mystery_k
mystery_m
mystery_n
mystery_o
mystery_p
mystery_q
mystery_r
mystery_s
mystery_t
mystery_u
mystery_v
mystery_x');

        $this->unknown = explode("\n", 'unknown_1
unknown_2
unknown_3
unknown_4
unknown_5
unknown_6
unknown_7
unknown_8
unknown_9
unknown_a
unknown_b
unknown_c
unknown_d
unknown_e
unknown_f
unknown_g
unknown_h
unknown_i
unknown_j
unknown_k
unknown_m
unknown_n
unknown_o
unknown_p
unknown_q
unknown_r
unknown_s
unknown_t
unknown_u
unknown_v
unknown_x');


        $this->process();

    }

    /**
     * @return array
     */
    public function getFurKai()
    {
        return $this->furKai;
    }

    /**
     * @return array
     */
    public function getPatternKai()
    {
        return $this->patternKai;
    }

    private function makeKaiTranslation()
    {
        $kai = '1
2
3
4
5
6
7
8
9
a
b
c
d
e
f
g
h
i
j
k
m
n
o
p
q
r
s
t
u
v
w
x';
        $this->kaiTranslation = explode("\n", $kai);
    }

    private function process()
    {
        $this->makeKaiTranslation();

        for ($x=0; $x<count($this->kaiTranslation)-1; $x++) {
            $kai = $this->kaiTranslation[$x];

            $this->furKai[$this->fur[$x]] = $kai;
            $this->patternKai[$this->pattern[$x]] = $kai;
            $this->eyeColorKai[$this->eyeColor[$x]] = $kai;
            $this->eyeShapeKai[$this->eyeShape[$x]] = $kai;
            $this->baseColorKai[$this->baseColor[$x]] = $kai;
            $this->highlightColorKai[$this->highlightColor[$x]] = $kai;
            $this->accentColorKai[$this->accentColor[$x]] = $kai;
            $this->wildKai[$this->wild[$x]] = $kai;
            $this->mouthKai[$this->mouth[$x]] = $kai;

            $this->secretKai[$this->secret[$x]] = $kai;
            $this->unknownKai[$this->unknown[$x]] = $kai;
            $this->mysteryKai[$this->mystery[$x]] = $kai;

            $this->RfurKai[$kai] = $this->fur[$x];
            $this->RpatternKai[$kai] = $this->pattern[$x];
            $this->ReyeColorKai[$kai] = $this->eyeColor[$x];
            $this->ReyeShapeKai[$kai] = $this->eyeShape[$x];
            $this->RbaseColorKai[$kai] = $this->baseColor[$x];
            $this->RhighlightColorKai[$kai] = $this->highlightColor[$x];
            $this->RaccentColorKai[$kai] = $this->accentColor[$x];
            $this->RwildKai[$kai] = $this->wild[$x];
            $this->RmouthKai[$kai] = $this->mouth[$x];

            $this->RsecretKai[$kai] = $this->secret[$x];
            $this->RunknownKai[$kai] = $this->unknown[$x];
            $this->RmysteryKai[$kai] = $this->mystery[$x];
        }
    }

    /**
     * @return mixed
     */
    public function getEyeColorKai()
    {
        return $this->eyeColorKai;
    }

    /**
     * @return mixed
     */
    public function getEyeShapeKai()
    {
        return $this->eyeShapeKai;
    }

    /**
     * @return mixed
     */
    public function getBaseColorKai()
    {
        return $this->baseColorKai;
    }

    /**
     * @return mixed
     */
    public function getHighlightColorKai()
    {
        return $this->highlightColorKai;
    }

    /**
     * @return mixed
     */
    public function getAccentColorKai()
    {
        return $this->accentColorKai;
    }

    /**
     * @return mixed
     */
    public function getWildKai()
    {
        return $this->wildKai;
    }

    /**
     * @return mixed
     */
    public function getMouthKai()
    {
        return $this->mouthKai;
    }

    public function getMegaArray()
    {
        $cattributes =
            array_merge(
                array_keys($this->getFurKai()),
                array_keys($this->getPatternKai()),
                array_keys($this->getEyeColorKai()),
                array_keys($this->getEyeShapeKai()),
                array_keys($this->getBaseColorKai()),
                array_keys($this->getHighlightColorKai()),
                array_keys($this->getAccentColorKai()),
                array_keys($this->getWildKai()),
                array_keys($this->getMouthKai()),
                array_keys($this->getMysteryKai()),
                array_keys($this->getSecretKai()),
                array_keys($this->getUnknownKai())
            )
        ;

        return [
            'fur' => $this->getFurKai(),
            'pattern' => $this->getPatternKai(),
            'eyeColor' => $this->getEyeColorKai(),
            'eyeShape' => $this->getEyeShapeKai(),
            'baseColor' => $this->getBaseColorKai(),
            'highlightColor' => $this->getHighlightColorKai(),
            'accentColor' => $this->getAccentColorKai(),
            'wild' => $this->getWildKai(),
            'mouth' => $this->getMouthKai(),
            'unknown' => $this->getUnknownKai(),
            'secret' => $this->getSecretKai(),
            'mystery' => $this->getMysteryKai(),
            'cattributes' => $cattributes
        ];
    }

    public function getFormatedMegaArray()
    {
        return [
            1 => [
                'label' => 'Unknown',
                'codes' => $this->getRUnknownKai()
            ],
            2 => [
                'label' => 'Secret',
                'codes' => $this->getRSecretKai()
            ],
            3 => [
                'label' => 'Mystery',
                'codes' => $this->getRMysteryKai()
            ],
            4 => [
                'ui_label' => 'mouth',
                'label' => 'Mouth',
                'codes' => $this->getRmouthKai()
            ],
            5 => [
                'ui_label' => 'wild',
                'label' => 'Wild',
                'codes' => $this->getRwildKai()
            ],
            6 => [
                'ui_label' => 'secondarycolor',
                'label' => 'Accent Color',
                'codes' => $this->getRaccentColorKai()
            ],
            7 => [
                'ui_label' => 'highlightcolor',
                'label' => 'Highlight Color',
                'codes' => $this->getRhighlightColorKai()
            ],
            8 => [
                'ui_label' => 'bodycolor',
                'label' => 'Base Color',
                'codes' => $this->getRbaseColorKai()
            ],
            9 => [
                'ui_label' => 'eyeshape',
                'label' => 'Eye Shape',
                'codes' => $this->getReyeShapeKai()
            ],
            10 => [
                'ui_label' => 'eyecolor',
                'label' => 'Eye Color',
                'codes' => $this->getReyeColorKai()
            ],
            11 => [
                'ui_label' => 'pattern',
                'label' => 'Pattern',
                'codes' => $this->getRpatternKai()
            ],
            12 => [
                'ui_label' => 'body',
                'label' => 'Body',
                'codes' => $this->getRfurKai()
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getRfurKai()
    {
        return $this->RfurKai;
    }

    /**
     * @return mixed
     */
    public function getRpatternKai()
    {
        return $this->RpatternKai;
    }

    /**
     * @return mixed
     */
    public function getReyeColorKai()
    {
        return $this->ReyeColorKai;
    }

    /**
     * @return mixed
     */
    public function getReyeShapeKai()
    {
        return $this->ReyeShapeKai;
    }

    /**
     * @return mixed
     */
    public function getRbaseColorKai()
    {
        return $this->RbaseColorKai;
    }

    /**
     * @return mixed
     */
    public function getRhighlightColorKai()
    {
        return $this->RhighlightColorKai;
    }

    /**
     * @return mixed
     */
    public function getRaccentColorKai()
    {
        return $this->RaccentColorKai;
    }

    /**
     * @return mixed
     */
    public function getRwildKai()
    {
        return $this->RwildKai;
    }

    /**
     * @return mixed
     */
    public function getRmouthKai()
    {
        return $this->RmouthKai;
    }

    /**
     * @return array
     */
    public function getFur(): array
    {
        return $this->fur;
    }

    /**
     * @return array
     */
    public function getPattern(): array
    {
        return $this->pattern;
    }

    /**
     * @return array
     */
    public function getEyeColor(): array
    {
        return $this->eyeColor;
    }

    /**
     * @return array
     */
    public function getEyeShape(): array
    {
        return $this->eyeShape;
    }

    /**
     * @return array
     */
    public function getBaseColor(): array
    {
        return $this->baseColor;
    }

    /**
     * @return array
     */
    public function getHighlightColor(): array
    {
        return $this->highlightColor;
    }

    /**
     * @return array
     */
    public function getAccentColor(): array
    {
        return $this->accentColor;
    }

    /**
     * @return array
     */
    public function getWild(): array
    {
        return $this->wild;
    }

    /**
     * @return array
     */
    public function getMouth(): array
    {
        return $this->mouth;
    }

    public function getRUnknownKai() {
        return $this->RunknownKai;
    }

    public function getRSecretKai() {
        return $this->RsecretKai;
    }

    public function getRMysteryKai() {
        return $this->RmysteryKai;
    }

    /**
     * @return mixed
     */
    public function getUnknownKai()
    {
        return $this->unknownKai;
    }

    /**
     * @return mixed
     */
    public function getMysteryKai()
    {
        return $this->mysteryKai;
    }

    /**
     * @return mixed
     */
    public function getSecretKai()
    {
        return $this->secretKai;
    }


}