<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Routing\Route;

use Cake\Routing\Route\Route;
use Cake\Utility\Inflector;

/**
 * This route class will transparently inflect the controller and plugin routing
 * parameters, so that requesting `/my_controller` is parsed as `['controller' => 'MyController']`
 */
class InflectedRoute extends Route {

/**
 * Parses a string URL into an array. If it mathes, it will convert the prefix, controller and
 * plugin keys to their camelized form
 *
 * @param string $url The URL to parse
 * @return mixed false on failure, or an array of request parameters
 */
	public function parse($url) {
		$params = parent::parse($url);
		if (!$params) {
			return false;
		}
		if (!empty($params['controller'])) {
			$params['controller'] = Inflector::camelize($params['controller']);
		}
		if (!empty($params['plugin'])) {
			$params['plugin'] = Inflector::camelize($params['plugin']);
		}
		if (!empty($params['prefix'])) {
			$params['prefix'] = Inflector::camelize($params['prefix']);
		}
		return $params;
	}

/**
 * Underscores the prefix, controller and plugin params before passing them on to the
 * parent class
 *
 * @param array $url Array of parameters to convert to a string.
 * @param array $context An array of the current request context.
 *   Contains information such as the current host, scheme, port, and base
 *   directory.
 * @return mixed either false or a string URL.
 */
	public function match(array $url, array $context = array()) {
		if (!empty($url['controller'])) {
			$url['controller'] = Inflector::underscore($url['controller']);
		}
		if (!empty($url['plugin'])) {
			$url['plugin'] = Inflector::underscore($url['plugin']);
		}
		if (!empty($url['prefix'])) {
			$url['prefix'] = Inflector::underscore($url['prefix']);
		}
		return parent::match($url, $context);
	}

}