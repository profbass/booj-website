@layout('blog::layouts.layout')

@section('page_title')
| blog ~ subscribe by email
@endsection


@section('content')
<div class="row">
	<div class="col-xs-9">
		<div class="title-bar margin-bottom-30">
			<h1>Subscribe By Email</h1>
		</div>
	</div>
	<div class="col-xs-3">
		@include('blog::sidebar')
	</div>
</div>
@endsection