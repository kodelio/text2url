<?php
// TODO : 
// Text area séparé par ; ou saut à la ligne
// Upload multiple fichiers pour récup non
if (isset($_POST['texte'])) {
	$oldTexte = $_POST['texte'];
	$resultat = $_POST['texte'];
	if (isset($_POST['rawurlencode']) AND $_POST['rawurlencode']) {
		$resultat = rawurlencode($resultat);
	}
	else {
		if (isset($_POST['accents']) AND $_POST['accents']) {
			$accent = array('á','à','â','ä','ã','å','ç','é','è','ê','ë','í','ì','î','ï','ñ','ó','ò','ô','ö','õ','ú','ù','û','ü','ý','ÿ','Á','À','Â','Ä','Ã','Å','Ç','É','È','Ê','Ë','Í','Ì','Î','Ï','Ñ','Ó','Ò','Ô','Ö','Õ','Ú','Ù','Û','Ü','Ý','Ÿ');
			$normal = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y','Y');
			$resultat = str_replace($accent, $normal, $resultat);
		}
		if (isset($_POST['majuscules']) AND $_POST['majuscules']) {
			$accentM = array('Á','À','Â','Ä','Ã','Å','Ç','É','È','Ê','Ë','Í','Ì','Î','Ï','Ñ','Ó','Ò','Ô','Ö','Õ','Ú','Ù','Û','Ü','Ý','Ÿ');
			$normalM = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y','Y');
			$resultat = str_replace($accentM, $normalM, $resultat);
			$resultat = strtolower($resultat);
		}
		if (isset($_POST['caracteres']) AND $_POST['caracteres']) {
			if (isset($_POST['choixCarac']) AND $_POST['choixCarac'] == "underscore") {
				$resultat = preg_replace('/[^a-zA-Z0-9\']/', '_', $resultat);
				$resultat = preg_replace('/[\']/', '_', $resultat);
			}
			else {
				$resultat = preg_replace('/[^a-zA-Z0-9\']/', '-', $resultat);
				$resultat = preg_replace('/[\']/', '-', $resultat);
			}

		}
		if (isset($_POST['choixCarac']) AND $_POST['choixCarac'] == "underscore") {
			$resultat = trim($resultat, "_");
			$resultat = preg_replace('/[_]+/', '_', $resultat);
		}
		else {
			$resultat = trim($resultat, "-");
			$resultat = preg_replace('/[-]+/', '-', $resultat);
		}
	}
	if (isset($_POST['prefixe']) AND $_POST['prefixe'] != "") {
		$resultat = $_POST['prefixe'].$resultat;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Text 2 URL</title>
	<link rel="stylesheet" media="screen" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="jumbotron">
					<h2>Text 2 URL <a style="text-decoration: none;" target="_blank" href="https://github.com/kokno/text2url"><i class="fa fa-github"></i></a></h2>
					<p style="font-size: 16px;">Text 2 URL permet de convertir un ou plusieurs mots (ou noms de fichiers) afin d'être utilisable en tant qu'URL propre (pas d'espaces, pas d'accents, pas de majuscules etc ...). La conversion est personnalisable, vous pouvez choisir quels éléments garder ou non.</p>
					<p style="font-size: 16px;" class="text-primary"><b>Exemple : <i>Catalogue à vendre</i> -> <i>catalogue-a-vendre</i></b></p>
				</div>
				<?php 
				if (isset($resultat) and $resultat != "") {
					echo '
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">Résultat <span id="resultat" style="cursor: pointer; float: right;" data-placement="top" title="Copier" data-clipboard-text="'.$resultat.'">Copier <i class="fa fa-clipboard"></i></span></h3>
						</div>
						<div class="panel-body">
							'.$resultat.'
						</div>
					</div>';
				}
				else if (isset($oldTexte) and $oldTexte == "") {
					echo '
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Erreur</h3>
						</div>
						<div class="panel-body">
							Vous n\'avez pas entrez un texte valide !
						</div>
					</div>';
				}
				?>
				<div class="col-lg-12">
					<div class="well">
						<form action="#" method="post" id="convert">
							<fieldset>
								<div class="form-group">
									<label for="texte">Texte à convertir</label>
									<input class="form-control" name="texte" />
								</div>
								<div class="form-group">
									<label for="texte">Préfixe d'URL (facultatif)</label>
									<input class="form-control" name="prefixe" />
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>
											<input type="checkbox" class="choix2" name="accents" checked> Convertir les accents (à -> a, É -> E)
										</label>
									</div>
									<div class="form-group">
										<label>
											<input type="checkbox" class="choix2" name="caracteres" checked> Convertir les espaces et les caractères spéciaux (: / ; _ ' ")
										</label>
									</div>
									<div class="form-group">
										<label>
											<input type="checkbox" class="choix2" name="majuscules" checked> Convertir les majuscules (A -> a)
										</label>
									</div>
									<div class="form-group">
										<label>
											<input type="checkbox" class="choix1" name="rawurlencode" value="choix1"> Convertir avec la fonction PHP rawurlencode()
										</label>
									</div>
								</div>
								<div class="col-md-6" id="radioDiv">
									<div class="form-group">
										<label class="control-label">Caractère de séparation :</label>
										<div class="radio">
											<label>
												<input type="radio" name="choixCarac" id="tiret" value="tiret" checked="">
												Utiliser un "-" (par défaut)
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" name="choixCarac" id="underscore" value="underscore">
												Utiliser un "_"
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<input class="form-control btn-primary" name="submit" value="Valider" type="submit">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/clipboard.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script>
		var clipboard = new Clipboard('#resultat');
		clipboard.on('success', function(e) {
			e.clearSelection();
			id = e.trigger.id;
			$("#"+id).tooltip('show');
		});
	</script>
	<script>
		$('input[class^="choix"]').click(function() {
			var $this = $(this);
			if ($this.is(".choix1")) {
				if ($(".choix1:checked").length > 0) {
					$(".choix2").prop({ disabled: true, checked: false });
					$("#radioDiv").hide();
				} else {
					$(".choix2").prop("disabled", false);
					$("#radioDiv").show();
				}
			}
		});
	</script>
</body>
</html>
