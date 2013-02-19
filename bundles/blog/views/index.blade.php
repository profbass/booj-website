@layout('blog::layouts.layout')

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
		<? if (!empty($posts->results)): ?>
			<? $iter = 0; $max = count($posts->results) - 1; ?>
			<? foreach ($posts->results as $post): ?>
				<? if ($iter === 0): ?>
					<div class="post-landing post-landing-first white-box shadow-box">
				<? else: ?>
					<div class="span6 post-landing white-box shadow-box">
				<? endif; ?>
						<div class="post-landing-photo">
							<? if ($iter === 0): ?>
								<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><img src="<?=$post->main_photo;?>" alt="<?=$post->short_title;?>"></a>
							<? else: ?>
								<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><img src="<?=$post->small_photo;?>" alt="<?=$post->short_title;?>"></a>
							<? endif; ?>
							<? if (!empty($post->category)): ?>
								<a class="category-button" href="<?=$action_urls['category'];?>/<?=$post->category->slug;?>" title="<?=$post->category->title;?>"><?=$post->category->title;?></a>
								<? if ($iter === 0): ?><span class="category-button-padder"></span><? endif; ?>
							<? endif; ?>
						</div>
						<div class="post-landing-outer">
							<div class="post-landing-inner">
								<? if ($iter === 0): ?>
									<h2 class="font-28"><a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->title;?>"><?=$post->title;?></a></h2>
								<? else: ?>
									<h2 class="font-18"><a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>" title="<?=$post->short_title;?>"><?=$post->short_title;?></a></h2>
								<? endif; ?>
								<p class="post-landing-author">
									<?=date('F jS, Y', strtotime($post->created_at));?>
									<? if (!empty($post->user)): ?>
										 // by <a href="<?=$action_urls['author'];?>/<?=$post->user->slug;?>" title="View profile for <?=$post->user->first_name;?> <?=$post->user->last_name;?>">+<?=$post->user->first_name;?> <?=$post->user->last_name;?></a>
									<? endif; ?>
								</p>
								<p class="post-landing-content">
									<? if ($iter === 0): ?>
										<?=$post->truncated_content(600);?>
									<? else: ?>
										<?=$post->truncated_content();?>
									<? endif; ?>
								</p>
								<div class="addthis_toolbox addthis_default_style" addthis:url="http://booj.com<?=$action_urls['blog'];?>/<?=$post->slug;?>" addthis:title="<?=$post->title;?>">
									<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
									<!-- <a class="addthis_button_linkedin_counter"></a>  -->
									<a class="addthis_button_google_plusone" g:plusone:size="medium"></a> 
									<a class="addthis_button_tweet"></a>
								</div>
							</div>
						</div>
					</div>
				<? if ($iter === 0): ?>
					<div class="row-fluid">
				<? else: ?>
					<? if ($iter % 2 == 0 && $iter < $max): ?>
						</div><div class="row-fluid">
					<? endif; ?>
				<? endif; ?>
				<? $iter++; ?>
			<? endforeach; ?>
			</div>
		<? endif; ?>
		<?=$posts->links(); ?>
	</div>
	<div class="span3">
		@include('blog::sidebar')
	</div>
</div>
@endsection