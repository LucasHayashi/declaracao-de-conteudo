<?php
session_start();

require("vendor/autoload.php");
require("class/Table.class.php");
require("includes/helpers/funcoes.php");

use Dompdf\Dompdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

$filters = [
    'nome_remetente' => FILTER_SANITIZE_SPECIAL_CHARS,
    'documento_remetente' => FILTER_SANITIZE_SPECIAL_CHARS,
    'cep_remetente' => FILTER_SANITIZE_SPECIAL_CHARS,
    'cidade_remetente' => FILTER_SANITIZE_SPECIAL_CHARS,
    'uf_remetente' => FILTER_SANITIZE_SPECIAL_CHARS,
    'endereco_remetente' => FILTER_SANITIZE_SPECIAL_CHARS,
    'nome_destinatario' => FILTER_SANITIZE_SPECIAL_CHARS,
    'documento_destinatario' => FILTER_SANITIZE_SPECIAL_CHARS,
    'cep_destinatario' => FILTER_SANITIZE_SPECIAL_CHARS,
    'cidade_destinatario' => FILTER_SANITIZE_SPECIAL_CHARS,
    'uf_destinatario' => FILTER_SANITIZE_SPECIAL_CHARS,
    'endereco_destinatario' => FILTER_SANITIZE_SPECIAL_CHARS,
    'dt_envio' => FILTER_SANITIZE_SPECIAL_CHARS,
    'cod_rastreamento' => FILTER_SANITIZE_SPECIAL_CHARS,
    'chk_aut_vizinho' => FILTER_SANITIZE_SPECIAL_CHARS,
    'csrf_token' => FILTER_SANITIZE_SPECIAL_CHARS,
    'nome_vizinho' => FILTER_SANITIZE_SPECIAL_CHARS,
    'conteudo' => [
        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY
    ]
];

$data = filter_input_array(INPUT_POST, $filters);

if (!isset($data['csrf_token']) || !isset($_SESSION['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Erro: Token CSRF inválido. Requisição não autorizada.");
}

if (empty($data)) {
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

$chk_aut_vizinho = $data["chk_aut_vizinho"];
$nome_vizinho = $data["nome_vizinho"];

$date = DateTime::createFromFormat("d/m/Y", $_POST['dt_envio']);
$monthNum = $date->format("m");
$dayNum = $date->format("d");
$yearNum = $date->format("Y");

$cod_rastreamento = $data['cod_rastreamento'];

$monthNameInPortuguese = nomeDoMes(intval($monthNum));

$dompdf = new Dompdf();

$html = "<div class='declaracao'><h2>DECLARAÇÃO DE CONTEÚDO</h2>";
if (!empty($cod_rastreamento)) {
    $html .= "<h3>Codigo de rastreamento: {$cod_rastreamento}</h3>";
}
$html .= "</div>";

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
$dadosTable->addTableData("CIDADE: $cidade_remetente", 3);
$dadosTable->addTableData("UF: $uf_remetente", 2);
$dadosTable->addTableData("CIDADE: $cidade_destinatario", 3);
$dadosTable->addTableData("UF: $uf_destinatario", 2);
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
    $conteudoTable->addTableData($value['valor'], 1, 'center');
    $conteudoTable->closeRowBody();
    $quantidade_total += $value['quantidade'];
    $valor_total += $value['valor'];
}

$conteudoTable->startRowBody();
$conteudoTable->addTableData("VALOR TOTAL", 8, 'price-cells');
$conteudoTable->addTableData($quantidade_total, 1, 'center');
$conteudoTable->addTableData($valor_total, 1, 'center');
$conteudoTable->closeRowBody();
$html .= $conteudoTable->render();

$html .= "<div class='declaracao'><h2>DECLARAÇÃO</h2>";
$html .= "<p>Declaro que não me enquadro no conceito de contribuinte previsto no art. 4º da Lei Complementar nº 87/1996, uma vez que não realizo, com habitualidade ou em volume que caracterize intuito comercial, operações de circulação de mercadoria, ainda que se
iniciem no exterior, ou estou dispensado da emissão da nota fiscal por força da legislação tributária vigente, responsabilizando-me, nos termos da lei e a quem de direito, por informações inverídicas.
</p><p>Declaro ainda que não estou postando conteúdo inflamável, explosivo, causador de combustão espontânea, tóxico, corrosivo, gás ou qualquer outro conteúdo que constitua perigo, conforme o art. 13 da Lei Postal nº 6.538/78.</p>";
$html .= "<p style='text-align: right;'>$cidade_remetente . $dayNum de $monthNameInPortuguese de $yearNum ______________________________</p>
<p style='text-align: right;'>Assinatura do Declarante/Remetente</p></p:>
</div>";

$html .= "<div class='declaracao'><h2 id='obs'>OBSERVAÇÃO:</h2>";
$html .= "<p>Constitui crime contra a ordem tributária suprimir ou reduzir tributo, ou contribuição social e qualquer acessório (Lei 8.137/90 Art. 1º, V)</p></div>";

$generator = new BarcodeGeneratorPNG();
$barcode = $generator->getBarcode($cep_destinatario, $generator::TYPE_CODE_128);

$html .= '
    <!-- Quebra de página para a etiqueta -->
    <div style="page-break-before: always;"></div>

    <style>
        .etiqueta-correios {
            width: 9cm;
            height: 14cm;
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 12px;
            position: relative;
        }
        .etiqueta-correios .barcode {
            text-align: center;
            margin-top: 10px;
        }
        .etiqueta-correios .barcode img {
            width: 4cm;
            height: 1cm;
        }
        .etiqueta-correios .sticker-area {
            width: 8.5cm;
            height: 5cm;
            border: 1px dashed #000;
            margin: 0 auto;
            text-align: center;
            line-height: 5cm;
            font-size: 12px;
            color: #666;
        }
        .etiqueta-correios .info {
            margin-bottom: 10px;
        }
        .etiqueta-correios .info div {
            margin-bottom: 5px;
        }
        .etiqueta-correios .recebedor {
            margin-top: 10px;
        }
        .etiqueta-correios .recebedor div {
            margin-bottom: 5px;
        }
    </style>

    <!-- Etiqueta dos Correios -->
    <div class="etiqueta-correios">
        <div class="sticker-area">Espaço para colagem da etiqueta</div>
        <div class="recebedor">
            <div><strong>Recebedor:</strong> _______________________________</div>
            <div><strong>Assinatura:</strong> _______________________________</div>
            <div><strong>Documento:</strong> _____________________________</div>
        </div>
        <div class="info">
            <div><strong>Entrega no vizinho autorizada?</strong> ' . ($chk_aut_vizinho ? $nome_vizinho : "Entrega no vizinho não autorizada") . '</div>
        </div>
        <div class="info">
            <div><strong>Destinatário:</strong> ' . $nome_destinatario . '</div>
            <div>' . $endereco_destinatario . '</div>
            <div>' . $cidade_destinatario . '/' . $uf_destinatario . ' - ' . $cep_destinatario . '</div>
        </div>
        <div class="barcode">
            <img src="data:image/png;base64,' . base64_encode($barcode) . '" alt="Código de Barras">
        </div>
        <hr />
        <div class="info">
            <div><strong>Remetente:</strong> ' . $nome_remetente . '</div>
            <div>' . $endereco_remetente . '</div>
            <div>' . $cidade_remetente . '/' . $uf_remetente . ' - ' . $cep_remetente . '</div>
        </div>
    </div>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4");
$dompdf->render();
$dompdf->stream('declaracao_de_conteudo_' . date("dmYHis"), ['Attachment' => 0]);
