<?php
Autoloader::map(array(
    'Blog_Base_Controller' => Bundle::path('blog').'controllers/base.php',
    'Blog_Admin_Base_Controller' => Bundle::path('blog/admin').'controllers/admin/base.php',
));
Autoloader::namespaces(array(
    'Blog\Models' => Bundle::path('blog').'models',
    'Blog\Libraries' => Bundle::path('blog').'libraries',
));