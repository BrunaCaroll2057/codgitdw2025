<?php
require_once "Database.class.php";
class Livro{
    private $id;
    private $titulo;
    private $autor;
    private $publicacao;
    private $genero;
    private$paginas;
    private $capa;

    // construtor da classe
    public function __construct($id,$tit,$aut,$publi,$gen,$pag,$capa){
        $this->id = $id;
        $this->titulo = $tit;
        $this->autor = $aut;
        $this->publicacao = $publi;
        $this->genero = $gen;
        $this->paginas = $pag;
        $this->capa = $capa;
    }

    // função / interface para alterar e ler
    public function setTitulo($tit){
        if ($tit == "")
            throw new Exception("Erro, o título deve ser informado!");
        else
            $this->titulo = $tit;
    }
    // cada atributo tem um método set para alterar seu valor
    public function setId($id){
        if ($id < 0)
            throw new Exception("Erro, a ID deve ser maior que 0!");
        else
            $this->id = $id;
    }

    public function setAutor($aut){
            if ($aut == "")
                throw new Exception("Erro, o nome do autor deve ser informado!");
            else
                $this->autor = $aut;
    }
        public function setPublicacao($publi){
        if ($publi == "")
            throw new Exception("Erro, a data de publicação deve ser informada!");
        else
            $this->publicacao = $publi;
    }
        public function setGenero($gen){
        if ($gen == "")
            throw new Exception("Erro, o gênero do livro deve ser informado!");
        else
            $this->genero = $gen;
    }
        public function setPaginas($pag){
        if ($pag < 0)
            throw new Exception("Erro, a quantidade total de páginas deve ser maior que 0!");
        else
            $this->paginas = $pag;
    }
    // capa pode ser em branco por isso o parâmetro é opcional
    public function setCapa($capa = ''){
        $this->capa = $capa;
    }

    public function getId(): int{
        return $this->id;
    }
    public function getTitulo(): String{
        return $this->titulo;
    }
    public function getAutor(): String{
        return $this->autor;
    }
        public function getGenero(): String{
        return $this->genero;
    }
        public function getPublicacao(): String{
        return $this->publicacao;
    }
        public function getPaginas(): int{
        return $this->paginas;
    }
    public function getCapa(): String{
        return $this->capa;
    }

    // método mágico para imprimir uma atividade
    public function __toString():String{  
        $str = "Livro: $this->id - $this->titulo
                 - Autor: $this->autor
                 - Publicação: $this->publicacao
                 - Gênero: $this->genero
                 - Páginas: $this->paginas
                 - Capa: $this->capa";       
        return $str;
    }

    // insere um livro no banco 
    public function inserir():Bool{
        // montar o sql/ query
        $sql = "INSERT INTO livros 
                    (titulo, autor, publicacao, genero, paginas, capa)
                    VALUES(:titulo, :autor, :publicacao, :genero, :paginas, :capa)";
        
        $parametros = array(':titulo'=>$this->getTitulo(),
                            ':autor'=>$this->getAutor(),
                            ':publicacao'=>$this->getPublicacao(),
                            ':genero'=>$this->getGenero(),
                            ':paginas'=>$this->getPaginas(),
                            ':capa'=>$this->getCapa());
        return Database::executar($sql, $parametros) == true;
    }

    public static function listar($tipo=1, $info=''):Array{
        $sql = "SELECT * FROM livros";
        switch ($tipo){
            case 0: break;
            case 1: $sql .= " WHERE id = :info ORDER BY id"; break; // filtro por ID
            case 2: $sql .= " WHERE titulo like :info ORDER BY titulo"; $info = '%'.$info.'%'; break; // filtro por título
            case 3: $sql .= " WHERE autor like :info ORDER BY autor"; $info = '%'.$info.'%'; break; // filtro por autor
            case 4: $sql .= " WHERE publicacao like :info ORDER BY publicacao"; $info = '%'.$info.'%'; break; // filtro por publicação
            case 5: $sql .= " WHERE genero like :info ORDER BY genero"; $info = '%'.$info.'%'; break; // filtro por gênero
            case 6: $sql .= " WHERE paginas like :info ORDER BY paginas"; $info = '%'.$info.'%'; break; // filtro por páginas
        }
        $parametros = array();
        if ($tipo > 0)
            $parametros = [':info'=>$info];

        $comando = Database::executar($sql, $parametros);

        $livros = [];
        while ($registro = $comando->fetch()){
            $livro = new Livro($registro['id'],$registro['titulo'],$registro['autor'],$registro['publicacao'],$registro['genero'],$registro['paginas'],$registro['capa']);
            array_push($livros,$livro);
        }
        return $livros;
    }

    public function alterar():Bool{       
       $sql = "UPDATE livros
                  SET titulo = :titulo, 
                      autor = :autor,
                      publicacao = :publicacao,
                      genero = :genero,
                      paginas = :paginas,
                      capa = :anexo
                WHERE id = :id";
         $parametros = array(':id'=>$this->getid(),
                        ':titulo'=>$this->getTitulo(),
                        ':autor'=>$this->getAutor(),
                        ':publicacao'=>$this->getPublicacao(),
                        ':genero'=>$this->getGenero(),
                        ':paginas'=>$this->getPaginas(),
                        'anexo'=>$this->getCapa());
        return Database::executar($sql, $parametros) == true;
    }

    public function excluir():Bool{
        $sql = "DELETE FROM livros
                      WHERE id = :id";
        $parametros = array(':id'=>$this->getid());
        return Database::executar($sql, $parametros) == true;
     }
}

?>