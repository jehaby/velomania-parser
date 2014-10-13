<?php


class PatternsModel extends Model
{

    public function getListOfPatterns()
    {
        $sql = "SELECT pattern_id, pattern, sections FROM Pattern JOIN UserPattern USING (pattern_id)
            JOIN User USING (user_id) WHERE user_id = :user_id;";
        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $_SESSION['user_id']]);
        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pattern', ['pattern_id', 'pattern', 'sections']);
    }

    public function delete() {

    }

    private function patternExists($pattern, $sections)
    {
        $sql = "SELECT pattern_id, pattern, sections FROM Pattern WHERE pattern = :pattern AND sections = :sections";
        $query = $this->db->prepare($sql);
        $query->execute([':pattern' => $pattern, ':sections' => $sections]);
        if ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            return new Pattern($res['pattern_id'], $res['pattern'], $res['sections']);
        }
        return false;
    }

    public function add($themes_model)
    {
        if (!isset($_POST['new_pattern']) || !isset($_POST['sections']) ) {
            throw new Exception("'new_pattern' and 'sections' must be set!");
        }

        $new_pattern = $_POST['new_pattern'];
        sort($_POST['sections']);
        $sections = implode(' ', $_POST['sections']);

        if (!$existing_pattern = $this->patternExists($new_pattern, $sections)) {
            $themes_model->newPatternInSections();
            $sql = "INSERT INTO ";


        } else {
            // check if current user has this pattern
            $sql = "SELECT * FROM UserPattern
                WHERE pattern_id = {$existing_pattern->pattern_id} AND user_id = {$_SESSION['user_id']}";
            if ($this->db->exec($sql)->fetch()) {
                // finishepta
            }
            $sql = "";


        }



        //
        $new_pattern = $_POST['new_pattern'];




        $sql = "INSERT INTO Pattern (pattern) VALUES (:pattern)";
        $query = $this->db->prepare($sql);
        $query->execute([':pattern' => $_POST['new_pattern']]);

        return true;
    }



} 