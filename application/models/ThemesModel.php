<?php


class ThemesModel extends Model
{


    public function getThemes($pattern_id)
    {
        $sql = 'SELECT theme_id, title FROM Theme JOIN PatternTheme USING (theme_id) WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => (int)$pattern_id]);
        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Theme', ['', '']);
    }

    public function checkAllPatterns()
    {
        $all_patterns = $this->db->query("SELECT pattern_id, pattern, sections FROM Pattern")
            ->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pattern', ['', '', 1]) ;

        foreach ($all_patterns as $pattern) {
            $sections = explode(' ', $pattern->sections);
            foreach ($sections as $section) {
                $this->checkSection($pattern, $section);
            }
        }
    }

    public function newPatternInSections($pattern)
    {
        foreach (explode(' ', $pattern->sections) as $section) {
            $this->checkSection($pattern->pattern, $section);
        }
    }

    private function getCheckedThemes($pattern_id)
    {
        $sql = 'SELECT theme_id FROM Theme JOIN PatternTheme USING (theme_id) WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => $pattern_id]);
        return array_flip($query->fetchAll(PDO::FETCH_COLUMN));
    }

    private function getUselessThemes($pattern_id)
    {
        $sql = 'SELECT theme_id FROM UselessTheme WHERE pattern_id = :pattern_id';
        $query = $this->db->prepare($sql);
        $query->execute([':pattern_id' => $pattern_id]);
        return array_flip($query->fetchAll(PDO::FETCH_COLUMN));
    }

    private function addThemes($pattern_id, $themes)
    {
        $sql = 'INSERT INTO PatternTheme(pattern_id, theme_id) VALUES (:pattern_id, :theme_id);';
        $query1 = $this->db->prepare($sql);

        $sql = 'INSERT INTO Theme(theme_id, title, author) VALUES (:theme_id, :title, :author)';
        $query2 = $this->db->prepare($sql);

        foreach ($themes as $theme) {
            $query1->execute([':pattern_id' => $pattern_id, ':theme_id' => $theme->id ]);
            $query2->execute([':theme_id' => $theme->id, ':title' => $theme->title, ':author' => $theme->author]);
        }
    }

    private function addUselessThemes($themes)
    {
        if (count($themes) < 2)
            return;

        $sql = 'INSERT INTO UselessTheme(theme_id, pattern_id) VALUES ' .
            implode(', ' , array_fill(0, count($themes) / 2, '(?, ?)'));

        $query = $this->db->prepare($sql);
        $query->execute($themes);
    }

    private function stringContainsPattern ($pattern, $string)
    {
        return preg_match("/$pattern/i", $string);
    }

    private function themeBodyContainsPattern($pattern, $theme_id) // checks only first message of the theme
    {
        $link = "http://forum.velomania.ru/showthread.php?t=" . $theme_id;
        $xpath = new DOMXPath(DOMDocument::loadHTMLFile($link));
        $query_xpath = "(//div[@class='content']/div/blockquote)[1]";  // TODO: speed up xpath queries?
        $message_text = $xpath -> query($query_xpath) -> item(0) -> nodeValue;
        return $this->stringContainsPattern($pattern, $message_text);
    }

    private function themeContainsPattern($pattern, $theme_id, $theme_title)
    {
        if ($this->stringContainsPattern($pattern, $theme_title)) return True;
        if ($this->themeBodyContainsPattern($pattern, $theme_id)) return True;
        return False;
    }

    private function tooOldThemes($days_from_last_message)
    {
        if ($days_from_last_message > 10) return True;
        return False;
    }


    function checkSection($pattern, $section_id, $new_pattern = False)
    {
        if (!$new_pattern) {
            $checked_themes = $this->getCheckedThemes($pattern->pattern_id);
            $useless_themes = $this->getUselessThemes($pattern->pattern_id);
        }

        $themes_with_pattern = [];
        $themes_without_pattern = [];

        for ($page = $days_from_last_message = 1; !$this->tooOldThemes($days_from_last_message); $page++) {

            $link = "http://forum.velomania.ru/forumdisplay.php?f=" . $section_id . "&page=" . $page;
            $xpath = new DOMXPath(DOMDocument:: loadHTMLFile($link));
            $query_xpath = "//h3[@class='threadtitle']/a";

            foreach ($xpath->query($query_xpath) as $ore_for_theme) {
                $str = $ore_for_theme->C14N();
                preg_match("/(?<=php\?t=)(\d+)/", $str, $matches);

                $theme = new Theme($matches[1], $ore_for_theme->nodeValue);

                if (!$new_pattern &&
                    (array_key_exists($theme->id, $checked_themes) ||
                        array_key_exists($theme->id, $useless_themes))) {
                    continue;
                }

                if ($this->themeContainsPattern($pattern->pattern, $theme->id, $theme->title)) {
                    $themes_with_pattern[] = $theme;
                } else {
                    array_push($themes_without_pattern, $theme->id, $pattern->pattern_id);
                }
            }

            if (!$new_pattern) break;
            // Looking for time of last posting in theme. I suspect it's terribly ugly.
            $query_time = "(//dl[@class='threadlastpost td' and last()]/dd[span])[last()]";
            $last_date = explode(',', $t = $xpath->query($query_time)->item(0)->textContent)[0];
            $days_from_last_message = (new DateTime())->diff(DateTime:: createFromFormat("d.m.Y", $last_date))->d;
        }

        if ($themes_with_pattern) {
            $this->addThemes($pattern->pattern_id, $themes_with_pattern);
            Mailer::sendMail($_SESSION['user_email'], $_SESSION['username'], $pattern, $themes_with_pattern);
        }

        // TODO: mail $themes_with_pattern
        $this->addUselessThemes($themes_without_pattern);
    }

} 