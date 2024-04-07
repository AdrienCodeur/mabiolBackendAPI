import './bootstrap';

let messagee =  document.getElementById('message') ;
const pseudo=  document.getElementById('pseudo') ;
const submit=  document.getElementById('submit') ;
const  chatDiv = document.getElementById("chat") ;
submit.addEventListener("click" ,  async function (){
        const data =   await axios.post('api/v1/message/create' ,{emetteur_id:'1' , recepteur_id:'3', contenue:message.value})
        // fetch('chat' ,{
        //         method:post ,
        //         body:{pseudo ,message} 
        // }).then((response)=>  response).then((data)=>console.log(data)).catch((err)=>console.log(err))
})

 let p =  document.createElement("p") ;

window.Echo.channel('chat')
        .listen('.chat-message' ,({message})=>{
            p.innerHTML += ` <div class="bg-blue-200 text-black p-2 rounded-lg max-w-xs">
${message.contenue} <br>
</div>   <small>${message.created_at}</small> <br>`
                chatDiv.appendChild(p)
                  messagee.value= ''
        })


let msg = 'Aucun Message pour le moment'
        document.addEventListener('DOMContentLoaded',  async  function() {
             const  {data} =  await  axios.get('/api/v1/message/get') ;
        });
        
window.Echo.channel('chat')
        .listen('.get-message' ,({message})=>{
            if(message.length>=1){
                p.innerHTML =''
                message.forEach(element => {
                    p.innerHTML += ` <div class="bg-blue-200 text-black p-2 rounded-lg max-w-xs">
                    ${element.contenue} <br> 
                    </div>  <small>   </small> <br>`
                                    chatDiv.appendChild(p)
                });
            }
            else{
                p.innerHTML += ` <div class="bg-blue-200 text-black p-1 rounded-lg max-w-xs">
                     ${msg}   <br> 
                </div>`
                chatDiv.appendChild(p)
            }
            
        })