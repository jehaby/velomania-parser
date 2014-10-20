<div id="content">

    <?php $this->renderFeedbackMessages(); ?>

    <table>
    <?php
    if (!$this->themes) echo "<p> Для этого паттерна пока тем нет. </p>";
    foreach ($this->themes as $theme): ?>
        <tr>
            <td><?= $theme->theme_id?></td>
            <td><?= $theme->title?></td>
        </tr>
    <?php endforeach; ?>
    </table>



</div>

