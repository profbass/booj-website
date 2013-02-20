@layout('blog::layouts.layout')

@section('page_title')
 ~ Search Results
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
		<h1 class="title-bar margin-bottom-30">Search Results</h1>
		<? if (!empty($data['term'])): ?>
			<p>Results for <em><?=$data['term'];?></em></p>
		<? endif; ?>
		<? if (!empty($data['posts']->results)): ?>
			<ul class="unstyled">
				<? foreach ($data['posts']->results as $post): ?>
					<li>
						<div class="row-fluid">
							<div class="span2">
								<? if (!empty($post->user) && !empty($post->user->user_metadata->avatar)): ?>
									<img class="gray-border" src="<?=$post->user->user_metadata->avatar; ?>" alt="" class="pull-right">
								<? endif; ?>
							</div>
							<div class="span10">
								<a href="<?=$action_urls['blog'];?>/<?=$post->slug;?>"><?=$post->title;?></a>
								<p><?=$post->truncated_content();?></p>
							</div>
						</div>
						<hr>
					</li>
				<? endforeach; ?>
			</ul>
			<?=$data['posts']->links(); ?>
		<? else: ?>
			<div class="alert alert-error alert-block">No Results Found</div>
		<? endif; ?>
	</div>
	<div class="span3">
		@include('blog::sidebar')
	</div>
</div>
@endsection