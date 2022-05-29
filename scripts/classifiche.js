function onJsonPilot(json) {
  console.log("pilot");
  console.log(json);
    const container=document.querySelector("#piloti");
    container.innerHTML="";
    const table=document.createElement("table");
    table.classList.add("table");
    const intestazione=document.createElement("tr");
    intestazione.classList.add("intestazione");
    const  intestazione1=document.createElement("th");
    intestazione1.textContent="Posizione";
    const  intestazione2=document.createElement("th");
    intestazione2.textContent="Pilota";
    const  intestazione3=document.createElement("th");
    intestazione3.textContent="Scuderia";
    const  intestazione4=document.createElement("th");
    intestazione4.textContent="Punti";
    const  intestazione5=document.createElement("th");
    intestazione5.textContent="Vittorie";
    
    intestazione.appendChild(intestazione1);
    intestazione.appendChild(intestazione2);
    intestazione.appendChild(intestazione3);
    intestazione.appendChild(intestazione4);
    intestazione.appendChild(intestazione5);
    table.appendChild(intestazione);
  
    const length=json.length;
    console.log(length);
    if(length == 0)
    {
      const errore = document.createElement("h1"); 
      const messaggio = document.createTextNode("Nessun risultato!"); 
      errore.appendChild(messaggio); 
      container.appendChild(errore);
    }

    const results=json;

    for(let i=0;i<length;i++){
        const classifica=results[i];
        const pos=classifica.position;
        const name=classifica.pilot;
        const team=classifica.scuderia;
        const wins=classifica.wins;
        const points=classifica.points;

        const righe=document.createElement("tr");

        const position=document.createElement("td");
        position.classList.add("td");
        position.textContent=pos+"°";

        const nome=document.createElement("td");
        nome.textContent=name;
        nome.classList.add("td");

        const scuderia=document.createElement("td");
        scuderia.textContent=team;
        scuderia.classList.add("td");

        const punti=document.createElement("td");
        punti.textContent=points;
        punti.classList.add("td");

        const vittorie=document.createElement("td");
        vittorie.textContent=wins;
        vittorie.classList.add("td");


        righe.appendChild(position);
        righe.appendChild(nome);
        righe.appendChild(scuderia);
        righe.appendChild(punti);
        righe.appendChild(vittorie);
        table.appendChild(righe);

        container.appendChild(table);
    }
    
}

function onJsonTeam(json) {
  const container=document.querySelector("#piloti");
  container.innerHTML="";
  const table=document.createElement("table");
  table.classList.add("table");
  const intestazione=document.createElement("tr");
  intestazione.classList.add("intestazione");
  const  intestazione1=document.createElement("th");
  intestazione1.textContent="Posizione";
  const  intestazione2=document.createElement("th");
  intestazione2.textContent="Costruttore";
  const  intestazione3=document.createElement("th");
  intestazione3.textContent="Punti";
  const  intestazione4=document.createElement("th");
  intestazione4.textContent="Vittorie";
  
  intestazione.appendChild(intestazione1);
  intestazione.appendChild(intestazione2);
  intestazione.appendChild(intestazione3);
  intestazione.appendChild(intestazione4);
  table.appendChild(intestazione);

  const length=json.length;
  if(length == 0)
  {
    const errore = document.createElement("h1"); 
    const messaggio = document.createTextNode("Nessun risultato!"); 
    errore.appendChild(messaggio); 
    container.appendChild(errore);
  }

  const results=json;

  for(let i=0;i<length;i++){
    const classifica=results[i];
    const pos=classifica.position;
    const team=classifica.constructor;
    const wins=classifica.wins;
    const points=classifica.points;

      const righe=document.createElement("tr");

      const position=document.createElement("td");
      position.classList.add("td");
      position.textContent=pos+"°";

      const nome=document.createElement("td");
      nome.textContent=team;
      nome.classList.add("td");

      const punti=document.createElement("td");
      punti.textContent=points;
      punti.classList.add("td");

      const vittorie=document.createElement("td");
      vittorie.textContent=wins;
      vittorie.classList.add("td");

      righe.appendChild(position);
      righe.appendChild(nome);
      righe.appendChild(punti);
      righe.appendChild(vittorie);
      table.appendChild(righe);

      container.appendChild(table);
  }
  
}


function search(event){
  const pilot=document.querySelector('#pilota');
  const type = document.querySelector("#tipo").value;
  fetch("api.php?type="+type+"&q="+encodeURIComponent(pilot.value)).then(onResponse).then(searchJson);
  event.preventDefault();
}

function onResponse(response) {
  console.log('Risposta ricevuta');
  return response.json();
}

function searchJson(json){
  const type=json[0].type;
    
    if(type==='pilot') onJsonPilot(json);
    else onJsonTeam(json);

}

function adattaTesto(event){
    const tipo=event.target.value;
    if(tipo==="piloti"){
        const insert=document.querySelector(".insert")
        insert.textContent="Inserisci anno (dal 1950 al corrente)"
    }else if(tipo==="costruttori"){
        const insert1=document.querySelector(".insert")
        insert1.textContent="Inserisci anno (dal 1958 al corrente)"
    }
}

const tipo1=document.querySelector('#tipo');
tipo1.addEventListener("change",adattaTesto);

const form = document.querySelector('#form');
form.addEventListener('submit', search);



