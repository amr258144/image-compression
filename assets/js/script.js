var theDocument = top.document || window.parent.document;
var abc = theDocument.querySelector('#imgUrl');



// function for  validate file extension
var validExt = ".png, .jpeg, .jpg";
function fileExtValidate() {
    var filePath = abc.value;
    var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
    var pos = validExt.indexOf(getFileExt);
    if (pos < 0) {
        alert("Invalid URL !!");
        return false;
    } else {
        return true;
    }
}

function myfunction() {
    if (abc.value == "") {
        alert("Enter the Image URL");
        return false;
    }
    else {  // file extension validation function
        if(fileExtValidate(this)) {
            var img = document.createElement("img");
 
img.src = abc.value;
var src = document.getElementById("ogiimage");
 console.log(src);
src.appendChild(img);

        }
    }
}