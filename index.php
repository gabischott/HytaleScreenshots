<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload de Múltiplas Imagens</title>
    </head>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Nick:
            <input type="text" name="nick">
            Selecione as imagens para upload:
            <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
            <input type="submit" value="Upload Images" name="submit">
        </form>
    </body>
</html>