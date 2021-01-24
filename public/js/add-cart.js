function mouseEnterMethod(id) {
    var elem = document.querySelector('.swip');
    if (elem.clientWidth > 768) {
        let card = document.querySelector('#card-' + id);
        card.style.height = "475px";
        card.style.zIndex = 999;
        card.style.boxShadow = "0px 0px 3px#444";


        setTimeout(function () {
            if (document.querySelector('#addCart-' + id) != 'undefined') {
                document.querySelector('#addCart-' + id).style.opacity = "1";
            }
        }, 200);
    }



}


function mouseLeaveMethod(id) {

    let card = document.querySelector('#card-' + id);
    let img = document.querySelector('#image-' + id);
    card.style.boxShadow = "";
    card.style.zIndex = 1;
    setTimeout(function () {
        card.style.height = "";
        if (document.querySelector('#addCart-' + id).style.opacity == 1 && typeof document.querySelector('#addCart-' + id) != 'undefined') {
            document.querySelector('#addCart-' + id).style.opacity = "0";
        }
    }, 200);


}


function changeText(e, id) {
    if (e.target.tagName == 'INPUT') {
        // Obtener contenedor
        let stockSize = document.querySelector("#stock-size-" + id);
        // Obtener valor seleccionado
        let radio = stockSize.querySelector('input[type="radio"]:checked');
        let value = (radio && radio.value) ? radio.value : false;
        console.log(radio.checked);
        if (radio.checked) {
            document.querySelector(".add-cart-detail").style.opacity = 1;
            document.querySelector(".placeholder-size").style.opacity = 0;
        }
    }
}