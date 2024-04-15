<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
// Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
// Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/', [
	'controller' => 'pages', 'action' => 'index'
]);
Router::connect('/messages', [
	'controller' => 'pages', 'action' => 'messages'
]);
Router::connect('/edit', [
	'controller' => 'pages', 'action' => 'editprofile'
]);
Router::connect('/newmessage', [
	'controller' => 'pages', 'action' => 'newmessage'
]);

Router::connect('/getcontacts', [
	'controller' => 'users', 'action' => 'getcontacts'
]);

Router::connect(
	'/messagelist/:convowith',
	[
		'controller' => 'pages', 'action' => 'messagelist'
	],
	['pass' => ['convowith']]
);

Router::connect(
	'/getchats/:convowith',
	[
		'controller' => 'messages', 'action' => 'getchats'
	],
	['pass' => ['convowith']]
);

Router::connect('/login', [
	'controller' => 'users', 'action' => 'login'
]);

Router::connect('/signin', [
	'controller' => 'users', 'action' => 'signin', '[method]' => 'POST'
]);

Router::connect('/updateprofile', [
	'controller' => 'users', 'action' => 'updateprofile', '[method]' => 'POST'
]);

Router::connect('/signup', [
	'controller' => 'users', 'action' => 'signup'
]);

Router::connect('/register', [
	'controller' => 'users', 'action' => 'register', '[method]' => 'POST'
]);

Router::connect('/directlogin', [
	'controller' => 'users', 'action' => 'directlogin'
]);

Router::connect('/logout', [
	'controller' => 'users', 'action' => 'logout'
]);

Router::connect('/getuser', [
	'controller' => 'users', 'action' => 'getuser'
]);

Router::connect('/sendmessage', [
	'controller' => 'messages', 'action' => 'sendmessage'
]);

Router::connect('/convolist', [
	'controller' => 'messages', 'action' => 'convolist'
]);

Router::connect('/deleteconvo', [
	'controller' => 'messages', 'action' => 'deleteconvo'
]);

Router::connect('/deletemessage', [
	'controller' => 'messages', 'action' => 'deletemessage'
]);

Router::connect('/getimgs', [
	'controller' => 'users', 'action' => 'getimgs'
]);
