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


function validateSellerForm(event) {
    event.preventDefault();

    const businessName = document.getElementById("businessName").value.trim();
    const yearsExperience = document.getElementById("yearsExperience").value.trim();
    const expertiseArea = Array.from(document.querySelectorAll('input[name="expertiseArea[]"]:checked')).map(input => input.value);
    const certifications = document.getElementById("certifications").value.trim();
    const panCardNumber = document.getElementById("panCardNumber").value.trim();
    const billingLocation = document.getElementById("billingLocation").value.trim();
    const billingCity = document.getElementById("billingCity").value.trim();
    const billingProvince = document.getElementById("billingProvince").value.trim();

    if (!yearsExperience || expertiseArea.length === 0 || !panCardNumber || !billingCity || !billingLocation || !billingProvince) {
        alert("Please fill in all required fields.");
        return;
    }

    const panRegex = /^[0-9]{9}$/;
    if (!panRegex.test(panCardNumber)) {
        alert("Invalid PAN Card Number. Please enter a valid 9-digit PAN number.");
        return;
    }    

    document.querySelector(".sellerForm").submit();
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


function validateListForm(event) {
    const fileInput = document.getElementById('images');
    const files = fileInput.files;
    console.log('Number of files selected:', files.length);

    if (files.length > 5) {
        alert("You can upload a maximum of 5 images.");
        event.preventDefault();
    }
}


function confirmPurchase() {
    // Ask the user to confirm by typing 'confirm'
    var userConfirmation = prompt("Type 'confirm' to proceed with purchasing this service:");

    // Check if the input is exactly 'confirm'
    if (userConfirmation === 'confirm') {
        return true;  // Allow the link to be followed
    } else {
        alert("You must type 'confirm' to proceed.");
        return false;  // Prevent the link from being followed
    }
}


function showDiv(divId) {
    var divs = document.querySelectorAll('.content-div');
    divs.forEach(function(div) {
        div.style.display = 'none';
    });
    var selectedDiv = document.getElementById(divId);
    if (selectedDiv) {
        selectedDiv.style.display = 'block';
    }
}