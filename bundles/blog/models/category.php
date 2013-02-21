<?php

namespace Blog\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Database as DB;
use \Laravel\Config as Config;
use \Laravel\Cache as Cache;

class Category extends Eloquent {
	public static $timestamps = true;
	public static $table = 'categories';

	protected function make_slug($name) 
	{
		$name = preg_replace( '/[^a-z0-9_-]/', '', str_replace(' ', '-', strtolower(trim(trim($name)))));
		return str_replace('--', '-', $name);
	}

	public static function get_categories()
	{
		$key = 'blog_categories';

		if (Cache::has($key)) {
			return Cache::get($key);
		}

		$categories = Category::order_by('title', 'ASC')->get();

		Cache::put($key, $categories, 120);

		return $categories;
	}

	public static function remove_by_id($id = FALSE)
	{
		if ($id) {
			$category = Category::find($id);
			if ($category) {
				$affected = DB::table('posts')
					->where('category_id', '=', $category->id)
					->update(array('category_id' => 1))
				;

				$category->delete();

				$build = Blogrss::build_feed();

				// kill caches
				Cache::forget('blog_categories');

				return TRUE;
			}
		}
		return FALSE;
	}

	public static function get_by_id($id = FALSE)
	{
		if ($id) {
			$cat = Category::find($id);
			if ($cat) {
				return $cat;
			}
		}
		return FALSE;
	}

	public static function save_by_id($id = FALSE, $data = array())
	{
		if ($id) {
			$category = Category::find($id);
			if ($category) {
				$category->title = $data['title'];
				$category->slug = $category->make_slug($data['slug']);
				$category->save();

				// kill caches
				Cache::forget('blog_category_slug_' . $category->slug);
				Cache::forget('blog_category_id_posts_' . $category->id);
				Cache::forget('blog_categories');

				return TRUE;
			}
		}
		return FALSE;
	}	

	public static function store($data = array())
	{
		$category = new Category;
		if ($category) {
			$category->title = $data['title'];
			$category->slug = $category->make_slug($data['slug']);
			$category->save();

			// kill caches
			Cache::forget('blog_categories');

			return TRUE;
		}
		return FALSE;
	}

	public static function get_category_by_slug($slug = FALSE)
	{
		$key = 'blog_category_slug_' . $slug;

		if (Cache::has($key)) {
			return Cache::get($key);
		}

		$category = array();	
		
		if ($slug) {
			$category = Category::where('slug', '=', $slug)->first();
		}

		if (empty($category)) {
			$category = FALSE;
		}

		Cache::put($key, $category, 120);

		return $category;
	}

	public static function get_posts_in_category_by_slug($slug = FALSE) 
	{
		$data = FALSE;

		if ($slug) {
			$category = Category::get_category_by_slug($slug);
			if ($category) {
				$posts = $category->posts()->where('is_published', '=', 1)->order_by('created_at', 'DESC')->paginate(Config::get('Blog::blog.paging_count'));
				$data = array(
					'category' => $category,
					'posts' => $posts,
				);
			}
		}

		return $data;
	}

	public static function get_posts_in_category_by_id($id = FALSE) 
	{
		if ($id) {
			$key = 'blog_category_id_posts_' . $slug;

			if (Cache::has($key)) {
				return Cache::get($key);
			}

			$category = Category::find($id)->get();
			if ($category) {
				$posts = $category->posts()->where('is_published', '=', 1)->order_by('created_at', 'DESC')->get();
				$data = array(
					'category' => $category,
					'posts' => $posts,
				);

				Cache::put($key, $data, 120);

				return $data;
			}
		}

		return FALSE;
	}

	public function posts()
	{
		return $this->has_many('Blog\Models\Post');
	}
}