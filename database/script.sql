CREATE TABLE usuarios (
id_user INT NOT NULL AUTO_INCREMENT,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
senha VARCHAR(255) NOT NULL,
PRIMARY KEY (id_user)
);

CREATE TABLE lancamentos (
id_lan INT NOT NULL AUTO_INCREMENT,
valor DECIMAL NOT NULL,
tipo ENUM('entrada', 'saida') NOT NULL,
descricao VARCHAR(255) NOT NULL,
fk_lan_user INT NOT NULL,
data_lancamento DATE NOT NULL,
PRIMARY KEY (id_lan),
FOREIGN KEY (fk_lan_user) REFERENCES usuarios(id_user)
);

CREATE TABLE balanco (
id_bal INT NOT NULL AUTO_INCREMENT,
valor_balanco DECIMAL NOT NULL,
data_balanco DATE NOT NULL,
tipo_balanco ENUM('entrada', 'saida') NOT NULL,
fk_bal_user INT NOT NULL,
PRIMARY KEY (id_bal),
FOREIGN KEY (fk_bal_user) REFERENCES usuarios(id_user)
); 