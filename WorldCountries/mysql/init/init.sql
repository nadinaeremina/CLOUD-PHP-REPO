
-- создание таблицы аэропортов
CREATE TABLE country_t (
	id INT NOT NULL AUTO_INCREMENT,
    shortName_f NVARCHAR(200) NULL,
    fullName_f NVARCHAR(200) NOT NULL,
    isoAlpha2_f CHAR(2) NOT NULL,
    isoAlpha3_f CHAR(3) NOT NULL,
    isoNumeric_f CHAR(4) NOT NULL,
    population_f INT NOT NULL,
    square_f INT NOT NULL,
    --
    PRIMARY KEY(id),
    UNIQUE(isoAlpha2_f, isoAlpha3_f, isoNumeric_f)
);

-- добавить данные
INSERT INTO country_t (
	shortName_f, 
    fullName_f, 
    isoAlpha2_f, 
    isoAlpha3_f,
    isoNumeric_f,
    population_f,
    square_f
) VALUES 
	(N'Россия', N'Российская Федерация', 'RU', 'RUS', 643, 146150789, 17125191),
    (N'США', N'Соединенные Штаты Америки', 'US', 'USA', 840, 340100000, 9867000),
    (N'КНР', N'Китайская Народная Республика', 'CN', 'CHN', 156, 1411000000, 9597000),
    (N'Англия', N'Соединенное Королевство Великобритании и Северной Ирландии', 'GB', 'GBR', 
    826, 56489800, 130279),
    (N'Монако', N'Княжество Монако', 'MC', 'MCO', 492, 38956, 2002);
