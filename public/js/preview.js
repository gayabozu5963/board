
const imageNum = [0,1];
    function previewImage1(obj)
    {
        var fileReader = new FileReader();
        fileReader.onload = (function() {
            var canvas = document.getElementById('preview1');
            var ctx = canvas.getContext('2d');
            var image = new Image();
            image.src = fileReader.result;
            image.onload = (function () {
                canvas.width = image.width;
                canvas.height = image.height;
                ctx.drawImage(image, 0, 0);
                if (obj.files[0]) {
                    canvas.style.display ="block";
                } else {
                    canvas.style.display ="none";
                }
            });
        });
        fileReader.readAsDataURL(obj.files[0]);
    }

function previewImage2(obj)
    {
        var fileReader = new FileReader();
        fileReader.onload = (function() {
            var canvas = document.getElementById('preview2');
            var ctx = canvas.getContext('2d');
            var image = new Image();
            image.src = fileReader.result;
            image.onload = (function () {
                canvas.width = image.width;
                canvas.height = image.height;
                ctx.drawImage(image, 0, 0);
                console.log(obj.files[0]);
                console.log('aaaaaaaaaaaaaaaaaaaa');
                if (obj.files[0]) {
                    canvas.style.display ="block";
                } else {
                    canvas.style.display ="none";
                }
            });
        });
        fileReader.readAsDataURL(obj.files[0]);
    }