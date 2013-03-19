@layout('content::layouts.home_layout')

@section('page_title')
@if (!empty($page_data->meta_title))
| {{ strtolower($page_data->meta_title) }}
@elseif (!empty($page_data->pretty_name))
| {{ strtolower($page_data->pretty_name) }}
@endif
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
	<div id="scrolling-pages">
		<? if (!empty($content_sections)): ?>
			<? foreach($content_sections as $title => $obj): ?>
				<div id="<? if ($title == '/') echo 'home'; else echo strtolower($title);?>-section" class="scrolling-pages-section">
					<div class="container">
						<? if (!empty($obj->cmspage)): ?>
							<?=$obj->cmspage->content;?>
						<? endif; ?>
						@if (strtolower($obj->pretty_name) == 'home')
							<div id="booj-triangle"><img src="/img/booj-triangle.png" alt="Booj Triangle Logo"></div>
							<div id="booj-questions-container"></div>
						@elseif (strtolower($obj->pretty_name) == 'events' && !empty($events_data) && !empty($events_data['posts']))
						    <div class="jcarousel-events">
						        <div class="jcarousel" id="jcarousel1" data-next=".carousel-next" data-prev=".carousel-prev">
						            <ul>
										<? foreach($events_data['posts']->results as $post): ?>
											<li>
												<a href="/blog/<?=$post->slug;?>" title="View <?=$post->short_title; ?>"><img src="<?=$post->small_photo; ?>" alt="<?=$post->short_title; ?>"></a>
												<div class="carousel-content">
													<h4><a href="/blog/<?=$post->slug;?>" title="View <?=$post->short_title; ?>"><?=substr($post->short_title, 0, 32); ?></a></h4>
													<? if (!empty($post->event_date)): ?>
														<?=date('F jS, Y', strtotime($post->event_date)); ?>
													<? else: ?>
														<?=date('F jS, Y', strtotime($post->created_at)); ?>
													<? endif; ?>
													<p><?=$post->truncated_content(200);?></p>
												</div>
											</li>
										<? endforeach; ?>
									</ul>
								</div>
						        <a href="#" class="left carousel-control carousel-next">&lsaquo;</a>
						        <a href="#" class="right carousel-control carousel-prev">&rsaquo;</a>
							</div>
						@endif
					</div>
				</div>
			<? endforeach; ?>
		<? endif; ?>
	</div>
@endsection

@section('styles')
	 {{ $content_css }} 
@endsection

@section('scripts')
	 {{ $content_js }} 
	<script src="/js/jcarousel/dist/jquery.jcarousel.min.js"></script>
	<script src="/dist/homepage.min.js"></script>	
@endsection