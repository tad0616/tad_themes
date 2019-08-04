<?php
use XoopsModules\Tadtools\ResponsiveSlides;

if (!class_exists('XoopsModules\Tadtools\ResponsiveSlides')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式
function tad_themes_responsive_slider($options)
{
    global $xoopsDB, $xoopsConfig;

    $sql = 'select * from ' . $xoopsDB->prefix('tad_themes') . " where `theme_name`='{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql);
    $data = $xoopsDB->fetchArray($result);
    if (empty($data)) {
        return;
    }

    foreach ($data as $k => $v) {
        $$k = $v;
    }
    if ($slide_width > 0) {
        return;
    }

    $block = '';

    if (!empty($logo_img)) {
        if ('page' === $logo_position) {
            $block = '';
        } else {
            $logo_place = '';
            if (!empty($logo_top)) {
                $logo_place .= "top:{$logo_top}px;";
            }

            if (!empty($logo_bottom)) {
                $logo_place .= "bottom:{$logo_bottom}px;";
            }

            if ('1' == $logo_center) {
                $logo_place .= 'margin-left: auto; margin-right: auto; left: 0; right: 0;';
            } else {
                if (!empty($logo_right)) {
                    $logo_place .= "right:{$logo_right}px;";
                }

                if (!empty($logo_left)) {
                    $logo_place .= "left:{$logo_left}px;";
                }
            }

            $block = "<a href='" . XOOPS_URL . "' alt='{$xoopsConfig['sitename']}' title='{$xoopsConfig['sitename']}'><img src='{$logo_img}' style='position:absolute;z-index:100;{$logo_place}'></a>";
        }
    }

    $ResponsiveSlides = new ResponsiveSlides(120, false);

    $sql = 'select a.*,b.slide_width,b.slide_height from ' . $xoopsDB->prefix('tad_themes_files_center') . ' as a left join ' . $xoopsDB->prefix('tad_themes') . " as b on a.col_sn=b.theme_id  where a.`col_name`='slide' and b.`theme_name`='{$xoopsConfig['theme_set']}'";

    $result = $xoopsDB->query($sql);

    $slide_images = 0;
    while (false !== ($data = $xoopsDB->fetchArray($result))) {
        foreach ($data as $k => $v) {
            $$k = $v;
            //$this->assign($k,$$k);
        }
        $slide_images++;

        if ($description) {
            // preg_match_all("/\](.*)\[/", $description, $matches);
            // $url         = isset($matches[1][0]) ? $matches[1][0] : XOOPS_URL;
            // $description = str_replace("[url]{$url}[/url]", "", $description);

            preg_match_all("/\](.*)\[/", $description, $matches);
            $url = $matches[1][0];
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

    $block .= $ResponsiveSlides->render('tad_themes_ResponsiveSlides');

    return $block;
}
