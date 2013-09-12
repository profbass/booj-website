<?php

use Laravel\CLI\Command as Command;
use \Laravel\Database as DB;

class Content_Setup_Task {

	/**
	 * php artisan content::setup
	 */
	public function run($arguments)
	{
		Command::run(array('bundle:publish', 'content'));	

		$id = DB::table('menu_items')->insert_get_id(array(
			'pretty_name' => 'Home',
			'uri' => '/',
			'controller' => 'home',
			'parent_id' => 0,
			'display_order' => 0,
			'meta_title' => 'Home',
		));
		$affected = DB::table('cms_pages')->insert(array('menu_item_id' => $id, 'content' => '<h2>Homepage</h2>'));
		
		$id = DB::table('menu_items')->insert_get_id(array(
			'pretty_name' => 'About',
			'uri' => '/about',
			'controller' => 'cms',
			'parent_id' => 0,
			'display_order' => 0,
			'meta_title' => 'About',
		));
		$affected = DB::table('cms_pages')->insert(array('menu_item_id' => $id, 'content' => '<h2>about</h2>'));

		$id = DB::table('menu_items')->insert_get_id(array(
			'pretty_name' => 'teams',
			'uri' => '/teams',
			'controller' => 'cms',
			'parent_id' => 0,
			'display_order' => 0,
			'meta_title' => 'teams',
		));
		$affected = DB::table('cms_pages')->insert(array('menu_item_id' => $id, 'content' => '<h2>teams</h2>'));

		$id = DB::table('menu_items')->insert_get_id(array(
			'pretty_name' => 'clients',
			'uri' => '/clients',
			'controller' => 'cms',
			'parent_id' => 0,
			'display_order' => 0,
			'meta_title' => 'clients',
		));
		$affected = DB::table('cms_pages')->insert(array('menu_item_id' => $id, 'content' => '<h2>clients</h2>'));

		$id = DB::table('menu_items')->insert_get_id(array(
			'pretty_name' => 'events',
			'uri' => '/events',
			'controller' => 'cms',
			'parent_id' => 0,
			'display_order' => 0,
			'meta_title' => 'events',
		));
		$affected = DB::table('cms_pages')->insert(array('menu_item_id' => $id, 'content' => '<h2>events</h2>'));

		$affected = DB::table('menu_items')->insert(array(
			'pretty_name' => 'Contact Us',
			'uri' => '/contact-us',
			'controller' => 'cms',
			'parent_id' => 0,
			'display_order' => 1,
			'meta_title' => 'Contact Us',
		));

		$affected = DB::table('menu_items')->insert(array(
			'pretty_name' => 'Blog',
			'uri' => '/blog',
			'controller' => 'controller',
			'parent_id' => 0,
			'display_order' => 1,
			'meta_title' => 'Blog',
		));

		echo ($affected) ? 'Page created successfully!' : 'Error creating page!';
	}
}