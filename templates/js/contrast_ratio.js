/**
 * 計算兩個顏色之間的對比度，並顯示在指定元素中
 * @param {string} textColorId - 文字顏色輸入框的ID (可選，預設為 'navbar_color')
 * @param {string} displayElementId - 用於顯示對比度的元素ID
 */
function ContrastRatio( textColorId, displayElementId) {
    // 將十六進制顏色轉換為RGB
    function hexToRgb(hex) {
        // 處理空值
        if (!hex) return null;

        // 確保有 # 前綴
        if (hex.charAt(0) !== '#') {
            hex = '#' + hex;
        }

        // 擴展簡寫形式 (#RGB) 到完整形式 (#RRGGBB)
        const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    // 計算相對亮度
    function getLuminance(color) {
        const rgb = hexToRgb(color);
        if (!rgb) return 0;

        // 將RGB值轉換為相對亮度
        let r = rgb.r / 255;
        let g = rgb.g / 255;
        let b = rgb.b / 255;

        r = r <= 0.03928 ? r / 12.92 : Math.pow((r + 0.055) / 1.055, 2.4);
        g = g <= 0.03928 ? g / 12.92 : Math.pow((g + 0.055) / 1.055, 2.4);
        b = b <= 0.03928 ? b / 12.92 : Math.pow((b + 0.055) / 1.055, 2.4);

        // 計算相對亮度
        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    }

    // 獲取顏色值 - 自動從觸發事件的元素獲取背景色
    const bgColor = $(document.activeElement).val() || $('#navbar_bg_top').val() || '#ffffff';
    const textColor = $('#' + textColorId).val() || '#000000';
    const $displayElement = $('#' + displayElementId);

    if (bgColor && textColor) {
        // 計算對比度
        const bgLuminance = getLuminance(bgColor);
        const textLuminance = getLuminance(textColor);

        const ratio = (Math.max(bgLuminance, textLuminance) + 0.05) /
                     (Math.min(bgLuminance, textLuminance) + 0.05);

        // 設置對比度顯示
        const ratioText = ratio.toFixed(2) + ':1';
        $displayElement.text(ratioText);

        // 根據對比度值設置顏色
        if (parseFloat(ratio) < 4.5) {
            $displayElement.css('color', 'red');
        } else {
            $displayElement.css('color', 'blue');
        }
    }
}

// 當文檔載入完成後設置事件監聽器
$(document).ready(function() {
    // 監聽顏色變化事件，自動更新對比度
    $('.color-picker').on('change input keyup paste colorpickerChange colorpickerCreate colorpickerUpdate', function() {
        // 對於任何顏色選擇器的變化，都更新對比度
        if ($('#navbar_color_contrast').length) {
            ContrastRatio('navbar_color_contrast');
        }

        // 可以根據需要添加更多的條件
        if ($('#contrast-ratio').length) {
            ContrastRatio('contrast-ratio');
        }
    });

    // 初始化時計算一次
    if ($('#navbar_color_contrast').length) {
        ContrastRatio('navbar_color_contrast');
    }

    if ($('#contrast-ratio').length) {
        ContrastRatio('contrast-ratio');
    }
});