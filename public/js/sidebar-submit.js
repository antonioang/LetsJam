document.addEventListener("DOMContentLoaded", ()=>{

    //logica bottone ordinamento dei risultati
    document.querySelector('.sort-direction').addEventListener('click', (e)=>{
        console.log(e.target);
        let input = document.querySelector('input[name="sortDirection"]');
        input.value = (input.value == 'ASC') ? 'DESC' : 'ASC';
        document.querySelector('#sidebar-form').submit();
    });

    //autosubmit della form al cambio dei valori degli input
    document.querySelectorAll('#sidebar-form input').forEach(function (el){
        el.addEventListener('change', e => {
            document.querySelector('#sidebar-form').submit();
        });
    });
});

function goToSong(id) {
    window.location.href = `/songs/${id}`;
}
function goToSheet(id) {
    window.location.href = `/musicsheets/${id}`;
}
