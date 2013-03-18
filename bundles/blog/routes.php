<?php
Route::controller(array(
	'blog::home',
));

Route::any('blog/search', 'blog::post@search');
Route::any('blog/subscribe', 'blog::rss@subscribe_email');

Route::get('blog/rss', 'blog::rss@feed');

Route::get('blog/categories', 'blog::category@index');
Route::get('blog/categories/(:any)', 'blog::category@index');

Route::get('blog/tags', 'blog::tag@index');
Route::get('blog/tags/(:any)', 'blog::tag@index');

Route::get('blog/authors', 'blog::author@index');
Route::get('blog/authors/(:any)', 'blog::author@author');

Route::get('blog/(:any)', 'blog::post@index');


/* admin blog base route */
Route::get('admin/blog', 'blog::admin.home@index');

/* admin blog post routes */
Route::get('admin/blog/post', 'blog::admin.post@index');
Route::get('admin/blog/post/destroy/(:num)', 'blog::admin.post@destroy');
Route::get('admin/blog/post/create', 'blog::admin.post@create');
Route::post('admin/blog/post/store', 'blog::admin.post@store');
Route::get('admin/blog/post/edit/(:num)', 'blog::admin.post@edit');
Route::post('admin/blog/post/save/(:num)', 'blog::admin.post@save');
Route::get('admin/blog/post/edit-photos/(:num)', 'blog::admin.post@edit_photos');
Route::post('admin/blog/post/save-photos/(:num)', 'blog::admin.post@save_photos');

/* admin blog category routes */
Route::get('admin/blog/category', 'blog::admin.category@index');
Route::get('admin/blog/category/destroy/(:num)', 'blog::admin.category@destroy');
Route::get('admin/blog/category/create', 'blog::admin.category@create');
Route::post('admin/blog/category/store', 'blog::admin.category@store');
Route::get('admin/blog/category/edit/(:num)', 'blog::admin.category@edit');
Route::post('admin/blog/category/save/(:num)', 'blog::admin.category@save');

/* admin blog tag routes */
Route::get('admin/blog/tag', 'blog::admin.tag@index');
Route::get('admin/blog/tag/destroy/(:num)', 'blog::admin.tag@destroy');
Route::get('admin/blog/tag/create', 'blog::admin.tag@create');
Route::post('admin/blog/tag/store', 'blog::admin.tag@store');
Route::get('admin/blog/tag/edit/(:num)', 'blog::admin.tag@edit');
Route::post('admin/blog/tag/save/(:num)', 'blog::admin.tag@save');



View::composer(array('blog::layouts.layout'), function($view)
{
	$url = '/' . Request::uri();
	if ($url === '//') $url = '/';
	$current_uri = array_values(array_filter( explode('/', $url)));
	$view['current_uri'] = '/' . (!empty($current_uri[0]) ? $current_uri[0] : '');

	if (!empty($current_uri[1]) && $current_uri[1] == 'categories' && !empty($current_uri[2])) {
		$view['current_category'] = $current_uri[2];
	} else {
		$view['current_category'] = FALSE;
	}

	// set the build version 
	$view['build_version'] = Config::get('application.build_version');
});