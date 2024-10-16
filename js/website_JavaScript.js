function validateForm(event) {
    event.preventDefault(); 

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const password = document.getElementById("password").value.trim();
    const phoneRegex = /^(?:\+977)?[9][6-9]\d{8}$/;

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
    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return;
    }
    document.querySelector(".registrationForm").submit();
    console.log(name+email+phone+password)
}
