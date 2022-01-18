document.addEventListener("DOMContentLoaded", () => {
  let container = document.getElementById("embed");
  var editor = new Flat.Embed(container, {
    score: "",
    height: "1000px",
    embedParams: {
      mode: "view",
      appId: "59e7684b476cba39490801c2",
      branding: false,
      controlsDisplay: true,
      controlsPanel: false,
      controlsPosition: "top",
      hideFlatPlayback: false,
      layout: "page",
    },
  });

  let data = JSON.parse(musicSheetData.content);
  editor.loadJSON(data);

  document.querySelectorAll(".instrument").forEach((i) => {
    i.addEventListener("click", async () => {
      let partList = Object.values(musicSheetData.instrumentMapping);
      let disabledInstruments = document.querySelectorAll(".disabled");

      if (i.classList.contains("disabled")) i.classList.remove("disabled");
      else {
        //Check to deny user from disabling all instruments
        if (disabledInstruments.length == partList.length - 1) return;
        i.classList.add("disabled");
      }

      let partToRemove = [];
      document
        .querySelectorAll(".disabled")
        .forEach((i) => partToRemove.push(i.getAttribute("partId")));
      partToRemove.forEach((p) => {
        partList.splice(
          partList.findIndex((part) => part == p),
          1
        );
      });

      let formData = new FormData();
      formData.append("partList", JSON.stringify(partList));
      formData.append("musicSheetId", musicSheetData.id);
      return await fetch("/musicsheets/getScoreWithOnlyParts", {
        method: "POST",
        ContentType: "multipart/form-data",
        processData: false,
        body: formData,
      })
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          editor.loadJSON(data);
        });
    });
  });

  document.getElementById("downloadXml").addEventListener("click", function () {
    editor.getMusicXML().then(function (buffer) {
      exportFile(buffer, "application/xml", "musicxml");
    });
  });

  document.getElementById("downloadPng").addEventListener("click", function () {
    editor
      .getPNG({
        result: "dataURL",
        layout: "page",
        dpi: 300,
      })
      .then(function (buffer) {
        var a = document.createElement("a");
        a.href = buffer;
        a.download = musicSheetTitle + ".png";
        a.style = "display: none";
        document.body.appendChild(a);
        a.click();
        a.remove();
      });
  });

  document.getElementById("downloadPdf").addEventListener("click", function () {
    editor.print();
  });

  document.querySelectorAll(".respond-button").forEach((b) => {
    b.addEventListener("click", (e) => {
      e.preventDefault();
      addRespondtextBox(e.target.parentElement.parentElement.parentElement);
    });
  });

  document.querySelectorAll(".write-comment input").forEach((el) => {
    el.addEventListener("keyup", (e) => {
      if (e.keyCode == 13) {
        let lastComment = document.querySelector(
          ".comments-container"
        ).children;
        lastComment = lastComment[lastComment.length - 2];
        addComment(el, lastComment, false);
      }
    });
  });

  document.querySelectorAll('.showResponses-button').forEach(el =>{
    el.addEventListener('click', e=>{
      e.preventDefault();
      showReplies(el.parentElement.parentElement.parentElement.getAttribute('commentid')).then(()=>{
        el.style.display='none';
      });
    });
  });

  document.querySelector('.like').addEventListener('click', like);

  document.querySelector('.rearrangeButton').addEventListener('click', e =>{
    e.preventDefault();
    rearrange();
  });
});



function exportFile (buffer, mimeType, ext) {
  var blobUrl = window.URL.createObjectURL(
    new Blob([buffer], {
      type: mimeType,
    })
  );
  var a = document.createElement("a");
  a.href = blobUrl;
  a.download = musicSheetTitle + "." + ext;
  a.style = "display: none";
  document.body.appendChild(a);
  a.click();
  a.remove();
};

