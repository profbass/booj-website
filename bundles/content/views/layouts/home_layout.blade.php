<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="@yield('page_keywords')">
        <meta name="description" content="@yield('page_description')">
        <meta name="robots" content="index,follow">
        <meta name="google-site-verification" content="phSnk9YeCZCEuzy9AaIECmpP06UO73xh6BRHwCd22wY">
        <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/blog/rss">
        <link href='https://plus.google.com/107717391600262472445' rel="publisher" title='booj on Google+'>
        <link rel="canonical" href="http://www.booj.com/">
        <title>booj @yield('page_title')</title>
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,300italic' rel='stylesheet' type='text/css'>
        <link href="/css/filters.<? if(!empty($build_version)) echo $build_version . '.';?>css" rel="stylesheet">
        <link href="/dist/style.min.<? if(!empty($build_version)) echo $build_version . '.';?>css" rel="stylesheet">
        
        {{ Asset::styles() }}
        @yield('styles')
    </head>
    <body class="scrolling-homepage-layout">
        <div class="content-container">
            @yield('content')
        </div>

        @include('content::footers.footer')

        <header class="site-header" id="scrolling-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="span8">
                        <div class="navbar">
                            <div class="navbar-inner clearfix">
                                <a href="/" class="brand"><img src="/img/booj-flame.png" alt="Booj Logo"></a>
                                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                    Main Menu
                                </button>
                                <div class="nav-collapse">
                                    <ul class="nav" id="js-menu">
                                        @if (isset($menu_items))
                                            @foreach ($menu_items as $menu_item)
                                                <li class="<? if ( $current_uri == $menu_item->uri || ($parent_menu_item == $menu_item->uri)) { echo 'active'; } if (!empty($menu_item->children)) { echo 'dropdown'; }?>">
                                                    @if (in_array($menu_item->uri, array('/about', '/teams', '/clients', '/events')))
                                                        <a class="click-to-section" data-target="#<?=str_replace('/', '', $menu_item->uri);?>-section" href="#<?=str_replace('/', '', $menu_item->uri);?>-section" title="{{ $menu_item->pretty_name }}"><span>{{ $menu_item->pretty_name }}@if (!empty($menu_item->children)) <b class="caret"></b>@endif</span></a>
                                                    @elseif (in_array($menu_item->uri, array('/')))
                                                        <a class="click-to-section" data-target="#home-section" href="#home-section" title="{{ $menu_item->pretty_name }}"><span>{{ $menu_item->pretty_name }}@if (!empty($menu_item->children)) <b class="caret"></b>@endif</span></a>
                                                    @elseif ($menu_item->controller == 'link')
                                                        <a href="{{ $menu_item->uri }}" target="_blank" rel="nofollow" title="{{ $menu_item->pretty_name }}"><span>{{ $menu_item->pretty_name }}@if (!empty($menu_item->children)) <b class="caret"></b>@endif</span></a>
                                                    @else
                                                        <a href="{{ $menu_item->uri }}" title="{{ $menu_item->pretty_name }}"><span>{{ $menu_item->pretty_name }}@if (!empty($menu_item->children)) <b class="caret"></b>@endif</span></a>
                                                    @endif
                                                    @if (isset($menu_item->children) && count($menu_item->children) > 0)
                                                        <ul class="dropdown-menu">
                                                            @foreach ($menu_item->children as $menu_item_child)
                                                                <li<?php if($current_uri == $menu_item_child->uri) echo ' class="active"';?>>
                                                                    @if ($menu_item_child->controller == 'link')
                                                                        <a href="{{ $menu_item_child->uri }}" title="{{ $menu_item_child->pretty_name }}" target="_blank" rel="nofollow">{{ $menu_item_child->pretty_name }}</a>
                                                                    @else
                                                                        <a href="{{ $menu_item_child->uri }}" title="{{ $menu_item_child->pretty_name }}">{{ $menu_item_child->pretty_name }}</a>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                        <li class="hidden-desktop"><a href="/contact" title="Contact us"><span>Contact Us</span></a></li>
                                        <li class="hidden-desktop clearfix">
                                            <a href="https://www.youtube.com/boojvideo" title="Booj YouTube Page" target="_blank" style="float:left;"><i class="bicon-white-youtube">&nbsp;</i></a>
                                            <a href="https://www.facebook.com/boojers" title="Booj Facebook Page" target="_blank" style="float:left;"><i class="bicon-white-facebook">&nbsp;</i></a>
                                            <a href="https://plus.google.com/107717391600262472445" title="Booj Google Plus Page" target="_blank" style="float:left;"><i class="bicon-white-google-plus">&nbsp;</i></a>
                                            <a href="http://www.twitter.com/boojers" title="Booj Twitter Page" target="_blank" style="float:left;"><i class="bicon-white-twitter">&nbsp;</i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span2 header-social-networks visible-desktop">
                        <a href="https://www.youtube.com/boojvideo" title="Booj YouTube Page" target="_blank"><i class="bicon-white-youtube">&nbsp;</i></a>
                        <a href="https://www.facebook.com/boojers" title="Booj Facebook Page" target="_blank"><i class="bicon-white-facebook">&nbsp;</i></a>
                        <a href="https://plus.google.com/107717391600262472445" title="Booj Google Plus Page" target="_blank"><i class="bicon-white-google-plus">&nbsp;</i></a>
                        <a href="http://www.twitter.com/boojers" title="Booj Twitter Page" target="_blank"><i class="bicon-white-twitter">&nbsp;</i></a>
                    </div>
                    <div class="span2 header-contact visible-desktop">
                        <a href="/contact" title="Contact us">Contact Us</a>     
                    </div>
                </div>
            </div>
        </header>

        <script src="/dist/app.min.<? if(!empty($build_version)) echo $build_version . '.';?>js"></script>
       
        {{ Asset::scripts() }}
        
        @yield('scripts')

        <script>
            var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-244849-36']); _gaq.push(['_trackPageview']); (function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
        </script>
        
        <div id="ipadNavHack" style="height:0;"></div>
    </body>
</html>