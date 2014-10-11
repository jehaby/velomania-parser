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

    public function add() {

    }



} 