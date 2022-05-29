/*
function createNewPost(event)
{
    "value=".$_POST["username"]
    event.preventDefault();
    console.log("ciao");
    console.log(event);
    const textarea=document.querySelector("textarea");
    const content=document.querySelector(".content_text");
    content.textContent=textarea.text;

    // Preparo i dati da mandare al server e invio la richiesta con POST
    const formData = new FormData(document.querySelector(".invia_post"));
    formData.append('type', contentObj.type);
    formData.append('id', contentObj.id);
    fetch("post_dispatcher.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);

    
}
function dispatchResponse(response) {
    // Aggiungi animazione e controlla il risultato della richiesta
    document.getElementById('title_modal').classList.add('flip');

    if(!response.ok) {
        dispatchError();
        return null;
    }
    console.log(response);
    return response.json().then(databaseResponse); 
}

function dispatchError(error) { 
    const result = document.getElementById('dispatch_result_fail');
    result.classList.remove('hidden');
    setTimeout(function(){ result.classList.remove('invisible'); }, 3);
    result.querySelector('svg').classList.add('animated');
}
const formStatus = {'upload': true};
console.log(formStatus);
document.querySelector(".invia_post").addEventListener("submit", createNewPost);
*/
/*

function jsonCheckEmail(json) {
    if (formStatus.email = !json.exists) {
        document.querySelector('.email').classList.remove('errorj');
    } else {
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email').classList.add('errorj');
    }
    
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json;
}

function checkUsername(event) {
    const input = document.querySelector('.text input');

        input.parentNode.parentNode.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        input.parentNode.parentNode.classList.add('errorj');
    } else {
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}*/


/*
function createNewPost(event){
    const formData=new FormData(document.querySelector(".invia_post"));
    fetch("post_dispatcher.php",{method:'post', body:formData}).then(dispatchResponse, dispatchError);

    event.preventDefault();
}

function dispatchResponse(response) {
    console.log("ciao");

    if(!response.ok) {
        dispatchError();
        return null;
    }
    console.log(response);
    return response.json().then(databaseResponse); 
}

function dispatchError(error) { 
    const result = document.getElementById('dispatch_result_fail');
    result.classList.remove('hidden');
    setTimeout(function(){ result.classList.remove('invisible'); }, 3);
    result.querySelector('svg').classList.add('animated');
}


function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        return null;
    }
    /*const result = document.getElementById('dispatch_result_success');
    result.classList.remove('hidden');
    setTimeout(function(){ result.classList.remove('invisible'); }, 3);
    result.querySelector('svg').classList.add('animated');
}

*/

function enableSubmit(event){
    const input = document.getElementById('text_area');
    const span=document.querySelector("form span");
    const submit=document.getElementById("submit");
    
    
    /*contentObj.id = event.currentTarget.dataset.id;
    formData.append('type', contentObj.type);
    formData.append("id",contentObj.id);*/

    if(!input.value || input.value === ' '){    
        span.classList.remove("hidden");
        span.classList.add("errore");
        submit.disabled=true;
    }
    else{
        span.classList.add("hidden");
        submit.disabled=false;
        console.log(input.value);
    }
}

function createNewPost(){
    const formData=new FormData(document.querySelector(".invia_post"));
    fetch("post_dispatcher.php",{method: 'post', body: formData}).then(dispatchResponse);    
}
function dispatchResponse(response) {
    console.log(response);
    if (!response.ok) return null;
    return response.json;
}


document.getElementById("text_area").addEventListener("blur", enableSubmit);
document.querySelector(".invia_post").addEventListener("submit", createNewPost);