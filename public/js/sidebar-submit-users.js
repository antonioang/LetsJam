document.addEventListener("DOMContentLoaded", () => {
    let wrapperPromote = document.getElementById('newAdmins')
    let wrapperDelete = document.getElementById('deleteAdmins')
    let amichetti = document.querySelectorAll('.user-card')
    let users = [];
    amichetti.forEach((amico) => {
        amico.querySelector('#deleteUser').addEventListener('click', function (e) {
            fillForm(wrapperDelete, users, e)
        })
        amico.querySelector('#promoteUser').addEventListener('click', function (e) {
            fillForm(wrapperPromote, users, e)
        })
    })
});

function fillForm(wrapper, users, amico) {
    if (users.includes(amico.currentTarget.dataset.user)) {
        return
    } else {
        users.push(amico.currentTarget.dataset.user)
    }
    let newAdmin = document.createElement('input')
    newAdmin.style.height = '40px'
    newAdmin.style.width = '40px'
    newAdmin.style.color = '#ffffff'
    let div = document.createElement('div')
    div.style.paddingTop = '16px'
    div.style.display = 'flex'
    div.style.alignItems = 'center'
    let label = document.createElement('label')
    label.innerHTML = amico.currentTarget.dataset.username;
    label.style.color = '#ffffff'
    label.style.marginLeft = '24px'
    newAdmin.setAttribute('type', 'checkbox')
    newAdmin.setAttribute('value', amico.currentTarget.dataset.user)
    newAdmin.setAttribute('checked', 'true')
    newAdmin.setAttribute('name', 'userIds')
    div.appendChild(newAdmin);
    div.appendChild(label);
    wrapper.appendChild(div)
    console.log(newAdmin.value)
}