@layout('admin::layouts.main')

@section('page_title')
| Blog - Edit Tag
@endsection


@section('content')
<div class="row-fluid">
	<div class="span3">
		@include('blog::admin.sidenav')
	</div>
    <div class="span9">
        <h2>Edit Blog Tag</h2>
        <hr>
        <?=Form::open($controller_alias . '/save/' . $tag->id, null, array('class' => 'form-horizontal')); ?>
            <fieldset>
                
                <div class="control-group{{ isset($errors) && $errors->has('title') ? ' error' : '' }}">
                    <?=Form::label('title', 'Title *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('title', Input::old('title') ? Input::old('title') : $tag->title, array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Title')); ?>
                        @if ($errors && $errors->has('title'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('slug') ? ' error' : '' }}">
                    <?=Form::label('slug', 'Slug *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::text('slug', Input::old('slug') ? Input::old('slug') : $tag->slug, array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Slug')); ?>
                        @if ($errors && $errors->has('slug'))
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
