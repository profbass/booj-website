@layout('admin::layouts.main')

@section('page_title')
| Blog - Categories
@endsection

@section('content')
<div class="row-fluid">
	<div class="span3">
		@include('blog::admin.sidenav')
	</div>
    <div class="span9">
        <h2>Blog Categories</h2>
        <a href="<?=$controller_alias; ?>/create" class="btn btn-primary">Create New Category</a>
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
								<div class="btn-toolbar">
									<div class="btn-group">
										<a href="<?=$controller_alias; ?>/edit/<?=$category->id; ?>" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i> Edit</a>
                                        <a data-action="confirm" href="<?=$controller_alias; ?>/destroy/<?=$category->id; ?>" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> DELETE Page</a>
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
