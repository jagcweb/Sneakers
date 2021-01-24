function openDiv(id){
    let button_gender = document.querySelector('#button-' + id);
    let search_gender = document.querySelector("#search-" + id);
    if(search_gender.classList.contains('open-div')){
       search_gender.classList.remove('open-div');
    }else{
        search_gender.classList.add('open-div');
    }
}

function changeText(e, id) {
    // Solo si el clic fue en un radio
    if(e.target.tagName == 'INPUT') {
        // Obtener contenedor
        let search_gender = document.querySelector("#search-" + id);
        // Obtener valor seleccionado
        let radio = search_gender.querySelector('input[type="radio"]:checked');
        let value = (radio && radio.value) ? radio.value : false;
    }
}