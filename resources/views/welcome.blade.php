<form action="{{ route('process.docx') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="docx_file" accept=".docx">
    <select name="language">
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
    <button type="submit">Generate Audio</button>
</form>
