@layout('blog::layouts.layout')

@section('page_title')
 ~ author
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
<div class="row">
	<div class="col-xs-9">
		<div class="title-bar margin-bottom-30">
			@if (!empty($data['author']))
				<h1 class="caps"><?=$data['author']->first_name; ?> <?=$data['author']->last_name; ?></h1>
			@else
				<h1>Author</h1>
			@endif
		</div>
		@if (!empty($data['author']))
			<div class="author-bio-section margin-bottom-30">
				<img class="author-bio-img" src="<?=$data['author']->user_metadata->avatar;?>" alt="photo of <?=$data['author']->first_name; ?> <?=$data['author']->last_name; ?>">
				<span class="block author-bio-title"><?=$data['author']->user_metadata->title; ?></span>
				<span class="block">
					<? if (!empty($data['author']->user_metadata->facebook_id)) echo '<a href="' . $action_urls['facebook'] . $data['author']->user_metadata->facebook_id . '" rel="nofollow" target="_blank" title="My Facebook Page"><i class="glyphicon glyphicon-red-facebook">Facebook</i></a>'; ?>
					<? if (!empty($data['author']->user_metadata->google_plus_id)) echo '<a href="' . $action_urls['google_plus'] . $data['author']->user_metadata->google_plus_id . '" rel="nofollow" target="_blank" title="My Google Plus Page"><i class="glyphicon glyphicon-red-google-plus">Google Plus</i></a>'; ?>
					<? if (!empty($data['author']->user_metadata->twitter_handle)) echo '<a href="' . $action_urls['twitter'] . $data['author']->user_metadata->twitter_handle . '" rel="nofollow" target="_blank" title="My Twitter Page"><i class="glyphicon glyphicon-red-twitter">Twitter</i></a>'; ?>
				</span>
				<span class="block author-bio-spacer">&nbsp;</span>
				<?=$data['author']->user_metadata->bio;?>
			</div>

			@if (!empty($data['posts']->results))
				<h2 class="font-30 margin-bottom-15">My Previous Posts</h2>
				<div class="row">
					<? $iter = 0; $max = count($data['posts']->results) - 1; ?>
					<? foreach ($data['posts']->results as $post): ?>
						<div class="col-xs-6 post-landing shadow-box white-box">
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
											 // by <a href="<?=$action_urls['author'];?>/<?=$post->user->username;?>" title="View profile for <?=$post->user->first_name;?> <?=$post->user->last_name;?>">+ <?=$post->user->first_name;?> <?=$post->user->last_name;?></a>
										<? endif; ?>
									</p>
									<p class="post-landing-content"><?=$post->truncated_content();?></p>
									<div class="addthis_toolbox addthis_default_style" addthis:url="<?=$action_urls['domain'];?><?=$action_urls['blog'];?>/<?=$post->slug;?>" addthis:title="<?=$post->title;?>">
										<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
										<a class="addthis_button_google_plusone" g:plusone:size="medium"></a> 
										<a class="addthis_button_tweet"></a>
									</div>
								</div>
							</div>
						</div>
						<? if ($iter % 2 == 1 && $iter < $max): ?>
							</div><div class="row">
						<? endif; ?>
						<? $iter++; ?>
					<? endforeach; ?>
				</div>
				<?=$data['posts']->links(); ?>
			@endif
		@else
			<div class="alert alert-block alert-error">Contributor not found.</div>
		@endif
	</div>
	<div class="col-xs-3">
		@include('blog::sidebar')
	</div>
</div>
@endsection