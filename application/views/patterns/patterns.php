<?php
$sections = array (
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
    72 => 'Украли!',
);

?>


<div id="content">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>


    <table>
        <?php
        if ($this->patterns) {
            foreach($this->patterns as $pattern) {
                echo '<tr >';
                echo "<td> <a href='". URL . "themes/show/$pattern'>$pattern</a> </td>";
                echo "<td> <a href = '" . URL . "patterns/delete/$pattern'> x </a> </td>";
                echo '</tr >';
            }
        } else {
            echo "You don't have patterns yet";
        }
        ?>
    </table>


    <form action="<?=URL . 'patterns/add'?>" method="POST">
        <input type="text" name="new_pattern" required /><br>
        <?php foreach ($sections as $section_id => $section_name): ?>
            <input type="checkbox" value="<?= $section_id?>" name="sections[]"> <?=$section_name?> <br>
        <?php endforeach; ?>
        <input type="submit" value="Добавить паттерн"/>
    </form>

    <?php d($this->patterns); ?>
</div>