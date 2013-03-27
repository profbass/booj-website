<?php

namespace Blog\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Database as DB;
use \Laravel\Input as Input;
use \Laravel\File as File;
use \Laravel\Config as Config;
use Resizer as Resizer;
use \Laravel\Cache as Cache;

class Post extends Eloquent {
	public static $timestamps = true;
	public static $table = 'posts';

	protected function make_slug($name) 
	{
		$name = preg_replace( '/[^a-z0-9_-]/', '', str_replace(' ', '-', strtolower(trim(trim($name)))));
		return str_replace('--', '-', $name);
	}

	public function truncated_content($strlen = 200)
	{
		$p = substr(strip_tags($this->content), 0, $strlen);
		if (strlen($this->content) > $strlen) $p .= '...';
		return $p;
	}

	public static function search_posts($args = array())
	{
		$results = array('posts', 'term');

		if (!empty($args['term'])) {
			$results['term'] = $args['term'];
			$results['posts'] = Post::where('is_published', '=', 1)->where('content', 'LIKE', '%' . $args['term'] . '%')->paginate(20);
			return $results;
		}
		return FALSE;
	}

	public static function remove_post_by_id($id = FALSE)
	{
		if ($id) {
			$post = Post::find($id);
			if ($post) {
				$affected = DB::table('post_tag')->where('post_id', '=', $post->id)->delete();
				$post->delete();

				$build = Blogrss::build_feed();

				// kill caches
				Cache::forget('blog_post_most_popular');
				
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function get_by_id($id = FALSE)
	{
		if ($id) {
			return Post::with(array('category', 'user', 'tags'))->find($id);
		}
		return FALSE;
	}

	public static function save_post_by_id($id = FALSE, $args = array())
	{
		if ($id) {
			$post = Post::find($id);
			if ($post) {
				$post->title = $args['title'];
				$post->short_title = $args['short_title'];
				$post->category_id = $args['category_id'];
				$post->user_id = $args['user_id'];
				$post->content = $args['content'];
				$post->is_published = $args['is_published'] == 1 ? 1 : 0;
				if (!empty($args['created_at'])) {
					$post->created_at = $args['created_at'];
				}
				if (!empty($args['event_date'])) {
					$post->event_date = $args['event_date'];
				}
				$post->slug = $post->make_slug($args['slug']);
				$post->save();

				$ot = $post->tags;
				$old_tags = array();
				if (!empty($ot)) {
					foreach ($ot as $tag) {
						if (empty($args['tag_ids'])) {
							DB::table('post_tag')->where('post_id', '=', $post->id)->where('tag_id', '=', $tag->id)->delete();
						} elseif (!in_array($tag->id, $args['tag_ids'])) {
							DB::table('post_tag')->where('post_id', '=', $post->id)->where('tag_id', '=', $tag->id)->delete();
						} 
						$old_tags[] = $tag->id;
					}
				}
				if (!empty($args['tag_ids'])) {
					foreach ($args['tag_ids'] as $id) {
						if (!in_array($id, $old_tags)) {
							DB::table('post_tag')->insert(array(
								'post_id' => $post->id,
								'tag_id' => $id,
							));
						}
					}
				}

				// kill caches
				Cache::forget('blog_post_slug_' . $post->slug);
				Cache::forget('blog_post_most_popular');

				// build rss
				$build = Blogrss::build_feed();

				return TRUE;
			}
		}
		return FALSE;
	}

	public static function update_post_photo_by_id($id = FALSE, $type = FALSE, $args = array())
	{
		if ($id && $type) {
			$post = Post::find($id);

			$path = Config::get('Blog::blog.photo_path');

			if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $path)) {
				mkdir($_SERVER['DOCUMENT_ROOT'] . $path, 0777);
			}

			if ($post) {
				switch ($type) {
					case 'main-photo':
						$photo_name = uniqid('main-') . '.' . strtolower(File::extension(Input::file('main_photo.name')));
						Input::upload('main_photo', $_SERVER['DOCUMENT_ROOT'] . $path, $photo_name);
						$post->main_photo = $path . '/' . $photo_name;

						$post->save();

						$resize_file = $_SERVER['DOCUMENT_ROOT'] . $path . '/' . $photo_name;
						$dims = Config::get('Blog::blog.main_photo');
						Resizer::open( $resize_file )
							->resize( $dims['width'] , $dims['height'] , 'crop' )
							->save( $resize_file , 100 )
						;

						break;
					
					case 'small-photo':
						$photo_name = uniqid('small-') . '.' . strtolower(File::extension(Input::file('small_photo.name')));
						Input::upload('small_photo', $_SERVER['DOCUMENT_ROOT'] . $path, $photo_name);
						$post->small_photo = $path . '/' . $photo_name;

						$resize_file = $_SERVER['DOCUMENT_ROOT'] . $path . '/' . $photo_name;
						$dims = Config::get('Blog::blog.small_photo');
						Resizer::open( $resize_file )
							->resize( $dims['width'] , $dims['height'] , 'crop' )
							->save( $resize_file , 100 )
						;

						$post->save();
						break;

					default:
						break;
				}

				// kill caches
				Cache::forget('blog_post_slug_' . $post->slug);
				Cache::forget('blog_post_most_popular');

				// build rss
				$build = Blogrss::build_feed();

				return TRUE;
			}
		}
		return FALSE;
	}

	public static function create_new($args = array())
	{
		$post = new Post;
		if ($post) {
			$post->title = $args['title'];
			$post->short_title = $args['short_title'];
			$post->category_id = $args['category_id'];
			$post->user_id = $args['user_id'];
			$post->content = $args['content'];
			$post->is_published = $args['is_published'] == 1 ? 1 : 0;
			if (!empty($args['created_at'])) {
				$post->created_at = $args['created_at'];
			}
			if (!empty($args['event_date'])) {
				$post->event_date = $args['event_date'];
			}			
			$post->slug = $post->make_slug($args['title']);

			$path = Config::get('Blog::blog.photo_path');

			if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $path)) {
				mkdir($_SERVER['DOCUMENT_ROOT'] . $path, 0777);
			}

			$main_photo_name = uniqid('main-') . '.' . strtolower(File::extension(Input::file('main_photo.name')));
			Input::upload('main_photo', $_SERVER['DOCUMENT_ROOT'] . $path, $main_photo_name);
			$post->main_photo = $path . '/' . $main_photo_name;

			$small_photo_name = uniqid('small-') . '.' . strtolower(File::extension(Input::file('small_photo.name')));
			Input::upload('small_photo', $_SERVER['DOCUMENT_ROOT'] . $path, $small_photo_name);
			$post->small_photo = $path . '/' . $small_photo_name;

			$post->save();

			if (!empty($args['tag_ids'])) {
				foreach ($args['tag_ids'] as $id) {
					DB::table('post_tag')->insert(array(
						'post_id' => $post->id,
						'tag_id' => $id,
					));
				}
			}

			$resize_file = $_SERVER['DOCUMENT_ROOT'] . $path . '/' . $main_photo_name;
			$dims = Config::get('Blog::blog.main_photo');
			Resizer::open( $resize_file )
				->resize( $dims['width'] , $dims['height'] , 'crop' )
				->save( $resize_file , 100 )
			;

			$resize_file = $_SERVER['DOCUMENT_ROOT'] . $path . '/' . $small_photo_name;
			$dims = Config::get('Blog::blog.small_photo');
			Resizer::open( $resize_file )
				->resize( $dims['width'] , $dims['height'] , 'crop' )
				->save( $resize_file , 100 )
			;			

			// build rss
			$build = Blogrss::build_feed();

			return TRUE;
		}
		return FALSE;
	}

	public static function get_post_from_uri($slug = FALSE) 
	{
		$key = 'blog_post_slug_' . $slug;

		if (Cache::has($key)) {
			// update the view count and last viewed
			$post = Post::where('slug', '=', $slug)->first();
			if ($post) {
				$post->number_views += 1;
				$post->viewed_at = new \DateTime;
				$post->save();
			}
			return Cache::get($key);
		}

		$data = FALSE;

		$post = Post::with(array('category', 'tags', 'user'))->where('slug', '=', $slug)->first();
	

		if ($post) {
			// update the view count and last viewed
			$post->number_views += 1;
			$post->viewed_at = new \DateTime;
			$post->save();

			$similar_by_category = Post::with(array('category', 'tags', 'user'))
				->where('is_published', '=', 1)
				->where('category_id', '=', $post->category->id)
				->where('id', '!=', $post->id)
				->order_by('created_at', 'DESC')
				->take(Config::get('Blog::blog.similar_category_count'))
				->get()
			;			

			$similar_by_tags = array();
			$tags = array();
			$valid_ids = array();
			if (!empty($post->tags)) {
				foreach ($post->tags as $tag) {
					$tags[] = $tag->id;
				}
				if (!empty($tags)) {
					$similar_tag_ids = DB::table('post_tag')->where_in('tag_id', $tags)->take(Config::get('Blog::blog.similar_tag_count'))->get(array('post_id'));
					
					if (!empty($similar_tag_ids)) {
						foreach ($similar_tag_ids as $obj) {
							if ($obj->post_id != $post->id) {
								$valid_ids[] = $obj->post_id;
							}
						}
						if (!empty($valid_ids)) {
							$similar_by_tags = Post::with(array('category', 'tags', 'user'))
								->where('is_published', '=', 1)
								->where_in('id', $valid_ids)
								->order_by('created_at', 'DESC')
								->get()
							;
						}
					}
				}
			}

			$previous = Post::where('created_at', '<', $post->created_at)
				->where('is_published', '=', 1)
				->where('id', '!=', $post->id)
				->order_by('created_at', 'DESC')
				->take(1)
				->get()
			;

			$next = Post::where('created_at', '>', $post->created_at)
				->where('is_published', '=', 1)
				->where('id', '!=', $post->id)
				->order_by('created_at', 'ASC')
				->take(1)
				->get()
			;

			$random = Post::where('id', '!=', $post->id)
				->where('is_published', '=', 1)
				->order_by(DB::raw(''), DB::raw('RAND()'))
				->take(1)
				->get()
			;

			if ($post) {
				$data = array(
					'post' => $post,
					'similar_posts_by_category' => $similar_by_category,
					'similar_posts_by_tags' => $similar_by_tags,
					'next_post' => !empty($next) ? $next[0] : FALSE,
					'previous_post' => !empty($previous) ? $previous[0] : FALSE,
					'random_post' => !empty($random) ? $random[0] : FALSE,
				);

				Cache::put($key, $data, 120);
			}
		}

		return $data;
	}

	public static function get_most_popular_posts($count = 3)
	{
		$key = 'blog_post_most_popular';

		if (Cache::has($key)) {
			return Cache::get($key);
		}

		$post = Post::where('is_published', '=', 1)->order_by('viewed_at', 'DESC')->order_by('number_views', 'DESC')->take($count)->get();
		
		if ($post) {
			Cache::put($key, $post, 120);
			return $post;
		}
		return FALSE;
	}

	public static function get_posts_by_author($id = FALSE, $count = 4)
	{
		$posts = Post::with('category', 'user')
			->where('is_published', '=', 1)
			->where('user_id', '=', $id)
			->order_by('created_at', 'DESC')
			->paginate($count)
		;
		if ($posts) {
			return $posts;
		}
		return FALSE;
	}

	public static function get_posts($count = FALSE)
	{
		if (!$count) {
			$count = Config::get('Blog::blog.posts_per_page');
		}
		return Post::with(array('category', 'user'))
			->order_by('created_at', 'DESC')
			->where('is_published', '=', 1)
			->paginate($count)
		;
	}

	public static function get_posts_for_admin()
	{
		return Post::with(array('category', 'tags'))
			->order_by('created_at', 'DESC')
			->paginate(20)
		;
	}

	public static function store($data = array())
	{
		$post = new Post;
		if ($post) {
			$post->title = $data['title'];
			$post->content = $data['content'];
			$post->blurb = $data['blurb'];
			$post->slug = $post->make_slug($data['title']);
			$post->save();
			return TRUE;
		}
		return FALSE;
	}

	public function tags()
	{
		return $this->has_many_and_belongs_to('Blog\Models\Tag');
	}

	public function category()
	{
		return $this->belongs_to('Blog\Models\Category');
	}

	public function user()
	{
		return $this->belongs_to('Admin\Models\User');
	}
}
