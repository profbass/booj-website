@layout('admin::layouts.main')

@section('page_title')
| Users - Create
@endsection

@section('scripts')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')	
<div class="row-fluid">
	<div class="span3">
		@include('admin::users.sidenav')
	</div>
    <div class="span9">
    	<h2>Create User</h2>
    	<hr>
		<?php echo Form::open($controller_alias . '/store', null, array('class' => 'form-horizontal') ); ?>
			<fieldset>				

				<div class="control-group{{ isset($errors) && $errors->has('first_name') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('first_name', 'First Name *', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('first_name', Input::old('first_name'), array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter First Name'));
							?>
							@if ($errors && $errors->has('first_name'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('last_name') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('last_name', 'Last Name *', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('last_name', Input::old('last_name'), array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Last Name'));
							?>
							@if ($errors && $errors->has('last_name'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('slug') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('slug', 'Slug *', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('slug', Input::old('slug'), array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter Slug'));
							?>
							@if ($errors && $errors->has('slug'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('twitter_handle') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('twitter_handle', 'Twitter Handle', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('twitter_handle', Input::old('twitter_handle'), array('class' => 'span6', 'placeholder' => 'Enter Twitter Handle'));
							?>
							@if ($errors && $errors->has('twitter_handle'))
								<span class="help-inline">This field is required</span>
							@endif
							<span class="help-block">Just use your handle ie: sixfootsix</span>
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('facebook_id') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('facebook_id', 'Facebook Id', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('facebook_id', Input::old('facebook_id'), array('class' => 'span6', 'placeholder' => 'Enter Facebook Id'));
							?>
							@if ($errors && $errors->has('facebook_id'))
								<span class="help-inline">This field is required</span>
							@endif
							<span class="help-block">Just use your id ie: james.c.olson</span>
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('google_plus_id') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('google_plus_id', 'Google Plus Id', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('google_plus_id', Input::old('google_plus_id'), array('class' => 'span6', 'placeholder' => 'Enter Google Plus Id'));
							?>
							@if ($errors && $errors->has('google_plus_id'))
								<span class="help-inline">This field is required</span>
							@endif
							<span class="help-block">Just use your id ie: 64646987</span>
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('title') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('title', 'Title', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::text('title', Input::old('title'), array('class' => 'span6', 'placeholder' => 'Enter Title'));
							?>
							@if ($errors && $errors->has('title'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('email') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('email', 'Email *', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo Form::email('email', Input::old('email'), array('class' => 'span6', 'required' => 'required', 'placeholder' => 'Enter New Email Address'));
							?>
							@if ($errors && $errors->has('email'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="control-group{{ isset($errors) && $errors->has('bio') ? ' error' : '' }}">
					<div class="control-group">
						<?php echo Form::label('bio', 'Biography', array('class' => 'control-label')); ?>
						<div class="controls">
							<?=Form::textarea('bio', Input::old('bio'), array('class' => 'span12 ckeditor', 'style' => 'height: 200px;', 'placeholder' => 'Enter Biography'));?>
							@if ($errors && $errors->has('bio'))
								<span class="help-inline">This field is required</span>
							@endif
						</div>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" name="submit" value="1" class="btn btn-success">Create User</button>
				</div>
				<?php echo Form::token(); ?>
			</fieldset>

   		<?php echo Form::close(); ?>
    </div>
</div>
@endsection