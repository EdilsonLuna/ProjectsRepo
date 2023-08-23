const buscar = document.getElementById('searchApi');
const URL = 'https://pokeapi.co/api/v2/pokemon/';
const lista = document.getElementById("divLista");

//Asigno al botón como submit, luego con el click hago que deshabilite su función principal
//tomo el valor del input para que poder concatenarlo con la URL y poder hacer el fetch
buscar.addEventListener('click', e=>{
    e.preventDefault();
    var id= document.getElementById("input").value;
    var api = URL+id
    callApi(api);
})

function callApi (api){
    fetch(api)
        .then(res => res.json())
        .then(data=>addHTML(data))
        .catch(
            function(err){
                alert("Los datos ingresados no corresponden a ningún pokemon. Ingrese un nombre válido");
                window.location.href="index.html";
            }
        );
}

function addHTML(data){
    const div = document.createElement('div');
    div.innerHTML = `
        <h1>NOMBRE DEL POKEMON BUSCADO:${data.name}</h1>
        <h3>EXPERIENCIA DEL POKEMON: ${data.base_experience}</h3>
        <h3>ID DEL POKEMON: ${data.id}</h3>
    `;
    lista.append(div);
}
