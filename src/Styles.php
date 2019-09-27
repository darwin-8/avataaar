<?php

namespace Avataaar;


class Styles
{
    public $avatarStyle = [
        "Circle", "Transparent"
    ];
    public $accessoriesType = [
        "Blank", "Kurt", "Prescription01", "Prescription02", "Round",
        "Sunglasses", "Wayfarers"
    ];
    public $clotheType = [
        "BlazerShirt", "BlazerSweater", "CollarSweater", "GraphicShirt", "Hoodie",
        "Overall", "ShirtCrewNeck", "ShirtScoopNeck", "ShirtVNeck"
    ];
    public $clotheColor = [
        "Black", "Blue01", "Blue02", "Blue03", "Gray01", "Gray02", "Heather", "PastelBlue",
        "PastelGreen", "PastelOrange", "PastelRed", "PastelYellow", "Pink", "Red", "White"
    ];
    public $eyebrowType = [
        "Angry", "AngryNatural", "Default", "DefaultNatural", "FlatNatural",
        "RaisedExcited", "RaisedExcitedNatural", "SadConcerned",
        "SadConcernedNatural", "UnibrowNatural", "UpDown", "UpDownNatural"
    ];
    public $eyeType = [
        "Close", "Cry", "Default", "Dizzy", "EyeRoll", "Happy", "Hearts", "Side",
        "Squint", "Surprised", "Wink", "WinkWacky"
    ];
    public $facialHairColor = [
        "Auburn", "Black", "Blonde", "BlondeGolden", "Brown", "BrownDark",
        "Platinum", "Red"
    ];
    public $facialHairType = [
        "Blank", "BeardMedium", "BeardLight", "BeardMagestic", "MoustacheFancy",
        "MoustacheMagnum"
    ];
    public $graphicType = [
        "Bat", "Cumbia", "Deer", "Diamond", "Hola", "Pizza", "Resist", "Selena",
        "Bear", "SkullOutline", "Skull"
    ];
    public $hairColor = [
        "Auburn", "Black", "Blonde", "BlondeGolden", "Brown", "BrownDark",
        "PastelPink", "Platinum", "Red", "SilverGray"
    ];
    public $mouthType = [
        "Concerned", "Default", "Disbelief", "Eating", "Grimace", "Sad",
        "ScreamOpen", "Serious", "Smile", "Tongue", "Twinkle", "Vomit"
    ];
    public $skinColor = [
        "Tanned", "Yellow", "Pale", "Light", "Brown", "DarkBrown", "Black"
    ];
    public $topType = [
        "NoHair", "Eyepatch", "Hat", "Hijab", "Turban", "WinterHat1",
        "WinterHat2", "WinterHat3", "WinterHat4", "LongHairBigHair",
        "LongHairBob", "LongHairBun", "LongHairCurly", "LongHairCurvy",
        "LongHairDreads", "LongHairFrida", "LongHairFro", "LongHairFroBand",
        "LongHairNotTooLong", "LongHairShavedSides", "LongHairMiaWallace",
        "LongHairStraight", "LongHairStraight2", "LongHairStraightStrand",
        "ShortHairDreads01", "ShortHairDreads02", "ShortHairFrizzle",
        "ShortHairShaggyMullet", "ShortHairShortCurly", "ShortHairShortFlat",
        "ShortHairShortRound", "ShortHairShortWaved", "ShortHairSides",
        "ShortHairTheCaesar", "ShortHairTheCaesarSidePart"
    ];

    /**
     * @var array [styleKey => [function(){}, ]]
     */
    private $filters = [];

    /**
     * @return array
     */
    public function getStylesKeys()
    {
        return [
            'avatarStyle',
            'accessoriesType',
            'clotheType',
            'clotheColor',
            'eyebrowType',
            'eyeType',
            'facialHairColor',
            'facialHairType',
            'graphicType',
            'hairColor',
            'mouthType',
            'skinColor',
            'topType',
        ];
    }

    /**
     * @return array
     */
    public function getStyles()
    {
        return [
            'avatarStyle' => $this->avatarStyle,
            'accessoriesType' => $this->accessoriesType,
            'clotheType' => $this->clotheType,
            'clotheColor' => $this->clotheColor,
            'eyebrowType' => $this->eyebrowType,
            'eyeType' => $this->eyeType,
            'facialHairColor' => $this->facialHairColor,
            'facialHairType' => $this->facialHairType,
            'graphicType' => $this->graphicType,
            'hairColor' => $this->hairColor,
            'mouthType' => $this->mouthType,
            'skinColor' => $this->skinColor,
            'topType' => $this->topType,
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getRandomStyles()
    {
        $result = [];
        foreach ($this->getStylesKeys() as $style) {
            $result[$style] = $this->getRandomStyle($style);
        }
        return $result;
    }

    /**
     * @param string $key
     * @return string
     * @throws \Exception
     */
    public function getRandomStyle($key)
    {
        if (!property_exists($this, $key)) {
            throw new \Exception("There is no property {$key}");
        }
        if (key_exists($key, $this->filters) && !empty($this->filters[$key])) {
            $result = $this->{$key}[array_rand($this->appendFilters($this->{$key}, $this->filters[$key]))];
        } else {
            $result = $this->{$key}[array_rand($this->{$key})];
        }
        return $result;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function except($data = [])
    {
        foreach ($data as $key => $styles) {
            $this->filters[$key][] = function ($item) use ($styles) {
                return !in_array($item, $styles);
            };
        }
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function only($data = [])
    {
        foreach ($data as $key => $styles) {
            $this->filters[$key][] = function ($item) use ($styles) {
                return in_array($item, $styles);
            };
        }
        return $this;
    }

    /**
     * @param $array
     * @param $functions
     * @return mixed
     */
    private function appendFilters($array, $functions)
    {
        while ($functions) {
            $result = array_filter($array, array_shift($functions));
            return $this->appendFilters($result, $functions);
        }
        return $array;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function __invoke()
    {
        return $this->getRandomStyles();
    }
}