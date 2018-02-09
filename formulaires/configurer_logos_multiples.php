<?php
/*
 * Plugin Logos Multiples
 * (c) 2018 Julien Tessier
 * Distribué sous licence GPL
 *
 */


function formulaires_configurer_logos_multiples_verifier_dist(){
    $erreurs = array();
    // check that mandatory fields are indeed filled out:
    $types = explode("\r\n", _request('types'));
    $erreur = '';
    foreach($types as $type) {
    	list($cle, $valeur) = explode('|', $type);
    	if (!preg_match('/^[a-z0-0_]+$/', $cle)) {
    		$erreur .= "Clé $cle invalide\r\n";
    	}
    }
    if ($erreur) $erreurs['types'] = nl2br(trim($erreur));
   
    return $erreurs;
}