/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

require('jquery-ui/ui/widgets/draggable');

import $ from 'jquery';

let divSelected = document.querySelector('#btninventaire');

divSelected.addEventListener('click',async ()=>{
    let path = divSelected.getAttribute('data-target')
    fetch(path)
    .then((response)=>{
        return response.text()
    }).then((newDom)=>{
        let parser = new DOMParser();
        let doc = parser.parseFromString(newDom, 'text/html');

        document.querySelector('#inventaire').replaceWith(doc.querySelector('#testjs'))
    })
})

let btnLeave = document.querySelector('#btnLeaveFight');

 btnLeave.addEventListener('click',async ()=>{
    let path = btnLeave.getAttribute('data-return')
    fetch(path)
    .then((response)=>{
        return response.text()
    }).then((newDom)=>{
        let parser = new DOMParser();
        let doc = parser.parseFromString(newDom, 'text/html');
        document.querySelector('#testjs').replaceWith(doc.querySelector('#inventaire'))
    })
})





// $(".inventaire").load("show_inventory")
        
// $('.inventaire').css('display','none');

// let btninventaire = document.getElementById('btninventaire');
//     let overlay = document.getElementById('inventaire');
//     btninventaire.addEventListener('click',openModal);
//     function openModal() {
//         console.log("test");
//         overlay.style.display='block';
//     }

// function fermerpopup(){   
//     $('.inventaire').css('display','none');
// }

// $(function(){
//     $( ".inventaire" ).draggable({
//         containment: "body",
//     });
// });
