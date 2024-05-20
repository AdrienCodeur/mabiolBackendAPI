<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat message</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<!-- component -->
<div class="bg-gray-100 h-screen flex flex-col max-w-lg mx-auto">
     <div class="bg-blue-500 p-4 text-white flex justify-between items-center">
      <button id="login" class="hover:bg-blue-400 rounded-md p-1">
        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="6" r="4" stroke="#ffffff" stroke-width="1.5"></circle> <path d="M15 20.6151C14.0907 20.8619 13.0736 21 12 21C8.13401 21 5 19.2091 5 17C5 14.7909 8.13401 13 12 13C15.866 13 19 14.7909 19 17C19 17.3453 18.9234 17.6804 18.7795 18" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
      </button>
      <span>Chat Private</span>
      <div class="relative inline-block text-left">
      <button id="setting" class="hover:bg-blue-400 rounded-md p-1">

      </button>
      
      </div>
    </div> 

    <div class="flex-1 overflow-y-auto p-4">
        <div class="flex flex-col space-y-2">
          
            <div class="flex justify-end" id="chat">
             
            </div>
            
        </div>
    </div>
    
    <div class="bg-white p-4 flex items-center">
        <input type="text" placeholder="enter your message..." class="flex-1 border rounded-full px-4 py-2 focus:outline-none" id="message" name="message" value="hello world">
        <input type="text" placeholder=" inter  your pseudo" class="flex-1 border rounded-full px-4 py-2 focus:outline-none" id="pseudo" id="pseudo" value="djeudje tenkeu">
        <button class="bg-blue-500 text-white rounded-full p-2 ml-2 hover:bg-blue-600 focus:outline-none" id="submit">
          Envoyer
        </button>  
    </div>
    
  </div>

</body>
</html>