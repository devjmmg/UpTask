const btnMobileMenu = document.querySelector("#mobile");
const cerrar = document.querySelector("#cerrar-menu");
const sidebar = document.querySelector(".sidebar");

if(btnMobileMenu){
    btnMobileMenu.addEventListener('click',function () {
        sidebar.classList.toggle("mostrar");
    });
}

if(cerrar){
    cerrar.addEventListener('click',function() {
        sidebar.classList.add("ocultar");
        setTimeout( () => {
            sidebar.classList.remove("mostrar");
            sidebar.classList.remove("ocultar");
        },500);
    });
}

//Ancho pantalla
window.addEventListener('resize',function() {
    const ancho = document.body.clientWidth;
    if(ancho >= 768) {
        sidebar.classList.remove("mostrar");
    }
})