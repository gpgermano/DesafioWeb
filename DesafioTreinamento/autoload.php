<?php
    spl_autoload_register(
        function (string $nomeCompletoDaCLasse) 
        {
            // Substitui o namespace Gui\\Base pelo diretório src
            $caminhoCompleto = str_replace('Desafio', 'src', $nomeCompletoDaCLasse);
            
            // Substitui as barras invertidas por barras
            $caminhoArquivo = str_replace('\\', DIRECTORY_SEPARATOR, $caminhoCompleto);

            // Adiciona a extensão .php ao final do caminho de arquivo
            $caminhoArquivo.='.php';

            // Verifica se o arquivo existe
            if (file_exists($caminhoArquivo)) {
                // Inclui o arquivo
                require $caminhoArquivo;
            }
        }
    )
?>