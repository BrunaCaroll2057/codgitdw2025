<?php
    require_once("../Classes/Livros.class.php");
    $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Livro::listar($tipo, $busca);
    $itens = '';
    foreach($lista as $livro){
        $item = file_get_contents('itens_listagem_livros.html');
        $item = str_replace('{id}',$livro->getId(),$item);
        $item = str_replace('{titulo}',$livro->getTitulo(),$item);
        $item = str_replace('{autor}',$livro->getAutor(),$item);
        $item = str_replace('{publicacao}',$livro->getPublicacao(),$item);
        $item = str_replace('{genero}',$livro->getGenero(),$item);
        $item = str_replace('{paginas}',$livro->getPaginas(),$item);
        $item = str_replace('{capa}',$livro->getCapa(),$item);
        $itens .= $item;
    }

    $listagem = file_get_contents('listagem_livros.html');
    $listagem = str_replace('{itens}',$itens,$listagem);
    print $listagem ;
?>