function addRespondtextBox(el) {
  document
    .querySelectorAll(".write-comment")
    .forEach((el) => (el.style.display = "none"));
  let container = document.createElement("div");
  container.classList.add("write-comment");
  container.style.marginLeft = "7%";
  let userImage = document.createElement("div");
  userImage.classList.add("user-image");
  userImage.append("\u00A0");
  userImage.style.background = loggedUser.avatar
  ? "url("+loggedUser.avatar+")"
  : "url(https://avatars.dicebear.com/api/male/" +
    loggedUser.firstname +
    ".svg)";
  let input = document.createElement("input");
  input.setAttribute("type", "text");
  input.setAttribute("placeholder", (lang == 'it') ? "Scrivi il tuo commento" : "Write your comment");
  input.style.flex = "17";
  input.addEventListener("keyup", (e) => {
    if (e.keyCode === 13) {
      addComment(input, el, true);
    }
  });
  container.appendChild(userImage);
  container.appendChild(input);

  el.parentNode.insertBefore(container, el.nextSibling);
}

function addComment(input, parent, isResponse) {
  if (isResponse) persistComment(input.value, 1);
  else persistComment(input.value, null);

  let comment = document.createElement("div");
  comment.classList = isResponse
    ? "comment response d-flex align-items-center justify-content-start"
    : "comment d-flex align-items-center justify-content-start";
  let userImage = document.createElement("div");
  userImage.classList.add("user-image");
  userImage.style.background = loggedUser.avatar
    ? "url("+loggedUser.avatar+")"
    : "url(https://avatars.dicebear.com/api/male/" +
      loggedUser.firstname +
      ".svg)";
  userImage.style.backgroundPosition = "center";
  userImage.style.backgroundSize = "cover";
  userImage.append("\u00A0");
  let textContainer = document.createElement("div");
  textContainer.classList =
    "d-flex flex-column align-items-start justify-content-start";
  textContainer.style.flex = "17";
  let username = document.createElement("h6");
  username.classList = "user-name";
  username.innerText = `${loggedUser.firstname}  ${loggedUser.lastname}`;
  let p = document.createElement("p");
  p.classList = "comment-content";
  p.innerText = input.value;

  let commentActions = document.createElement("div");
  commentActions.classList =
    "d-flex align-items-center justify-content-start comment-actions";
  commentActions.style.gap = "10px";

  let respond = document.createElement("a");
  respond.classList = "respond-button";
  respond.innerText = (lang == 'it') ? "Rispondi" : 'Reply';
  respond.href = "";
  respond.addEventListener("click", (e) => {
    e.preventDefault();
    addRespondtextBox(e.target.parentElement.parentElement.parentElement);
  });

  commentActions.appendChild(respond);

  textContainer.appendChild(username);
  textContainer.appendChild(p);
  textContainer.appendChild(commentActions);

  comment.appendChild(userImage);
  comment.appendChild(textContainer);

  if (isResponse) input.parentElement.remove();
  else input.parentElement.style.display = "none";
  input.value = "";
  parent.parentNode.insertBefore(comment, parent.nextSibling);
  document
    .querySelectorAll(".write-comment")
    .forEach((el) => (el.style.display = "flex"));
}

async function persistComment(content, parentId) {
  let formData = new FormData();
  formData.append("content", content);
  formData.append("parentId", parentId);
  formData.append("musicSheetId", musicSheetData.id);

  return await fetch("/musicsheets/addComment", {
    method: "POST",
    ContentType: "multipart/form-data",
    processData: false,
    body: formData,
  });
}

