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
let skillCount = 1;
document.getElementById('AddSkill').addEventListener('click',function(){
    skillCount++;
    const container=
    document.getElementById('SkillsContainer');
    const input = document.createElement('input');
    input.type ='text';
    input.name = 'skills[]';
    input.placeholder = 'Skill' + skillCount;
    container.appendChild(document.createElement('br'));
    container.appendChild(append);
});