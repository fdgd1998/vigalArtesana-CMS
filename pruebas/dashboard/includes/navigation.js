function loadSection(section){
    finalURL = '';
        switch (section) {
            case 'users':
                finalURL = './users.php';
                break;
        }
    var webFrame = document.getElementById("frame");
    if (webFrame) {
        webFrame.src = finalURL;
    }
}