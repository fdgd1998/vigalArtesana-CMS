// Getting URL of the image stored in the server.
function readURL(input, selector) {
    console.log(input);
    console.log(selector);
    console.log(input.files[0]);
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $(selector).attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}