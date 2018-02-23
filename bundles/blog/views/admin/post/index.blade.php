@layout('admin::layouts.main')

@section('page_title')
| Blog - Posts
@endsection

@section('content')
<div class="row">
    <div class="col-xs-3">
        @include('blog::admin.sidenav')
    </div>
    <div class="col-xs-9">
        <h2>Blog Posts</h2>
        <a href="<?=$controller_alias; ?>/create" class="btn btn-default btn btn-default-primary">Create New Post</a>
        <hr>

        <table class="table table-striped list-table">
            <thead>
                <tr>
                    <th>Post Title</th>
                    <th>Posted Date</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th class="align-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <? if (!empty($posts->results)): ?>
                    <? foreach($posts->results as $post): ?>
                        <tr>
                            <td><?=$post->title;?> <a href="<?=$blog_url;?>/<?=$post->slug;?>" target="_blank" title="Go To Post"><i class="glyphicon glyphicon-circle-arrow-up"></i></a></td>
                            <td><?=date('m-d-Y', strtotime($post->created_at));?></td>
                            <td><? if ($post->is_published == 1) echo 'Published'; else echo 'Pending'; ?></td>
                            <td><?=$post->category->title;?></td>
                            <td>
                                <? if (!empty($post->tags)): ?>
                                    <? foreach ($post->tags as $tag): ?>
                                        <span class="label"><?=$tag->title;?></span>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </td>
                            <td>
                                <div class="btn btn-default-toolbar">
                                    <div class="btn btn-default-group">
                                        <a href="<?=$controller_alias; ?>/edit/<?=$post->id; ?>" class="btn btn-default btn btn-default-mini btn btn-default-primary"><i class="glyphicon glyphicon-pencil glyphicon glyphicon-white"></i> Edit</a> 
                                        <a href="<?=$controller_alias; ?>/edit-photos/<?=$post->id; ?>" class="btn btn-default btn btn-default-mini btn btn-default-primary"><i class="glyphicon glyphicon-picture glyphicon glyphicon-white"></i> Edit Photos</a>
                                        <a data-action="confirm" href="<?=$controller_alias; ?>/destroy/<?=$post->id; ?>" class="btn btn-default btn btn-default-mini btn btn-default-danger"><i class="glyphicon glyphicon-remove glyphicon glyphicon-white"></i> DELETE Page</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <? endforeach; ?>
                <? endif; ?>
            </tbody>
        </table>
        <? if (!empty($posts)) echo $posts->links(); ?>
    </div>
</div>
@endsection
