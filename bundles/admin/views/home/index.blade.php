@layout('admin::layouts.main')

@section('page_title')
| Dashboard
@endsection

@section('content')
<div class="row-fluid">
    <div class="span12">
 		<h1>Admin Dashboard</h1>
 		
 		<p>Welcome to your admin panel. Use the navigation at the top to manage your site.</p>

 		<ul class="unstyled">
 			<li><a href="/admin/content">Content</a></li>
 			<li><a href="/admin/users">Users</a></li>
 			<li><a href="/admin/blog">Blog</a></li>
 			<li><a href="/admin/myaccount">My Account</a></li>
 			<li>&nbsp;</li>
 			<li><a href="/admin/logout">Logout</a></li>
 		</ul>
 		<br><br>
 		<p>
 			<button class="btn" id="browser_file_system">Browse And Manage Files</button>
 		</p>
	</div>
</div>
@endsection

@section('scripts')
	<script src="/ckfinder/ckfinder.js"></script>
	<script>
	jQuery(document).ready(function($) {
		$('#browser_file_system').on('click', function(event) {
			event.preventDefault();
			CKFinder.popup( '/public/ckfinder/', null, null, null);
		});
	});
	</script>
@endsection