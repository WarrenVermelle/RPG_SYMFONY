import { Controller } from "@stimulus/core";

export default class extends Controller
{
    async inventaire()
    {
        let btn = this.element.querySelector('a');
        let path = btn.getAttribute('data-start');
        await fetch(path).then((response)=>{
            return response.text()
            
        }).then((text)=>{
            document.querySelector('#insertpopup').innerHTML = text
        })
    }
    disableinventaire()
    {
        setTimeout(()=>{
            this.element.innerHTML = ""
        },
        1000)
        
    }


    async equip(event)
    {
        let path = event.target.getAttribute('data-start');
        await fetch(path).then((response)=>{
            return response.text()
            
        }).then((text)=>{
            document.querySelector('#insertpopup').innerHTML = text
        })
    }

    async potionHeal()
    {
        
        let btn = this.element.querySelector('a.equip');
        let path = btn.getAttribute('data-potion');
        console.log(path)
        await fetch(path).then((response)=>{
            
            return response.text()
        }).then((text)=>{
            console.log('1')
            if(text.startsWith("\"\\")){
                console.log('2')
                let redirectPath = JSON.parse(text);
                window.location.href = redirectPath;
            }else{
                console.log(text)
                let parser = new DOMParser();
                let doc = parser.parseFromString(text, 'text/html');
                this.element.replaceWith(doc.querySelector('#startCombat'))
            }
        })
    }
}