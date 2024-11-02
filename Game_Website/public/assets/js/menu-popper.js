var dropdown = document.querySelector('.dropdown-list');
if(dropdown != null)
    dropdown.classList.add('hide');

var dropdown = document.querySelector('.dropdown');

if(dropdown != null) 
{
    dropdown.addEventListener("click", function(e) {
        e.currentTarget.querySelector(".dropdown-list").classList.toggle('hide');
    });
}