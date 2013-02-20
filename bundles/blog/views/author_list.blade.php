@layout('blog::layouts.layout')

@section('page_title')
 ~ Meet Our Blog Contributors
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
			<h1>Meet Our Blog Contributors</h1>
		</div>
		@if (!empty($authors))
			@foreach($authors as $author)
				<div class="post-author-section shadow-box white-box margin-bottom-30">
					<a href="<?=$action_urls['author'];?>/<?=$author->username;?>" title="View profile for <?=$author->first_name; ?> <?=$author->last_name; ?>">
							<img class="post-author-img" src="<?=$author->user_metadata->avatar;?>" alt="photo of <?=$author->first_name; ?> <?=$author->last_name; ?>">
						</a>
					<h2 class="font-30">
						<a href="<?=$action_urls['author'];?>/<?=$author->username;?>" title="View profile for <?=$author->first_name; ?> <?=$author->last_name; ?>" class="caps"><?=$author->first_name; ?> <?=$author->last_name; ?></a>
						<? if (!empty($author->user_metadata->facebook_id)) echo '<a href="' . $action_urls['facebook'] . $author->user_metadata->facebook_id . '" rel="nofollow" target="_blank" title="My Facebook Page"><i class="bicon-red-facebook margin-top-5">Facebook</i></a>'; ?>
						<? if (!empty($author->user_metadata->google_plus_id)) echo '<a href="' . $action_urls['google_plus'] . $author->user_metadata->google_plus_id . '" rel="nofollow" target="_blank" title="My Google Plus Page"><i class="bicon-red-google-plus margin-top-5">Google Plus</i></a>'; ?>
						<? if (!empty($author->user_metadata->twitter_handle)) echo '<a href="' . $action_urls['twitter'] . $author->user_metadata->twitter_handle . '" rel="nofollow" target="_blank" title="My Twitter Page"><i class="bicon-red-twitter margin-top-5">Twitter</i></a>'; ?>
					</h2>
					<span class="block author-title"><?=$author->user_metadata->title; ?></span>
					<p><?=$author->user_metadata->bio;?></p>
				</div>
			@endforeach
		@else
			<p>We currently do not have any contributors.</p>
		@endif
	</div>
	<div class="span3">
		@include('blog::sidebar')
	</div>
</div>
@endsection 