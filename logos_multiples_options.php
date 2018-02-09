<?php
/*
 * Plugin Logos Multiples
 * (c) 2018 Julien Tessier
 * Distribué sous licence GPL
 *
 */

	function _logos_multiples_types() {
		$types = array();
		include_spip('inc/config');
		if ($config = lire_config('logos_multiples/config/types')) {
			$fond = '';
			$config = explode("\r\n", $config);
			foreach($config as $line) {
				list($type, $label) = explode('|', $line);
				$type = strtolower(preg_replace('/[^a-z0-0_]/', '', $type));
				$types[$type] = $label;
			}
		}
		return $types;
	}