<?php

namespace Admin\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Database as DB;
use \Laravel\Hash as Hash;
use \Laravel\Config as Config;
use \Laravel\Input as Input;
use \Laravel\File as File;
use Resizer as Resizer;

class User extends Eloquent {
	public static $timestamps = true;
	public static $table = 'users';

	protected function make_slug($name) 
	{
		$name = preg_replace( '/[^a-z0-9_-]/', '', str_replace(' ', '-', strtolower(trim(trim($name)))));
		return str_replace('--', '-', $name);
	}

	public function truncated_bio($strlen = 200)
	{
		$p = substr(strip_tags($this->bio), 0, $strlen);
		if (strlen($this->bio) > $strlen) $p .= '...';
		return $p;
	}	

	public static function get_user_by_id($id = FALSE)
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				return $user;
			}
		}
		return FALSE;
	}

	public static function update_user_avatar($id = FALSE, $args = array())
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				$photo_name = uniqid('avatar-' . $user->id . '-') . '.' . strtolower(File::extension(Input::file('avatar.name')));
				$photo_small = uniqid('avatar-small-' . $user->id . '-') . '.' . strtolower(File::extension(Input::file('avatar.name')));
				Input::upload('avatar', $_SERVER['DOCUMENT_ROOT'] . '/uploads', $photo_name);
				
				$user->avatar = '/uploads/' . $photo_name;
				$user->avatar_small = '/uploads/' . $photo_small;
				$user->save();

				$resize_file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $photo_name;
				$dims = Config::get('Admin::admin.avatar');
				Resizer::open( $resize_file )
					->resize( $dims['width'] , $dims['height'] , 'crop' )
					->save( $resize_file , 100 )
				;

				$dims = Config::get('Admin::admin.avatar_small');
				Resizer::open( $resize_file )
					->resize( $dims['width'] , $dims['height'] , 'crop' )
					->save( $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $photo_small , 100 )
				;
				
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function set_user_status($id = FALSE, $status = 0)
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				$user->status = $status;
				$user->save();
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function delete_user($id = FALSE)
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				$user->delete();
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function update_user_password($id, $args = array())
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				$user->password = Hash::make($args['password']);
				$user->save();
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function reset_user_password($id)
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				$user->password = Hash::make(Config::get('Admin::auth.default_password'));
				$user->save();
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function create_user($args = array())
	{
		$user = new User;
		if ($user) {
			$user->first_name = $args['first_name'];
			$user->last_name = $args['last_name'];
			$user->slug = $user->make_slug($args['slug']);
			$user->email = $args['email'];
			$user->bio = !empty($args['bio']) ? $args['bio'] : '';
			$user->twitter_handle = !empty($args['twitter_handle']) ? $args['twitter_handle'] : '';
			$user->facebook_id = !empty($args['facebook_id']) ? $args['facebook_id'] : '';
			$user->google_plus_id = !empty($args['google_plus_id']) ? $args['google_plus_id'] : '';
			$user->title = !empty($args['title']) ? $args['title'] : '';
			$user->password = Hash::make(Config::get('Admin::auth.default_password'));
			$user->save();
			return TRUE;
		}
		return FALSE;
	}

	public static function update_user($id = FALSE, $args = array())
	{
		if ($id) {
			$user = User::find($id);
			if ($user) {
				$user->first_name = $args['first_name'];
				$user->last_name = $args['last_name'];
				$user->slug = $user->make_slug($args['slug']);
				$user->email = $args['email'];
				$user->bio = !empty($args['bio']) ? $args['bio'] : '';
				$user->twitter_handle = !empty($args['twitter_handle']) ? $args['twitter_handle'] : '';
				$user->facebook_id = !empty($args['facebook_id']) ? $args['facebook_id'] : '';
				$user->google_plus_id = !empty($args['google_plus_id']) ? $args['google_plus_id'] : '';
				$user->title = !empty($args['title']) ? $args['title'] : '';
				$user->save();
				return TRUE;
			}
		}
		return FALSE;
	}
}