@layout('admin::layouts.main')

@section('page_title')
| Blog - Posts
@endsection

@section('content')
<div class="row-fluid">
    <div class="span3">
        @include('blog::admin.sidenav')
    </div>
    <div class="span9">
        <h2>Blog Posts</h2>
        <a href="<?=$controller_alias; ?>/create" class="btn btn-primary">Create New Post</a>
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
                            <td><?=$post->title;?> <a href="<?=$blog_url;?>/<?=$post->slug;?>" target="_blank" title="Go To Post"><i class="icon-circle-arrow-up"></i></a></td>
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
                                <div class="btn-toolbar">
                                    <div class="btn-group">
                                        <a href="<?=$controller_alias; ?>/edit/<?=$post->id; ?>" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i> Edit</a> 
                                        <a href="<?=$controller_alias; ?>/edit-photos/<?=$post->id; ?>" class="btn btn-mini btn-primary"><i class="icon-picture icon-white"></i> Edit Photos</a>
                                        <a data-action="confirm" href="<?=$controller_alias; ?>/destroy/<?=$post->id; ?>" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> DELETE Page</a>
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
