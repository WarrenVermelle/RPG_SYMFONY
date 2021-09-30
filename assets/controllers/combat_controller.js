import { Controller } from "@stimulus/core";

export default class extends Controller
{
    
    connect(){

    }

    async startCombat()
    {
        localStorage.setItem('cbtStart', 'true')
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
                localStorage.removeItem('cbtStart')
                window.location.href = redirectPath;
            }else{
                let parser = new DOMParser();
            let doc = parser.parseFromString(text, 'text/html');
            this.element.replaceWith(doc.querySelector('#startCombat'))
            }
        })
    }
    
    
}