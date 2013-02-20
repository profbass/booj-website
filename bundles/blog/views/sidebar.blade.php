
<div class="fb-like-box" data-href="https://www.facebook.com/ActiveWebsite" data-width="292" data-border_color="#f0f1f1" data-show-faces="true" data-stream="false" data-header="false"></div>

<a class="btn btn-block btn-large btn-primary margin-bottom-30 lower" target="_blank" href="<?=$action_urls['twitter'];?>boojers" title="follow @boojers"><i class="bicon-twitter"></i> follow @boojers</a>

<a class="btn btn-block btn-large btn-primary lower" href="http://feeds.feedburner.com/Booj" target="_blank" title="Subscribe by email">Subscribe by Email</a>

<hr>

@if (!empty($popular))
	
	<div id="blog-sidebar-top-posts">
		<h3 class="font-30 margin-0">Top Posts</h3>
		<ul class="unstyled">
			<? $iter = 0; ?>
			<? foreach ($popular as $post): ?>
				<li>
					<? if ($iter == 0): ?>
						<img src="<?=$post->small_photo;?>" alt="">
					<? endif; ?>
					<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>"><?=$post->title;?></a>
				</li>
				<? $iter++; ?>
			<? endforeach; ?>
		</ul>
	</div>

@endif

@if (!empty($popular_authors))

	<hr>
	<div id="blog-sidebar-contributors">
		<h3 class="font-30 margin-0">Contributors</h3>
		<ul class="unstyled">
			<? foreach($popular_authors as $author): ?>
				<li class="clearfix">
					<? if (!empty($author->avatar_small)): ?>
						<a class="font-16" href="<?=$action_urls['author'];?>/<?=$author->username; ?>" title="View profile for <?=$author->first_name; ?> <?=$author->last_name; ?>">
							<img class="pull-left" src="<?=$author->avatar_small;?>" alt="Photo of <?=$author->first_name; ?> <?=$author->last_name; ?>">
						</a>
					<? endif; ?>
					<a class="font-16" href="<?=$action_urls['author'];?>/<?=$author->username; ?>" title="View profile for <?=$author->first_name; ?> <?=$author->last_name; ?>"><?=$author->first_name; ?> <?=$author->last_name; ?></a>
					<? if (!empty($author->title)): ?>
						<span class="block author-title font-12"><?=$author->title; ?></span>
					<? endif; ?>
					<? if (!empty($author->twitter_handle)): ?>
						<a href="<?=$action_urls['twitter'];?><?=$author->twitter_handle;?>" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @<?=$author->twitter_handle;?></a>
					<? endif; ?>
				</li>
			<? endforeach; ?>
		</ul>
		<a class="btn margin-top-15 btn-block btn-large btn-primary lower" href="<?=$action_urls['author'];?>" title="View all our contributors">View all our contributors</a>
	</div> 

@endif

<hr>
<a class="block margin-bottom-30 full-shadow" href="http://www.boojers.com" target="_blank"><img src="/img/meet-boojers.gif" alt="Meet the Boojers"></a>
<a class="block full-shadow" href="/careers/"><img src="/img/were-hiring.jpg" alt="we're hiring"></a>