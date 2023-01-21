<?php
require("vendor/autoload.php");
require("class/Table.class.php");
require("includes/helpers/funcoes.php");

use Dompdf\Dompdf;

$data = $_POST;

if (empty($_POST)) {
    header("Location: index.php");
    exit();
}

$nome_remetente = $data["nome_remetente"];
$endereco_remetente = $data["endereco_remetente"];
$cidade_remetente = $data["cidade_remetente"];
$uf_remetente = $data["uf_remetente"];
$cep_remetente = $data["cep_remetente"];
$documento_remetente = $data["documento_remetente"];

$nome_destinatario = $data["nome_destinatario"];
$endereco_destinatario = $data["endereco_destinatario"];
$cidade_destinatario = $data["cidade_destinatario"];
$uf_destinatario = $data["uf_destinatario"];
$cep_destinatario = $data["cep_destinatario"];
$documento_destinatario = $data["documento_destinatario"];

$date = DateTime::createFromFormat("d/m/Y", $_POST['dt_envio']);
$monthNum = $date->format("m");
$dayNum = $date->format("d");
$yearNum = $date->format("Y");

$monthNameInPortuguese = nomeDoMes(intval($monthNum));

$dompdf = new Dompdf();

$html = "<div><h2>DECLARAÇÃO DE CONTEÚDO</h2></div>";

$dadosTable = new Table("dados");
$dadosTable->startRowHeader();
$dadosTable->addTableHeader("REMETENTE", 5);
$dadosTable->addTableHeader("DESTINATÁRIO", 5);
$dadosTable->closeRowHeader();
$dadosTable->startRowBody();
$dadosTable->addTableData("NOME: $nome_remetente", 5);
$dadosTable->addTableData("NOME: $nome_destinatario", 5);
$dadosTable->closeRowBody();
$dadosTable->startRowBody();
$dadosTable->addTableData("ENDEREÇO: $endereco_remetente", 5);
$dadosTable->addTableData("ENDEREÇO: $endereco_destinatario", 5);
$dadosTable->closeRowBody();
$dadosTable->startRowBody();
$dadosTable->addTableData("CIDADE: $cidade_remetente", 2);
$dadosTable->addTableData("UF: $uf_remetente", 3);
$dadosTable->addTableData("CIDADE: $cidade_destinatario", 2);
$dadosTable->addTableData("UF: $uf_destinatario", 3);
$dadosTable->closeRowBody();
$dadosTable->startRowBody();
$dadosTable->addTableData("CEP: $cep_remetente", 2);
$dadosTable->addTableData("CPF/CNPJ: $documento_remetente", 3);
$dadosTable->addTableData("CEP: $cep_destinatario", 2);
$dadosTable->addTableData("CPF/CNPJ: $documento_destinatario", 3);
$dadosTable->closeRowBody();
$html .= $dadosTable->render();

$conteudoTable = new Table("conteudo");
$conteudoTable->startRowHeader();
$conteudoTable->addTableHeader("IDENTIFICAÇÃO DOS BENS", 10);
$conteudoTable->closeRowHeader();
$conteudoTable->startRowHeader();
$conteudoTable->addTableHeader("ITEM", 1);
$conteudoTable->addTableHeader("CONTEÚDO", 7);
$conteudoTable->addTableHeader("QUANT.", 1);
$conteudoTable->addTableHeader("VALOR", 1);
$conteudoTable->closeRowHeader();

$quantidade_total = 0;
$valor_total = 0;
$countItem = 0;
foreach ($data['conteudo'] as $key => $value) {
    $countItem++;
    $conteudoTable->startRowBody();
    $conteudoTable->addTableData($countItem, 1, 'center');
    $conteudoTable->addTableData($value['name'], 7);
    $conteudoTable->addTableData($value['quantidade'], 1, 'center');
    $conteudoTable->addTableData($value['valor'],1, 'center');
    $conteudoTable->closeRowBody();
    $quantidade_total+=$value['quantidade'];
    $valor_total+=$value['valor'];
}
$qtdRows = 15 - (count($data['conteudo']));
$emptyRowsHtml = Table::createEmptyRows($qtdRows, 4, [1, 7, 1, 1]);
$conteudoTable->addTableHtmlToBody($emptyRowsHtml);
$conteudoTable->startRowBody();
$conteudoTable->addTableData("VALOR TOTAL", 8, 'price-cells');
$conteudoTable->addTableData($quantidade_total, 1, 'center');
$conteudoTable->addTableData($valor_total, 1, 'center');
$conteudoTable->closeRowBody();
$html .= $conteudoTable->render();

$html .= "<div><h2>DECLARAÇÃO</h2>";
$html .= "<p>Declaro que não me enquadro no conceito de contribuinte previsto no art. 4º da Lei Complementar nº 87/1996, uma vez que não realizo, com habitualidade ou em volume que caracterize intuito comercial, operações de circulação de mercadoria, ainda que se
iniciem no exterior, ou estou dispensado da emissão da nota fiscal por força da legislação tributária vigente, responsabilizando-me, nos termos da lei e a quem de direito, por informações inverídicas.
</p><p>Declaro ainda que não estou postando conteúdo inflamável, explosivo, causador de combustão espontânea, tóxico, corrosivo, gás ou qualquer outro conteúdo que constitua perigo, conforme o art. 13 da Lei Postal nº 6.538/78.</p>";
$html .= "<p style='text-align: right;'>$cidade_remetente . $dayNum de $monthNameInPortuguese de $yearNum ______________________________</p>
<p style='text-align: right;'>Assinatura do Declarante/Remetente</p></p:>
</div>";

$html .= "<div><h2 id='obs'>OBSERVAÇÃO:</h2>";
$html .= "<p>Constitui crime contra a ordem tributária suprimir ou reduzir tributo, ou contribuição social e qualquer acessório (Lei 8.137/90 Art. 1º, V)</p></div>";

$dompdf->loadHtml($html);

$dompdf->setPaper("A4");

$dompdf->render();

$dompdf->stream('declaracao_de_conteudo_'.date("dmYHis"), ['Attachment' => 0]);
?>