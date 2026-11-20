<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload de Múltiplas Imagens</title>
        <style>.warning { color: red; font-weight: bold; }</style>
    </head>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
            Selecione as imagens para upload:
            <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
            <input type="submit" value="Upload Images" name="submit">
        </form>
        <div id="status" class="warning"></div>

        <script>
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                const files = document.getElementById('fileToUpload').files;
                const status = document.getElementById('status');
                status.innerHTML = '';

                if (files.length > 500) {
                    e.preventDefault();
                    status.innerHTML = 'Erro: Máximo de 500 arquivos permitido.';
                    return;
                }

                let totalSize = 0;
                for (let i = 0; i < files.length; i++) {
                    totalSize += files[i].size;
                }

                if (totalSize > 500 * 1024 * 1024) {
                    e.preventDefault();
                    status.innerHTML = 'Erro: O tamanho total excede 500MB. Isso pode causar lentidão severa.';
                } else if (totalSize > 100 * 1024 * 1024) {
                    status.innerHTML = 'Aviso: Você está enviando muitos dados. O processo pode demorar.';
                }
            });
        </script>
    </body>
</html>