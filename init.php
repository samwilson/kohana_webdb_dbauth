<?php

Route::set('dbauth', 'dbauth')->defaults(array(
	'directory' => 'WebDB',
	'controller' => 'DBAuth',
	'action' => 'index',
));
