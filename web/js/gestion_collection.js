	// Gestion d'une collection c'est à dire d'une relation OneToMany. Exemple un article et des commentaires
	//$container représenter la div qui contient les commentaires déjà existant et le modele « data-prototype » fourni par symfony pour permettre de générer de nouveaux commentaires.
	// le but ici est d'ajouter un bouton "add" qui nous permettra d'ajouter de nouveaux input formatés selon le modèle fourni par symfony.
	function gestion_collection($container) {
	
	// On ajoute un bouton delete à chaque commentaires déjà existants lors de la génération du form
	$container.children('div').each(function() {
        addDeleteButton($(this));
      });
	
	// On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement. Ici, mes entités filles sont constituées de 2input. Je pourrais le passer en parametre de gestion_collection...
    var index = $container.find(':input').length / 2;
	
	// On ajoute un lien dont l'action ajoutera un formulaire pour un nouveau commentaire
	addAddButton($container, index);

	}

    // La fonction qui ajoute un formulaire commentaire
    function addLien($container, index) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Lien n°' + (index+1))
          .replace(/__name__/g, index));

      // On ajoute au prototype un lien pour pouvoir supprimer le commentaire. A noter que la suppression est liée au proto, pas au container entier.
      addDeleteButton($prototype);
	  
	  // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
	
	  // On ajoute le prototype modifié au container
      $container.append($prototype);
	
	  //on ajoute un bouton add tout en bas du container, le précédent s'étant détruit à l'activation afin que le btn add soit tjs en bas. 
	  //Il est important de noter que le btn est lié au container, pas au proto. Il ne sera pas détruit par le btn delete
	  addAddButton($container, index);

    }

    // La fonction qui ajoute un lien de suppression d'un commentaire (de facto, suppression de $my_div passé en paramètre et à laquelle il appartiendra lui même)
    function addDeleteButton($my_div) {
      // Création du lien
      var $deleteButton = $('<a href="#" class="btn btn-danger">Supprimer</a>');
	  
      // Ajout du lien à la brique
      $my_div.append($deleteButton);

      // Ajout du listener sur le clic du lien
      $deleteButton.click(function(e) {
        $my_div.remove();
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
	}
	
	// ajout d'un bouton d'ajout sur $my_div. L'index sera incrémenter pour changer les id des champs du prochaine commentaire
	function addAddButton($my_div, index) {
      // Création du lien
	  var $addButton = $('<div><a href="#" id="add_lien" class="btn btn-default">Ajouter un lien</a></div>');
	  
      // Ajout du lien
	  $my_div.append($addButton);

      // Ajout du listener sur le clic du lien
	  $addButton.click(function(e) {
	  $addButton.remove(); // On détruit le bouton car il ne sera plus tout en bas. addLien se chargera de regare un nouveau bouton plus bas
      addLien($my_div, index);
      e.preventDefault(); // évite qu'un # apparaisse dans l'URL  
      return false;
      }); 
    }