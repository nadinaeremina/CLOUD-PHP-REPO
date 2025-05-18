-- Создание таблицы users
CREATE TABLE users_t (
  id SERIAL PRIMARY KEY,
  login VARCHAR(50) NOT NULL UNIQUE
);

-- Добавление пользователей
INSERT INTO users_t (login) VALUES ('vasya1');
INSERT INTO users_t (login) VALUES ('petya2');
INSERT INTO users_t (login) VALUES ('misha3');

-- Вывод всех пользователей
SELECT * FROM users_t;
