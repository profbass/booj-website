@layout('admin::layouts.main')

@section('page_title')
| Blog - Edit Post
@endsection

@section('scripts')
<script src="/ckeditor/ckeditor.js"></script>
<script src="/ckfinder/ckfinder.js"></script>
<script>
if (typeof CKEDITOR === 'object') {
    var editor = CKEDITOR.replace( 'editor1' );
    CKFinder.setupCKEditor( editor, '/ckfinder/' );
}
</script>
@endsection

@section('content')
<div class="row-fluid">
	<div class="span3">
		@include('blog::admin.sidenav')
	</div>
    <div class="span9">
        <h2>Edit Blog Post</h2>
        <hr>
        <?=Form::open($controller_alias . '/save/' . $post->id, null, array('class' => 'form-horizontal')); ?>
            <fieldset>
                
                <div class="control-group{{ isset($errors) && $errors->has('title') ? ' error' : '' }}">
                    <?=Form::label('title', 'Post Title *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('title', Input::old('title') ? Input::old('title') : $post->title, array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Post Title')); ?>
                        @if ($errors && $errors->has('title'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('short_title') ? ' error' : '' }}">
                    <?=Form::label('short_title', 'Short Title *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('short_title', Input::old('short_title') ? Input::old('short_title') : $post->short_title, array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Short Title')); ?>
                        @if ($errors && $errors->has('short_title'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('slug') ? ' error' : '' }}">
                    <?=Form::label('slug', 'Slug *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('slug', Input::old('slug') ? Input::old('slug') : $post->slug, array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Slug')); ?>
                        @if ($errors && $errors->has('slug'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('is_published') ? ' error' : '' }}">
                    <?=Form::label('is_published', 'Status *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?
                        $select_options = array('1' => 'Published', '0' => 'Pending');
                        echo Form::select('is_published', $select_options, Input::old('is_published') ? Input::old('is_published') : $post->is_published, array('class' => 'span6', 'required' => 'required'));
                        ?>
                        @if ($errors && $errors->has('is_published'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('created_at') ? ' error' : '' }}">
                    <?=Form::label('created_at', 'Published Date *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('created_at', Input::old('created_at') ? Input::old('created_at') : $post->created_at, array('class' => 'span6 date-widget', 'required' => 'required', 'placeholder' => 'Enter Date Published')); ?>
                        @if ($errors && $errors->has('created_at'))
                            <span class="help-inline">This field is required</span>
                        @endif
                        <span class="help-block">format: yyyy-mm-dd</span>
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('event_date') ? ' error' : '' }}">
                    <?=Form::label('event_date', 'Event Date', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('event_date', Input::old('event_date') ? Input::old('event_date') : $post->event_date, array('class' => 'span6 date-widget', 'placeholder' => 'Enter Event Date')); ?>
                        @if ($errors && $errors->has('event_date'))
                            <span class="help-inline">This field is required</span>
                        @endif
                        <span class="help-block">format: yyyy-mm-dd</span>
                    </div>
                </div>

                <div class="control-group">
                    <?=Form::label('content', 'Content', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::textarea('content', Input::old('content') ? Input::old('content') : $post->content, array('cols' => '80', 'id' => 'editor1', 'rows' => '10', 'class' => 'span12', 'style' => 'height: 400px;', 'placeholder' => 'Enter Content'));?>
                        @if ($errors && $errors->has('content'))
                            <span class="help-block">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <div class="alert alert-block">For a reference on what markup to use and all the style resources visit <a href="http://www.getbootstrap.com" target="_blank">www.getbootstrap.com</a> and navigate to the <strong>Base CSS page</strong></div>
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('user_id') ? ' error' : '' }}">
                    <?php echo Form::label('user_id', 'Author *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?
                        $select_options = array('' => 'Choose Author');
                        if(!empty($users)) {
                            foreach($users as $obj) {
                                $select_options[$obj->id] = $obj->first_name . ' ' . $obj->last_name;
                            }
                        }
                        echo Form::select('user_id', $select_options, Input::old('user_id') ? Input::old('user_id') : (!empty($post->user) ? $post->user->id : 0), array('class' => 'span6', 'required' => 'required'));
                        ?>
                        @if ($errors && $errors->has('user_id'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('category_id') ? ' error' : '' }}">
                    <?php echo Form::label('category_id', 'Category *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?
                        $select_options = array('' => 'Choose Category');
                        if(!empty($categories)) {
                            foreach($categories as $obj) {
                                $select_options[$obj->id] = $obj->title;
                            }
                        }
                        echo Form::select('category_id', $select_options, Input::old('category_id') ? Input::old('category_id') : $post->category->id, array('class' => 'span6', 'required' => 'required'));
                        ?>
                        @if ($errors && $errors->has('category_id'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('tag_ids[]') ? ' error' : '' }}">
                    <?php echo Form::label('tag_ids[]', 'Tags', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?
                        $old_values = array();
                        if (!empty($post->tags)) {
                        	foreach ($post->tags as $t) {
                        		$old_values[] = $t->id;
                        	};
                        }
                        $select_options = array('' => 'Choose Tags');
                        if(!empty($tags)) {
                            foreach($tags as $obj) {
                                $select_options[$obj->id] = $obj->title;
                            }
                        }
                        echo Form::select('tag_ids[]', $select_options, Input::old('tag_ids') ? Input::old('tag_ids') : $old_values, array('class' => 'span6', 'multiple' => 'multiple'));
                        ?>
                        @if ($errors && $errors->has('tag_ids[]'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" value="1" class="btn btn-large btn-success">Save</button>
                </div>
                
                <?=Form::token(); ?>
            </fieldset>
        <?=Form::close(); ?>       
    </div>
</div>
@endsection
