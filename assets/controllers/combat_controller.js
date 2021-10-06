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

        document.querySelectorAll('div.fleche').forEach((el)=>{el.innerHTML = ''})
    }

    async attakMonster()
    {
        let btn = this.element.querySelector('button');
        let path = btn.getAttribute('data-attak');
        await fetch(path).then((response)=>{
            return response.text()
        }).then((text)=>{
            if(text.startsWith("\"\\")){
                console.log(text)
                let redirectPath = JSON.parse(text);
                localStorage.removeItem('cbtStart')
                console.log(redirectPath)
                //window.location.href = redirectPath;
                fetch(redirectPath).then((response)=>{
                    return response.text()
                }).then((text)=>{
                    console.log(text)
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(text, 'text/html');
                    this.element.replaceWith(doc.querySelector('#endCombat'))
                })
            }else{
                let parser = new DOMParser();
                let doc = parser.parseFromString(text, 'text/html');
                this.element.replaceWith(doc.querySelector('#startCombat'))

                let hp_stats = document.querySelector('.hp_stats');
                let target = document.querySelector('.currentHp');
                hp_stats.innerHTML = target.getAttribute('data-hp') + ' / ' + target.getAttribute('data-max-hp');
            }
        });
    }
    
   async endFight()
   {
        //console.log('cc')
        window.location.href = '/game/voyage/4';
   }

    async fuite(event )
    {
        
        let path = event.currentTarget.getAttribute('data-fuite');
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