<?php
use XoopsModules\Tadtools\ResponsiveSlides;
use XoopsModules\Tadtools\Utility;

if (!class_exists('XoopsModules\Tadtools\ResponsiveSlides')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式
function tad_themes_responsive_slider($options)
{
    global $xoopsDB, $xoopsConfig;

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes') . '` WHERE `theme_name` =?';
    $result = Utility::query($sql, 's', [$xoopsConfig['theme_set']]);

    $data = $xoopsDB->fetchArray($result);
    if (empty($data)) {
        return;
    }

    if ($data['slide_width'] > 0) {
        return;
    }

    $block = '';

    if (!empty($data['logo_img'])) {
        if ('page' === $data['logo_position']) {
            $block = '';
        } else {
            $logo_place = '';
            if (!empty($data['logo_top'])) {
                $logo_place .= "top:{$data['logo_top']}px;";
            }

            if (!empty($data['logo_bottom'])) {
                $logo_place .= "bottom:{$data['logo_bottom']}px;";
            }

            if ('1' == $data['logo_center']) {
                $logo_place .= 'margin-left: auto; margin-right: auto; left: 0; right: 0;';
            } else {
                if (!empty($data['logo_right'])) {
                    $logo_place .= "right:{$data['logo_right']}px;";
                }

                if (!empty($data['logo_left'])) {
                    $logo_place .= "left:{$data['logo_left']}px;";
                }
            }

            $block = "<a href='" . XOOPS_URL . "' title='{$xoopsConfig['sitename']}'><img src='" . XOOPS_URL . "/uploads/tad_themes/{$xoopsConfig['theme_set']}/logo/{$data['logo_img']}' alt='{$xoopsConfig['sitename']}' style='position:absolute; z-index:3;{$logo_place}'></a>";
        }
    }

    $ResponsiveSlides = new ResponsiveSlides(120, false);

    $sql = 'SELECT a.*, b.`slide_width`, b.`slide_height` FROM `' . $xoopsDB->prefix('tad_themes_files_center') . '` AS a LEFT JOIN `' . $xoopsDB->prefix('tad_themes') . "` AS b ON a.`col_sn` = b.`theme_id` WHERE a.`col_name` = 'slide' AND b.`theme_name` = '{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $slide_images = 0;
    $title = $date = '';
    while ($data = $xoopsDB->fetchArray($result)) {
        $files_sn     = $data['files_sn'];
        $file_name    = $data['file_name'];
        $description  = $data['description'];
        $slide_width  = $data['slide_width'];
        $slide_height = $data['slide_height'];
        $url          = XOOPS_URL;
        $slide_target = '';
        $slide_images++;

        if ($description) {
            // preg_match_all("/\](.*)\[/", $description, $matches);
            // $url         = isset($matches[1][0]) ? $matches[1][0] : XOOPS_URL;
            // $description = str_replace("[url]{$url}[/url]", "", $description);

            preg_match_all("/\](.*)\[/", $description, $matches);
            $url = isset($matches[1][0]) ? $matches[1][0] : '';
            if (empty($url)) {
                $url = XOOPS_URL;
            }

            if (false !== mb_strpos($description, 'url_blank')) {
                $description = str_replace("[url_blank]{$url}[/url_blank]", '', $description);
                $slide_target = "target='_blank'";
            } else {
                $description = str_replace("[url]{$url}[/url]", '', $description);
                $slide_target = '';
            }
        }

        if ('swf' === mb_strtolower(mb_substr($file_name, -3)) and $slide_width <= 12) {
            $slide_width = round((100 / 12) * 12, 0) . '%';
            if (0 == $slide_height) {
                $slide_height = 250;
            }
        }
        $ResponsiveSlides->add_content($files_sn, $title, $description, XOOPS_URL . "/uploads/tad_themes/{$xoopsConfig['theme_set']}/slide/{$file_name}", $date, $url, $slide_width, $slide_height, $slide_target);
    }

    if (empty($slide_images)) {
        $title = $xoopsConfig['sitename'];
        $content = isset($xoopsConfig['meta_description']) ? $xoopsConfig['meta_description'] : '';

        $ResponsiveSlides->add_content(1, $title, $content, XOOPS_URL . "/themes/{$xoopsConfig['theme_set']}/images/slide/default.png", '', XOOPS_URL);
        $ResponsiveSlides->add_content(2, $title, $content, XOOPS_URL . "/themes/{$xoopsConfig['theme_set']}/images/slide/default2.png", '', XOOPS_URL);
        $ResponsiveSlides->add_content(3, $title, $content, XOOPS_URL . "/themes/{$xoopsConfig['theme_set']}/images/slide/default3.png", '', XOOPS_URL);
    }

    $sql = 'SELECT a.`value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` AS a LEFT JOIN `' . $xoopsDB->prefix('tad_themes') . '` AS b ON a.`theme_id`=b.`theme_id` WHERE a.`name`=? AND b.`theme_name`=?';
    $result = Utility::query($sql, 'ss', ['slide_timeout', $xoopsConfig['theme_set']]) or Utility::web_error($sql, __FILE__, __LINE__);

    $slide_timeout = $xoopsDB->fetchRow($result)[0] ?? null;

    $sql = 'SELECT a.`value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` AS a LEFT JOIN `' . $xoopsDB->prefix('tad_themes') . '` AS b ON a.`theme_id`=b.`theme_id` WHERE a.`name`=? AND b.`theme_name`=?';
    $result = Utility::query($sql, 'ss', ['slide_nav', $xoopsConfig['theme_set']]);

    $slide_nav = $xoopsDB->fetchRow($result)[0] ?? null;

    $block .= $ResponsiveSlides->render('tad_themes_ResponsiveSlides', null, $slide_timeout, $slide_nav);

    return $block;
}
