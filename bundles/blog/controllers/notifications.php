<?php
use Blog\Models\Post as Post;
use \Laravel\Config as Config;

class Blog_Notifications_Controller extends Blog_Base_Controller {
    
    public function post_new_comment($post_id)
    {       
        $disqusApiSecret = Config::get('Blog::blog.disgus_key');; 

        $commentId = isset($_POST['comment']) ? $_POST['comment'] : false;

        $postId = $post_id;

        $post = Post::with(array('user'))->where('id', '=', $postId)->first();

        $postAuthor = $post->user->email; 

        if ($commentId === false || strlen($postAuthor) < 4) {
            return Response::error('500');
        }

        $postAuthor = 'james@booj.com';

        $session = curl_init('http://disqus.com/api/3.0/posts/details.json?api_secret=' . $disqusApiSecret .'&post=' . $commentId . '&related=thread');

        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($session);

        curl_close($session);

        $results = json_decode($result);

        if ($results === NULL) {
            return Response::error('500');
        }

        $author = $results->response->author;

        $thread = $results->response->thread;

        $comment = $results->response->raw_message;

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:admin@booj.com' . '\r\n';

        $subject = 'New comment on ' . $thread->title;

        $message = '<h3>A comment was posted on <a href="' . $thread->link . '#comment-' . $commentId . '">' . $thread->title . '</a></h3><p>' . $author->name . ' wrote:</p><blockquote>' . $comment .'</blockquote><p><a href="http://' . $results->response->forum . '.disqus.com/admin/moderate/#/approved/search/id:' . $commentId . '">Moderate comment</a></p>';

        mail($postAuthor,$subject,$message,$headers);

        exit();
    }
}