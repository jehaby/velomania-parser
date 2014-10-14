<?php
$sections = Pattern::getSectionsMapping();

?>


<div id="content">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>


    <table>
        <?php
        if ($this->patterns) {
            foreach($this->patterns as $pattern) {
                echo '<tr >';
                echo "<td> <a href='". URL . "themes/show/$pattern->pattern_id'>$pattern->pattern</a> </td>";
                ?>
                <td> <?=$pattern->sectionsAsWords()?> </td>
                <td>
                    <form action="<?=URL?>patterns/delete" method="POST">
                        <input type="hidden" name="pattern_id_for_deletion" value="<?=$pattern->pattern_id?>">
                        <input type="submit" content="Удалить" name = 'x' value="x">
                    </form>
                </td>
                <?php
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
        <input type="reset" name="Очистить">
        <input type="submit" value="Добавить паттерн"/>
    </form>

    <?php d($this->patterns); ?>
</div>