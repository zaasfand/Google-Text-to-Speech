<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text-to-Speech Converter</title>

    <style>
        /* Add this CSS for the navbar */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        nav {
            background-color: #333;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>

<body>
    <nav>
        <a href="#">Google Text-to-Speech</a>
    </nav>

    <form action="{{ route('process.docx') }}" method="post" enctype="multipart/form-data" class="form-container" id="audioForm">
        @csrf
        <div class="form-group">
            <label for="docx_file">Choose a .docx file:</label>
            <input type="file" name="docx_file" id="docx_file" accept=".docx" class="file-input">
        </div>

        <div class="form-group">
            <label for="language">Select Language:</label>
            <select name="language" id="language" class="select-language">
                <option value="da-DK">Danish</option>
                <option value="nl-NL">Dutch</option>
                <option value="fa-IR">Farsi</option>
                <option value="hu-HU">Hungarian</option>
                <option value="fi-FI">Finnish</option>
                <option value="id-ID">Indonesian</option>
                <option value="it-IT">Italian</option>
                <option value="sv-SE">Swedish</option>
                <option value="tr-TR">Turkish</option>
                <!-- Add more language options as needed -->
            </select>
        </div>

        <button class="generate-button" type="submit">Generate Audio</button>
    </form>

    <style>
.form-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 8px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.file-input, .select-language {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.generate-button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.generate-button:hover {
    background-color: #45a049;
}

    </style>


</body>

</html>
