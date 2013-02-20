<?php
namespace Blog\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Database as DB;
use Admin\Models\User as User;


class Author extends Eloquent {
	public static $timestamps = true;
	public static $table = 'users';

	public static function get_most_popular($number_authors = 1)
	{
		$query = DB::table('posts')
			->select(array('posts.user_id', DB::raw('count(*) AS number_posts'), 'users.*', 'users_metadata.avatar_small', 'users_metadata.title', 'users_metadata.twitter_handle'))
			->join('users', 'users.id', '=', 'posts.user_id')
			->join('users_metadata', 'users_metadata.user_id', '=', 'posts.user_id')
			->group_by('user_id')
			->order_by('number_posts', 'DESC')
			->take($number_authors)
			->get()
		;

		if (!empty($query)) {
			return $query;
		}
		return FALSE;
	}

	public static function get_authors()
	{
		$query = DB::table('posts')
			->select(array('user_id'))
			->distinct()
			->get()
		;
		$user_ids = array();
		foreach ($query as $v) {
			$user_ids[] = $v->user_id;
		}
		$users = User::with('user_metadata')->where_in('id', $user_ids)->order_by('last_name', 'ASC')->get();
		if ($users) {
			return $users;
		}

		return FALSE;
	}

	public static function get_author_by_slug($slug = FALSE, $num_posts = 4)
	{
		if ($slug) {
			$user = User::with('user_metadata')->where('username', '=', $slug)->first();
			if ($user) {
				return array(
					'author' => $user,
					'posts' => Post::get_posts_by_author($user->id, $num_posts)
				);
			}			
		}

		return FALSE;
	}
}