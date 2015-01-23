<?php

class Controller_WebDB_DBAuth extends Controller_Base {

	public function action_index()
	{
		$auth = Auth::instance();

		// Must use the DB Auth driver if we're changing the DB user's password.
		if (get_class($auth) != 'Auth_DB')
		{
			$this->add_template_message('The DB Auth driver is not enabled.', 'notice');
			return;
		}

		// Must be logged in to change password.
		if ( ! $auth->logged_in())
		{
			$this->add_flash_message('Please log in before attempting to change your password.', 'info');
			$return_to = Route::get('dbauth')->uri();
			$this->redirect(Route::get('login')->uri().URL::query(array('return_to' => $return_to)));
		}

		// Set up view.
		$this->view = View::factory('webdb/dbauth');
		$this->template->content = $this->view;

		// Change password. @TODO Give this its own action.
		$password = $this->request->post('password');
		if ($password)
		{
			if ($password != $this->request->post('password_verification'))
			{
				$this->add_template_message('The passwords that you entered do not match.');
			} else
			{
				// @TODO This should probably be handled by the dbauth module,
				// but Auth doesn't have a standard password-setting system.
				$config = Kohana::$config->load('database')->default;
				$config['connection']['username'] = $auth->get_user();
				$config['connection']['password'] = $auth->password($auth->get_user());
				$db = Database::instance('dbauth', $config);
				$sql = "SET PASSWORD = PASSWORD(".$db->quote($password).")";
				$db->query(NULL, $sql);
				$auth->logout();
				Session::instance()->destroy();
				$this->add_flash_message('Your password has been changed. Please log in again.', 'info');
				$this->redirect(Route::url('login', array(), TRUE));
			}
		}
	}

}
