create database zendEnterprise;

use zendEnterprise;

-- Tables

create table company (
    id int(11) primary key auto_increment,
    name varchar(50),
    cnpj varchar(50),
    address varchar(50)
);

create table owner (
    id int(11) primary key auto_increment,
    name varchar(50),
    cpf varchar(50),
    phone varchar(50),
    email varchar(50)
);

-- Inserts

insert into company (name, cnpj, address) values 
('Company A', '94837485000192', 'Rua A Bairro B'),
('Company B', '83726374000281', 'Rua B Bairro C'),
('Company C', '72615263000370', 'Rua D Bairro E');

insert into owner (name, cpf, phone, email) values
('João', '93874637281', '92984756274', 'joao@email.com'),
('Maria', '82763526170', '81873645163', 'maria@email.com'),
('Pedro', '71652415069', '79762534052', 'pedro@email.com');