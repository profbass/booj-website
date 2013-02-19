@layout('admin::layouts.main')

@section('page_title')
| Users - My Account
@endsection

@section('content')	
<div class="row-fluid">
    <div class="span3">
        &nbsp;
    </div>
    <div class="span9">
    	<h2>My Account</h2>
    	<hr>
    	<table class="table table-striped">
    		<tbody>
    			<tr>
    				<td>Name</td>
    				<td><?=$user->first_name;?> <?=$user->last_name; ?></td>
    			</tr>
    			<tr>
    				<td>Title</td>
    				<td><?=$user->title;?></td>
    			</tr>	

    			<tr>
    				<td>Email</td>
    				<td><?=$user->email;?></td>
    			</tr>	
    			<tr>
    				<td>Twitter Handle</td>
    				<td><?=$user->twitter_handle;?></td>
    			</tr>
                <tr>
                    <td>Facebook Id</td>
                    <td><?=$user->facebook_id;?></td>
                </tr>
                <tr>
                    <td>Google Plus Id</td>
                    <td><?=$user->google_plus_id;?></td>
                </tr>
    			<tr>
    				<td>Bio</td>
    				<td><?=$user->bio;?></td>
    			</tr>	
    			<tr>
    				<td>Avatar</td>
    				<td>
                        <? if (!empty($user->avatar)): ?>
                            <a href="<?=$user->avatar;?>" target="_blank"><img src="<?=$user->avatar;?>" class="img-polaroid" alt="Avatar" style="max-width:100px;"></a>
                        <? else: ?>
                            No Image Uploaded
                        <? endif; ?>
                        <a href="<?=$admin_alias;?>/users/edit_avatar/<?=$user->id;?>">Change/Upload Avatar</a>
                    </td>
    			</tr>	
    		</tbody>
    	</table>
    	<a href="<?=$admin_alias;?>/users/edit/<?=$user->id;?>" class="btn btn-primary">Edit This Info</a>

    	<hr>
    	<h3>Change Password</h3>

		<?php echo Form::open($controller_alias . '/change_password/' . $user->id, null, array('class' => 'form-horizontal') ); ?>
			<fieldset>

				<div class="control-group{{ isset($errors) && $errors->has('password') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('password', 'Password *', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::password('password', array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter New Password'));
							?>
							@if ($errors && $errors->has('password'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" name="submit" value="1" class="btn btn-success">Change Password</button>
				</div>
				<?php echo Form::token(); ?>
			</fieldset>
   		<?php echo Form::close(); ?>	
</div>
@endsection