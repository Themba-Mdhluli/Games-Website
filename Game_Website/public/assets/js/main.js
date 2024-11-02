var links = document.querySelector("nav").querySelectorAll(".main-nav li");
for (let i = 0; i < links.length; i++) {

    if(links[i].children[0].href == window.location.href || links[i].children[0].href+"/" == window.location.href)
    {
        links[i].children[0].classList.add("active");
    }
    else {
        links[i].children[0].classList.remove("active");
    }
}

function sendToServer()
{
    var request = new XMLHttpRequest();
    request.onreadystatechange = ()=> {

        if(request.readyState == 4 && request.status == 200)
        {

        }
    };
    request.open("get", 'home.php?sort=', true);
}

// var sort = document.querySelector('#sort');
// sort.addEventListener('change', (e)=> {

//     // if (e.target.value == "") {
        
//     // } else {
        
//     // }
//     alert(e.target.value);
// });