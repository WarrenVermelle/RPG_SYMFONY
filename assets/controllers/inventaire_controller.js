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
    
    disableinventaire2()
    {
        this.element.innerHTML = ""
    }

    disableinventaire()
    {
        if (window.location.pathname == '/game/voyage/4' ){
            if (localStorage.getItem('cbtStart')  == "true"){
                setTimeout(()=>{
                    this.element.innerHTML = ""
                },
                2000)
            }else{
                this.element.innerHTML = ""
            }
            
        }else{
            this.element.innerHTML = ""
        }
        
    }


    async equip(event)
    {
        let path = event.target.getAttribute('data-start');
        await fetch(path).then((response)=>{
            return response.text()
            
        }).then((text)=>{
            document.querySelector('#insertpopup').innerHTML = text
        })

        if ( window.location.pathname == '/game/voyage/4'){
            
            let btn = this.element.querySelector('a.equip');
            let path = btn.getAttribute('data-potion');

            if (localStorage.getItem('cbtStart')  == "true"){
                
                await fetch(path).then((response)=>{
                
                    return response.text()
                }).then((text)=>{
                    
                    if(text.startsWith("\"\\")){
                        
                        let redirectPath = JSON.parse(text);
                        window.location.href = redirectPath;
                    }else{
                        
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(text, 'text/html');
    
                        document.querySelector('#startCombat').replaceWith(doc.querySelector('#startCombat'))
                    }
                })
            }else{
                console.log('coucou')
            }
        }else{
            console.log('Coucou ami dev')
        }

    }

    
}