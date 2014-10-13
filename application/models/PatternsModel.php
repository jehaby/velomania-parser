<?php


class PatternsModel extends Model{

    public function getListOfPatterns() {
        $sql = "SELECT pattern_id, pattern, sections FROM Pattern JOIN UserPattern USING (pattern_id)
            JOIN User USING (user_id) WHERE user_id = :user_id;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":user_id" => $_SESSION['user_id']));
        $res = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pattern', ['pattern_id', 'pattern', 'sections']);
        return $res;
    }

    public function delete() {

    }

    public function add($themes_model) {
        if (!isset($_POST['new_pattern']) || !isset($_POST['sections']) ) {
            echo 'wtf';
            return false;
        }
        $themes_model->newPatternInSections();
        //
        $new_pattern = $_POST['new_pattern'];

        sort($_POST['sections']);
        $sections = implode(' ', $_POST['sections']);

        $sql = "INSERT INTO Pattern (pattern) VALUES (:pattern)";
        $query = $this->db->prepare($sql);
        $query->execute([':pattern' => $_POST['new_pattern']]);

        return true;
    }



} 