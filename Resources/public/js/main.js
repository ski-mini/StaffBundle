$( document ).ready(function() {
    $('#confirmExtends').click(function(e) {
        var isGood=confirm('Attention ! Les rôles seront réinitialisés et seront strictement égaux au nouveau groupe selectionné.');
        if (!isGood) {
            e.preventDefault();
        }
    });
});