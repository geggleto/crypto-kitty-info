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
FU02
birman
koladiviya
bobtail
FU06
pixiebob
FU08
cymric
chartreux
himalayan
munchkin
sphynx
ragamuffin
ragdoll
norwegianforest
FU17
highlander
FU19
FU20
mainecoon
laperm
persian
FU24
FU25
FU26
manx
FU28
FU29
FU30');

        $this->pattern = explode("\n", 'PA00
tiger
rascal
ganado
leopard
camo
rorschach
spangled
calicool
luckystripe
amur
jaguar
spock
PA13
totesbasic
totesbasic
PA16
thunderstruck
dippedcone
highsociety
tigerpunk
henna
PA22
PA23
PA24
razzledazzle
hotrod
PA27
PA28
PA29
PA30');


        $this->eyeColor = explode("\n", 'thundergrey
gold
topaz
mintgreen
EC04
sizzurp
chestnut
strawberry
sapphire
forgetmenot
dahlia
coralsunrise
EC12
doridnudibranch
parakeet
cyan
pumpkin
limegreen
EC18
bubblegum
twilightsparkle
palejade
EC22
eclipse
babypuke
EC25
autumnmoon
EC27
EC28
EC29
EC30');

        $this->eyeShape = explode("\n", 'swarley
wonky
serpent
googly
otaku
simple
crazy
thicccbrowz
caffeine
ES09
baddate
ES11
chronic
slyboots
wiley
stunned
chameleon
alien
fabulous
raisedbrow
ES20
ES21
sass
sweetmeloncakes
oceanid
wingtips
ES26
buzzed
bornwithit
ES29
ES30');

        $this->baseColor = explode("\n", 'shadowgrey
salmon
BC02
orangesoda
cottoncandy
mauveover
aquamarine
nachocheez
harbourfog
cinderella
greymatter
BC11
BC12
dragonfruit
hintomint
bananacream
cloudwhite
BC17
oldlace
koala
lavender
BC21
BC22
verdigris
BC24
onyx
BC26
BC27
BC28
BC29
BC30');

        $this->highlightColor = explode("\n", 'HC00
springcrocus
egyptiankohl
poisonberry
lilac
apricot
royalpurple
HC07
swampgreen
violet
scarlet
barkbrown
coffee
lemonade
chocolate
butterscotch
HC16
safetyvest
turtleback
HC19
wolfgrey
cerulian
skyblue
garnet
HC24
HC25
royalblue
mertail
HC28
pearl
HC30');

        $this->accentColor = explode("\n", 'belleblue
sandalwood
peach
icy
granitegrey
AC05
kittencream
emeraldgreen
AC08
shale
purplehaze
AC11
azaleablush
missmuffett
morningglory
frosting
daffodil
flamingo
AC18
bloodred
AC20
AC21
periwinkle
patrickstarfish
seafoam
AC25
AC26
mintmacaron
AC28
AC29
AC30');

        $this->wild = explode("\n", 'WE00
WE01
WE02
WE03
WE04
WE05
WE06
WE07
WE08
WE09
WE10
WE11
WE12
WE13
WE14
WE15
WE16
elk
WE18
trioculus
daemonwings
WE21
WE22
daemonhorns
WE24
WE25
WE26
WE27
WE28
WE29
WE30');

        $this->mouth = explode("\n", 'whixtensions
wasntme
wuvme
gerbil
MO04
MO05
belch
rollercoaster
beard
pouty
saycheese
grim
MO12
MO13
happygokitty
soserious
cheeky
starstruck
MO18
ruhroh
dali
grimace
MO22
tongue
yokel
MO25
neckbeard
MO27
MO28
MO29
MO30');

        $this->secret = explode("\n", 'SE00
SE01
SE02
SE03
SE04
SE05
SE06
SE07
SE08
SE09
SE10
SE11
SE12
SE13
SE14
SE15
SE16
SE17
SE18
SE19
SE20
SE21
SE22
SE23
SE24
SE25
SE26
SE27
SE28
SE29
SE30');

        $this->mystery = explode("\n", 'EN00
EN01
EN02
EN03
EN04
EN05
EN06
EN07
EN08
EN09
EN10
EN11
EN12
EN13
EN14
EN15
salty
EN17
EN18
tinybox
EN20
EN21
EN22
EN23
EN24
EN25
EN26
EN27
EN28
EN29
EN30');

        $this->unknown = explode("\n", 'UN00
UN01
UN02
UN03
UN04
UN05
UN06
UN07
UN08
UN09
UN10
UN11
UN12
UN13
UN14
UN15
UN16
UN17
UN18
UN19
UN20
UN21
UN22
UN23
UN24
UN25
UN26
UN27
UN28
UN29
UN30');


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