SET NAMES utf8mb4;

DROP TABLE IF EXISTS cats;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES
('admin', 'supersecretpassword123'),
('moderator', 'meowmeowmeow');

CREATE TABLE cats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'General'
);

INSERT INTO cats (name, description, image, category) VALUES
('Mittens', 'Un gatito juguetón que ama el estambre y causar problemas.', 'https://loremflickr.com/400/300/kitten,cat?lock=1', 'Kitten'),
('Whiskers', 'Un gato sabio que disfruta las siestas en el sol y juzgarte.', 'https://loremflickr.com/400/300/cat,sleeping?lock=2', 'Senior'),
('Luna', 'Una misteriosa ave nocturna que ama cazar sombras.', 'https://loremflickr.com/400/300/blackcat?lock=3', 'Mystic'),
('Garfield', 'Ama la lasaña, odia los lunes. Un clásico gato atigrado naranja.', 'https://loremflickr.com/400/300/ginger,cat?lock=4', 'Chunky'),
('Salem', 'Un gato negro con ingenio sarcástico y pasado mágico.', 'https://loremflickr.com/400/300/black,cat?lock=5', 'Mystic'),
('Simba', 'El rey de la selva de la sala de estar.', 'https://loremflickr.com/400/300/cat,lion?lock=6', 'Royal'),
('Nala', 'Reina de la casa, feroz y leal.', 'https://loremflickr.com/400/300/cat,tabby?lock=7', 'Royal'),
('Felix', 'Siempre cae de pie, sin importar el problema.', 'https://loremflickr.com/400/300/cat,tuxedo?lock=18', 'Lucky'),
('Bella', 'Hermosa y elegante, exige los mejores premios.', 'https://loremflickr.com/400/300/cat,persian?lock=19', 'Fancy'),
('Oreo', 'Blanco y negro y dulce por todos lados.', 'https://loremflickr.com/400/300/cat,black,white?lock=10', 'Sweet'),
('Shadow', 'Nunca lo verás venir hasta que quiera caricias.', 'https://loremflickr.com/400/300/cat,grey?lock=11', 'Ninja'),
('Cleo', 'Regia y exigente, ella manda en el gallinero.', 'https://loremflickr.com/400/300/cat,siamese?lock=12', 'Fancy'),
('Coco', 'Un gato encantador.', 'https://i.ibb.co/MDt1pHWW/IMG-1308.jpg', 'User'),
('Blanca', 'Una hermosa gata blanca.', 'https://i.ibb.co/675fqvZq/IMG-1212.jpg', 'User'),
('Mochi', 'Un gato color crema súper esponjoso y dulce.', 'https://loremflickr.com/400/300/cat,cream?lock=101', 'Sweet'),
('Thor', 'Un tabby gris fuerte con mirada de trueno.', 'https://loremflickr.com/400/300/cat,grey,tabby?lock=102', 'Mystic'),
('Ziggy', 'Un pequeño aventurero que se mete en todo.', 'https://loremflickr.com/400/300/kitten,playing?lock=103', 'Kitten'),
('Misty', 'Una dama gris tranquila y elegante.', 'https://loremflickr.com/400/300/cat,grey?lock=104', 'Senior'),
('Loki', 'El dios de las travesuras, siempre escondido.', 'https://loremflickr.com/400/300/cat,black?lock=105', 'Ninja');
