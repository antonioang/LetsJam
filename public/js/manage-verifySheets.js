document.addEventListener("DOMContentLoaded", ()=>{
    const btnsVerify = document.querySelectorAll('[data-verify]')
    btnsVerify.forEach((bt) => {
        const span = bt.querySelector('span')
        span.addEventListener('click', function() {
            const modal = document.querySelector('#confirm-verify-modal');
            modal.style.display = 'flex';
            const btn = modal.querySelector('button')
            btn.addEventListener('click',function(){
                verifySheet(bt.dataset.verify).then(() => {
                    modal.style.display = 'none';
                    const badge = document.getElementById(bt.dataset.verify);
                    if (badge !== null && badge.classList.contains('not-verified-badge')) {
                        badge.classList.remove('not-verified-badge')
                    } else {
                        const wrap = document.querySelector('.left-container')
                        let p = document.createElement('p');
                        p.innerHTML = 'Lo spartito è stato verificato con successo';
                        p.classList.add('mt-4');
                        p.style.fontStyle = 'bold';
                        p.style.color = '#3763EB';
                        wrap.appendChild(p);
                    }
                    bt.style.display='none';
                })
            })
        })
    })
})

async function verifySheet(id) {
    let formData = new FormData();
    formData.append("musicSeetId", id);
    return await fetch('/admin/verifyMusicsheet', {
        method: "POST",
        ContentType: "multipart/form-data",
        processData: false,
        body: formData
    }).then((response) => {
        return response
    })
}