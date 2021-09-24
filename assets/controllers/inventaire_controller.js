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
        this.element.innerHTML = ""
    }
    async equip()
    {
        let btn = this.element.querySelector('a.equip');
        let path = btn.getAttribute('data-start');
        await fetch(path).then((response)=>{
            return response.text()
            
        }).then((text)=>{
            document.querySelector('#insertpopup').innerHTML = text
        })
    }
}