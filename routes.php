<?php
Router::connect('/', '/auth/login');
Router::connect('/login', '/auth/login');
Router::connect('/logout', '/auth/logout');

Router::connect('/class', '/task');
Router::connect('/subject', '/project');
// Router::connect('/:int', '/user/profile/:1');
// Router::connect('/f/:string/:string', '/event/feed/:1/:2');
?>