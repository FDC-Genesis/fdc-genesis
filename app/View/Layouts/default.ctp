<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->fetch('meta');
	echo $this->Html->css('bootstrap');
	echo $this->Html->css('choosen');
	echo $this->Html->css('datepicker');
	// echo $this->Html->script('angular');
	?>
	<style>
		.error-message {
			color: red;
		}

		.customdelete {
			animation: cdelete 2s 1 ease-in-out;
		}

		@keyframes cdelete {
			from {
				opacity: 1;
			}

			to {
				opacity: 0;
			}
		}
	</style>
</head>

<body>

	<?php echo $this->fetch('content'); ?>

</body>

</html>