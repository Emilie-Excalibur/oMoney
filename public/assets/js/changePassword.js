var app = {
    // Sélections des champs HTML
    UserPassword: document.querySelector('.new_password'),
    userPasswordConf: document.querySelector('.new_password_conf'),
    formPassword: document.querySelector('#form-password'),

  
    init: function () {
      app.UserPassword.addEventListener('blur', app.handleInputPasswordBlur);
      app.userPasswordConf.addEventListener('blur', app.handleInputChekPasswordBlur);
      app.formPassword.addEventListener('submit', app.handleFormSubmit);
    },
  
    /**
     * Définis si oui ou non un champs est valide
     * @param {champs du formulaire} field 
     */
    isFieldValid: function (field) {
      // Récupère le contenu du champs
      let fieldValue = field.value;
  
      // Le champs est valide s'il contient au moins 3 caractères
      if (fieldValue.length < 3) {
        return false;
      } else {
        return true;
      }
    },

    /**
     * Définis si oui ou non le champs new_password_conf est valide
     * @param {champs du formulaire} field 
     */
    isPasswordValid: function(field) {
      // Récupère le contenu du champs new_password
      let passwordToCompare = app.UserPassword.value;
  
      // Récupère le contenu du champs
      let fieldValue = field.value;
  
      // Compare si les 2 champs contiennent strictement la même valeur
      if(fieldValue === passwordToCompare) {
        return true;
      } else {
        return false;
      }
    },
  
    /**
     * Modifie le css du champs pour le passer visuellement en valid
     * @param {champs du formulaire} field 
     */
    markFieldAsValid: function (field) {
      field.classList.add('valid');
      field.classList.remove('invalid');
    },
  
    markFieldAsInvalid: function (field) {
      field.classList.add('invalid');
      field.classList.remove('valid');
    },
  
  
    /**
     * Vérifie si le champs new_password du formulaire est valide
     */
    handleInputPasswordBlur: function () {
      if (app.isFieldValid(app.UserPassword)) {
        // Action à faire si le champs est valide
        app.markFieldAsValid(app.UserPassword);
  
      } else {
        // Action à faire si le champs est invalide
        app.markFieldAsInvalid(app.UserPassword);
      }
    },
  
    /**
     * Vérifie si le champs new_password_conf du formulaire est valide
     */
    handleInputChekPasswordBlur: function () {
      if (app.isPasswordValid(app.userPasswordConf)) {
        // Action à faire si le champs est valide
        app.markFieldAsValid(app.userPasswordConf);
  
      } else {
        // Action à faire si le champs est invalide
        app.markFieldAsInvalid(app.userPasswordConf);
      }    
    },
  
    /**
     * Vérifie les champs lors de la soumission du formulaire
     * @param {*} event 
     */
    handleFormSubmit: function (event) {
      let errors = [];
  
      // Refait une étape de validation des champs lors de la soumission du formulaire
      // Ainsi, même si les champs sont vides, la classe invalide est appliquée
      if (app.isFieldValid(app.UserPassword)) {
        // Action à faire si le champs est valide
        app.markFieldAsValid(app.UserPassword);
  
      } else {
        // Action à faire si le champs est invalide
        app.markFieldAsInvalid(app.UserPassword);
        errors.push('Le champ mot de passe doit faire au moins 3 caractères');
      }
  
        // Vérifie si new_password = new_password_conf
      if (app.isPasswordValid(app.userPasswordConf)) {
        // Action à faire si le champs est valide
        app.markFieldAsValid(app.userPasswordConf);
  
      } else {
        // Action à faire si le champs est invalide
        app.markFieldAsInvalid(app.userPasswordConf);
        errors.push('Le mot de passe doit correspondre');
      }
  
      let errorsContainer = document.querySelector('#errors');
  
      // Réinitialise le conteneur d'erreurs
      errorsContainer.innerHTML = '';
  
      // Boucle sur les erreurs pour les ajouter au conteneur
      for (let index in errors) {
  
        errorsContainer.innerHTML += '<div>' + errors[index] + '</div>';
      }
  
      // Affiche le conteneur d'erreur UNIQUEMENT s'il y a au moins 1 erreur
      // Si le tableau n'est pas vide
      if (errors.length > 0) {
  
        // Affiche l'erreur
        errorsContainer.style.display = "block";
  
        // Empêche la soumission du formulaire
        event.preventDefault();
      }
    }
  };
  
  
  document.addEventListener('DOMContentLoaded', app.init);