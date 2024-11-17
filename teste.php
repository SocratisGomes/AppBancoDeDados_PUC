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
      background-color: #f4f4f4;
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
      <button class="btn btn-warning" my-2 my-sm-0" type="submit" name="bancos" value="Bancos">Banco</button>
    </form>

    <form class="form-inline" action="consulta.php" method="POST">
      <button class="btn btn-warning" my-2 my-sm-0" type="submit" name="energia" value="Energia">Energia</button>
    </form>

    <form class="form-inline" action="consulta.php" method="POST">
      <button class="btn btn-warning" my-2 my-sm-0" type="submit" name="saneamento"
        value="Saneamento">Saneamento</button>
    </form>

    <a class="btn btn-primary" href="index.php">Voltar</a>

    <?php
    include "conexao.php";
    function buscarDadosBancos($conn){
    $sql = "SELECT TOP 6 
    Ticker,
    Nome,
    Setores,
    Dividendos,  
    Preco_Sobre_Valor_Patrimonial,
    Preco_Lucro,
    Retorno_Sobre_Patrimonio_Liquido,
    Taxa_de_Crescimento_5_Anos,
    Grau_De_Endividamento,
    Liquidez_Diaria,
    FORMAT(Valor_De_Mercado, 'C', 'pt-BR') AS Valor_De_Mercado_Formatado
    FROM fundamentalista
    WHERE Setores = 'Bancos'
    ORDER BY Valor_De_Mercado DESC;";

      $result = $conn->prepare($sql);
      $result->execute();
      return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscarDadosEnergia($conn)
    {
      // Define a consulta SQL para obter os dados do setor "Energia"
      $sql = "SELECT TOP 6 
    Ticker,
    Nome,
    Setores,
    Dividendos,  
    Preco_Sobre_Valor_Patrimonial,
    Preco_Lucro,
    Retorno_Sobre_Patrimonio_Liquido,
    Taxa_de_Crescimento_5_Anos,
    Grau_De_Endividamento,
    Liquidez_Diaria,
    FORMAT(Valor_De_Mercado, 'C', 'pt-BR') AS Valor_De_Mercado_Formatado
    FROM fundamentalista
    WHERE Setores = 'Energia Elétrica'
    ORDER BY Valor_De_Mercado DESC;";

      $result = $conn->prepare($sql);
      $result->execute();
      return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    function buscarDadosSaneamento($conn)
    {
      // Define a consulta SQL para obter os dados do setor "Saneamento"
      $sql = "SELECT TOP 6 
      Ticker,
      Nome,
      Setores,
      Dividendos,  
      Preco_Sobre_Valor_Patrimonial,
      Preco_Lucro,
      Retorno_Sobre_Patrimonio_Liquido,
      Taxa_de_Crescimento_5_Anos,
      Grau_De_Endividamento,
      Liquidez_Diaria,
      Valor_De_Mercado AS Valor_De_Mercado_Formatado
      FROM fundamentalista
      WHERE Setores = 'Água e Saneamento'
      ORDER BY Valor_De_Mercado DESC;";
    

      $result = $conn->prepare($sql);
      $result->execute();
      return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    function gerarEstruturaTabela($dados, $colunaDestaque1, $colunaDestaque2, $colunaDestaque3, $colunaDestaque4, $colunaDestaque5, $colunaDestaque6, $colunaDestaque7, $colunaDestaque8)
    {
      // Verifica se há dados para exibir
      if (empty($dados)) {
        return "<p>Nenhum resultado encontrado.</p>";
      }
      // Encontrar os maiores valores das duas colunas desejadas para destaque
      $maiorValor1 = max(array_column($dados, $colunaDestaque1));
      $maiorValor2 = min(array_column($dados, $colunaDestaque2));
      $maiorValor3 = min(array_column($dados, $colunaDestaque3));
      $maiorValor4 = max(array_column($dados, $colunaDestaque4));
      $maiorValor5 = max(array_column($dados, $colunaDestaque5));
      $maiorValor6 = min(array_column($dados, $colunaDestaque6));
      $maiorValor7 = max(array_column($dados, $colunaDestaque7));
      $maiorValor8 = max(array_column($dados, $colunaDestaque8));
      // Gera a estrutura da tabela
      $tabela = '<table class="table cabecalho">';
      $tabela .= '<thead class="thead-light">';
      $tabela .= '<tr>';
      $tabela .= '<th scope="col">Ticker</th>';
      $tabela .= '<th scope="col">Empresa</th>';
      $tabela .= '<th scope="col">Setor</th>';
      $tabela .= '<th scope="col">Dividendos</th>';
      $tabela .= '<th scope="col">Preço/Patrimônio</th>';
      $tabela .= '<th scope="col">Preço/Lucro</th>';
      $tabela .= '<th scope="col">Retorno/Patrimônio Liq.</th>';
      $tabela .= '<th scope="col">Taxa de Crescimento</th>';
      $tabela .= '<th scope="col">Endividamento</th>';
      $tabela .= '<th scope="col">Liquidez Diária</th>';
      $tabela .= '<th scope="col">Valor de Mercado</th>';
      $tabela .= '</tr>';
      $tabela .= '</thead>';
      $tabela .= '<tbody>';

      // Gera as linhas de dados da tabela
      foreach ($dados as $row) {
        $tabela .= '<tr>';
        $tabela .= '<td>' . htmlspecialchars($row['Ticker']) . '</td>';
        $tabela .= '<td>' . htmlspecialchars($row['Nome']) . '</td>';
        $tabela .= '<td>' . htmlspecialchars($row['Setores']) . '</td>';
        // Gerar as células da linha com destaque para a coluna de interesse
        foreach (['Dividendos', 'Preco_Sobre_Valor_Patrimonial', 'Preco_Lucro', 'Retorno_Sobre_Patrimonio_Liquido', 'Taxa_de_Crescimento_5_Anos', 'Grau_De_Endividamento', 'Liquidez_Diaria', 'Valor_De_Mercado_Formatado'] as $coluna) {
          // Verifica se a coluna atual é uma das colunas de destaque e tem o maior valor correspondente
          if (
            ($coluna === $colunaDestaque1 && $row[$coluna] == $maiorValor1) ||
            ($coluna === $colunaDestaque2 && $row[$coluna] == $maiorValor2) ||
            ($coluna === $colunaDestaque3 && $row[$coluna] == $maiorValor3) ||
            ($coluna === $colunaDestaque4 && $row[$coluna] == $maiorValor4) ||
            ($coluna === $colunaDestaque5 && $row[$coluna] == $maiorValor5) ||
            ($coluna === $colunaDestaque6 && $row[$coluna] == $maiorValor6) ||
            ($coluna === $colunaDestaque7 && $row[$coluna] == $maiorValor7) ||
            ($coluna === $colunaDestaque8 && $row[$coluna] == $maiorValor8)
          ) {
            // Aplica o destaque ao maior valor
            $tabela .= '<td style="font-weight: bold; color: green;">' . htmlspecialchars($row[$coluna]) . '</td>';
          } else {
            $tabela .= '<td>' . htmlspecialchars($row[$coluna]) . '</td>';
          }
        }
        $tabela .= '</tr>';
      }
      $tabela .= '</tbody>';
      $tabela .= '</table>';
      return $tabela;
    }
    // Chamada das funções
    $bancos = $_POST['bancos'] ?? '';
    $energia = $_POST['energia'] ?? '';
    $saneamento = $_POST['saneamento'] ?? '';
    
    if ($bancos) {
      $dados = buscarDadosBancos($conn);
      // print_r($dados);
      echo gerarEstruturaTabela(
        $dados,
        'Dividendos',
        'Preco_Sobre_Valor_Patrimonial',
        'Preco_Lucro',
        'Retorno_Sobre_Patrimonio_Liquido',
        'Taxa_de_Crescimento_5_Anos',
        'Grau_De_Endividamento',
        'Liquidez_Diaria',
        'Valor_De_Mercado_Formatado'
      );

    } else if ($energia) {
      $dados = buscarDadosEnergia($conn);
      echo gerarEstruturaTabela(
        $dados,
        'Dividendos',
        'Preco_Sobre_Valor_Patrimonial',
        'Preco_Lucro',
        'Retorno_Sobre_Patrimonio_Liquido',
        'Taxa_de_Crescimento_5_Anos',
        'Grau_De_Endividamento',
        'Liquidez_Diaria',
        'Valor_De_Mercado_Formatado'
      );
    } else if ($saneamento) {
      $dados = buscarDadosSaneamento($conn);
      echo gerarEstruturaTabela(
        $dados,
        'Dividendos',
        'Preco_Sobre_Valor_Patrimonial',
        'Preco_Lucro',
        'Retorno_Sobre_Patrimonio_Liquido',
        'Taxa_de_Crescimento_5_Anos',
        'Grau_De_Endividamento',
        'Liquidez_Diaria',
        'Valor_De_Mercado_Formatado'
      );
    } else {
      echo "<p>Parâmetro não foi fornecido.</p>";
    }

    ?>
  </nav>
  <?php
  $pesquisa = $_POST['busca'] ?? '';
  include "conexao.php";
  if ($pesquisa) {
    $sql = "SELECT * FROM fundamentalista WHERE Nome LIKE :pesquisa";
    $result = $conn->prepare($sql);
    // $result = prepare($sql);
    $result->bindValue(':pesquisa', "%$pesquisa%");
    $result->execute();
    // print_r($result)     
    // $dados = mysqli_query($conn, $sql);
    $resultados = $result->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="table cabecalho">
      <thead class="thead-light">
        <tr>
          <th scope="col">Ticker</th>
          <th scope="col">Empresa</th>
          <th scope="col">Setor</th>
          <th scope="col">Dividendos</th>
          <th scope="col">Preço/Patrimônio</th>
          <th scope="col">Preço/Lucro</th>
          <th scope="col">Retorno/Patrimônio Liq.</th>
          <th scope="col">Taxa de Crescimento</th>
          <th scope="col">Endividamento</th>
          <th scope="col">Liquidez Diária</th>
          <th scope="col">Valor de Mercado</th>
        </tr>
      </thead>

      <tbody>
        <?php
        if ($resultados) {
          foreach ($resultados as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Ticker']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Nome']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Setores']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Dividendos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Preco_Sobre_Valor_Patrimonial']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Preco_Lucro']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Retorno_Sobre_Patrimonio_Liquido']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Taxa_de_Crescimento_5_Anos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Grau_De_Endividamento']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Liquidez_Diaria']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Valor_De_Mercado']) . "</td>";
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo "Nenhum resultado encontrado.";
        }
  } else {
    echo "";
  }
  ?>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">

      </div>

      <?php
      include "conexao.php";
      // Consulta SQL
      $sql = "SELECT Ticker, Nome, Setores FROM fundamentalista ORDER BY Setores";
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
              <!-- <th scope="col">Ticker</th> -->
              <th scope="col">Empresa</th>
              <th scope="col">Setor</th>
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
                echo "<td>" . htmlspecialchars($row['Setores']) . "</td>";
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
</body>

</html>