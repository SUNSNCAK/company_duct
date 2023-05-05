  //open and close popup login/register
  document.querySelector('#login-btn').onclick = () =>{
    document.querySelector('.login-form-container').classList.toggle('active');
  }

  document.querySelector('#close-login-form').onclick = () =>{
    document.querySelector('.login-form-container').classList.remove('active');
  }

  document.querySelector('#toregister').onclick = () =>{
    document.querySelector('.register-form-container').classList.toggle('active');
  }

  document.querySelector('#tologin').onclick = () =>{
    document.querySelector('.register-form-container').classList.toggle('active');
  }

  //show-hide password
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");

  togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    
    // toggle the icon
    this.classList.toggle("bi-eye");
  });
  
