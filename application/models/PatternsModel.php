<?php


class PatternsModel extends Model{

    public function getListOfPatterns() {
        $sql = "SELECT pattern FROM Pattern JOIN UserPattern USING (pattern_id) " .
            "JOIN User USING (user_id) WHERE user_id = :user_id;";
        $query = $this->db->prepare($sql);
        $query->execute(array(":user_id" => 1));
        $res = $query->fetchAll(PDO::FETCH_COLUMN);
        return $res;
    }

    public function delete() {

    }

    public function add($themes_model) {
        if (!isset($_POST['new_pattern'])) {
            echo 'wtf';
            return false;
        }
        $themes_model->newPatternInSections();
        //
        d($_POST);
        d($_SESSION);


        $sql = "INSERT INTO Pattern (pattern) VALUES (:pattern)";
        $query = $this->db->prepare($sql);
        $query->execute([':pattern' => $_POST['new_pattern']]);

        return true;
    }



} 