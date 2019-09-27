<?php

namespace Avataaar;

/**
 * Class Avataaar
 * @package Avaaatar
 *
 */
class Avataaar
{
    //  set in config https://avataaars.io
    private $host;

    /**
     * @var Styles
     */
    private $styles;

    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->styles = new Styles();
    }

    /**
     * @param null $styles
     * @return mixed
     * @throws \Exception
     */
    public function get($styles = null)
    {
        if (is_null($styles)) {
            $query = $this->host . '?' . http_build_query(call_user_func($this->styles));
        } else {
            $query = $this->host . '?' . http_build_query($styles);
        }
        $ch = curl_init($query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {
            $result = curl_exec($ch);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        if ($result === false) {
            var_dump(curl_error($ch));
            throw new \Exception(curl_error($ch));
        } else {
            curl_close($ch);
            return $result;
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function except($data = [])
    {
        $this->styles->except($data);
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function only($data = [])
    {
        $this->styles->only($data);
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function girl()
    {
        $this->styles->only(['topType' => ["LongHairBigHair",
            "LongHairBob", "LongHairBun", "LongHairCurly", "LongHairCurvy",
            "LongHairDreads", "LongHairFrida", "LongHairFro", "LongHairFroBand",
            "LongHairNotTooLong", "LongHairShavedSides", "LongHairMiaWallace",
            "LongHairStraight", "LongHairStraight2", "LongHairStraightStrand",
        ], 'facialHairType' => ['Blank']]);
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function guy()
    {
        $this->styles->except(['topType' => ["LongHairBigHair",
            "LongHairBob", "LongHairBun", "LongHairCurly", "LongHairCurvy",
            "LongHairDreads", "LongHairFrida", "LongHairFro", "LongHairFroBand",
            "LongHairNotTooLong", "LongHairShavedSides", "LongHairMiaWallace",
            "LongHairStraight", "LongHairStraight2", "LongHairStraightStrand",
        ]]);
        return $this;
    }

}