<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

	public function index()
	{
		$id = $this->Auth->user()['User']['id'];
		$this->set('id', $id);
		$this->render('home');
	}
	public function messages()
	{
		$id = $this->Auth->user()['User']['id'];
		$this->set('id', $id);
		$this->render('messages');
	}
	public function editprofile()
	{
		$id = $this->Auth->user()['User']['id'];
		$this->set('id', $id);
		$this->render('edit');
	}

	public function newmessage()
	{
		$id = $this->Auth->user()['User']['id'];
		$this->set('id', $id);
		$this->render('newmessage');
	}

	public function messagelist($convowith = null)
	{
		if ($convowith === null) {
			$this->redirect('/messages');
			return;
		}

		// print_r($convowith);
		$this->loadModel('User');

		// check kung naa ba ni siya nga tao
		$userExists = $this->User->exists(['User.id' => $convowith]);

		if (!$userExists) {
			$this->redirect('/messages');
			return;
		}

		$id = $this->Auth->user()['User']['id'];

		// check para dili siya mag send sa iyaha kaugalingon
		if ((int)$id === (int)$convowith) {
			$this->redirect('/messages');
		} else {
			$this->set(compact('id', 'convowith'));
			$this->render('messagelist');
		}
	}
}
