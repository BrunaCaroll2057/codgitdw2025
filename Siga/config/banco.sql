use siga;

create table livros(
    id int auto_increment primary key,
    titulo varchar(250),
    autor varchar(250),
    publicacao varchar(250),
    genero varchar(250),
    paginas int,
    capa varchar(250));
    
    select * from livros;
    -- script de criação do banco de dados 