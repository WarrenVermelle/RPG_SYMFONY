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

        await fetch(path)
        .then((response)=>{
            return response.text()
        })
        .then((text)=>{

            if(text.startsWith("\"\\"))
            {
                let redirectPath = JSON.parse(text);
                localStorage.removeItem('cbtStart')

                fetch(redirectPath)
                .then((response)=>{
                    return response.text()
                })
                .then((text)=>{
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(text, 'text/html');

                    this.element.replaceWith(doc.querySelector('#endCombat'));
                });
            }
            else
            {
                let parser = new DOMParser();
                let doc = parser.parseFromString(text, 'text/html');

                this.element.replaceWith(doc.querySelector('#startCombat'));

                // récup les dégats subits et les soustraits aux pv
                let hp_stats = document.querySelector('.hp_stats');
                let damage = Number(document.querySelector('#degat').textContent);
                let currentHealth = Number(document.querySelector('.hp_stats').textContent.match(/^[0-9]*/)[0]);
                let target = document.querySelector('.currentHp');

                currentHealth += damage;
                hp_stats.innerHTML = currentHealth + ' / ' + target.getAttribute('data-max-hp');
                // -----------------------------------------------
            }
        });
    }
    
   async endFight()
   {
        window.location.href = '/game/voyage/4';
   }

    async fuite(event)
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