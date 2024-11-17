<?php

session_start();

ob_start();

include_once "conexao.php";

$arquivo = $_FILES['arquivo'];

$linhas_importadas = 0;
$linhas_nao_importadas = 0;
$cabecalho = true;

if ($arquivo['type'] == 'text/csv') {
    $dados_arquivo = fopen($arquivo["tmp_name"], "r");

    while ($linha = fgetcsv($dados_arquivo, 0, ";")) {

        if ($cabecalho) {
            $cabecalho = false;
            continue;
        }

        array_walk_recursive($linha, 'converter');

        $query_csv = "INSERT INTO indicadores (ticker, nome, preco, dy, p_l, p_vp, p_ativos, margem, margem_ebit, margem_liq, p_ebit, ev_ebit, divida_liquida_ebit, divida_liq_patrimonio, 
        psr, p_cap_giro, p_at_circ, liq_corrente, roe, roa, roic, patrimonio_ativo, passivo_ativo, giro_ativo, cagr_receita_5_anos, cagr_lucro_5_anos, liquidez_media_diaria, vpa, lpa, peg_ration, valor_de_mercado) 
        VALUES(:ticker, :nome, :preco, :dy, :p_l, :p_vp, :p_ativos, :margem, :margem_ebit, :margem_liq, :p_ebit, :ev_ebit, :divida_liquida_ebit, :divida_liq_patrimonio, 
        :psr, :p_cap_giro, :p_at_circ, :liq_corrente, :roe, :roa, :roic, :patrimonio_ativo, :passivo_ativo, :giro_ativo, :cagr_receita_5_anos, :cagr_lucro_5_anos, :liquidez_media_diaria, :vpa, :lpa, :peg_ration, :valor_de_mercado)";
        $arquivo_csv = $conn->prepare($query_csv);

        $arquivo_csv->bindValue(':ticker', $linha[0] ?? "");
        $arquivo_csv->bindValue(':nome', $linha[1] ?? "");
        $arquivo_csv->bindValue(':preco', floatval(str_replace(',', '.', $linha[2])));
        $arquivo_csv->bindValue(':dy', floatval(str_replace(',', '.', $linha[3])));
        $arquivo_csv->bindValue(':p_l', floatval(str_replace(',', '.', $linha[4])) ?? "0");
        $arquivo_csv->bindValue(':p_vp', floatval(str_replace(',', '.', $linha[5])) ?? "0");
        $arquivo_csv->bindValue(':p_ativos', floatval(str_replace(',', '.', $linha[6])) ?? "0");
        $arquivo_csv->bindValue(':margem', floatval(str_replace(',', '.', $linha[7])) ?? "0");
        $arquivo_csv->bindValue(':margem_ebit', floatval(str_replace(',', '.', $linha[8])) ?? "0");
        $arquivo_csv->bindValue(':margem_liq', floatval(str_replace(',', '.', $linha[9])) ?? "0");
        $arquivo_csv->bindValue(':p_ebit', floatval(str_replace(',', '.', $linha[10])) ?? "0");
        $arquivo_csv->bindValue(':ev_ebit', floatval(str_replace(',', '.', $linha[11])) ?? "0");
        $arquivo_csv->bindValue(':divida_liquida_ebit', floatval(str_replace(',', '.', $linha[12])) ?? "0");
        $arquivo_csv->bindValue(':divida_liq_patrimonio', floatval(str_replace(',', '.', $linha[13])) ?? "0");
        $arquivo_csv->bindValue(':psr', floatval(str_replace(',', '.', $linha[14])) ?? "0");
        $arquivo_csv->bindValue(':p_cap_giro', floatval(str_replace(',', '.', $linha[15])) ?? "0");
        $arquivo_csv->bindValue(':p_at_circ', floatval(str_replace(',', '.', $linha[16])) ?? "0");
        $arquivo_csv->bindValue(':liq_corrente', floatval(str_replace(',', '.', $linha[17])) ?? "0");
        $arquivo_csv->bindValue(':roe', floatval(str_replace(',', '.', $linha[18])) ?? "0");
        $arquivo_csv->bindValue(':roa', floatval(str_replace(',', '.', $linha[19])) ?? "0");
        $arquivo_csv->bindValue(':roic', floatval(str_replace(',', '.', $linha[20])) ?? "0");
        $arquivo_csv->bindValue(':patrimonio_ativo', floatval(str_replace(',', '.', $linha[21])) ?? "0");
        $arquivo_csv->bindValue(':passivo_ativo', floatval(str_replace(',', '.', $linha[22])) ?? "0");
        $arquivo_csv->bindValue(':giro_ativo', floatval(str_replace(',', '.', $linha[23])) ?? "0");
        $arquivo_csv->bindValue(':cagr_receita_5_anos', floatval(str_replace(',', '.', $linha[24])) ?? "0");
        $arquivo_csv->bindValue(':cagr_lucro_5_anos', floatval(str_replace(',', '.', $linha[25])) ?? "0");
        $arquivo_csv->bindValue(':liquidez_media_diaria', floatval(str_replace(',', '.', str_replace(['.', ' '], '', $linha[26]))) ?? "0");
        $arquivo_csv->bindValue(':vpa', floatval(str_replace(',', '.', $linha[27])) ?? "0");
        $arquivo_csv->bindValue(':lpa', floatval(str_replace(',', '.', $linha[28])) ?? "0");
        $arquivo_csv->bindValue(':peg_ration', floatval(str_replace(',', '.', $linha[29])) ?? "0");
        $arquivo_csv->bindValue(':valor_de_mercado', floatval(str_replace(',', '.', str_replace(['.', ' '], '', $linha[30]))) ?? "0");

        $arquivo_csv->execute();

        if ($arquivo_csv->rowCount()) {
            $linhas_importadas++;
        } else {
            $linhas_nao_importadas++;
        }

    }


    $_SESSION['msg'] = "<p>$linhas_importadas  Linha(s) importada(s)!</p>";
    header("location:enviaCSV.php");

} else {
    echo "ENVIAR SOMENTE ARQUIVO CSV";
}

function converter(&$dados_arquivo)
{
    //Converter dados de ISO-8859-1 para UTF-8
    $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
}

?>