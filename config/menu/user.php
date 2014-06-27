<?php

$items = array();

if (Auth::instance()->logged_in())
{
	$items[] = array(
		'url' => Route::get('dbauth')->uri(array('username' => Auth::instance()->get_user())),
		'tooltip' => 'Change your password',
		'title' => 'Password',
	);
}
return array('items' => $items);
