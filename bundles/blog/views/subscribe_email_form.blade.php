@layout('blog::layouts.layout')

@section('page_title')
| Blog ~ Subscribe By Email
@endsection


@section('content')
<div class="row-fluid">
	<div class="span9">
		<div class="title-bar margin-bottom-30">
			<h1>Subscribe By Email</h1>
		</div>
	</div>
	<div class="span3">
		@include('blog::sidebar')
	</div>
</div>
@endsection