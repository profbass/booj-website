@layout('admin::layouts.main')

@section('page_title')
| Blog - Create Post
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
<div class="row">
	<div class="col-xs-3">
		@include('blog::admin.sidenav')
	</div>
    <div class="col-xs-9">
        <h2>Create Blog Post</h2>
        <hr>
        <?=Form::open_for_files($controller_alias . '/store', null, array('class' => 'form-horizontal')); ?>
            <fieldset>
                
                <div class="control-group{{ isset($errors) && $errors->has('title') ? ' error' : '' }}">
                    <?=Form::label('title', 'Title *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('title', Input::old('title'), array('class' => 'col-xs-6', 'required' => 'required', 'placeholder' => 'Enter Title')); ?>
                        @if ($errors && $errors->has('title'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('short_title') ? ' error' : '' }}">
                    <?=Form::label('short_title', 'Short Title *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('short_title', Input::old('short_title'), array('class' => 'col-xs-6', 'required' => 'required', 'placeholder' => 'Enter Short Title')); ?>
                        @if ($errors && $errors->has('short_title'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('is_published') ? ' error' : '' }}">
                    <?=Form::label('is_published', 'Status *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?
                        $select_options = array('1' => 'Published', '0' => 'Pending');
                        echo Form::select('is_published', $select_options, Input::old('is_published') ? Input::old('is_published') : 1, array('class' => 'col-xs-6', 'required' => 'required'));
                        ?>
                        @if ($errors && $errors->has('is_published'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('created_at') ? ' error' : '' }}">
                    <?=Form::label('created_at', 'Published Date *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('created_at', Input::old('created_at') ? Input::old('created_at') : date('Y-m-d', time()), array('class' => 'col-xs-6 date-widget', 'required' => 'required', 'placeholder' => 'Enter Date Published')); ?>
                        @if ($errors && $errors->has('created_at'))
                            <span class="help-inline">This field is required</span>
                        @endif
                        <span class="help-block">format: yyyy-mm-dd</span>
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('event_date') ? ' error' : '' }}">
                    <?=Form::label('event_date', 'Event Date', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('event_date', Input::old('event_date') ? Input::old('event_date') : date('Y-m-d', time()), array('class' => 'col-xs-6 date-widget', 'placeholder' => 'Enter Event Date')); ?>
                        @if ($errors && $errors->has('event_date'))
                            <span class="help-inline">This field is required</span>
                        @endif
                        <span class="help-block">format: yyyy-mm-dd</span>
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('main_photo') ? ' error' : '' }}">
                    <?=Form::label('main_photo', 'Main Image *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::file('main_photo'); ?>
                        <span class="help-inline">Image will be cropped to {{ $main_image['width'] }} X {{ $main_image['height'] }}</span>
                        @if ($errors && $errors->has('main_photo'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('small_photo') ? ' error' : '' }}">
                    <?=Form::label('small_photo', 'Small Image *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::file('small_photo'); ?>
                        <span class="help-inline">Image will be cropped to {{ $small_image['width'] }} X {{ $small_image['height'] }}</span>
                        @if ($errors && $errors->has('small_photo'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <?=Form::label('content', 'Content', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::textarea('content', Input::old('content'), array('cols' => '80', 'rows' => '10', 'id' => 'editor1', 'class' => 'col-xs-12', 'style' => 'height: 400px;', 'placeholder' => 'Enter Content'));?>
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
                        echo Form::select('user_id', $select_options, Input::old('user_id') ? Input::old('user_id') : $curr_user_id, array('class' => 'col-xs-6', 'required' => 'required'));
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
                        echo Form::select('category_id', $select_options, Input::old('category_id'), array('class' => 'col-xs-6', 'required' => 'required'));
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
                        $select_options = array('' => 'Choose Tags');
                        if(!empty($tags)) {
                            foreach($tags as $obj) {
                                $select_options[$obj->id] = $obj->title;
                            }
                        }
                        echo Form::select('tag_ids[]', $select_options, Input::old('tag_ids[]'), array('class' => 'col-xs-6', 'multiple' => 'multiple'));
                        ?>
                        @if ($errors && $errors->has('tag_ids[]'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" value="1" class="btn btn-default btn btn-default-large btn btn-default-success">Create</button>
                </div>
                
                <?=Form::token(); ?>
            </fieldset>
        <?=Form::close(); ?>       
    </div>
</div>
@endsection
