@layout('admin::layouts.main')

@section('page_title')
| Blog - Tags
@endsection

@section('content')
<div class="row-fluid">
	<div class="span3">
		@include('blog::admin.sidenav')
	</div>
    <div class="span9">
        <h2>Blog Tags</h2>
        <a href="<?=$controller_alias; ?>/create" class="btn btn-primary">Create New Tag</a>
        <hr>

    	<table class="table table-striped list-table">
    		<thead>
    			<tr>
    				<th>Tag Title</th>
    				<th>Created Date</th>
    				<th class="align-right">Actions</th>
    			</tr>
    		</thead>
    		<tbody>
    			<? if (!empty($tags)): ?>
    				<? foreach($tags as $tag): ?>
	    				<tr>
	    					<td><?=$tag->title;?></td>
	    					<td><?=date('m-d-Y', strtotime($tag->created_at));?></td>
	    					<td>
								<div class="btn-toolbar">
									<div class="btn-group">
										<a href="<?=$controller_alias; ?>/edit/<?=$tag->id; ?>" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i> Edit</a>
                                        <a data-action="confirm" href="<?=$controller_alias; ?>/destroy/<?=$tag->id; ?>" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> DELETE Page</a>
									</div>
								</div>
	    					</td>
	    				</tr>
    				<? endforeach; ?>
    			<? endif; ?>
    		</tbody>
    	</table>
    </div>
</div>
@endsection
