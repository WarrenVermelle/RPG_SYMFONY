/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

let divSelected = document.querySelector('#btnStart');

document.addEventListener('readystatechange', ()=>{
    divSelected.addEventListener('click',async ()=>{
        let path = divSelected.getAttribute('data-start')
        fetch(path)
        .then((response)=>{
            return response.text()
        }).then((newDom)=>{
            let parser = new DOMParser();
            let doc = parser.parseFromString(newDom, 'text/html');
    
            document.querySelector('#Combat').replaceWith(doc.querySelector('#startCombat'))
        })
    })
})


// let btnAtt = document.querySelector('#btnAtt');

//  btnAtt.addEventListener('click',async ()=>{
//      console.log('coucou');
//     let path = btnAtt.getAttribute('data-Att')
//     fetch(path)
//     .then((response)=>{
//         return response.text()
//     }).then((newDom)=>{
//         let parser = new DOMParser();
//         let doc = parser.parseFromString(newDom, 'text/html');

//         document.querySelector('#startCombat').replaceWith(doc.querySelector('#combat'))
//     })
// })


