
// upload images
function productImagePreview(event, previewImageId, imageTextId) {
    const file = event.target.files[0];
    const previewImage = document.getElementById(previewImageId);
    const imageText = document.getElementById(imageTextId);
    const errorMessage = document.getElementById('error-message' + previewImageId.charAt(previewImageId.length - 1));

    if (file) {
        const fileType = file.type;
        if (fileType === "image/png" || fileType === "image/jpeg" || fileType === "image/jpg") {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Set the preview image source
                previewImage.classList.remove('hidden'); // Show the preview
                imageText.classList.add('hidden'); // Hide the placeholder text
                errorMessage.classList.add('hidden'); // Hide the error message
            };
            reader.readAsDataURL(file);
        } else {
            errorMessage.classList.remove('hidden'); // Show error message
            previewImage.src = ''; // Clear the image source
            previewImage.classList.add('hidden'); // Hide the preview image
            imageText.classList.remove('hidden'); // Show the placeholder text
        }
    } else {
        previewImage.src = ''; // Clear the image source
        previewImage.classList.add('hidden'); // Hide the preview image
        imageText.classList.remove('hidden'); // Show the placeholder text
    }
} 