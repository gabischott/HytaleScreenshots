<?php
$target_dir = "uploads/";
$uploadOk = 1;

// Verifica se o formulário foi enviado
if(isset($_POST["submit"])) {
    
    // Conta quantos arquivos foram enviados
    $totalFiles = count($_FILES['fileToUpload']['name']);

    // Loop através de cada arquivo
    for($i = 0; $i < $totalFiles; $i++) {
        
        $fileName = $_FILES["fileToUpload"]["name"][$i];
        
        if(empty($fileName)) {
            continue;
        }

        $target_file = $target_dir . basename($fileName);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $currentUploadOk = 1;
        
        $dataExtraida = null;
        $horaExtraida = null;

        // O Regex procura por: Ano (4 dígitos), Mês (2), Dia (2), Hora (2), Minuto (2), Segundo (2)
        if (preg_match('/^Hytale(\d{4})-(\d{2})-(\d{2})_(\d{2})-(\d{2})-(\d{2})\.(jpg|jpeg|png|gif)$/i', $fileName, $matches)) {
            $ano = $matches[1];
            $mes = $matches[2];
            $dia = $matches[3];
            $hora = $matches[4];
            $minuto = $matches[5];
            $segundo = $matches[6];

            $dataExtraida = "$dia/$mes/$ano";
            $horaExtraida = "$hora:$minuto:$segundo";
        } else {
            echo "<br>O arquivo <strong>" . htmlspecialchars($fileName) . "</strong> foi rejeitado. O print precisa ter sido tirado usado a ferramenta ingame do Hytale.<br>";
            $currentUploadOk = 0;
        }

        // 1. Verifica se é uma imagem real
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
        if($check !== false) {
            echo "<br>Arquivo <strong>" . htmlspecialchars($fileName) . "</strong> é uma imagem - " . $check["mime"] . ".";
        } else {
            echo "<br>Arquivo <strong>" . htmlspecialchars($fileName) . "</strong> não é uma imagem.";
            $currentUploadOk = 0;
        }

        // 2. Verifica se o arquivo já existe
        if (file_exists($target_file)) {
            echo "<br>Desculpe, o arquivo <strong>" . htmlspecialchars($fileName) . "</strong> já existe.";
            $currentUploadOk = 0;
        }

        // 3. Verifica o tamanho do arquivo (limite de por exemplo)
        if ($_FILES["fileToUpload"]["size"][$i] > 50000) {
            echo "<br>Desculpe, o arquivo <strong>" . htmlspecialchars($fileName) . "</strong> é muito grande.";
            $currentUploadOk = 0;
        }

        // 4. Permite apenas determinados formatos
        if($imageFileType != "png") {
            echo "<br>Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos para <strong>" . htmlspecialchars($fileName) . "</strong>.";
            $currentUploadOk = 0;
        }

        // 5. Tenta fazer o upload se tudo estiver ok para este arquivo
        if ($currentUploadOk == 0) {
            echo "<br>O arquivo <strong>" . htmlspecialchars($fileName) . "</strong> não pôde ser enviado.<br>";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                echo "<br>O arquivo <strong>" . htmlspecialchars(basename($fileName)) . "</strong> foi enviado com sucesso.<br>";
            } else {
                echo "<br>Desculpe, ocorreu um erro ao enviar o arquivo <strong>" . htmlspecialchars($fileName) . "</strong>.<br>";
            }
        }
    }
}
?>