import './bootstrap';

let messagee =  document.getElementById('message') ;
const pseudo=  document.getElementById('pseudo') ;
const submit=  document.getElementById('submit') ;
const  chatDiv = document.getElementById("chat") ;
submit.addEventListener("click" ,  async function (){
        const data =   await axios.post('api/v1/message/create' ,{emetteur_id:'1' , recepteur_id:'3', contenue:messagee.value})
        console.log("date" ,data)
        // fetch('chat' ,{
        //         method:post ,
        //         body:{pseudo ,message} 
        // }).then((response)=>  response).then((data)=>console.log(data)).catch((err)=>console.log(err))
})

//  let p =  document.createElement("p") ;

// window.Echo.channel('chat')
//         .listen('.chat-message' ,({message})=>{
//             p.innerHTML += ` <div class="bg-blue-200 text-black p-2 rounded-lg max-w-xs">
// ${message.contenue} <br>
// </div>   <small>${message.created_at}</small> <br>`
//                 chatDiv.appendChild(p)
//                   messagee.value= ''
//         })

        let p = document.createElement('p');

        window.Echo.channel('chat').listen('.chat-message', ({ message ,user }) => {
            const chatDiv = document.getElementById('chatDiv'); // Assurez-vous d'avoir un élément avec l'ID 'chatDiv' dans votre HTML
            const messageContent = `
                <div class="bg-blue-200 text-black p-2 rounded-lg max-w-xs">
                    ${message.contenue} <br>
                </div>
                <small>${formatDate(message.created_at)}</small> <br>
            `;
            p.innerHTML = messageContent;
            chatDiv.appendChild(p);
            messagee.value = ''; // Assurez-vous que 'messagee' est votre champ d'entrée de message
        });
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Intl.DateTimeFormat('fr-FR', options).format(date);
        }
        


let msg = 'Aucun Message pour le moment'
        document.addEventListener('DOMContentLoaded',  async  function() {
             const  {data} =  await  axios.get('/api/v1/message') ;
             console.log("data" ,data)
        });
        
window.Echo.channel('chat')
        .listen('.get-message' ,({message ,user})=>{
            console.log("message get" ,message) 
            if(message.length>=1){
                p.innerHTML =''
                message.forEach(element => {
                    p.innerHTML += ` <div class="bg-blue-200 text-black p-2 rounded-lg max-w-xs">
                    ${element.contenue} <br> 
                    </div>  <small class="bg-blue-50">  ${formatDate(element.created_at) }</small> <br>`
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