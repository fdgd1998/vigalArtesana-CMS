// Getting URL of the image stored in the server.
function readURL(input, img) {
    console.log(input);
    console.log(img);
    console.log(input.files[0]);
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $(img).attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}