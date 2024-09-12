const express = require('express');
const path = require('path');
const fs = require('fs');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;

// Middleware to serve static files from "public" directory
app.use(express.static(path.join(__dirname, 'public')));

// Middleware to parse form data
app.use(bodyParser.urlencoded({ extended: true }));

// Helper function to generate a unique filename
function generateUniqueFilename() {
    const uniqueId = Date.now();
    return `idmd_${uniqueId}.html`;
}

// Handle POST request from form submission
app.post('/generate', (req, res) => {
    const { site_url, meta_title, meta_description, meta_image } = req.body;

    // Create the metadata content
    const metadata = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>${meta_title}</title>
            <meta name="description" content="${meta_description}">
            <meta property="og:title" content="${meta_title}">
            <meta property="og:description" content="${meta_description}">
            <meta property="og:image" content="${meta_image}">
            <meta http-equiv="refresh" content="0; URL='${site_url}'">
        </head>
        <body></body>
        </html>
    `;

    // Save the file with a unique name in the public directory
    const filename = generateUniqueFilename();
    const filePath = path.join(__dirname, 'public', filename);

    fs.writeFile(filePath, metadata, (err) => {
        if (err) {
            return res.status(500).send('Error saving the metadata file.');
        }

        // Return a success message with a link to the file
        res.send(`Your metadata has been saved. <a href="/${filename}">View your metadata</a>`);
    });
});

// Serve the form at the root URL
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'form.html'));
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
