const btn = document.getElementById('search');
const div = document.getElementById('anadir');
btn.addEventListener('click',()=>{
    callApi();
})

function callApi(){
    fetch('https://dog.ceo/api/breeds/image/random')
        .then(res=>res.json())
        .then(data=>{
            añadirHTML(data)
        })
        .catch(err=>{
            console.log(err);
        })
}

function añadirHTML(data){
    div.innerHTML = `
        <img src="${data.message}"></img>
        <h1>Status: ${data.status}</h1>
    `;
}