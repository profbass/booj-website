<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="@yield('page_keywords')">
        <meta name="description" content="@yield('page_description')">
        <meta name="robots" content="index,follow">
        <meta name="google-site-verification" content="phSnk9YeCZCEuzy9AaIECmpP06UO73xh6BRHwCd22wY">
        @yield('opengraph')
        <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/blog/rss">
        <link href='https://plus.google.com/107717391600262472445' rel="publisher" title='booj on Google+'>
        <link rel="canonical" href="http://www.booj.com/">
        <title>booj | web development &amp; technology blog @yield('page_title')</title>
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,300italic' rel='stylesheet' type='text/css'>
        <link href="/css/filters.<? if(!empty($build_version)) echo $build_version . '.';?>css" rel="stylesheet">
        <link href="/dist/style.min.<? if(!empty($build_version)) echo $build_version . '.';?>css" rel="stylesheet">
        {{ Asset::styles() }}
        @yield('styles')
    </head>
    <body class="blog-layout">
        <header id="blog-header">
            <div class="container">
                <div class="row-fluid">
                    <div class="span5 clearfix">
                        <a href="/" class="blog-flame pull-left"><img src="/img/booj-flame.png" alt="Booj Logo"></a>
                        <a href="/" class="blog-back-home pull-left"><i class="bicon-previous"></i> Back to booj</a>
                    </div>
                    <div class="span4 blog-header-social clearfix hidden-phone">
                        <a href="https://www.youtube.com/boojvideo" title="Booj YouTube Page" target="_blank"><i class="bicon-white-youtube">&nbsp;</i></a>
                        <a href="https://www.facebook.com/boojers" title="Booj Facebook Page" target="_blank"><i class="bicon-white-facebook">&nbsp;</i></a>
                        <a href="https://plus.google.com/107717391600262472445" title="Booj Google Plus Page" target="_blank"><i class="bicon-white-google-plus">&nbsp;</i></a>
                        <a href="http://www.twitter.com/boojers" title="Booj Twitter Page" target="_blank"><i class="bicon-white-twitter">&nbsp;</i></a>
                    </div>
                    <div class="span3 blog-header-search">
                        <?=Form::open('/blog/search', null, array('id' => 'blog-search')); ?>
                            <div class="input-append">
                                <input type="text" name="term" value="" placeholder="search blog here">
                                <button class="btn btn-white" type="submit"><i class="bicon-red-spy"></i></button>
                            </div>
                            <?=Form::token(); ?>
                        <?=Form::close(); ?>       
                    </div>
                </div>
            </div>
        </header>
        <div id="blog-logo" class="container"><a href="/blog" title="Booj Bytes Blog Home"><img src="/img/logo-booj-bytes.png" alt="Booj Bytes technology blog"></a></div> 
        <div id="blog-nav">
            <nav class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            Blog Menu
                        </button>
                        <div class="nav-collapse">
                            <ul class="nav">
                                @if (isset($categories))
                                    <? foreach($categories as $category): ?>
                                        <? if ($category->visible == 1): ?>
                                            <li<? if (!empty($current_category) && $current_category == $category->slug) echo ' class="active"'; ?>><a href="<?=$action_urls['category'];?>/<?=$category->slug;?>"><?=$category->title;?></a></li>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                @endif
                                <li class="visible-phone clearfix">
                                    <a href="https://www.youtube.com/boojvideo" title="Booj YouTube Page" target="_blank" style="float:left;"><i class="bicon-gray-youtube">&nbsp;</i></a>
                                    <a href="https://www.facebook.com/boojers" title="Booj Facebook Page" target="_blank" style="float:left;"><i class="bicon-gray-facebook">&nbsp;</i></a>
                                    <a href="https://plus.google.com/107717391600262472445" title="Booj Google Plus Page" target="_blank" style="float:left;"><i class="bicon-gray-google-plus">&nbsp;</i></a>
                                    <a href="http://www.twitter.com/boojers" title="Booj Twitter Page" target="_blank" style="float:left;"><i class="bicon-gray-twitter">&nbsp;</i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="content-container">
            <div class="container">
                @yield('content')
            </div>
        </div>

        @include('content::footers.footer')

        <span id="scroll-to-top" class="hidden"><i class="bicon-scroll-up"></i></span>
        
        <div id="fb-root"></div>

        <script src="/dist/app.min.<? if(!empty($build_version)) echo $build_version . '.';?>js"></script>
        {{ Asset::scripts() }}
        @yield('scripts')

        <!-- twitter follow code -->
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        
        <script>
            $(function() {
                var toTop = $('#scroll-to-top');
                var body = $('body');
                $(window).on('scroll', function() {
                    if (body.scrollTop() > 200) {
                        toTop.removeClass('hidden');
                    } else {                    
                        toTop.addClass('hidden');
                    }
                });
                if (body.scrollTop() > 200) {
                    toTop.removeClass('hidden');
                }
                toTop.on('click', function(e) {
                    $('html, body').animate({scrollTop: '0px'}, 500);
                });
            });
        </script>       

        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=219575128103821";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <!-- AddThis Button BEGIN -->
        <script async="async" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4db83ad024813ea2"></script>
        <!-- AddThis Button END -->

        <script>
            var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-244849-36']); _gaq.push(['_trackPageview']); (function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
        </script>
        
    </body>
</html>