import { Controller } from "@stimulus/core";

export default class extends Controller
{
    async startCombat()
    {
        let btn = this.element.querySelector('button');
        let path = btn.getAttribute('data-start');
        await fetch(path).then((response)=>{
            return response.text()
        }).then((text)=>{
            let parser = new DOMParser();
            let doc = parser.parseFromString(text, 'text/html');
            this.element.replaceWith(doc.querySelector('#startCombat'))
        })
    }

    async attakMonster()
    {
        let btn = this.element.querySelector('button');
        let path = btn.getAttribute('data-attak');
        await fetch(path).then((response)=>{
            return response.text()
        }).then((text)=>{
            if(text.startsWith("\"\\")){
                let redirectPath = JSON.parse(text);
                window.location.href = redirectPath;
            }else{
                let parser = new DOMParser();
            let doc = parser.parseFromString(text, 'text/html');
            this.element.replaceWith(doc.querySelector('#startCombat'))
            }
        })
    }
    
    async potionHeal()
    {
        
        let btn = this.element.querySelector('button#popo');
        console.log(btn);
        let path = btn.getAttribute('data-potion');
        console.log(path);
        await fetch(path).then((response)=>{
            return response.text()
        }).then((text)=>{
            console.log('marche2');
            if(text.startsWith("\"\\")){
                console.log('marche3');
                let redirectPath = JSON.parse(text);
                window.location.href = redirectPath;
            }else{
                console.log('marche4');
                let parser = new DOMParser();
                console.log(parser);
                console.log(text);
                let doc = parser.parseFromString(text, 'text/html');
                console.log(doc);
                this.element.replaceWith(doc.querySelector('#startCombat'))
            }
        })
    }
}