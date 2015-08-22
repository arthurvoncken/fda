function makeThumbnailIn(file, imgId) {
	var reader = new FileReader(); // Filereader va transformer le ficher en une url lisible par un navigateur via la balise img
		reader.addEventListener('load', function() { // il faut créer un evt sur ce reader qui se déclenchera à la fin de la transformation du ficher
			document.getElementById(imgId).src = this.result; // je donne le résultat de la transformation au src de la balise img prévue
		}, false);

    reader.readAsDataURL(file); // on lance le reader sur le ficher passé en paramètre
}