@layout('admin::layouts.main')

@section('page_title')
| Users - Edit User Avatar
@endsection

@section('content')	
<div class="row">
	<div class="col-xs-3">
		@include('admin::users.sidenav')
	</div>
    <div class="col-xs-9">
        <h2>Edit Avatar for <?=$user->first_name . ' ' . $user->last_name; ?></h2>
        <hr>
        <?=Form::open_for_files($controller_alias . '/update_avatar/' . $user->id, null, array('class' => 'form-horizontal')); ?>
            <fieldset>
                
                <div class="control-group">
                	<label class="control-label">Current Avatar</label>
                	<div class="controls">
                        <? if (!empty($user->user_metadata->avatar)): ?>
                            <a href="<?=$user->user_metadata->avatar;?>" target="_blank"><img src="<?=$user->user_metadata->avatar;?>" class="img-polaroid" alt="Avatar" style="max-width:100px;"></a>
                        <? else: ?>
                            No Image Uploaded
                        <? endif; ?>
                        <span class="help-inline">Image will be cropped to {{ $dims['width'] }} X {{ $dims['height'] }}</span>
                    </div>
                </div>

                <div class="control-group{{ isset($errors) && $errors->has('avatar') ? ' error' : '' }}">
                    <?=Form::label('avatar', 'Avatar *', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?=Form::file('avatar'); ?>
                        @if ($errors && $errors->has('avatar'))
                            <span class="help-inline">This field is required</span>
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" value="main-photo" class="btn btn-default btn btn-default-large btn btn-default-success">Change Avatar</button>
                </div>

                <?=Form::token(); ?>
            </fieldset>
        <?=Form::close(); ?> 
    </div>
</div>
@endsection
