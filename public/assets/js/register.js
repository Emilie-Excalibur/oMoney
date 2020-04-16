var app = {
  // Sélections des champs HTML
  inputUsername: document.querySelector('.username'),
  inputMail: document.querySelector('.email'),
  inputPassword: document.querySelector('.password_1'),
  inputCheckPassword: document.querySelector('.password_2'),
  form: document.querySelector('#register-form'),

  init: function () {

    app.inputUsername.addEventListener('blur', app.handleinputUsernameBlur);
    app.inputMail.addEventListener('blur', app.handleEmailInputBlur);
    app.inputPassword.addEventListener('blur', app.handleInputPasswordBlur);
    app.inputCheckPassword.addEventListener('blur', app.handleInputChekPasswordBlur);
    app.form.addEventListener('submit', app.handleFormSubmit);
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
   * Définis si oui ou non le champs email est valide
   * @param {champs du formulaire} field 
   */
  isMailValid: function (field) {
    // Récupère le contenu du champs
    let fieldValue = field.value;

    // Le champs est valide s'il est sous la forme Chaine.Avec-des_caractères/spéciaux1!@nomdomaine.domaine
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(fieldValue)) {
      return true;
    } else {
      return false;
    }
  },

  /**
   * Définis si oui ou non le champs password_2 est valide
   * @param {champs du formulaire} field 
   */
  isPasswordValid: function(field) {
    // Récupère le contenu du champs password_1
    let passwordToCompare = app.inputPassword.value;

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
   * Vérifie si le champs username du formulaire est valide
   */
  handleinputUsernameBlur: function () {
    if (app.isFieldValid(app.inputUsername)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputUsername);
    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputUsername);
    }
  },

  /**
   * Vérifie si le champs email du formulaire est valide
   */
  handleEmailInputBlur: function () {
    if (app.isMailValid(app.inputMail)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputMail);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputMail);
    }
  },

  /**
   * Vérifie si le champs password_1 du formulaire est valide
   */
  handleInputPasswordBlur: function () {
    if (app.isFieldValid(app.inputPassword)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputPassword);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputPassword);
    }
  },

  /**
   * Vérifie si le champs password_2 du formulaire est valide
   */
  handleInputChekPasswordBlur: function () {
    if (app.isPasswordValid(app.inputCheckPassword)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputCheckPassword);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputCheckPassword);
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
    if (app.isFieldValid(app.inputUsername)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputUsername);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputUsername);

      errors.push('Le champ nom doit faire au moins 3 caractères');
    }

    if (app.isMailValid(app.inputMail)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputMail);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputMail);

      errors.push('L\'adresse email n\'est pas valide');
    }    

    // Revérifie aussi le mot de passe
    if (app.isFieldValid(app.inputPassword)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputPassword);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputPassword);
      errors.push('Le champ mot de passe doit faire au moins 3 caractères');
    }

      // Vérifie si password_1 = password_2
    if (app.isPasswordValid(app.inputCheckPassword)) {
      // Action à faire si le champs est valide
      app.markFieldAsValid(app.inputCheckPassword);

    } else {
      // Action à faire si le champs est invalide
      app.markFieldAsInvalid(app.inputCheckPassword);
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

