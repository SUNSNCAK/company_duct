  $("#chat-circle").click(function() {    
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
  $(".chat-box-toggle").click(function() {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector(".chat-submit"),
  chatlogs = document.querySelector(".chat-logs");

  form.onsubmit = (e)=>{
    e.preventDefault();
  }
  inputField.focus();
  inputField.onkeyup = ()=>{
      if(inputField.value != ""){
          sendBtn.classList.add("active");
      }else{
          sendBtn.classList.remove("active");
      }
  }
  sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
  }
  chatlogs.onmouseenter = ()=>{
    chatlogs.classList.add("active");
  }

  chatlogs.onmouseleave = ()=>{
    chatlogs.classList.remove("active");
  }
  setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "get-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatlogs.innerHTML = data;
            if(!chatlogs.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
  }, 500);
  function scrollToBottom(){
    chatlogs.scrollTop = chatlogs.scrollHeight;
  }