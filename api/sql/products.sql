CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO products (name, price, quantity, image_url)
VALUES
('Tomat',30,100,'/images/tomat.jpeg'),
('Gurka',20,100,'/images/gurka.jpeg'),
('Banan',25,100,'/images/banan.jpeg'),
('Apelsin',30,50,'/images/apelsin.jpeg'),
('Isbergssallad',10,45,'/images/sallad.jpeg'),
('Spenat',50,100,'/images/spenat.jpeg'),
('Rödkål',15,100,'/images/rodkal.jpeg'),
('Ärtskott',50,100,'/images/artskott.jpeg'),
('Citron',40,100,'/images/citron.jpeg'),
('Lime',35,100,'/images/lime.jpeg'),
('Honungmelon',15,100,'/images/melon.jpeg'),
('Clementin',25,100,'/images/clementin.jpeg'),
('Dadel',35,100,'/images/dadel.jpeg'),
('Vitkål',2.90,20,'/images/vitkal.jpeg'),
('Selleri',10,40,'/images/selleri.jpeg'),
('Kålrot',15,40,'/images/kalrot.jpeg'),
('Basilika',25,50,'/images/basilika.jpeg'),
('Sötpotatis',30,100,'/images/sotpotatis.jpeg'),
('Koriander',25,100,'/images/koriander.jpeg'),
('Avokado',65,30,'/images/avokado.jpeg'),
('Päron',20,60,'/images/paron.jpeg'),
('Potatis',10,100,'/images/potatis.jpeg'),
('Ruccola',75,30,'/images/ruccola.jpeg'),
('Persika',30,200,'/images/persika.jpeg'),
('Grapefrukt',25,50,'/images/grape.jpeg'),
('Kålrabbi',20,40,'/images/kalrabbi.jpeg'),
('Mynta',25,20,'/images/mynta.jpeg'),
('Timjan',25,6,'/images/timjan.jpeg');
