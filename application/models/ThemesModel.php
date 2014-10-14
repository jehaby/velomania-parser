<?php


class ThemesModel extends Model {


    public function getThemes($pattern_id) {
        $sql = 'SELECT theme_id, title FROM Theme JOIN PatternTheme USING theme_id WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => (int)$pattern_id]);
        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Theme', ['', '']);
    }

    public function checkAllPatterns() {

    }


    public function newPatternInSections() {

    }
} 