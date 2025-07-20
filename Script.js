const hamburger = document.getElementById("hamburger");
        const navList = document.getElementById("nav-list");
        hamburger.onclick=()=> navList.classList.toggle("show");
        function toggleDropdown(){
    document.getElementById("dropdownMenu").classList.toggle("show");
}
window.onclick = function(event){
    if(!event.target.matches('.DropButton')){
        const dropdowns = document.getElementsByClassName('DropdownContent');
        for(let i=0;i<dropdowns.length;i++){
            dropdowns[i].classList.remove("show");
        }
    }
}