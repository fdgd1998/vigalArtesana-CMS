function ShowSpinnerOverlay (text) {
var spinner_div = $("<div style='height: 100%; min-height: 100%; z-index: 999999 !important; position: fixed; bottom:0; left:0; right:0; background-color: rgba(255,255,255,.75)' class='row justify-content-center align-items-center' id='spinner-div'><div class='spinner-border' role='status'></div><span style='margin-left: 10px'>"+text+"</span></div>");
    $("body").append(spinner_div);
}