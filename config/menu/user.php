<?php

$items = array();

if (get_class(Auth::instance()) == 'Auth_DB' AND Auth::instance()->logged_in())
{
	$items[] = array(
		'url' => Route::get('dbauth')->uri(array('username' => Auth::instance()->get_user())),
		'tooltip' => 'Change your password',
		'title' => 'Password',
	);
}
return array('items' => $items);
