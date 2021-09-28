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
        2000)
        
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
        await fetch(path).then((response)=>{
            
            return response.text()
        }).then((text)=>{
            if(text.startsWith("\"\\")){
                let redirectPath = JSON.parse(text);
                window.location.href = redirectPath;
            }else{
                let parser = new DOMParser();
                let doc = parser.parseFromString(text, 'text/html');
                console.log(this.element)
                document.querySelector('#startCombat').replaceWith(doc.querySelector('#startCombat'))
            }
        })
    }
}