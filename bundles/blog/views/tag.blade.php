@layout('blog::layouts.layout')

@section('page_title')
 ~ <? if (!empty($data['tag'])) echo $data['tag']->title . ' Tag'; else echo 'Tags'; ?>
@endsection

@section('page_description')
@if (!empty($page_data->meta_description))
{{ $page_data->meta_description }}
@endif
@endsection

@section('page_keywords')
@if (!empty($page_data->meta_keyword))
{{ $page_data->meta_keyword }}
@endif
@endsection

@section('content')
<div class="row-fluid">
	<div class="span9">
		<div class="title-bar margin-bottom-30">
			<h1>
				@if (!empty($data['tag']))
					<?=$data['tag']->title; ?>
				@else
					Tags
				@endif
			</h1>
		</div>
		@if (!empty($data))
			<? if (!empty($data['posts']->results)): ?>
				<div class="row-fluid">
					<? $iter = 0; $max = count($data['posts']->results) - 1; ?>
					<? foreach ($data['posts']->results as $post): ?>
						<div class="span6 post-landing shadow-box white-box">
							<div class="post-landing-photo">
								<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><img src="<?=$post->small_photo;?>" alt="<?=$post->short_title;?>"></a>
								<? if (!empty($post->category)): ?>
									<a class="category-button" href="<?=$action_urls['category'];?>/<?=$post->category->slug;?>" title="<?=$post->category->title;?>"><?=$post->category->title;?></a>
								<? endif; ?>
							</div>
							<div class="post-landing-outer">
								<div class="post-landing-inner">
									<h2 class="font-18">
										<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><?=$post->short_title;?></a>
									</h2>
									<p class="post-landing-author">
										<?=date('F jS, Y', strtotime($post->created_at));?>
										<? if (!empty($post->user)): ?>
											 // by <a href="<?=$action_urls['author'];?>/<?=$post->user->username;?>" title="View profile for <?=$post->user->first_name;?> <?=$post->user->last_name;?>">+<?=$post->user->first_name;?> <?=$post->user->last_name;?></a>
										<? endif; ?>
									</p>
									<p class="post-landing-content"><?=$post->truncated_content();?></p>
									<div class="addthis_toolbox addthis_default_style" addthis:url="<?=$action_urls['domain'];?><?=$action_urls['blog'];?>/<?=$post->slug;?>" addthis:title="<?=$post->title;?>">
										<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
										<!-- <a class="addthis_button_linkedin_counter"></a>  -->
										<a class="addthis_button_google_plusone" g:plusone:size="medium"></a> 
										<a class="addthis_button_tweet"></a>
									</div>
								</div>
							</div>
						</div>
						<? if ($iter % 2 == 1 && $iter < $max): ?>
							</div><div class="row-fluid">
						<? endif; ?>
						<? $iter++; ?>
					<? endforeach; ?>
				</div>
				<? if ($data['posts']->total > $data['posts']->per_page): ?>
					<hr>
					<?=$data['posts']->links(); ?>
				<? endif; ?>
			<? else: ?>
				<div class="alert alert-block">No posts were found in <?=$data['tag']->title;?>.</div>
			<? endif; ?>
		@elseif (isset($data))
			<div class="alert alert-error alert-block">Tag not found</div>
		@endif

		@if (empty($data) && !empty($tags))
			<ul>
			<? foreach($tags as $tag): ?>
				<li><a href="<?=$action_urls['tag'];?>/<?=$tag->slug;?>" title="<?=$tag->title;?>"><?=$tag->title;?></a></li>
			<? endforeach; ?>
			</ul>
		@endif

	</div>
	<div class="span3">
		@include('blog::sidebar')
	</div>
</div>
@endsection