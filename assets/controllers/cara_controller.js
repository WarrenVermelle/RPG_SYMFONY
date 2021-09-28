import { Controller } from "@stimulus/core";

export default class extends Controller
{
    async cara()
    {
        let btn = this.element.querySelector('a.acara');
        let path = btn.getAttribute('data-start');
        
        await fetch(path).then((response)=>{
            return response.text()
            
        }).then((text)=>{
            document.querySelector('#insertpopupcara').innerHTML = text
        })
    }
    disablecara()
    {
        this.element.innerHTML = ""
    }
}