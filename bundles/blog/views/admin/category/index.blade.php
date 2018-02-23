@layout('admin::layouts.main')

@section('page_title')
| Blog - Categories
@endsection

@section('content')
<div class="row">
	<div class="col-xs-3">
		@include('blog::admin.sidenav')
	</div>
    <div class="col-xs-9">
        <h2>Blog Categories</h2>
        <a href="<?=$controller_alias; ?>/create" class="btn btn-default btn btn-default-primary">Create New Category</a>
        <hr>

    	<table class="table table-striped list-table">
    		<thead>
    			<tr>
    				<th>Category Title</th>
    				<th>Created Date</th>
    				<th class="align-right">Actions</th>
    			</tr>
    		</thead>
    		<tbody>
    			<? if (!empty($categories)): ?>
    				<? foreach($categories as $category): ?>
    				<? if ($category->visible == 1): ?>
	    				<tr>
	    					<td><?=$category->title;?></td>
	    					<td><?=date('m-d-Y', strtotime($category->created_at));?></td>
	    					<td>
								<div class="btn btn-default-toolbar">
									<div class="btn btn-default-group">
										<a href="<?=$controller_alias; ?>/edit/<?=$category->id; ?>" class="btn btn-default btn btn-default-mini btn btn-default-primary"><i class="glyphicon glyphicon-pencil glyphicon glyphicon-white"></i> Edit</a>
                                        <a data-action="confirm" href="<?=$controller_alias; ?>/destroy/<?=$category->id; ?>" class="btn btn-default btn btn-default-mini btn btn-default-danger"><i class="glyphicon glyphicon-remove glyphicon glyphicon-white"></i> DELETE Page</a>
									</div>
								</div>
	    					</td>
	    				</tr>
	    			<? endif; ?>
    				<? endforeach; ?>
    			<? endif; ?>
    		</tbody>
    	</table>
    </div>
</div>
@endsection
