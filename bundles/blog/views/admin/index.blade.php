@layout('admin::layouts.main')

@section('page_title')
| Blog - Dashboard
@endsection

@section('content')
<div class="row-fluid">
	<div class="span3">
		@include('blog::admin.sidenav')
	</div>
    <div class="span9">
    	<h1>Manage Your Blog</h1>
    	<div class="alert alert-block">
    		Use the navigation to the left to manage the sections of your blog
    	</div>
    </div>
</div>
@endsection
