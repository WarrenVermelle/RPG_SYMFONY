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
            let redirectPath = JSON.parse(text);
            if(redirectPath == "/game/voyage/forest"){
                window.location.href = redirectPath;
            }else if (redirectPath == "/game/voyage/ville")
            {
                window.location.href = redirectPath;
            }
            else{
                let parser = new DOMParser();
            let doc = parser.parseFromString(text, 'text/html');
                console.log(doc)
            this.element.replaceWith(doc.querySelector('#startCombat'))
            }
        })
    }
    
}