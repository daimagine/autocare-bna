<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Autocare BNA :: {{ (isset($title) ? $title : 'Garage Integrated System') }}</title>
    <!--[if IE]> <link href="css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
    {{ Asset::styles() }}
</head>
<body>
    <!-- Top line begins -->
    <div id="top">
        <div class="wrapper">
            <a href="index.html" title="" class="logo"><img src="" alt="" /></a>

            <!-- Right top nav -->
            <div class="topNav">
                <ul class="userNav">
                    <li>{{ HTML::link('logout', '', array('class' => 'logout')) }}</li>
                    <li class="showTabletP"><a href="#" title="" class="sidebar"></a></li>
                </ul>
            </div>

            <!-- Responsive nav -->
            <ul class="altMenu">
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <!-- Top line ends -->


    <!-- Sidebar begins -->
    <div id="sidebar">
        <div class="mainNav">
            <div class="user">
                <a title="" class="leftUserDrop"><img src="" alt="" /><span><strong>3</strong></span></a><span>Eugene</span>
                <ul class="leftUser">
                </ul>
            </div>

            <!-- Responsive nav -->
            <div class="altNav">
                <div class="userSearch">
                    <!-- -->
                </div>

                <!-- User nav -->
                <ul class="userNav">
                    <!-- -->
                </ul>
            </div>

            <!-- Putn Main nav here-->
            <ul class="nav">
                @section('navigation')
                    {{ HTML::main_nav() }}
                @yield_section
            </ul>

        </div>

        <!-- Secondary nav -->
        <div class="secNav">
            <div class="secWrapper">
                <div class="secTop">
                    <div class="balance">
                        <div class="balInfo">Date:<span>Apr 21 2012</span></div>
                    </div>
                    <a href="#" class="triangle-red"></a>
                </div>

                <!-- Tabs container -->
                <div id="tab-container" class="tab-container">
                    <ul class="iconsLine ic3 etabs">
                        <li><a href="#general" title=""><span class="icos-fullscreen"></span></a></li>
                        <li><a href="#alt1" title=""><span class="icos-user"></span></a></li>
                        <li><a href="#alt2" title=""><span class="icos-archive"></span></a></li>
                    </ul>

                    <!-- Putn Sub nav here-->
                    <div class="divider"><span></span></div>

                    <div id="general" style="display: block; " class="active">
                        @section('subnav')
                            {{ HTML::sub_nav() }}
                        @yield_section
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!-- Sidebar ends -->


    <!-- Content begins -->
    <div id="content">
        <div class="contentTop">
            <span class="pageTitle"><span class="icon-screen"></span>Dashboard</span>

            <div class="clear"></div>
        </div>

        <!-- Breadcrumbs line -->
        <div class="breadLine">
            <div class="bc">
                <ul id="breadcrumbs" class="breadcrumbs">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Home</a> </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="wrapper">
            @yield('content')
        </div>
        <!-- Main content ends -->

    </div>
    <!-- Content ends -->

    <!-- javascript library -->
    {{ Asset::scripts() }}
</body>