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
        // TODO: bug here! Pattern_Theme! Fixed?
        if (!isset($_POST['pattern_id_for_deletion'])) {
            d($_POST);
            $_SESSION['feedback_negative'][] = 'wtf';
            return;
        }
        $pattern_id = $_POST['pattern_id_for_deletion'];

        $sql = 'SELECT user_id FROM UserPattern WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => $pattern_id]);
        $res = $query->fetchAll(PDO::FETCH_COLUMN);

        if (count($res) === 1) {  // if only current user has this pattern
            $this->db->exec("DELETE FROM Pattern WHERE pattern_id = {$pattern_id};");
            $this->db->exec("DELETE FROM PatternTheme WHERE pattern_id = {$pattern_id};");
        }

        $this->db->exec("DELETE FROM UserPattern WHERE pattern_id = {$pattern_id} AND user_id = {$_SESSION['user_id']}");
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
            $_SESSION['feedback_negative'][] = FEEDBACK_PATTERN_NO_PATTERN_OR_SECTIONS;
            return;
        }

        $new_pattern = $_POST['new_pattern'];
        sort($_POST['sections']);
        $sections = implode(' ', $_POST['sections']);

//        d($this->patternExists($new_pattern, $sections));

        if (!$existing_pattern = $this->patternExists($new_pattern, $sections)) {

            $sql = 'INSERT INTO Pattern(pattern, sections) VALUES (:pattern, :sections);';
            $query = $this->db->prepare($sql);
            d($query->execute([':pattern' => $new_pattern, ':sections' => $sections]));

            echo 'sadfsadf';

            $pattern_id = (int) $this->db->lastInsertId();
            $this->db->exec("INSERT INTO UserPattern(user_id, pattern_id) VALUES ({$_SESSION['user_id']}, {$pattern_id})");

            $themes_model->newPatternInSections(new Pattern($pattern_id, $new_pattern, $sections));

        } else {
            // check if current user has this pattern
            $sql = "SELECT * FROM UserPattern
                WHERE pattern_id = {$existing_pattern->pattern_id} AND user_id = {$_SESSION['user_id']}";
            if ($this->db->query($sql)) {
                $_SESSION['feedback_negative'][] = FEEDBACK_PATTERN_USER_ALREADY_HAS_PATTERN;
                return;
            }

            $this->db->exec("INSERT INTO UserPattern(user_id, pattern_id) " .
                " VALUES ({$_SESSION['user_id']}, {$existing_pattern->pattern_id})");
        }
    }



} 