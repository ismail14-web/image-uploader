document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('upload-form');
    const imageInput = document.getElementById('image-file');
    const statusMessage = document.querySelector('.status-message');
    const resultBox = document.querySelector('.result-box');
    const imageUrlParagraph = document.getElementById('image-url');
    const viewLink = document.getElementById('view-link');
    
    // The API endpoint now points to your specific domain
    const API_ENDPOINT = 'https://ghostwhite-eel-836203.hostingersite.com/upload.php';

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const file = imageInput.files[0];
        if (!file) {
            statusMessage.textContent = 'Please select a file to upload.';
            return;
        }

        const formData = new FormData();
        formData.append('image', file);
        
        statusMessage.textContent = 'Uploading... Please wait.';
        resultBox.style.display = 'none';

        try {
            const response = await fetch(API_ENDPOINT, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Image upload failed.');
            }

            const data = await response.json();
            const uploadedUrl = data.url;

            imageUrlParagraph.textContent = uploadedUrl;
            viewLink.href = uploadedUrl;
            resultBox.style.display = 'block';
            statusMessage.textContent = 'Upload successful!';
            
        } catch (error) {
            console.error('Error:', error);
            statusMessage.textContent = `Error: ${error.message}`;
        }
    });
});