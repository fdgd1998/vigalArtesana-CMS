function CheckImageSize (file, maxSize) {
    console.log("image size: "+file.size);
    console.log("maximum size: "+maxSize);
    console.log("image oversized: "+(file.size > maxSize));
    if (file.size > maxSize) {
        alert("El tamaño de la imagen supera "+(maxSize/1024/1024)+" MB. Revísalo e inténtalo de nuevo.");
        return true;
    } else {
        return false;
    }
}