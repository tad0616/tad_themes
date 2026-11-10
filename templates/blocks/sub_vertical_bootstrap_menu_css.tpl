<style>
    ul.vertical_bootstrap_menu {
        position:relative;
        background:#fff;
        width:100%;
        margin:auto;
        padding:0;
        list-style: none;
        overflow:hidden;
        border-radius: 5px;
        box-shadow:  1px 1px 10px rgba(0, 0, 0, 0.1);
    }

    /* 對比 #333 / #fff = 12.6:1，符合 AAA 7:1；不固定高度，文字放大或調整間距時不會被裁切 */
    .vertical_bootstrap_menu li a {
        box-sizing:border-box;
        width:100%;
        min-height:44px;
        padding:0.5rem 0.75rem 0.5rem 20px;
        display:flex;
        align-items:center;
        position:relative;
        text-decoration:none;
        font-size: 1rem;
        line-height:1.5;
        color:#333;
        overflow-wrap:anywhere;
        transition:background-color 0.2s linear;
    }

    .vertical_bootstrap_menu li a:hover,
    .vertical_bootstrap_menu li a:focus {
        background:#efefef;
        color:#1a1a1a;
        text-decoration:underline;
    }

    /* 明顯的鍵盤焦點框（內縮，避免被 ul 的 overflow 裁切） */
    .vertical_bootstrap_menu li a:focus-visible {
        outline:3px solid #0b4f9c;
        outline-offset:-3px;
    }

    .vertical_bootstrap_menu li:first-child a {
        border-radius: 5px 5px 0 0;
    }

    .vertical_bootstrap_menu li:last-child a {
        border-radius: 0 0 5px 5px;
    }

    .vertical_bootstrap_menu li a:hover i,
    .vertical_bootstrap_menu li a:focus i {
        color:#a01c16;
    }

    .vertical_bootstrap_menu i {
        flex:0 0 auto;
        margin-right:15px;
        transition:color 0.2s linear;
    }

    /* 徽章：#fff / #a01c16 對比 > 7:1，不固定高度 */
    .vertical_bootstrap_menu em {
        font-size: 0.75em;
        background: #a01c16;
        padding: 0.15em 0.5em;
        border-radius: 10px;
        font-style: normal;
        color: #fff;
        margin-left:auto;
        margin-right: 15px;
        line-height: 1.5;
    }

    .vertical_bootstrap_menu li.selected a {
        background:#efefef;
    }

    /* 僅供螢幕報讀器讀取的文字（佈景若未載入 Bootstrap 5 時的備援） */
    .vertical_bootstrap_menu .visually-hidden {
        position:absolute !important;
        width:1px !important;
        height:1px !important;
        padding:0 !important;
        margin:-1px !important;
        overflow:hidden !important;
        clip:rect(0, 0, 0, 0) !important;
        white-space:nowrap !important;
        border:0 !important;
    }

    /* 使用者要求減少動態效果時取消轉場 */
    @media (prefers-reduced-motion: reduce) {
        .vertical_bootstrap_menu li a,
        .vertical_bootstrap_menu i {
            transition:none;
        }
    }

    /* Windows 高對比模式下保留焦點框 */
    @media (forced-colors: active) {
        .vertical_bootstrap_menu li a:focus-visible {
            outline:3px solid CanvasText;
        }
    }
</style>
