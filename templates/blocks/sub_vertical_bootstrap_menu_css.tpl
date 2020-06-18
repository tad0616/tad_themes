<style>
    ul.vertical_bootstrap_menu {
        position:relative;
        background:#fff;
        width:100%;
        margin:auto;
        padding:0;
        list-style: none;
        overflow:hidden;

        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;

        -webkit-box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
        box-shadow:  1px 1px 10px rgba(0, 0, 0, 0.1);
    }

    .vertical_bootstrap_menu li a {
        width:96%;
        padding-left:20px;
        height:40px;
        line-height:40px;
        display:block;
        overflow:hidden;
        position:relative;
        text-decoration:none;
        text-transform:uppercase;
        font-size:14px;
        color:#686868;

        -webkit-transition:all 0.2s linear;
        -moz-transition:all 0.2s linear;
        -o-transition:all 0.2s linear;
        transition:all 0.2s linear;
    }

    .vertical_bootstrap_menu li a:hover {
        background:#efefef;
    }


    .vertical_bootstrap_menu li:first-child a:hover, .vertical_bootstrap_menu li:first-child a {
        -webkit-border-radius: 5px 5px 0 0;
        -moz-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
    }

    .vertical_bootstrap_menu li:last-child a:hover, .vertical_bootstrap_menu li:last-child a {
        -webkit-border-radius: 0 0 5px 5px;
        -moz-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
    }

    .vertical_bootstrap_menu li a:hover i {
        color:#ea4f35;
    }

    .vertical_bootstrap_menu i {
        margin-right:15px;

        -webkit-transition:all 0.2s linear;
        -moz-transition:all 0.2s linear;
        -o-transition:all 0.2s linear;
        transition:all 0.2s linear;
    }

    .vertical_bootstrap_menu em {
        font-size: 0.625em;
        background: #ea4f35;
        padding: 3px 5px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        font-style: normal;
        color: #fff;
        margin-top: 17px;
        margin-right: 15px;
        line-height: 10px;
        height: 10px;
        float:right;
    }

    .vertical_bootstrap_menu li.selected a {
        background:#efefef;
    }
</style>