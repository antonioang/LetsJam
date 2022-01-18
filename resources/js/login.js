window.addEventListener('load', ()=>{
    document.querySelector('div.button').addEventListener('click', ()=>{
        document.querySelector('form').submit();
    })
});