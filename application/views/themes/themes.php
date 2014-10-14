<div id="content">
    <table>
    <?php foreach ($this->themes as $theme): ?>
        <tr>
            <td><?= $theme->theme_id?></td>
            <td><?= $theme->title?></td>
        </tr>
    <?php endforeach; ?>
    </table>



</div>

