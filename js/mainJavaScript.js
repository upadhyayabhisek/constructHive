function toggleLoginPasswordVisibility() {
    const passwordInput = document.getElementById('passwordLogin');
    const toggleIcon = document.getElementById('togglePasswordLogin');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.src = 'images/bx-brush.svg';
    } else {
        passwordInput.type = 'password';
        toggleIcon.src = 'images/bxs-brush.svg'; 
    }
}


function validateForm(event) {
    event.preventDefault(); 

    const name = document.getElementById("nameRegister").value.trim();
    const email = document.getElementById("emailRegister").value.trim();
    const phone = document.getElementById("phoneRegister").value.trim();
    const password = document.getElementById("passwordRegister").value.trim();
    const phoneRegex = /^(?:\+977)?[9][6-9]\d{8}$/;
    const passwordregex = /^(?=.*\d)[A-Za-z\d]{8,}$/;

    if (name === "") {
        alert("Name is required.");
        return;
    }
    if (!email.includes("@") || !email.includes(".")) {
        alert("Please enter a valid email.");
        return;
    }
    if (!phoneRegex.test(phone)) {
        alert("Please enter a valid phone number in the format: +9779612345678 or 9612345678.");
        return;
    }
    if (!passwordregex.test(password)) {
        alert("Password must be at least 8 characters long, and must include a number.");
        return;
    }
    document.querySelector(".registrationForm").submit();
    console.log(name + email + phone + password);
}

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('passwordRegister');
    const toggle = document.getElementById('togglePassword');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggle.src = 'images/bx-brush.svg'; 
    } else {
        passwordInput.type = 'password';
        toggle.src = 'images/bxs-brush.svg'; 
    }
}


