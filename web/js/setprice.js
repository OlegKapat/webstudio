var importDoc = document.currentScript.ownerDocument;

document.addEventListener('load', function () {

    var button = document.querySelector("#getprice");

    button.addEventListener("click", function () {
        var content = document.querySelector("#allservices");
        document.body.appendChild(content);           
    });
});