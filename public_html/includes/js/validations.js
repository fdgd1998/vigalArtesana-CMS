function passwordComplexity(password) {
    var requirements = /^(?=(.*[a-z]){1,})(?=(.*[A-Z]){1,})(?=(.*[0-9]){1,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$/;
    var meetRequirements = requirements.test(password);
    if (meetRequirements) return true;
    else return false;
}

function emailFormatValid(email) {
    var requirements = /[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}/;
    var meetRequirements = requirements.test(email);
    if (meetRequirements) return true;
    else return false;
}