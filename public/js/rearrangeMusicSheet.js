document.addEventListener('DOMContentLoaded', () => {
    let container = document.getElementById("embed-example");
        let embed = new Flat.Embed(container, {
            score: "",
            height: "800px",
            embedParams: {
                mode: "edit",
                appId: "59e7684b476cba39490801c2",
                branding: false,
                controlsPosition: "top"
            }
        });
        embed.loadJSON(musicSheetData.content);
        console.log(musicSheet, musicSheetData);

        // document.querySelector('div.button.submit').addEventListener('click', () => {
        //     addInstrumentsToEmbed(embed);
        // });

        document.getElementById('rearrange-submit').addEventListener('click', () => {
            embed.getJSON().then( result => {
                document.getElementById('musicSheetContent').value = JSON.stringify(result);
                document.getElementById('createForm').submit();
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
});


