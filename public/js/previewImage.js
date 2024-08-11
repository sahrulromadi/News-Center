document.addEventListener("DOMContentLoaded", function() {
    const inputImage = document.getElementById('imageInput');
    const previewImage = document.getElementById('imagePreview');
    const inputPict = document.getElementById('pictInput');
    const previewPict = document.getElementById('pictPreview');

    if (inputImage && previewImage) {
        inputImage.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
    
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                }
    
                reader.readAsDataURL(file);
            } else {
                previewImage.src = "#";
                previewImage.style.display = 'none';
            }
        });
    }

    if (inputPict && previewPict) {
        inputPict.addEventListener('change', function() {
            const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewPict.src = e.target.result;
            }

            reader.readAsDataURL(file);
        } else {
            previewPict.src = "#";
        }
        });
    }
});
