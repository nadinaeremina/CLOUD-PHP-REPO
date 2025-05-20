USE some_db;

CREATE TABLE some_table_t (
    id INT NOT NULL AUTO_INCREMENT,
    some_field_f NVARCHAR(200) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO some_table_t (some_field_f) VALUES ('one'), ('two'), ('ten');