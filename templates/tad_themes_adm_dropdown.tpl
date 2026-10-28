<style>
    li{list-style:none;}
    .tt-wrap{max-width:1100px;}
    .tt-toolbar{display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin:0 0 14px;padding:10px 14px;background:#f6f8fa;border:1px solid #dde3ea;border-radius:8px;}
    .tt-toolbar form{margin:0;display:inline-block;}
    .tt-toolbar .tt-spacer{flex:1 1 auto;}
    .tt-savebar{display:none;align-items:center;gap:10px;margin:0 0 12px;padding:10px 14px;background:#fff8e1;border:1px solid #f0d98a;border-radius:8px;}
    .tt-savebar.show{display:flex;}
    .tt-savebar .tt-msg{flex:1 1 auto;color:#7a5b00;}
    .tt-tree{border:1px solid #dde3ea;border-radius:8px;background:#fff;padding:6px;}
    .tt-list{margin:0;padding:0;min-height:8px;}
    .tt-list .tt-list{margin-left:34px;border-left:2px solid #e6ebf0;padding-left:6px;}
    .tt-item{margin:0;}
    .tt-row{display:flex;align-items:center;gap:10px;padding:7px 10px;margin:3px 0;border:1px solid #eef1f4;border-radius:6px;background:#fff;}
    .tt-row:hover{background:#f8fbff;border-color:#cfe0f1;}
    .tt-item.tt-disabled > .tt-row{background:#f3f3f3;color:#8a8a8a;}
    .tt-item.tt-disabled > .tt-row .tt-name{text-decoration:line-through;}
    .tt-col-name{flex:1 1 auto;min-width:0;display:flex;align-items:center;gap:8px;}
    .tt-col-status{flex:0 0 auto;white-space:nowrap;}
    .tt-col-action{flex:0 0 auto;}
    .tt-actions{display:inline-flex;gap:4px;align-items:center;flex-wrap:nowrap;}
    .tt-handle{cursor:grab;color:#7b8a99;padding:2px 4px;}
    .tt-handle:active{cursor:grabbing;}
    .tt-toggle{cursor:pointer;color:#7b8a99;width:14px;text-align:center;visibility:hidden;}
    .tt-item.has-children > .tt-row .tt-toggle{visibility:visible;}
    .tt-item.collapsed > .tt-list{display:none;}
    .tt-item.collapsed > .tt-row .tt-toggle i{transform:rotate(-90deg);}
    .tt-link{margin-left:6px;font-size:.8em;color:#8aa;}
    .tt-badge{display:inline-block;padding:1px 8px;border-radius:10px;font-size:.75rem;line-height:1.6;color:#fff;vertical-align:middle;}
    .tt-badge-success{background:#2e9e5b;}
    .tt-badge-info{background:#2f8fc7;}
    .tt-badge-muted{background:#9aa5b1;}
    .tt-thumb{position:relative;display:inline-block;margin-left:8px;vertical-align:middle;}
    .tt-thumb img{max-height:32px;max-width:90px;border:1px solid #dde3ea;border-radius:4px;background:#fff;padding:1px;}
    .tt-thumb-del{position:absolute;top:-7px;right:-7px;width:16px;height:16px;line-height:14px;padding:0;border:0;border-radius:50%;background:#d9534f;color:#fff;font-size:12px;cursor:pointer;opacity:.85;}
    .tt-thumb-del:hover{opacity:1;}
    .tt-ghost > .tt-row{background:#e3f1fb;border:1px dashed #2f8fc7;}
    .tt-dragging .tt-list{min-height:26px;outline:1px dashed #c5d3e0;outline-offset:-1px;}
    .tt-add-root{padding:8px 10px;}
    #menu_action_form,#tree_form{display:none;}
</style>

<div class="tt-wrap">
    <div class="tt-toolbar">
        <form action="dropdown.php" method="post">
            <input type="hidden" name="op" value="import">
            <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$xoops_token_value}>">
            <button type="submit" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> <{$smarty.const._MA_TADTHEMES_IMPORT_MENU}></button>
        </form>
        <form action="dropdown.php" method="post">
            <input type="hidden" name="op" value="import_edit">
            <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$xoops_token_value}>">
            <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <{$smarty.const._MA_TADTHEMES_IMPORT_EDIT_MENU}></button>
        </form>
        <span class="tt-spacer"></span>
        <button type="button" id="tt_expand" class="btn btn-success"><i class="fa fa-expand" aria-hidden="true"></i> <{$smarty.const._MA_TADTHEMES_EXPAND_ALL}></button>
        <button type="button" id="tt_collapse" class="btn btn-warning"><i class="fa fa-compress" aria-hidden="true"></i> <{$smarty.const._MA_TADTHEMES_COLLAPSE_ALL}></button>
    </div>

    <div class="tt-savebar" id="tt_savebar">
        <span class="tt-msg"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <{$smarty.const._MA_TADTHEMES_SORT_CHANGED}></span>
        <button type="button" id="tt_save" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> <{$smarty.const._TAD_SAVE}></button>
        <button type="button" id="tt_cancel" class="btn btn-default btn-secondary"><{$smarty.const._TAD_CANCEL}></button>
    </div>

    <div class="tt-tree" id="tt_tree">
        <div class="tt-add-root">
            <a href="dropdown.php?op=add_tad_themes_menu&of_level=0" class="edit_dropdown" data-fancybox-type="iframe" style="font-size:1.1rem;text-decoration:none;">
                <i class="fa fa-plus-circle text-success" aria-hidden="true" style="font-size:1.5rem;margin:0 8px;vertical-align:middle;"></i><{$add_item|default:''}>
            </a>
        </div>
        <div id="tt_root"><{$all|default:''}></div>
    </div>
</div>

<form id="menu_action_form" action="dropdown.php" method="post">
    <input type="hidden" name="op" value="">
    <input type="hidden" name="menuid" value="">
    <input type="hidden" name="type" value="">
    <input type="hidden" name="status" value="">
    <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$xoops_token_value}>">
</form>

<form id="tree_form" action="dropdown.php" method="post">
    <input type="hidden" name="op" value="save_tree">
    <input type="hidden" name="tree" value="">
    <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$xoops_token_value}>">
</form>

<script type="text/javascript">
    $(document).ready(function() {
        var MAX_DEPTH = 3;
        var confirmOptions = <{$delete_confirm_options|default:'{}'}>;
        var $root = $('#tt_root');
        var dirty = false;

        // 所有會異動資料的操作都以 POST 表單送出（含 Token），不使用 GET 連結
        $(document).on('click', '.menu-action', function(e) {
            e.preventDefault();
            if (dirty && !window.confirm('<{$smarty.const._MA_TADTHEMES_SORT_LEAVE|escape:'javascript'}>')) {
                return;
            }
            dirty = false;
            var btn = $(this);
            var submitAction = function() {
                var f = $('#menu_action_form');
                f.find('[name=op]').val(btn.data('op'));
                f.find('[name=menuid]').val(btn.data('menuid'));
                f.find('[name=type]').val(btn.data('type') || '');
                f.find('[name=status]').val(btn.data('status') === undefined ? '' : btn.data('status'));
                f.trigger('submit');
            };

            if (btn.data('confirm') || btn.data('op') === 'del_pic') {
                var opt = $.extend({}, confirmOptions);
                if (btn.data('name')) {
                    opt.text = '「' + btn.data('name') + '」 ' + (opt.text || '');
                }
                Swal.fire(opt).then(function(result) {
                    if (result.isConfirmed) {
                        submitAction();
                    }
                });
            } else {
                submitAction();
            }
        });

        function refreshFlags() {
            $root.find('.tt-item').each(function() {
                $(this).toggleClass('has-children', $(this).children('.tt-list').children('.tt-item').length > 0);
            });
        }

        function subtreeHeight(li) {
            var m = 0;
            $(li).children('.tt-list').children('.tt-item').each(function() {
                m = Math.max(m, subtreeHeight(this));
            });
            return m + 1;
        }

        function toTree(ul) {
            return $(ul).children('.tt-item').map(function() {
                return {id: parseInt($(this).data('id'), 10), children: toTree($(this).children('.tt-list'))};
            }).get();
        }

        function setDirty(state) {
            dirty = state;
            $('#tt_savebar').toggleClass('show', state);
        }

        function makeSortable(el) {
            new Sortable(el, {
                group: 'menu',
                handle: '.tt-handle',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                ghostClass: 'tt-ghost',
                onStart: function() { $('#tt_tree').addClass('tt-dragging'); },
                onEnd: function() { $('#tt_tree').removeClass('tt-dragging'); },
                onMove: function(evt) {
                    // 目標清單所在層級 + 被拖曳項目的子樹高度，不可超過最大層數
                    var level = $(evt.to).parents('.tt-list').length;
                    return level + subtreeHeight(evt.dragged) <= MAX_DEPTH;
                },
                onSort: function() {
                    refreshFlags();
                    setDirty(true);
                }
            });
        }

        $root.find('.tt-list').each(function() { makeSortable(this); });
        refreshFlags();

        $root.on('click', '.tt-toggle', function() {
            $(this).closest('.tt-item').toggleClass('collapsed');
        });
        $('#tt_expand').on('click', function() { $root.find('.tt-item').removeClass('collapsed'); });
        $('#tt_collapse').on('click', function() { $root.find('.tt-item.has-children').addClass('collapsed'); });

        $('#tt_save').on('click', function() {
            var tree = toTree($root.children('.tt-list'));
            $('#tree_form [name=tree]').val(JSON.stringify(tree));
            dirty = false;
            $('#tree_form').trigger('submit');
        });

        $('#tt_cancel').on('click', function() {
            window.location.reload();
        });

        $(window).on('beforeunload', function(e) {
            if (dirty) {
                e.preventDefault();
                return '';
            }
        });
    });
</script>
