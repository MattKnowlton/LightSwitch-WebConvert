<?php
require_once('util/startup.php');
checkLogin();

?>
<html>
<head>
    <?= INCLUDE_DEFAULT_JS; ?>
    <script>
            window.actions = [];
            var pageImages = [];
            var pageNum = 1;
            var getContent = '';

            function getActiveTabID(){
                tabID = '';
                $('#pageTabs li').each(function(){
                    if($(this).hasClass('active')){
                        tabID = $(this).children('a').attr('href');
                    }
                });
                tabID = tabID.replace('#','');
                return tabID;
            }

            function runEvent(e){
                console.log(e);

                tab = getActiveTabID();

                if(window.actions[tab] != undefined && window.actions[tab][e] != undefined){
                    window.actions[tab][e]();
                }
            }

            function prepTitle(str){
                str = str.replace('-', ' - ');
                str = str.replace(/_/g, ' ');
                str = str.replace(/\w\S*/g, function(txt){
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
                return str;
            }

            function prepFileName(str){
                str = str.split(" -")[0];
                str = str.split("-")[0];
                return str;
            }

            function addPage(file, title){

                if($('#tab_'+file).attr('id') != undefined) return $('#tab_' + file).tab('show');

                filename = prepFileName(file);
                $.get('pages/'+filename+'.php').done(function(data){
                    pageName = prepTitle(title);

                    $('#pageTabs').append(
                        $('<li><a id="tab_'+file+'" href="#' + file + '"><b>' +
                            pageName + '&nbsp;&nbsp;<button class="close" type="button" ' +
                            'title="Remove this page">×</button>' + '</b></a></li>'));


                    $('#tabPages').append($('<div class="tab-pane" id="' + file + '">' + data + '</div><div id="footer"></div>'));
                    $('#tab_' + file).tab('show');

                }).fail(function() {
                    // not exists code
                })
            }

            function changePage(file, file){

            }

            $(document).ready(function() {
                $('a').click(function(e){
                    e.preventDefault();

                    href = $(this).attr('href');
                    if(href == undefined || $(this).data('toggle') != undefined) return;

                    file = title = href;
                    if($(this).data('title')) title = $(this).data('title');

                    addPage(file, title);
                });

                $('#pageTabs').on('click', ' li a .close', function() {
                    var tabId = $(this).parents('li').children('a').attr('href');
                    if($(this).parents('li').hasClass('active')){
                        $('#pageTabs a:first').tab('show');
                    }
                    $(this).parents('li').remove('li');
                    $(tabId).remove();
                    //reNumberPages();
                });


                $("#pageTabs").on("click", "a", function(e) {
                    e.preventDefault();
                    $(this).tab('show');
                    console.log($(this).attr('href'));
                });
            });
    </script>

    <?= INCLUDE_DEFAULT_CSS; ?>
    <style>
        #header div{
            width:100%;
        }

        #iconBox {
            background-color: white;
        }

        #pages {
            padding:20px;
        }

        .navbar {
            min-height: 30px !important;
            margin-bottom:-1px !important;
            border-bottom: 0px !important;
        }

        .nav>li>a {
            padding: 10px 10px !important;
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .nav-tabs{
            background-color: #F8F8F8 !important;
        }

        .nav-tabs>li>a {
            background-color: #eee;
        }
        .nav-tabs>li :hover {
            border-color: #bebbbb #bebbbb #ffffff #bebbbb !important;
        }
        .nav-tabs>li.active>a {
            background-color: #CCE5E6 !important;
        }

        #footer {
            background: linear-gradient(to bottom, rgba(81,183,209,1) 0%,rgba(43,93,124,1) 50%,rgba(133,156,178,1) 100%);
            width:100%;
            position:fixed;
            bottom:0px;
            left:0px;
            height: 90px;
            padding: 0px;
            margin: 0px;
        }

        #pages {
            background-color: #CCE5E6;
            max-height:calc(100% - 206px);
            height:calc(100% - 206px);
            overflow: auto;
        }

        .icon {
            width:90px;
        }
        .icon a{
            text-decoration: none !important;
        }
        .icon:hover{
            background-color: rgba(255, 255, 255, 0.15);
            text-decoration: none !important;
        }

        .largeBttn{
            font-size: 12px;
            font-weight: bold;
            width: 165px;
            height:60px;
            color: #3A3A3A;
            border-radius: 5px;;
            box-shadow: 0px 0px 2px #000;
        }

        .blueBttn {
            border: solid 2px #C6FBFF;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgb(186, 249, 248)), color-stop(0.3, rgb(22, 231, 255)), to(rgb(34, 255, 253)));
        }
        .yellowBttn {
            border: solid 2px #FDF4A2;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgb(255, 245, 153)), color-stop(0.3, rgb(218, 197, 0)), to(#FFE500));
        }
        .orangeBttn {
            border: solid 2px #FFCF88;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgb(255, 201, 122)), color-stop(0.3, rgb(239, 143, 1)), to(#FFB100));
        }
        .purpleBttn {
            border: solid 2px #FF8FD7;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FB85D1), color-stop(0.3, #E041A8), to(#F749BA));
        }
        .greyBttn {
            border: solid 2px #D0D0D0;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#CECECE), color-stop(0.3, #9E9E9E), to(#BBBBBB));
        }
        .greenBttn {
            border: solid 2px #66E06B;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#6FC772), color-stop(0.3, #18A01E), to(#2DC332));
        }

        #msgList th {
            background-color: #3dace8;
        }
    </style>

    <link rel="stylesheet" href="scripts/bootstrap.min.css">
    <script src="scripts/bootstrap.min.js"></script>
</head>
<body>
    <div id="header">
        <div id="iconBox">
            <img src="images/logoText.png" style="width:300px;">
        </div>
        <div id="menu">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li><a href="home">Home</a></li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Incident Reports <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="incident_dashboard">Incident Dashboard</a></li>
                                <li><a href="incident_search">Search Incident Reports</a></li>
                                <li><a href="incident_report">Create Incident Report</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">Store Inspections <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">House Charges <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">Payroll <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">Calendar <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">Resources <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">Administration <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="">Help <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="coming_soon">Coming Soon!</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div id="tabs">
            <ul id="pageTabs" class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#Home" id="tab_home">
                        <b>Home </b>
                    </a>
                </li>
            </ul>
        </div>

    </div>



    <div id="pages">
        <div id="tabPages" class="tab-content">
            <div id="Home" class="tab-pane active">
                <?php include('pages/home.php'); ?>
            </div>
        </div>
    </div>


</body>
</html>
