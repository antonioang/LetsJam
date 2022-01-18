document.addEventListener('DOMContentLoaded', () => {
    let container = document.getElementById("embed-example");
    let embed = new Flat.Embed(container, {
        score: "",
        height: "800px",
        embedParams: {
            mode: "edit",
            // appId: "59e7684b476cba39490801c2",
            branding: false,
            controlsPosition: "top"
        }
    });

    chooseIfCreateOrUpload(embed);
    document.getElementById('chooseSong').addEventListener('change', (e) => {
        searchForSongs(e)
    });
    document.querySelector('div.submit').addEventListener('click', e=> {
        embed.getJSON().then(json => {
            document.querySelector('#musicSheetContent').value = JSON.stringify(json);
            document.querySelector('#createForm').submit();
        });
    });
    document.querySelectorAll('.visibilityToggle input').forEach(i=>{
        i.addEventListener('change', e=>{
            if(e.target.checked){
                console.log(e.target);
                e.target.parentElement.classList.add("active");
            }
            document.querySelector('.visibilityToggle input:not(:checked)')
                .parentElement.classList.remove("active");
        })
    });

    document.querySelectorAll('.songToggle input').forEach(i=>{
        i.addEventListener('change', e=>{
            if(e.target.value == 0 && e.target.checked == true){
                document.querySelector('#chooseSong').style.display='block';
                document.querySelector('#newSongContainer').style.display='none';
            }
            else if(e.target.value == 1 && e.target.checked == true){
                document.querySelector('#chooseSong').style.display='none';
                document.querySelector('#newSongContainer').style.display='flex';
            }
            e.target.parentElement.classList.add("active");
            document.querySelector('.songToggle input:not(:checked)')
                .parentElement.classList.remove("active");

            document.querySelector('#songType').value = e.target.value;
        });
    });

});

function chooseIfCreateOrUpload(embed) {
    let selectedOption = 'crea';
    let select = document.getElementById('select')
    let instrumentForSheet = document.getElementById('instrumentForSheet')
    let fileForSheet = document.getElementById('fileForSheet')

    select.addEventListener('change', () => {
        selectedOption = select.value;
    })

    let confirmButton = document.getElementById('confirmFirst');

    confirmButton.addEventListener('click', () => {

        if (selectedOption === 'crea') {
            let instrumentForSheetStyle = window.getComputedStyle(instrumentForSheet);
            if (instrumentForSheetStyle.display === 'none') {
                instrumentForSheet.style.display = 'flex'
                fileForSheet.style.display = 'none'
            } else {
                createSheet(embed)
            }
        } else if (selectedOption === 'carica') {
            let fileStyle = window.getComputedStyle(fileForSheet);
            if (fileStyle.display === 'none') {
                instrumentForSheet.style.display = 'none'
                fileForSheet.style.display = 'block'
            } else {
                let file = fileForSheet.children[0].files[0];
                if (!file) {
                    return;
                }
                uploadFile(embed, file)
            }
        }
    })
    return selectedOption;
}

function uploadFile(embed, file) {
    let reader = new FileReader();
    reader.onload = function (e){
        let contents = e.target.result;
        embed.loadMusicXML(contents);

        embed.on('scoreLoaded', () => {
            embed.getJSON().then(async (score) => {
                let formData = new FormData();
                formData.append("score", JSON.stringify(score));
                return await fetch('/musicsheets/analyze', {
                    method: "POST",
                    ContentType: "multipart/form-data",
                    processData: false,
                    body: formData
                }).then((response) => {
                    return response.json()
                }).then((data) => {
                    document.getElementById('create').style.display = 'flex';
                    document.getElementById('choose').style.display = 'none';
                    document.getElementById('sheet-author').value = data.author;
                    document.getElementById('sheet-title').value = data.title;
                });
            })
        })
    };
    reader.readAsText(file);
}

function createSheet(embed) {
    let checkbox = document.querySelectorAll('input[type=checkbox]:checked');
    if(checkbox.length == 0){
        document.querySelector('#noInstrumentSelected').style.display="block";
        return;
    }
    else{
        document.querySelector('#noInstrumentSelected').style.display="none";
    }
    let selectedIntruments = []
    checkbox.forEach((check) => {
        selectedIntruments.push(check.name);
    })
    let formData = new FormData();
    formData.append("instruments", JSON.stringify(selectedIntruments));
    return fetch('/musicsheets/getEmptyScore', {
        method: "POST",
        ContentType: "application/json",
        body: formData
    }).then((response) => {
        return response.json()
    }).then((data) => {
        document.getElementById('create').style.display = 'flex'
        document.getElementById('choose').style.display = 'none'
        embed.loadJSON(data);
    });
}

function searchForSongs(e){
    let songSearchString = e.target.value;
    return fetch('/musicsheets/brani?' + new URLSearchParams({
        songSearchString: songSearchString
    }), {
        method: "GET",
        ContentType: "application/json",
    }).then((response) => {
        return response.json()
    }).then(data => {
        let list = document.getElementById('songList');
        list.innerHTML='';
        list.style.display='block';
        data.forEach(song => {
            let li = document.createElement('li');
            li.innerText = song.title+" - "+song.author;
            li.setAttribute("songId", song.id);
            li.setAttribute("spotifyId", song.spotifyId);
            li.addEventListener("click", e => selectSong(e));
            list.append(li);
        });
    });
}

function selectSong(e){
    document.querySelector('#chooseSong').value = e.target.innerText;
    document.querySelector('#selectedSong').value=JSON.stringify({
        songId: e.target.getAttribute("songid"),
        spotifyId: e.target.getAttribute("spotifyid")
    });
    document.querySelector('#songList').style.display='none';
}

