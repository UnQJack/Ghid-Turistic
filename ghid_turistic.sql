CREATE DATABASE ghid_turistic;
USE ghid_turistic;

CREATE TABLE destinatii (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100) NOT NULL,
    descriere TEXT,
    imagine VARCHAR(255) -- Stocăm URL-ul imaginii
);

INSERT INTO destinatii (nume, descriere, imagine) VALUES
('Palatul Parlamentului', 'Palatul Parlamentului din București, România, măsoară 270 m pe 240 m, 84 m înălțime și 92 m sub pământ. Conform World Records Academy, este a treia cea mai mare clădire administrativă pentru uz civil din lume, cea mai scumpă și cea mai grea clădire din lume.', 'images/palatul_parlamentului.jpg'),
('Castelul Bran', 'Castelul Bran, situat aproape de Brașov, este adesea asociat cu legenda lui Dracula. Deși legătura cu Vlad Țepeș este mai mult literară decât istorică, castelul atrage mii de turiști anual.', 'images/castelul_bran.jpg'),
('Delta Dunării', 'Delta Dunării este cea mai mare și mai bine conservată deltă din Europa. Sit UNESCO, adăpostește sute de specii rare de păsări și animale sălbatice, fiind un paradis pentru iubitorii de natură.', 'images/delta_dunarii.jpg'),
('Transfăgărășan', 'Transfăgărășanul, cunoscut ca DN7C, traversează Munții Făgăraș. Construit în anii ’70, oferă peisaje spectaculoase și este accesibil doar vara, din cauza condițiilor meteorologice dure.', 'images/image4.jpg'),
('Castelul Corvinilor', 'Castelul Corvinilor din Hunedoara, un impresionant castel gotic din secolul XV, a fost construit de Ioan de Hunedoara. Este faimos pentru arhitectura sa spectaculoasă și legendele sale medievale.', 'images/castelul_corvinilor.jpg'),
('Salina Turda', 'Salina Turda datează din perioada romană și a fost exploatată timp de peste 2.000 de ani. Restaurată în 2010, este acum una dintre cele mai spectaculoase atracții turistice subterane din România.', 'images/salina_turda.jpg'),
('Mocănița de pe Valea Vaserului', 'Mocănița din Maramureș este ultima locomotivă cu aburi din lume care funcționează pentru transport și turism. Traseul său străbate peisaje sălbatice deosebite.', 'images/mocanita_vaser.jpg'),
('Cazanele Dunării', 'Cazanele Dunării, situate în județul Mehedinți, sunt o zonă spectaculoasă unde fluviul Dunărea străbate Munții Carpați. Atractii includ Chipul lui Decebal și Mănăstirea Mraconia.', 'images/cazanele_dunarii.jpg'),
('Cimitirul Vesel de la Săpânța', 'Cimitirul Vesel din Săpânța este faimos pentru crucile viu colorate și epitafurile satirice, care descriu viața celor îngropați într-un mod unic și plin de umor.', 'images/cimitirul_vesel.jpg'),
('Cetatea Alba Carolina', 'Cetatea Alba Carolina, situată în Alba Iulia, este cea mai mare cetate din România, construită în stil Vauban în secolul XVIII. Este un simbol important al Unirii din 1918.', 'images/cetatea_alba_carolina.jpg');

CREATE TABLE detalii_destinatii (
    id INT AUTO_INCREMENT PRIMARY KEY,
    destinatie_id INT NOT NULL,
    descriere_lunga TEXT NOT NULL,
    galerie_foto TEXT NOT NULL,
    FOREIGN KEY (destinatie_id) REFERENCES destinatii(id) ON DELETE CASCADE
);

INSERT INTO detalii_destinatii (destinatie_id, descriere_lunga, galerie_foto) VALUES
(1, 'Palatul Parlamentului este un simbol al Bucureștiului și al României. Construcția a început în 1984 și a fost realizată la ordinul lui Nicolae Ceaușescu. Clădirea este folosită astăzi pentru administrație, fiind sediul Parlamentului României. Oferă tururi ghidate pentru vizitatori.', 'images/palat1.jpg,images/palat2.jpg,images/palat3.jpg'),
(2, 'Castelul Bran este unul dintre cele mai faimoase castele din lume, datorită asocierii cu legenda lui Dracula. Este construit pe o stâncă abruptă și oferă priveliști spectaculoase asupra Munților Carpați.', 'images/bran1.jpg,images/bran2.jpg,images/bran3.jpg'),
(3, 'Delta Dunării este o zonă unică în lume, cu o biodiversitate impresionantă. Aici se regăsesc peste 300 de specii de păsări și numeroase specii de pești. Este o destinație ideală pentru iubitorii de natură și fotografie.', 'images/delta1.jpg,images/delta2.jpg,images/delta3.jpg'),
(4, 'Transfăgărășanul este considerat unul dintre cele mai frumoase drumuri din lume. Construit în anii ’70, acesta traversează Munții Făgăraș, oferind peisaje incredibile și numeroase tuneluri și viaducte.', 'images/trans1.jpg,images/trans2.jpg,images/trans3.jpg'),
(5, 'Castelul Corvinilor este una dintre cele mai spectaculoase construcții medievale din România. Cu o arhitectură gotică impresionantă, castelul atrage mii de turiști anual.', 'images/corvin1.jpg,images/corvin2.jpg,images/corvin3.jpg'),
(6, 'Salina Turda este o atracție unică, aflată într-o fostă mină de sare. A fost restaurată și transformată într-un complex turistic cu zone de agrement.', 'images/salina1.jpg,images/salina2.jpg,images/salina3.jpg'),
(7, 'Mocănița de pe Valea Vaserului este o călătorie în timp. Locomotiva cu aburi te poartă printr-un peisaj de basm, prin pădurile Maramureșului.', 'images/mocanita1.jpg,images/mocanita2.jpg,images/mocanita3.jpg'),
(8, 'Cazanele Dunării reprezintă unul dintre cele mai spectaculoase peisaje din România. Chipul lui Decebal sculptat în stâncă este un punct de atracție important.', 'images/cazane1.jpg,images/cazane2.jpg,images/cazane3.jpg'),
(9, 'Cimitirul Vesel din Săpânța este faimos în întreaga lume pentru crucile sale viu colorate și epitafurile hazlii care povestesc viața celor înmormântați acolo.', 'images/sapanta1.jpg,images/sapanta2.jpg,images/sapanta3.jpg'),
(10, 'Cetatea Alba Carolina este un simbol istoric important al României. A fost restaurată și este o atracție turistică majoră.', 'images/alba1.jpg,images/alba2.jpg,images/alba3.jpg');
# a se adauga alte descrieri mai lungi si imagini
# se pot pune infinite (sau nici chiar) imagini cu virgula intre ele su cu update
# UPDATE detalii_destinatii 
# SET galerie_foto = CONCAT(galerie_foto, ',images/palat4.jpg') 
# WHERE destinatie_id = 1;

















CREATE TABLE feedback (
  id int AUTO_INCREMENT PRIMARY KEY,
  name varchar(20) NOT NULL,
  email varchar(30) NOT NULL,
  feedbk varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE table auth(
  id int AUTO_INCREMENT PRIMARY KEY,
  username varchar(100) UNIQUE NOT NULL,
  parola varchar(100) NOT NULL
)

INSERT INTO auth (username, parola) 
VALUES ('admin', '$2y$10$wkpKzDjYBa5qM8SglA1D0OSrB4eQHCpyn5/D9N7A1csQexnQpiO2G');
# a se adauga mai multe exemple

