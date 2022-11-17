function generatePass() {
    var result           = '';
    var characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&()\-_+,.';
    var charactersLength = characters.length;
    for ( var i = 0; i <= 12; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}