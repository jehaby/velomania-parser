<?php


class Pattern {

    public $pattern_id, $pattern, $sections;

    private static $sections_mapping = [
        130 => 'Велосипеды шоссэ',
        131 => 'Велосипеды МТБ',
        128 => 'Рамы шоссэ',
        129 => 'Рамы МТБ',
        95 => 'Услуги',
        60 => 'Колёса',
        61 => 'Вилки и амортизаторы',
        62 => 'Сидим и рулим',
        63 => 'Крутим',
        64 => 'Переключаем',
        65 => 'Тормозим',
        66 => 'Одежда, обувь и защита',
        73 => 'Туристическое снаряжение',
        80 => 'Свет и электричество',
        70 => 'Aксессуары',
        87 => 'Не велосипедное',
        69 => 'Меняю',
        81 => 'Подарю!',
        72 => 'Украли!'
    ];

    public static function getSectionsMapping() {
        return self::$sections_mapping;
    }

    public function __construct($pattern_id, $pattern, $sections) {
        $this->pattern_id = $pattern_id;
        $this->pattern = $pattern;

        // should be at least one number in section string!
        if (!$sections) {
            d($pattern, $sections);
            throw new Exception('There should be at least one number in sections string! ' . $sections);
        }
        $this->sections = $sections;
    }

    public function sectionsAsWords() {
        $res = '|';
        foreach (explode(' ', $this->sections) as $section) {
            $res .= ' ' . self::$sections_mapping[(int) $section] . ' |';
        }
        return $res;
    }


} 