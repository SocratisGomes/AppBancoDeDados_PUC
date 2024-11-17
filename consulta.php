<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <title>Query</title>
  <style>
    body tbody table nav {
      /* background: linear-gradient(to rigth, rgb(20, 147,220), rgb(17, 54, 71));
        color:white; */
      text-align: center;
    }

    .btn {
      width: 200px;
    }

    nav {
      position: sticky;
      top: 0;
      margin-bottom: 20px;
      z-index: 1;
    }

    table {
      margin-bottom: 20px;
    }

    .div_tabela1 {
      width: 40%;
      max-height: 1500px;
      overflow-y: auto;

    }

    .table {
      /* width: 40%; */
      border-collapse: collapse;
      table-layout: fixed;
      
    }

    thead th {
      position: sticky;
      top: 0;
      background-color: lightgray;
      /* Cor de fundo do cabeçalho */
      z-index: 1;
      /* Para manter o cabeçalho sobre o corpo da tabela */
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-light bg-light">
    <form class="form-inline" action="consulta.php" method="POST">
      <input class="form-control mr-sm-2" type="search" placeholder="Empresa" aria-label="Pesquisar" name="busca"
        autofocus>
      <button class="btn btn-info my-2 my-sm-0" type="submit">Pesquisar</button>
    </form>
    <a class="btn btn-secondary" href="">Nova Pesquisa</a>

    <form class="form-inline" action="consulta.php" method="POST">
      <button class="btn btn-warning my-2 my-sm-0" type="submit" name="bancos" value="Financeiro">Bancos</button>
    </form>

    <form class="form-inline" action="consulta.php" method="POST">
      <button class="btn btn-warning my-2 my-sm-0" type="submit" name="energia" value="Energia">Energia Elétrica</button>
    </form>

    <form class="form-inline" action="consulta.php" method="POST">
      <button class="btn btn-warning my-2 my-sm-0" type="submit" name="saneamento"
        value="Saneamento">Água e Saneamento</button>
    </form>

    <a class="btn btn-primary" href="index.php">Voltar</a>

  </nav>
  <nav class="navbar navbar-light bg-light">
  <?php
  $pesquisa = $_POST['busca'] ?? '';
  $bancos = $_POST['bancos'] ?? '';
  $energia = $_POST['energia'] ?? '';
  $saneamento = $_POST['saneamento'] ?? '';


  include "conexao.php";
  $resultPesquisa = [];
  $rows = [];
  if ($saneamento) {
    $sql = "SELECT TOP 6 
          Ticker,
          Nome,
          Setor,
          Dividendos,  
          Preco_Sobre_Valor_Patrimonial,
          Preco_Lucro,
          Retorno_Sobre_Patrimonio_Liquido,
          Taxa_de_Crescimento_5_Anos,
          Grau_De_Endividamento,
          Liquidez_Diaria,
          Valor_De_Mercado AS Valor_De_Mercado_Formatado
          FROM fundamentalista
          WHERE Setor = 'Água e Saneamento'
          ORDER BY Valor_De_Mercado DESC;";
    $result = $conn->prepare($sql);
    $result->execute();
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

  } else if ($bancos) {
    $sql = "SELECT TOP 6 
        Ticker,
        Nome,
        Setor,
        Dividendos,  
        Preco_Sobre_Valor_Patrimonial,
        Preco_Lucro,
        Retorno_Sobre_Patrimonio_Liquido,
        Taxa_de_Crescimento_5_Anos,
        Grau_De_Endividamento,
        Liquidez_Diaria,
        Valor_De_Mercado AS Valor_De_Mercado_Formatado
        FROM fundamentalista
        WHERE Setor = 'Financeiro'
        ORDER BY Valor_De_Mercado DESC;";
    $result = $conn->prepare($sql);
    $result->execute();
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

  } else if ($energia) {
    $sql = "SELECT TOP 6 
        Ticker,
        Nome,
        Setor,
        Dividendos,  
        Preco_Sobre_Valor_Patrimonial,
        Preco_Lucro,
        Retorno_Sobre_Patrimonio_Liquido,
        Taxa_de_Crescimento_5_Anos,
        Grau_De_Endividamento,
        Liquidez_Diaria,
        Valor_De_Mercado AS Valor_De_Mercado_Formatado
        FROM fundamentalista
        WHERE Setor = 'Energia Elétrica'
        ORDER BY Valor_De_Mercado DESC;";
    $result = $conn->prepare($sql);
    $result->execute();
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  } else if ($pesquisa) {
    $sql = "SELECT * FROM fundamentalista WHERE Nome LIKE :pesquisa";
    $result = $conn->prepare($sql);
    $result->bindValue(':pesquisa', "%$pesquisa%");
    $result->execute();
    $resultPesquisa = $result->fetchAll(PDO::FETCH_ASSOC);

  }
  ?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">TICKER</th>
        <th scope="col">EMPRESA</th>
        <th scope="col">SETOR</th>
        <th scope="col">(%)DIVIDENDOS</th>
        <th scope="col">PREÇO/VALOR PATRIM.</th>
        <th scope="col">PREÇO/LUCRO</th>
        <th scope="col">(%)RETOR/PATRIM. LÍQ.</th>
        <th scope="col">(%) DE CRESCIMENTO</th>
        <th scope="col">ENDIVIDAMENTO</th>
        <th scope="col">(R$)LIQUIDEZ DIÁRIA </th>
        <th scope="col">(R$)VALOR DE MERCADO </th>
      </tr>
    </thead>
    <tbody>
      <?php
      // include "conexao.php";
      if ($rows) {
        // Encontrar valores máximos de cada coluna
        $maxDividendos = max(array_column($rows, 'Dividendos'));
        $maxPvp = min(array_column($rows, 'Preco_Sobre_Valor_Patrimonial'));
        $maxPl = min(array_column($rows, 'Preco_Lucro'));
        $maxRoe = max(array_column($rows, 'Retorno_Sobre_Patrimonio_Liquido'));
        $maxCagr = max(array_column($rows, 'Taxa_de_Crescimento_5_Anos'));
        $maxEvebit = min(array_column($rows, 'Grau_De_Endividamento'));
        $maxLiqDiaria = max(array_column($rows, 'Liquidez_Diaria'));
        $maxValorMercado = max(array_column($rows, 'Valor_De_Mercado_Formatado'));

        // Função para destacar o valor máximo - movida para fora do loop
        function DestacaFormata($value, $max)
        {
          return $value == $max 
    ? "<strong style='color: green;'><img src='src/favorito.png' style='width: 20px; vertical-align: middle; margin-right: 5px;' alt='Máximo'>" . number_format($value, 2, ',', '.') . "</strong>" 
    : "<span style='display: inline-block; width: 25px;'></span> " . number_format($value, 2, ',', '.');
        }
        foreach ($rows as $linha) {
          $ticker = $linha['Ticker'];
          $nome = $linha['Nome'];
          $setor = $linha['Setor'];
          $dividendos = $linha['Dividendos'];
          $pvp = $linha['Preco_Sobre_Valor_Patrimonial'];
          $pl = $linha['Preco_Lucro'];
          $roe = $linha['Retorno_Sobre_Patrimonio_Liquido'];
          $cagr = $linha['Taxa_de_Crescimento_5_Anos'];
          $evebit = $linha['Grau_De_Endividamento'];
          $liqDiaria = $linha['Liquidez_Diaria'];
          $ValorMercado = $linha['Valor_De_Mercado_Formatado'];

          echo "<tr>
                        <td scope='row'>$ticker</td>
                        <td>$nome</td>
                        <td>$setor</td>
                        <td>" . DestacaFormata($dividendos, $maxDividendos) . "</td>
                        <td>" . DestacaFormata($pvp, $maxPvp) . "</td>
                        <td>" . DestacaFormata($pl, $maxPl) . "</td>
                        <td>" . DestacaFormata($roe, $maxRoe) . "</td>
                        <td>" . DestacaFormata($cagr, $maxCagr) . "</td>
                        <td>" . DestacaFormata($evebit, $maxEvebit) . "</td>
                        <td>" . DestacaFormata($liqDiaria, $maxLiqDiaria) . "</td>
                        <td>" . DestacaFormata($ValorMercado, $maxValorMercado) . "</td>
                    </tr>";
        }
      } else if ($resultPesquisa) {
        function Formata($value)
        {
          return number_format($value, 2, ',', '.');
        }
        foreach ($resultPesquisa as $linha) {
          $ticker = $linha['Ticker'];
          $nome = $linha['Nome'];
          $setor = $linha['Setor'];
          $dividendos = $linha['Dividendos'];
          $pvp = $linha['Preco_Sobre_Valor_Patrimonial'];
          $pl = $linha['Preco_Lucro'];
          $roe = $linha['Retorno_Sobre_Patrimonio_Liquido'];
          $cagr = $linha['Taxa_de_Crescimento_5_Anos'];
          $evebit = $linha['Grau_De_Endividamento'];
          $liqDiaria = $linha['Liquidez_Diaria'];
          $ValorMercado = $linha['Valor_De_Mercado'];

          echo "<tr>
                    <td scope='row'>$ticker</td>
                    <td>$nome</td>
                    <td>$setor</td>
                    <td>" . Formata($dividendos) . "</td>
                    <td>" . Formata($pvp) . "</td>
                    <td>" . Formata($pl) . "</td>
                    <td>" . Formata($roe) . "</td>
                    <td>" . Formata($cagr) . "</td>
                    <td>" . Formata($evebit) . "</td>
                    <td>" . Formata($liqDiaria) . "</td>
                    <td>" . Formata($ValorMercado) . "</td>
              
                </tr>";
        }
      }
      ?>
    </tbody>
  </table>

  </nav>
  <nav class="navbar navbar-light bg-light">
  <?php
  include "conexao.php";
  // consulta SQL
  $sql = "SELECT Ticker, Nome, Setor FROM fundamentalista ORDER BY Setor";
  // Preparar a consulta
  $result = $conn->prepare($sql);
  // Executar a consulta
  $result->execute();
  // print_r($result);
  ?>
  <div class="div_tabela1">
    <table class="table cabecalho">
      <thead class="thead-light">
        <tr>
          <!-- <th scope="col">TICKER</th> -->
          <th scope="col">EMPRESA</th>
          <th scope="col">SETOR</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result) {
          // Exibindo os dados em uma tabela HTML
          foreach ($result as $row) {
            echo "<tr>";
            // echo "<td>" . htmlspecialchars($row['Ticker']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nome']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Setor']) . "</td>";
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo "Nenhum resultado encontrado.";
        }
        ?>
      </tbody>
    </table>
  </div>
  </nav>
</body>

</html>