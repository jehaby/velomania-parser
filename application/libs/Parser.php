<?php


class Parser extends DB {

    private function tooOldThemes($days_from_last_message) {
        if ($days_from_last_message > 10) return True;
        return False;
    }

    private function stringContainsPattern ($pattern, $string) {
        return preg_match("/$pattern/i", $string);
    }

    private function themeBodyContainsPattern($pattern, $theme_id) {  // checks only first message of the theme
        $link = "http://forum.velomania.ru/showthread.php?t=" . $theme_id;
        $xpath = new DOMXPath(DOMDocument :: loadHTMLFile($link));
        $query_xpath = "(//div[@class='content']/div/blockquote)[1]";  // TODO: speed up xpath queries?
        $message_text = $xpath -> query($query_xpath) -> item(0) -> nodeValue;
        return $this -> stringContainsPattern($pattern, $message_text);
    }

    private function themeContainsPattern($pattern, $theme_id, $theme_title) {
        if ($this -> stringContainsPattern($pattern, $theme_title)) return True;
        if ($this -> themeBodyContainsPattern($pattern, $theme_id)) return True;
        return False;
    }

    function checkSection($pattern, $section_id, $new_pattern = False) {
        if (!$new_pattern) $checked_themes = $this->$db->getCheckedThemes($pattern);

        for ($page = $days_from_last_message = 1; !$this->tooOldThemes($days_from_last_message); $page++) {

            $link = "http://forum.velomania.ru/forumdisplay.php?f=" . $section_id . "&page=" . $page;
            $xpath = new DOMXPath(DOMDocument:: loadHTMLFile($link));
            $query_xpath = "//h3[@class='threadtitle']/a";

            foreach ($xpath->query($query_xpath) as $ore_for_theme) {
                $str = $ore_for_theme->C14N();
                preg_match("/(?<=php\?t=)(\d+)/", $str, $matches);   // Mmm ... regular expressions. First sex, then love.

                $theme = new Theme($matches[1], $ore_for_theme->nodeValue);

                if (!$new_pattern && array_key_exists($theme->id, $checked_themes)) continue;

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
        $this -> db -> addThemes($pattern, $themes_with_pattern);
        $this -> db -> addCheckedThemes($pattern, $themes_without_pattern);
    }

}
