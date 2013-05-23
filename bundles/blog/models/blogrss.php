<?php
namespace Blog\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \XMLWriter as XMLWriter;
use \Laravel\Config as Config;

class Blogrss extends Eloquent {

    public static function build_feed()
    {
    	$host = 'http://' . $_SERVER['HTTP_HOST'];
    	$posts = Post::get_posts(15);
		@date_default_timezone_set("GMT"); 
		$writer = new XMLWriter();
		$uri = $_SERVER['DOCUMENT_ROOT'] . '/rss/feed.xml';

		if (!is_dir($_SERVER['DOCUMENT_ROOT'] . '/rss')) {
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/rss', 0777);
		}

		touch($uri);
		$uri = realpath($uri);

		$writer->openURI($uri); 
		$writer->startDocument('1.0'); 
		$writer->setIndent(4); 

		// declare it as an rss document 
		$writer->startElement('rss'); 
		$writer->writeAttribute('version', '2.0'); 
		$writer->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom'); 
		$writer->startElement("channel"); 
		
		//---------------------------------------------------- 
		$writer->writeElement('title', Config::get('Blog::blog.blog_name'));
		$writer->writeElement('description', Config::get('Blog::blog.blog_description')); 
		$writer->writeElement('link', $host . Config::get('Blog::blog.blog_url')); 
		$writer->writeElement('pubDate', date("D, d M Y H:i:s e")); 
		//---------------------------------------------------- 

		if (!empty($posts)) {
			foreach ($posts->results as $post) {
				$writer->startElement("item"); 
					$writer->writeElement('title', $post->title); 
					$writer->writeElement('link', $host . '/blog/' . $post->slug ); 
					$writer->startElement('description');
						$writer->writeCData(str_replace('src="', 'src="' . $host, $post->content));
					$writer->endElement();
					$writer->writeElement('guid', $host . '/blog/' . $post->slug ); 
					$writer->writeElement('pubDate', date("D, d M Y H:i:s e", strtotime($post->created_at)));
					if (!empty($post->category)) { 
						$writer->startElement('category'); 
						    $writer->writeAttribute('domain', $host . '/categories/' . $post->category->slug); 
						    $writer->text($post->category->title); 
						$writer->endElement();
					}
				$writer->endElement();
			}
		}

		// End channel 
		$writer->endElement(); 

		// End rss 
		$writer->endElement(); 

		$writer->endDocument(); 

		$writer->flush(); 
	}
}