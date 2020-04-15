var app = {
    balance: document.querySelector('.balance'),
    form: document.querySelector('#form-retrait'),

    init: function() {
        if(app.balance.value != 0) {
            app.balance.readOnly = true;
            } else {
                app.balance.readOnly = false;
            }
    }
}

document.addEventListener('DOMContentLoaded', app.init);
