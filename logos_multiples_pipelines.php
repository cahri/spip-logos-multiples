<?php

/*
 * Plugin Logos Multiples
 * (c) 2018 Julien Tessier
 * Distribué sous licence GPL
 *
 */

	function logos_multiples_recuperer_fond($flux) {
		if ($flux['args']['fond'] == 'formulaires/editer_logo') {
			$objet		= $flux['args']['contexte']['objet'];
			$id_objet	= $flux['args']['contexte']['id_objet'];
			$editable	= $flux['args']['contexte']['_options']['editable'];

			if ($editable) {
				$extra = '';
				$valider = FALSE;
				$chercher_logo = charger_fonction('chercher_logo', 'inc');
			    foreach(_logos_multiples_types($objet, $id_objet) as $type => $label) {
					$objet = objet_type($objet);
					$primary = id_table_objet($objet);
			    	$erreur = ''; // @todo '<span class=\'erreur_message\'></span>'
			    	if ($logo = $chercher_logo($id_objet, $primary, $type)) {
			    		$extra .= '<div><h4 class="titre_logos_multiples">'.$label.'</h4></div>'.recuperer_fond('formulaires/inc-apercu-logo', array(
			    			'objet' => $objet,
			    			'id_objet' => $id_objet,
			    			'logo' => $logo[0],
			    			'quoi' => 'logo_'.$type,
			    			'editable' => $editable,
			    		));
			    	} else {
			    		$valider = TRUE;
				    	$extra .= '<div class="ajouter_'.$type.'"><h4 class="titre_logos_multiples">'.$label.'</h4></div>
						<div>
						<label for="logo_'.$cle.'">'._T('info_telecharger_nouveau_logo').'</label>
						'.$erreur.'
						<input type=\'file\' class=\'file\' name=\'logo_'.$type.'\' size="12" id=\'logo_'.$type.'_'.$objet.'_'.$id_objet.'\' value="" />
						</div>';
			    	}

			    }
			    // si on a pas de bouton, le rajouter (par défaut SPIP masque le bouton si on a le logo normal et survol)
				if ($valider) {
					if (strpos($flux['data']['texte'], '<p class="boutons"') === FALSE) $extra .= "<p class=\"boutons\"><input type='submit' class='submit' value='"._T('bouton_upload')."' /></p>";
				    $flux['data']['texte'] = str_replace('class="boutons" style=\'display:none;\'', 'class="boutons"', $flux['data']['texte']);
				}
				$flux['data']['texte'] = str_replace('<!--extra-->', $extra.'<!--extra-->', $flux['data']['texte']);
			}
		}
		return $flux;
	}

	function logos_multiples_formulaire_traiter($flux) {
		if ($flux['args']['form'] == 'editer_logo') {
			$objet		= $flux['args']['args'][0];
			$id_objet	= $flux['args']['args'][1];
			$res = $flux['data'];
			include_spip('action/editer_logo');

			if (!$_FILES) {
				$_FILES = isset($GLOBALS['HTTP_POST_FILES']) ? $GLOBALS['HTTP_POST_FILES'] : array();
			}
			foreach (_logos_multiples_types($objet, $id_objet) as $type => $label) {
				if (_request('supprimer_logo_'.$type)) {
					logo_supprimer($objet, $id_objet, $type);
					$res['message_ok'] = ''; // pas besoin de message : la validation est visuelle
					set_request('logo_up', ' ');
				} else if (isset($_FILES['logo_'.$type]) && $_FILES['logo_'.$type]['error'] == 0) {
					if ($err = logo_modifier($objet, $id_objet, $type, $_FILES['logo_'.$type])) {
						$res['message_erreur'] = $err;
					} else {
						$res['message_ok'] = '';
					} // pas besoin de message : la validation est visuelle
					set_request('logo_up', ' ');
				}
			}

			$flux['data'] = $res;

		}
	}