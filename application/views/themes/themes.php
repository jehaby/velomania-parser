<div id="content">

    <?php $this->renderFeedbackMessages(); ?>

    <table>
    <?php
    if (!$this->themes) echo "<p> Для этого паттерна пока тем нет. </p>";
    foreach ($this->themes as $theme): ?>
        <tr>
            <td><?= $theme->theme_id?></td>
            <td><?= $theme->title?></td>
            <td><a href='http://forum.velomania.ru/showthread.php?t=<?=$theme->theme_id?>'> <?= $theme->title?> </a></td>
        </tr>
    <?php endforeach; ?>
    </table>



</div>

