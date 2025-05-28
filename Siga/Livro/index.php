<?php
require_once "../Classes/Livros.class.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $titulo = isset($_POST['titulo'])?$_POST['titulo']:"";
    $autor = isset($_POST['autor'])?$_POST['autor']:"";
    $publicacao = isset($_POST['publicacao'])?$_POST['publicacao']:"";
    $genero = isset($_POST['genero'])?$_POST['genero']:"";
    $paginas = isset($_POST['paginas'])?$_POST['paginas']:0;
    $capa = isset($_POST['capa'])?$_POST['capa']:"";
    $acao = isset($_POST['acao'])?$_POST['acao']:"";

    $destino_capa = 'uploads/'.$_FILES['capa']['name'];
    move_uploaded_file($_FILES['capa']['tmp_name'],PATH_UPLOAD.$destino_capa);

    $livro = new Livro($id,$titulo,$autor,$publicacao,$genero,$paginas,$destino_capa);
var_dump($id);
    if ($acao == 'salvar'){
        if ($id > 0)
            $resultado = $livro->alterar();
        else
            $resultado = $livro->inserir();
     } else if ($acao == 'excluir')
        $resultado = $livro->excluir();

    if ($resultado)
         header("Location: index.php");
     else
         echo "Erro ao salvar dados: ". $livro;
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $formulario = file_get_contents('form_cad_livros.html');

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Livro::listar(1,$id);
    
    if ($resultado){
        $livro = $resultado[0];
        $formulario = str_replace('{id}',$livro->getId(),$formulario);
        $formulario = str_replace('{titulo}',$livro->getTitulo(),$formulario);
        $formulario = str_replace('{autor}',$livro->getAutor(),$formulario);
        $formulario = str_replace('{publicacao}',$livro->getPublicacao(),$formulario);
        $formulario = str_replace('{genero}',$livro->getGenero(),$formulario);
        $formulario = str_replace('{paginas}',$livro->getPaginas(),$formulario);
        $formulario = str_replace('{capa}',$livro->getCapa(),$formulario);
    }else{
        $formulario = str_replace('{id}',0,$formulario);
        $formulario = str_replace('{titulo}','',$formulario);
        $formulario = str_replace('{autor}','',$formulario);
        $formulario = str_replace('{publicacao}','',$formulario);
        $formulario = str_replace('{genero}','',$formulario);
        $formulario = str_replace('{paginas}','',$formulario);
        $formulario = str_replace('{capa}','',$formulario);
    }

    print $formulario; 
    include_once 'lista_livros.php';

}
?>