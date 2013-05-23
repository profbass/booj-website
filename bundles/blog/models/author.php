<?php
namespace Blog\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Database as DB;
use Admin\Models\User as User;
use \Laravel\Cache as Cache;

class Author extends Eloquent {
	public static $timestamps = true;
	public static $table = 'users';

	public static function get_most_popular($number_authors = 1, $exclude_array = array())
	{
		$key = 'most_popular_authors';

		if (Cache::has($key)) {
			return Cache::get($key);
		}

		if (empty($exclude_array)) {
			$exclude_array = array(0);
		}

		$query = DB::table('posts')
			->select(array('posts.user_id', DB::raw('count(*) AS number_posts'), 'users.*', 'users_metadata.avatar_small', 'users_metadata.title', 'users_metadata.twitter_handle'))
			->join('users', 'users.id', '=', 'posts.user_id')
			->join('users_metadata', 'users_metadata.user_id', '=', 'posts.user_id')					
			->where_not_in('users.id', $exclude_array)
			->group_by('user_id')
			->order_by('number_posts', 'DESC')
			->take($number_authors)
			->get()
		;

		if (!empty($query)) {
			Cache::put($key, $query, 120);
			return $query;
		}

		return FALSE;
	}

	public static function get_authors()
	{
		$key = 'blog_authors';

		if (Cache::has($key)) {
			return Cache::get($key);
		}

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
			Cache::put($key, $users, 120);
			return $users;
		}

		return FALSE;
	}

	public static function get_author_by_slug($slug = FALSE, $num_posts = 4)
	{
		if ($slug) {
			$key = 'blog_author_' . $slug;

			if (Cache::has($key)) {
				return Cache::get($key);
			}

			$user = User::with('user_metadata')->where('username', '=', $slug)->first();
			
			if ($user) {
				
				$data = array(
					'author' => $user,
					'posts' => Post::get_posts_by_author($user->id, $num_posts)
				); 

				Cache::put($key, $data, 120);

				return $data;
			}			
		}

		return FALSE;
	}
}