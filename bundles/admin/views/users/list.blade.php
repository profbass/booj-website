@layout('admin::layouts.main')

@section('page_title')
| Users - All Users
@endsection

@section('content')	
<div class="row">
	<div class="col-xs-3">
		@include('admin::users.sidenav')
	</div>
    <div class="col-xs-9">
    	<a href="<?=$controller_alias;?>/create" class="btn btn-default pull-right btn btn-default-primary">Create User</a>
     	<h2>Current Users</h2>
     	<hr>
     	<?php if(isset($users) && !empty($users)): ?>
     		<table class="table table-striped list-table">
     			<thead>
     				<tr>
     					<th>Name</th>
     					<th>Username</th>
     					<th>Email</th>
     					<th>Status</th>
     					<th>Groups</th>
     					<th class="align-right">Actions</th>
     				</tr>
     			</thead>
     			<tbody>
		     		<?php foreach($users as $user): ?>
		     			<tr>
		     				<td><?=$user->first_name;?> <?=$user->last_name;?></td>
		     				<td><?=$user->username;?></td>
		     				<td><?=$user->email;?></td>
		     				<td>
		     					<?php
		     					if ($user->status == 1):
		     						echo 'Active';
		     					elseif ($user->status == 0):
		     						echo 'Inactive';
		     					else:
		     						echo $user->status;
		     					endif;
		     					?>
		     				</td>
		     				<td>
		     					<? if (!empty($user->groups)) {
		     							foreach($user->groups as $group) {
		     								echo $group->name . "<br>";
		     							}
		     						}
		     					?>
		     				</td>
		     				<td>
								<div class="btn btn-default-toolbar">
									<div class="btn btn-default-group">
				     					<a href="<?=$controller_alias;?>/edit/<?=$user->id;?>" class="btn btn-default btn btn-default-mini"><i class="glyphicon glyphicon-edit"></i> Edit Info</a>
				     					<?
				     					if ($user->status == 1):
				     						echo '<a href="' . $controller_alias . '/lock/' . $user->id .'" class="btn btn-default btn btn-default-warning btn btn-default-mini" data-action="confirm"><i class="glyphicon glyphicon-lock glyphicon glyphicon-white"></i> Lock</a>';
				     					else:
				     						echo '<a href="' . $controller_alias . '/unlock/' . $user->id .'" class="btn btn-default btn btn-default-success btn btn-default-mini" data-action="confirm"><i class="glyphicon glyphicon-ok glyphicon glyphicon-white"></i> Un-Lock</a>';
				     					endif;
				     					?>
				     					<a href="<?=$controller_alias;?>/reset_password/<?=$user->id;?>" class="btn btn-default btn btn-default-mini btn btn-default-info" data-action="confirm"><i class="glyphicon glyphicon-refresh"></i> Reset Password</a>

				     					<a href="<?=$controller_alias;?>/destroy/<?=$user->id;?>" class="btn btn-default btn btn-default-danger btn btn-default-mini" data-action="confirm"><i class="glyphicon glyphicon-remove glyphicon glyphicon-white"></i> Delete</a>
		     						</div>
		     					</div>
		     				</td>
		     			</tr>
		     		<?php endforeach; ?>
	     		</tbody>
	     	</table>
	    <?php else: ?>
	    	<p>No users. <a href="<?=$controller_alias;?>/create">Create User</a></p>
     	<?php endif; ?>
    </div>
</div>
@endsection