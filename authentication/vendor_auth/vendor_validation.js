// validation using Regular expression for registration
function VendorFormValidation(){
    const name = document.getElementById('name');
    const email = document.getElementById('email')
    const password = document.getElementById('password');
    const username = document.getElementById('username');
    const phone = document.getElementById('phone');
    const gst = document.getElementById('gst');
    const bio = document.getElementById('bio');

    const vendorName = document.getElementById('vendorName');
    const vendorEmail = document.getElementById('vendorEmail');
    const vendorPass = document.getElementById('vendorPass');
    const vendorUsername = document.getElementById('vendorUsername');
    const vendorPhone = document.getElementById('vendorPhone');
    const vendorGst = document.getElementById('vendorGst');
    const vendorBio = document.getElementById('vendorBio');

    // Name
    name.addEventListener('blur',()=>{
        let regx = /^[a-zA-Z]([0-9a-zA-Z\s]){1,14}$/;
        let str = name.value;

        if(regx.test(str)){
            console.log('it match');
            vendorName.classList.add('hidden');
        }else{
            vendorName.classList.remove('hidden');;
        }
    })

    // E-mail
    email.addEventListener('blur',()=>{
        console.log('mail blur')
        let regx = /^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let str = email.value;

        if(regx.test(str)){
            console.log('it match');
            vendorEmail.classList.add('hidden');
        }else{
            vendorEmail.classList.remove('hidden');;
        }
    })

    // password
    password.addEventListener('blur',()=>{
        console.log('pass blur')
        let lengthRegex = /^.{8,}$/;
        let str = password.value.trim();

        if(lengthRegex.test(str)){
            console.log('it match');
            vendorPass.classList.add('hidden');
        }else{
            vendorPass.classList.remove('hidden');;
        }
    })

    // username
    username.addEventListener('blur',()=>{
        let regx = /^[a-zA-Z0-9_-]{3,20}$/;
        let str = username.value;

        if(regx.test(str)){
            console.log('it match');
            vendorUsername.classList.add('hidden');
        }else{
            vendorUsername.classList.remove('hidden');;
        }
    })

    // phone number
    phone.addEventListener('blur',()=>{
        let regx = /^[6-9]\d{9}$/;
        let str = phone.value;

        if(regx.test(str)){
            console.log('it match');
            vendorPhone.classList.add('hidden');
        }else{
            vendorPhone.classList.remove('hidden');
        }
    })

    // gst
    gst.addEventListener('blur',()=>{
        let regx = /^[a-zA-Z0-9]{1,15}$/;
        let str = gst.value;

        if(regx.test(str)){
            console.log('it match');
            vendorGst.classList.add('hidden');
        }else{
            vendorGst.classList.remove('hidden');
        }
    })

    // bio
    bio.addEventListener("blur",()=>{
        let regx = /^[\w\s.,!?'()-]{1,500}$/;
        let str = bio.value;

        if(regx.test(str)){
            console.log('it match');
            vendorBio.classList.add('hidden');
        }else{
            vendorBio.classList.remove('hidden');
        }
    });
}

VendorFormValidation();