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