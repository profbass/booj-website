@layout('admin::layouts.main')

@section('page_title')
| Blog - Edit Post Photos
@endsection

@section('content')
<div class="row-fluid">
	<div class="span3">
		@include('blog::admin.sidenav')
	</div>
    <div class="span9">
        <h2>Edit Blog Post Photos "<?=$post->title;?></h2>
        <hr>
        <?=Form::open_for_files($controller_alias . '/save-photos/' . $post->id, null, array('class' => 'form-horizontal')); ?>
            <fieldset>
                
                <div class="control-group">
                    <label class="control-label">Current Main Image</label>
                    <div class="controls">
                        <a href="<?=$post->main_photo; ?>" target="_blank"><img class="img-polaroid" src="<?=$post->main_photo; ?>" alt="" style="max-width:200px;"></a>
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

                <div class="form-actions">
                    <button type="submit" name="submit" value="main-photo" class="btn btn-large btn-success">Change Main Image</button>
                </div>

                <?=Form::token(); ?>
            </fieldset>
        <?=Form::close(); ?> 
        <hr>
        <?=Form::open_for_files($controller_alias . '/save-photos/' . $post->id, null, array('class' => 'form-horizontal')); ?>
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Current Small Image</label>
                    <div class="controls">
                        <a href="<?=$post->small_photo; ?>" target="_blank"><img class="img-polaroid" src="<?=$post->small_photo; ?>" alt="" style="max-width:200px;"></a>
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

                <div class="form-actions">
                    <button type="submit" name="submit" value="small-photo" class="btn btn-large btn-success">Change Small Image</button>
                </div>

                <?=Form::token(); ?>
            </fieldset>
        <?=Form::close(); ?>       
    </div>
</div>
@endsection
