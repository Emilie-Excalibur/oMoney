var app = {
    balance: document.querySelector('.balance'),

    init: function() {
        // Ajoute un attribut readonly à l'input
        // Si celui-ci a une valeur différente de 0
        if(app.balance.value != 0) {
            app.balance.readOnly = true;
        } else {
            app.balance.readOnly = false;
        }
    }
}

document.addEventListener('DOMContentLoaded', app.init);
