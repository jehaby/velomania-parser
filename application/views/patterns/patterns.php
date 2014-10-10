<div id="content">
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


    <form action="" method="POST">
        <input type="text"/>
        <input type="submit"/>
    </form>


</div>