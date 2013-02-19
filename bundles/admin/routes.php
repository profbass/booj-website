<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::controller(array(
	'admin::home',
	'admin::login',
	'admin::logout',
	'admin::reset',
	'admin::users',
	'admin::myaccount',
));

Route::filter('admin_auth', function() {
	if (Auth::guest()) {
		return Redirect::to(URL::to_action('admin::login'));
	}
});

Route::filter('admin_csrf', function() {

});

View::composer('admin::layouts.main', function($view) {
	$url = '/' . Request::uri();
	if ($url === '//') $url = '/';
	$admin_alias = Config::get('Admin::admin.admin_alias');
	$current_uri = array_values(array_filter( explode('/', $url)));

	$view['current_uri'] = '/' . (!empty($current_uri[1]) ? $current_uri[1] : $current_uri[0]);
	if ($view['current_uri'] !== $admin_alias) {
		$view['current_uri'] = $admin_alias . $view['current_uri'];
	}
	$view['main_admin_nav'] = Config::get('Admin::admin.main_nav');
});