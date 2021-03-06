DROP DATABASE IF EXISTS salvaai;
CREATE DATABASE salvaai;
USE salvaai;

CREATE TABLE usuarios (
id_usuario INT NOT NULL AUTO_INCREMENT,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
senha VARCHAR(255) NOT NULL,
PRIMARY KEY (id_usuario)
);

CREATE TABLE lancamentos (
id_lancamento INT NOT NULL AUTO_INCREMENT,
valor DECIMAL NOT NULL,
tipo ENUM('entrada', 'saida') NOT NULL,
descricao VARCHAR(255) NOT NULL,
fk_usuario INT NOT NULL,
data_lancamento DATE NOT NULL,
PRIMARY KEY (id_lancamento),
FOREIGN KEY (fk_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE balanco (
id_balanco INT NOT NULL AUTO_INCREMENT,
valor_balanco DECIMAL NOT NULL,
data_balanco DATE NOT NULL,
tipo_balanco ENUM('entrada', 'saida') NOT NULL,
fk_usuario INT NOT NULL,
PRIMARY KEY (id_balanco),
FOREIGN KEY (fk_usuario) REFERENCES usuarios(id_usuario)
); 