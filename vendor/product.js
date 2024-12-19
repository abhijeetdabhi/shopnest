// for Keyword Input
document.getElementById('add-keyword').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default button behavior

    let keywordContainer = document.getElementById('keyword-container');
    
    // Create a new container for the keyword and its remove button
    let keywordItem = document.createElement('div');
    keywordItem.className = 'flex items-center relative';
    
    // Create the input element for the keyword
    let keywordInput = document.createElement('input');
    keywordInput.type = 'text';
    keywordInput.name = 'keyword[]';
    keywordInput.placeholder = 'Enter keyword';
    keywordInput.className = 'relative h-10 border rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600';

    // Create the remove button
    let removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'p-2 text-red-500 bg-red-100 rounded focus:outline-none absolute right-0.5 top-0.5';
    removeButton.setAttribute('aria-label', 'Remove');
    removeButton.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    `;
    removeButton.addEventListener('click', function() {
        keywordContainer.removeChild(keywordItem);
    });
    
    // Append input and remove button to the keyword item container
    keywordItem.appendChild(keywordInput);
    keywordItem.appendChild(removeButton);
    
    // Append the keyword item container to the main container
    keywordContainer.appendChild(keywordItem);
});

// Prevent form submission when pressing Enter in any input field inside a form
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Prevent form submission if Enter is pressed
            event.preventDefault();
        }
    });
});



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

function loader() {
    let loader = document.getElementById('loader');
    let body = document.body;

    loader.style.display = 'flex';
    body.style.overflow = 'hidden';
}

function displayErrorMessage(message) {
    let popUp = document.getElementById('popUp');
    let errorMessage = document.getElementById('errorMessage');

    errorMessage.innerHTML = '<span class="font-medium">' + message + '</span>';
    popUp.style.display = 'flex';
    popUp.style.opacity = '100';

    setTimeout(() => {
        popUp.style.display = 'none';
        popUp.style.opacity = '0';
    }, 1800);
}

function displaySuccessMessage(message) {
    let SpopUp = document.getElementById('SpopUp');
    let Successfully = document.getElementById('Successfully');

    setTimeout(() => {
        Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
        SpopUp.style.display = 'flex';
        SpopUp.style.opacity = '100';
        window.location.href = "choose_product.php";
    }, 2000);
}  