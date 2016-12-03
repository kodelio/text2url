<?php

$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'upload';

if (!empty($_FILES)) {
	$tempFile = $_FILES['file']['tmp_name'];       
	$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
	$targetFile =  $targetPath. $_FILES['file']['name'];
	move_uploaded_file($tempFile,$targetFile);
}

foreach ($_FILES as $file) {
	$oldTexte = $file['file']['name'];
	$resultat = $file['file']['name'];
	$resultat = preg_split("/\r\n|\n|\r/", $resultat);
	if (count($resultat) < 15) {
		if (isset($_POST['rawurlencode']) AND $_POST['rawurlencode']) {
			for ($i=0; $i < count($resultat); $i++) { 
				$resultat[$i] = rawurlencode($resultat[$i]);
			}
		}
		else {
			if (isset($_POST['accents']) AND $_POST['accents']) {
				$accent = array('á','à','â','ä','ã','å','ç','é','è','ê','ë','í','ì','î','ï','ñ','ó','ò','ô','ö','õ','ú','ù','û','ü','ý','ÿ','Á','À','Â','Ä','Ã','Å','Ç','É','È','Ê','Ë','Í','Ì','Î','Ï','Ñ','Ó','Ò','Ô','Ö','Õ','Ú','Ù','Û','Ü','Ý','Ÿ');
				$normal = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y','Y');
				for ($i=0; $i < count($resultat); $i++) { 
					$resultat[$i] = str_replace($accent, $normal, $resultat[$i]);
				}
			}
			if (isset($_POST['majuscules']) AND $_POST['majuscules']) {
				$accentM = array('Á','À','Â','Ä','Ã','Å','Ç','É','È','Ê','Ë','Í','Ì','Î','Ï','Ñ','Ó','Ò','Ô','Ö','Õ','Ú','Ù','Û','Ü','Ý','Ÿ');
				$normalM = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y','Y');
				for ($i=0; $i < count($resultat); $i++) { 
					$resultat[$i] = str_replace($accentM, $normalM, $resultat[$i]);
					$resultat[$i] = strtolower($resultat[$i]);
				}
			}
			if (isset($_POST['caracteres']) AND $_POST['caracteres']) {
				if (isset($_POST['choixCarac']) AND $_POST['choixCarac'] == "underscore") {
					for ($i=0; $i < count($resultat); $i++) { 
						$resultat[$i] = preg_replace('/[^a-zA-Z0-9\']/', '_', $resultat[$i]);
						$resultat[$i] = preg_replace('/[\']/', '_', $resultat[$i]);
					}
				}
				else {
					for ($i=0; $i < count($resultat); $i++) { 
						$resultat[$i] = preg_replace('/[^a-zA-Z0-9\']/', '-', $resultat[$i]);
						$resultat[$i] = preg_replace('/[\']/', '-', $resultat[$i]);
					}
				}

			}
			if (isset($_POST['choixCarac']) AND $_POST['choixCarac'] == "underscore") {
				for ($i=0; $i < count($resultat); $i++) { 
					$resultat[$i] = trim($resultat[$i], "_");
					$resultat[$i] = preg_replace('/[_]+/', '_', $resultat[$i]);
				}
			}
			else {
				for ($i=0; $i < count($resultat); $i++) { 
					$resultat[$i] = trim($resultat[$i], "-");
					$resultat[$i] = preg_replace('/[-]+/', '-', $resultat[$i]);
				}
			}
		}
		if (isset($_POST['prefixe']) AND $_POST['prefixe'] != "") {
			for ($i=0; $i < count($resultat); $i++) { 
				$resultat[$i] = $_POST['prefixe'].$resultat[$i];
			}
		}
	}
	else {
		$erreurLignes = "Vous avez entré plus de 15 lignes !";
	}

}
?>