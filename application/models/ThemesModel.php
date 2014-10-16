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

    private function getCheckedThemes($pattern_id)
    {
        $sql = 'SELECT theme_id FROM Theme JOIN PatternTheme USING theme_id WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => $pattern_id]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getUselessThemes($pattern_id)
    {
        $sql = 'SELECT theme_id FROM UselessTheme WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => $pattern_id]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    private function addThemes($pattern_id, $themes)
    {

    }

    private function addUselessThemes($pattern_id, $themes)
    {
        
    }



    function checkSection($pattern, $section_id, $new_pattern = False)
    {

        $pattern_id = 1;  // TODO: !!!

        if (!$new_pattern) {
            $checked_themes = $this->getCheckedThemes($pattern_id);
            $useless_themes = $this->getUselessThemes($pattern_id);
        }

        for ($page = $days_from_last_message = 1; !$this->tooOldThemes($days_from_last_message); $page++) {

            $link = "http://forum.velomania.ru/forumdisplay.php?f=" . $section_id . "&page=" . $page;
            $xpath = new DOMXPath(DOMDocument:: loadHTMLFile($link));
            $query_xpath = "//h3[@class='threadtitle']/a";

            foreach ($xpath->query($query_xpath) as $ore_for_theme) {
                $str = $ore_for_theme->C14N();
                preg_match("/(?<=php\?t=)(\d+)/", $str, $matches);   // Mmm ... regular expressions. First sex, then love.

                $theme = new Theme($matches[1], $ore_for_theme->nodeValue);

                if (!$new_pattern &&
                    array_key_exists($theme->id, $checked_themes) ||
                    array_key_exists($theme->id, $useless_themes)) {
                    continue;
                }

                if ($this->themeContainsPattern($pattern, $theme->id, $theme->title)) {
                    $themes_with_pattern[] = $theme;
                } else {
                    $themes_without_pattern[] = $theme;
                }
            }

            if (!$new_pattern) break;
            // Looking for time of last posting in theme. I suspect it's terribly ugly.
            $query_time = "(//dl[@class='threadlastpost td' and last()]/dd[span])[last()]";
            $last_date = explode(',', $t = $xpath->query($query_time)->item(0)->textContent)[0];
            $days_from_last_message = (new DateTime())->diff(DateTime:: createFromFormat("d.m.Y", $last_date))->d;
        }

        var_dump($days_from_last_message);
        var_dump($page);
        $this->addThemes($pattern_id, $themes_with_pattern);
        $this->addCheckedThemes($pattern_id, $themes_without_pattern);
    }

} 