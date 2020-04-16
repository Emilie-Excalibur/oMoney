let app = {
    userEmail: document.querySelector('.new_email'),
    formUpdate: document.querySelector('#update'),

    init: function() {
        app.userEmail.addEventListener('blur', app.handleEmailInputBlur);
        app.formUpdate.addEventListener('submit', app.handleFormSubmit);
    },

    /**
   * Définis si oui ou non le champs email est valide
   * @param {champs du formulaire} field 
   */
    isMailValid: function (field) {
        let fieldValue = field.value;

        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(fieldValue)) {
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
   * Vérifie si le champs email du formulaire est valide
   */
    handleEmailInputBlur: function () {
        if (app.isMailValid(app.userEmail)) {
        // Action à faire si le champs est valide
        app.markFieldAsValid(app.userEmail);

        } else {
        // Action à faire si le champs est invalide
        app.markFieldAsInvalid(app.userEmail);
        }
    },
        
    handleFormSubmit: function (event) {
        let errors = [];
    
        if (app.isMailValid(app.userEmail)) {
          app.markFieldAsValid(app.userEmail);
        } else {
          app.markFieldAsInvalid(app.userEmail);
          errors.push('L\'adresse email n\'est pas valide');
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
}

document.addEventListener('DOMContentLoaded', app.init);
