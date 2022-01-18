document.addEventListener("DOMContentLoaded", () => {

    //logica bottone ordinamento dei risultati
    document.querySelector('.sort-direction').addEventListener('click', (e) => {
        console.log(e.target);
        let input = document.querySelector('input[name="sortDirection"]');
        input.value = (input.value == 'ASC') ? 'DESC' : 'ASC';
        document.querySelector('#sidebar-form').submit();
    });

    //autosubmit della form al cambio dei valori degli input
    document.querySelectorAll('#sidebar-form input').forEach(function (el) {
        el.addEventListener('change', e => {
            document.querySelector('#sidebar-form').submit();
        });
    });

    //set del numero pagina al click sui pulsanti della paginazione
    //coiao
    document.querySelectorAll('.page-item:not(.active)').forEach(function (el) {
        el.addEventListener('click', (e) => {
            document.querySelector('input#pageNumber').value = e.target.parentElement.getAttribute('page-value');
            document.querySelector('#sidebar-form').submit();
        });
    });

});
