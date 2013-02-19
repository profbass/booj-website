<?='<?xml version="1.0" encoding="utf-8"?>';?>
<rss version="2.0">
	<channel>
		<title>Booj Bytes</title>
		<link>http://www.booj.com/</link>
		<description>RSS 2.0 Blog Feed</description>
		<lastBuildDate><?=date('D, j M Y G:H:s e', time());?></lastBuildDate>
		<language>en-us</language>
	<? if (!empty($posts->results)): ?>
	<? foreach ($posts->results as $post): ?>
		<item>
			<title><?=$post->title;?></title>
			<link>http://booj.com<?=$action_urls['blog'];?>/<?=$post->slug;?></link>
			<guid>http://booj.com<?=$action_urls['blog'];?>/<?=$post->slug;?></guid>
			<pubDate><?=date('D, j M Y G:H:s e', strtotime($post->created_at));?></pubDate>
			<description>[CDATA[ <?=$post->truncated_content();?> ]]</description>
		</item>
	<? endforeach; ?>
	<? endif; ?>
	</channel>
</rss>