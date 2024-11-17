<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Envio da Base de Dados .csv</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #F0F8FF;
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            width: 30%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: 50%;
            border-radius: 20px;
            border: 2px dashed grey;
        }

        .img {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
            margin-bottom: 20px;
            width: 100px;
            height: 100px;
        }

        .icon_upload {
            margin-top: 25px;
        }

        .form {
            display: flex;
            width: 70%;
            height: 50%;
            flex-direction: column;
            justify-content: center;
            position: fixed;
            /* Fixa a div na janela */
            bottom: 50px;
            /* Distância do fundo da janela */
            left: 50%;
            /* Centraliza a div horizontalmente */
            transform: translateX(-50%);
            /* Ajusta a posição para o centro */
            padding: 10px;
            /* Espaçamento interno */
        }

        button {
            width: 100%;
            height: 50px;
            font-size: large;
            font-weight: bold;
            color: white;
            background-color: #5E9BFF;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #4682B4;
        }

        label {
            display: flex;
            justify-content: center;
            margin-bottom: 5px;
        }

        .arquivo {
            position: absolute;
            /* Posiciona em relação à div de fundo */
            top: 0;
            /* Alinha no topo da div de fundo */
            left: 0;
            /* Alinha à esquerda da div de fundo */
            width: 100%;
            /* Faz a div superior ocupar 100% da largura da div de fundo */
            height: 40%;
            /* Faz a div superior ocupar 100% da altura da div de fundo */
            /* background-color: rgba(255, 0, 0, 0.5); Cor de fundo vermelho com opacidade */
            display: flex;
            /* Usado para centralizar o texto */
            justify-content: center;
            /* Centraliza horizontalmente */
            align-items: center;
            /* Centraliza verticalmente */
            color: white;
            /* Cor do texto */
            font-size: 20px;
            /* Tamanho do texto */
            z-index: 1;
            /* Garante que esta div fique acima da div de fundo */
            cursor: pointer;
            opacity: 0;
            background-color: yellow;
        }

        .upload {
            margin-top: 60px;
            /* height: inherit; */
            display: inline-block;
            /* padding: 5px 5px; */
            cursor: pointer;
            /* Cor de fundo */
            color: black;
            transition: background-color 0.3s;
            /* Transição suave */
            text-align: center;
            /* Centraliza o texto */
        }

        .file-name {
            margin-left: 10px;
            /* Espaço entre o botão e o nome do arquivo */
            font-weight: bold;
            margin-bottom: 15px;
            gap: 20px;
            display: flex;
            font-size: small;
        }

        span {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            background-color: white;
        }
        .msg{
            color: green;
            font-weight: bold;
            position: fixed;
            bottom: 10px;
        }
        .button_padrao{
            width: 100px;
            margin-left: 20px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="img">
            <img src="src/logo-puc.png" style="margin-top: 10px;">
            <img class="icon_upload" src="src/icon_upload.png">
        </div>
        <div class="form">
            <form action="processa.php" method="POST" enctype="multipart/form-data">
                <label for="" class="upload">Selecione o arquivo da base de dados no formato CSV
                    <input type="file" name="arquivo" class="arquivo" onchange="updateFileName(event)"  accept="text/csv"/>
                </label>
                <span class="file-name" id="file-name">Nenhum arquivo selecionado</span>
                <button type="submit">Enviar para Banco de Dados</button>            
            </form>           
           </div>
           <div class="msg">
            <?php 
                if(isset($_SESSION["msg"])){
                    echo $_SESSION["msg"];
                    unset($_SESSION["msg"]);
                }          
                ?>
            </div>   
              
    </div>
       
    <script>
        function updateFileName(event) {
            const input = event.target;
            const fileName = input.files.length > 0 ? input.files[0].name : "Nenhum arquivo selecionado";
            document.getElementById("file-name").textContent = fileName;
        }
    </script>
    <div class="button_padrao">
        <a type="button" class="btn btn-primary" href="index.php">VOLTAR</a>   
    </div>
</body>

</html>