async function showReplies(commentId){
  let parent = document.querySelector(`[commentid="${commentId}"]`);

  let formData = new FormData();
  formData.append("parentId", commentId);

  return await fetch("/musicsheets/getReplies", {
    method: "POST",
    ContentType: "multipart/form-data",
    processData: false,
    body: formData,
  }).then((response) => {
    return response.json();
  })
  .then((replies) => {
    replies.forEach(r=>{
      let comment = document.createElement("div");
      comment.classList = "comment response d-flex align-items-center justify-content-start";
      let userImage = document.createElement("div");
      userImage.classList.add("user-image");
      userImage.style.background = r.userAvatar ? "url("+r.userAvatar+")" : "url(https://avatars.dicebear.com/api/male/" +r.firstName +".svg)";
      userImage.style.backgroundPosition = "center";
      userImage.style.backgroundSize = "cover";
      userImage.append("\u00A0");
      let textContainer = document.createElement("div");
      textContainer.classList =
        "d-flex flex-column align-items-start justify-content-start";
      textContainer.style.flex = "17";
      let username = document.createElement("h6");
      username.classList = "user-name";
      username.innerText = `${r.firstName}  ${r.lastName}`;
      let p = document.createElement("p");
      p.classList = "comment-content";
      p.innerText = r.content;
      
      textContainer.appendChild(username);
      textContainer.appendChild(p);
      comment.appendChild(userImage);
      comment.appendChild(textContainer);
      parent.parentNode.insertBefore(comment, parent.nextSibling);
    });
  });
}

async function like(){
  let element = document.querySelector('.like');
  let endpoint = element.classList.contains('liked') ? '/musicsheets/dislike' : '/musicsheets/like';
  let likes = parseInt(document.querySelector('.like').lastElementChild.innerText);

  if(element.classList.contains('liked')) {
    element.classList.remove('liked');
    likes -=1;
  }
  else {
    element.classList.add('liked');
    likes=+1;
  }

  document.querySelector('.like').lastElementChild.innerText = likes;

  let formData = new FormData();
  formData.append("musicSheetId", musicSheetData.id);
  return await fetch(endpoint, {
    method: "POST",
    ContentType: "multipart/form-data",
    processData: false,
    body: formData,
  });
}

function rearrange(){
  if(isAuthor){
    let container = document.getElementById("embed");
    container.innerHTML = "";
    editor = new Flat.Embed(container, {
      score: "",
      height: "1000px",
      embedParams: {
        mode: "edit",
        appId: "59e7684b476cba39490801c2",
        branding: false,
        controlsPosition: "top",
        layout: "page",
      },
    });
    editor.loadJSON(musicSheetData.content);

    container.nextElementSibling.style.display = 'none';
    container.nextElementSibling.nextElementSibling.classList.remove('d-flex');
    container.nextElementSibling.nextElementSibling.style.display = 'none';
    
    let saveButton = document.createElement('div');
    saveButton.classList='button wow fadeInUp mt-4 mb-4';
    saveButton.setAttribute('style', 'visibility: visible; width: fit-content;');
    let a = document.createElement('a');
    a.innerText=(lang ==  'it') ? 'Salva' : 'Save';
    a.href = '#';
    a.classList='btn';
    saveButton.append(a);
    saveButton.addEventListener('click', e => {
      e.preventDefault();
      updateMusicSheet();
    });

    container.parentNode.insertBefore(saveButton, container.nextSibling);
    return;
  }
  window.location.href= `http://${window.location.host}/musicsheets/rearrange/${musicSheetData.id}`;
}

function updateMusicSheet(){
  let container = document.getElementById("embed");
  container.nextElementSibling.remove();
  container.nextElementSibling.style.display='initial';
  container.nextElementSibling.nextElementSibling.classList.add('d-flex');

  editor.getJSON().then(async (json) => {
    musicSheetData.content = JSON.stringify(json);
    container.innerHTML = "";
    editor = new Flat.Embed(container, {
      score: "",
      height: "1000px",
      embedParams: {
        mode: "view",
        appId: "59e7684b476cba39490801c2",
        branding: false,
        controlsDisplay: true,
        controlsPanel: false,
        controlsPosition: "top",
        hideFlatPlayback: false,
        layout: "page",
      },
    });
    editor.loadJSON(musicSheetData.content);

    //ajax call
    let formData = new FormData();
    formData.append("musicSheetId", musicSheetData.id);
    formData.append("musicSheetContent", musicSheetData.content);
    return await fetch("/musicsheets/update", {
      method: "POST",
      ContentType: "multipart/form-data",
      processData: false,
      body: formData
    });
  });
}