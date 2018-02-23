@layout('admin::layouts.main')

@section('page_title')
| Conent - Dashboard
@endsection

@section('content')
<div class="row">
	<div class="col-xs-3">
		@include('content::admin.sidenav')
	</div>
    <div class="col-xs-9">
    	<h1>Manage Your Content</h1>
    	<div class="alert alert-block">
    		Use the navigation to the left to manage your content
    	</div>
    </div>
</div>
@endsection
