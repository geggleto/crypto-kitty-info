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

    public function __construct()
    {
        $this->fur = explode("\n", 'savannah
selkirk

birman

bobtail

pixiebob

cymric
chartreux
himalayan
munchkin
sphynx
ragamuffin
ragdoll
norwegianforest




mainecoon
laperm
persian



manx



');

        $this->pattern = explode("\n", '
tiger
rascal
ganado
leopard
camo

spangled
calicool
luckystripe
amur
jaguar
spock

totesbasic_f
totesbasic_g

thunderstruck
dippedcone

tigerpunk
henna

totesbasic_p


hotrod



');
        $this->eyeColor = explode("\n", 'thundergrey
gold
topaz
mintgreen

sizzurp
chestnut
strawberry
sapphire
forgetmenot

coralsunrise



cyan
pumpkin
limegreen

bubblegum
twilightsparkle



babypuke





');

        $this->eyeShape = explode("\n", '
wonky
serpent
googly
otaku
simple
crazy
thicccbrowz


baddate

chronic
slyboots
wiley
stunned

alien
fabulous
raisedbrow


sass
sweetmeloncakes

wingtips

buzzed


');

        $this->baseColor = explode("\n", 'shadowgrey
salmon

orangesoda
cottoncandy
mauveover
aquamarine
nachocheez
harbourfog

greymatter


dragonfruit
hintomint
bananacream
cloudwhite

oldlace
koala



verdigris

onyx




');

        $this->highlightColor = explode("\n", '

egyptiankohl
poisonberry
lilac
apricot
royalpurple

swampgreen
violet
scarlet
barkbrown
coffee
lemonade
chocolate


safetyvest
turtleback

wolfgrey
cerulian
skyblue



royalblue



');

        $this->accentColor = explode("\n", 'belleblue
sandalwood
peach
icy
granitegrey

kittencream
emeraldgreen


purplehaze

azaleablush
missmuffet
morningglory

daffodil
flamingo

bloodred


periwinkle

seafoam





');

        $this->wild = explode("\n", 'wild_1

wild_3
wild_4

wild_6

wild_8




wild_d




elk

trioculus










');

        $this->mouth = explode("\n", 'whixtensions
wasntme
wuvme
gerbil


belch

beard
pouty
saycheese
grim


happygokitty
soserious
cheeky
starstruck


dali
grimace

tongue
yokel

neckbeard



');

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

        for ($x=0; $x<count($this->kaiTranslation); $x++) {
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
                array_keys($this->getMouthKai())
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
            'cattributes' => $cattributes
        ];
    }
}