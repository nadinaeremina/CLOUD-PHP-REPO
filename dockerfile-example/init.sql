-- Создание таблицы users
CREATE TABLE users_t (
  id SERIAL PRIMARY KEY,
  login VARCHAR(50) NOT NULL UNIQUE
);

-- Добавление пользователей
INSERT INTO users_t (login) VALUES ('user1');
INSERT INTO users_t (login) VALUES ('user2');
INSERT INTO users_t (login) VALUES ('user3');

-- Вывод всех пользователей
SELECT * FROM users_t;