<?php

function getProximoContadorArquivos() {
    $arquivo = "contadorArquivos.txt";

    $handle = fopen($arquivo, 'r+'); //Abri o arquivo
    $dados = fread($handle, 512); //Pega o conteúdo do arquivo

    // Incrementa 1 se o número inteiro, caso contrário atribui 1
    // Evita o erro do contadoArquivos.txt estar vazio
    //$contador = (is_int($dados)) ? $dados + 1 : 1;
    $contador = $dados + 1; //incrementa em mais 1

    fseek($handle, 0); //Ponteiro volta para o início do arquivo
    fwrite($handle, $contador); //Escreve no arquivo
    fclose($handle); //Fecha o arquivo

    return $contador;
}

//echo getProximoContadorArquivos();

function adicionaArquivo($nomeArquivo, $arquivoTmp) {
    $ext = pathinfo($nomeArquivo, PATHINFO_EXTENSION); 
    $imagem = getProximoContadorArquivos() . "." . $ext;
    $caminhoDestino = "arquivos/" . $imagem;

    move_uploaded_file($arquivoTmp, $caminhoDestino);
    return $imagem;
}

function getImagemUsuario($id, $conexao) {
    $sql = "select imagem from usuario where id = {$id}";
    $resultado = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($resultado);

    return $linha['imagem'];
}

function excluiArquivo($pathArquivo) {
    if (!is_dir($pathArquivo) && file_exists($pathArquivo)) {
        unlink($pathArquivo);
    }
}