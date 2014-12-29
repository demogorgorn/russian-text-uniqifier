<?php

namespace tugmaks\RTU;

/**
 * Uniqifier class
 * Check symbol - http://unicodelookup.com
 * src - http://en.wikipedia.org/wiki/List_of_Unicode_characters
 * To add a new symbolMap use this template
 * [
  'А' => '',
  'Б' => '',
  'В' => '',
  'Г' => '',
  'Д' => '',
  'Е' => '',
  'Ё' => '',
  'Ж' => '',
  'З' => '',
  'И' => '',
  'Й' => '',
  'К' => '',
  'Л' => '',
  'М' => '',
  'Н' => '',
  'О' => '',
  'П' => '',
  'Р' => '',
  'С' => '',
  'Т' => '',
  'У' => '',
  'Ф' => '',
  'Х' => '',
  'Ц' => '',
  'Ч' => '',
  'Ш' => '',
  'Щ' => '',
  'Ъ' => '',
  'Ь' => '',
  'Э' => '',
  'Ю' => '',
  'Я' => '',
  'а' => '',
  'б' => '',
  'в' => '',
  'г' => '',
  'д' => '',
  'е' => '',
  'ё' => '',
  'ж' => '',
  'з' => '',
  'и' => '',
  'й' => '',
  'к' => '',
  'л' => '',
  'м' => '',
  'н' => '',
  'о' => '',
  'п' => '',
  'р' => '',
  'с' => '',
  'т' => '',
  'у' => '',
  'ф' => '',
  'х' => '',
  'ц' => '',
  'ч' => '',
  'ш' => '',
  'щ' => '',
  'ъ' => '',
  'ь' => '',
  'э' => '',
  'ю' => '',
  'я' => '',
  ];
 */
class Uniqifier {

    const MAP_LATIN = 'latin';
    const MAP_GREEK = 'greek';
    const MAP_ARMENIAN = 'armenian';
    const MAP_GEORGIAN = 'georgian';
    const MAP_CHEROKEE = 'cherokee';

    /**
     * Latin list
     * @var array
     */
    private $_latinMap = [
        'А' => 'A',
        'Б' => 'Ƃ', //Latin Capital Letter B with top bar
        'В' => 'B',
        'Е' => 'E',
        'К' => 'K',
        'М' => 'M',
        'Н' => 'H',
        'О' => 'O',
        'Р' => 'P',
        'С' => 'C',
        'Т' => 'T',
        'У' => 'Y',
        'Х' => 'X',
        'а' => 'a',
        'е' => 'e',
        'к' => 'k',
        'о' => 'o',
        'с' => 'c',
        'у' => 'y',
        'х' => 'x',
    ];

    /**
     * Greek list
     * @var array
     */
    private $_greekMap = [
        'А' => 'Α',
        'В' => 'Β',
        'Г' => 'Γ',
        'Е' => 'Ε',
        'К' => 'Κ',
        'М' => 'Μ',
        'Н' => 'Η',
        'О' => 'Ο',
        'П' => 'Π',
        'Р' => 'Ρ',
        'С' => 'C',
        'Т' => 'Τ',
        'У' => 'Υ',
        'Ф' => 'Φ',
        'Х' => 'Χ',
        'б' => 'ϭ', //Coptic Small Letter Shima
        'к' => 'κ',
        'о' => 'ο',
        'р' => 'ρ',
        'с' => 'ϲ', //Greek Lunate Sigma Symbol
        'ф' => 'ϕ',
        'э' => '϶', //Greek Reversed Lunate Epsilon Symbol
    ];

    /**
     * Armenian list
     * @var array
     */
    private $_armenianMap = [
        'О' => 'Օ',
        'Ф' => 'Փ',
        'о' => 'օ',
    ];

    /**
     * Georgian list
     * @var array
     */
    private $_georgianMap = [
        'У' => 'Ⴘ',
        'Ф' => 'Ⴔ',
        'Ч' => 'Ⴗ',
    ];

    /**
     * Cherokee list
     * @var array
     */
    private $_cherokeeMap = [
        'А' => 'Ꭺ',
        'В' => 'Ᏼ',
        'Г' => 'Ꮁ',
        'Е' => 'Ꭼ',
        'К' => 'Ꮶ',
        'М' => 'Ꮇ',
        'Н' => 'Ꮋ',
        'Р' => 'Ꮲ',
        'С' => 'Ꮯ',
        'Т' => 'Ꭲ',
        'У' => 'Ꭹ',
    ];

    /**
     * Result map. It will contain symbols according to choosen maps
     * @var array
     */
    private $_resultMap = [];

    /**
     * Text that should be uniqified
     * @var strig
     */
    public $text;

    /**
     * Array of maps that should be used
     * @var array
     */
    public $encodings;

    /**
     * Probablity that symbol be changed.
     * @var integer
     */
    public $probablity;

    /**
     * Constructor.
     * @param text $text
     * @param array $params configurations to be applied
     */
    public function __construct($text, $params = []) {
        $this->text = $text;
        $this->encodings = isset($params['encodings']) ? $params['encodings'] : [self::MAP_LATIN];
        $this->probablity = isset($params['probablity']) ? $params['probablity'] : 50;
        $this->prepareResultMap();
    }

    /**
     * Prepare result map of symbols
     */
    private function prepareResultMap() {
        $resultMap = [];
        foreach ($this->encodings as $encoding) {
            $map = "_" . $encoding . "Map";
            foreach ($this->$map as $ru => $fo) {
                $resultMap[$ru][] = $fo;
            }
        }
        $this->_resultMap = $resultMap;
    }

    /**
     * Setter for encodings
     * @param array $encodings Description
     * * @return this
     */
    public function setEncodings(array $encodings) {
        $this->encodings = $encodings;
        return $this;
    }

    /**
     * Setter for probablity
     * @param array $probablity Description
     * @return this
     */
    public function setProbablity($probablity) {
        $this->probablity = $probablity;
        return $this;
    }

    public function uniqify() {
        $symbols = $this->mb_str_split($this->text);
        var_dump($symbols);
        foreach ($symbols as $key => $symbol) {
            if (array_key_exists($symbol, $this->_resultMap) && $this->fireEvent()) {
                $symbols[$key] = $this->pickRandom($this->_resultMap[$key]);
            }
            return implode('', $symbols);
        }
    }

    /**
     * Check if replace should be done
     * @return bool
     */
    private function fireEvent() {
        $random = rand(0, 100);
        if ($random < $this->probablity) {
            return true;
        }
        return false;
    }

    /**
     * Pick one random symbols from array
     * @return string
     */
    private function pickRandom(array $symbols) {
        $rand_key = array_rand($symbols);
        return $symbols[$rand_key];
    }

    private function mb_str_split($string, $string_length = 1, $charset = 'utf-8') {
        if (mb_strlen($string, $charset) > $string_length || !$string_length) {
            do {
                $c = mb_strlen($string, $charset);
                $parts[] = mb_substr($string, 0, $string_length, $charset);
                $string = mb_substr($string, $string_length, $c - $string_length, $charset);
            } while (!empty($string));
        } else {
            $parts = array($string);
        }
        return $parts;
    }

}
