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
					<a href="<?=$action_urls['author'];?>/<?=$author->slug;?>" title="View profile for <?=$author->first_name; ?> <?=$author->last_name; ?>">
							<img class="post-author-img" src="<?=$author->avatar;?>" alt="photo of <?=$author->first_name; ?> <?=$author->last_name; ?>">
						</a>
					<h2 class="font-30">
						<a href="<?=$action_urls['author'];?>/<?=$author->slug;?>" title="View profile for <?=$author->first_name; ?> <?=$author->last_name; ?>" class="caps"><?=$author->first_name; ?> <?=$author->last_name; ?></a>
						<? if (!empty($author->facebook_id)) echo '<a href="' . $action_urls['facebook'] . $author->facebook_id . '" rel="nofollow" target="_blank" title="My Facebook Page"><i class="bicon-red-facebook margin-top-5">Facebook</i></a>'; ?>
						<? if (!empty($author->google_plus_id)) echo '<a href="' . $action_urls['google_plus'] . $author->google_plus_id . '" rel="nofollow" target="_blank" title="My Google Plus Page"><i class="bicon-red-google-plus margin-top-5">Google Plus</i></a>'; ?>
						<? if (!empty($author->twitter_handle)) echo '<a href="' . $action_urls['twitter'] . $author->twitter_handle . '" rel="nofollow" target="_blank" title="My Twitter Page"><i class="bicon-red-twitter margin-top-5">Twitter</i></a>'; ?>
					</h2>
					<span class="block author-title"><?=$author->title; ?></span>
					<p><?=$author->bio;?></p>
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