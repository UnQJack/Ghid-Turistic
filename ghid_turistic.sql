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
('Transfăgărășan', 'Transfăgărășanul, cunoscut ca DN7C, traversează Munții Făgăraș. Construit în anii ’70, oferă peisaje spectaculoase și este accesibil doar vara, din cauza condițiilor meteorologice dure.', 'images/transfagarasan.jpg'),
('Castelul Corvinilor', 'Castelul Corvinilor din Hunedoara, un impresionant castel gotic din secolul XV, a fost construit de Ioan de Hunedoara. Este faimos pentru arhitectura sa spectaculoasă și legendele sale medievale.', 'images/castelul_corvinilor.jpg'),
('Salina Turda', 'Salina Turda datează din perioada romană și a fost exploatată timp de peste 2.000 de ani. Restaurată în 2010, este acum una dintre cele mai spectaculoase atracții turistice subterane din România.', 'images/salina_turda.jpg'),
('Mocănița de pe Valea Vaserului', 'Mocănița din Maramureș este ultima locomotivă cu aburi din lume care funcționează pentru transport și turism. Traseul său străbate peisaje sălbatice deosebite.', 'images/mocanita_vaser.jpg'),
('Cazanele Dunării', 'Cazanele Dunării, situate în județul Mehedinți, sunt o zonă spectaculoasă unde fluviul Dunărea străbate Munții Carpați. Atractii includ Chipul lui Decebal și Mănăstirea Mraconia.', 'images/cazanele_dunarii.jpg'),
('Cimitirul Vesel de la Săpânța', 'Cimitirul Vesel din Săpânța este faimos pentru crucile viu colorate și epitafurile satirice, care descriu viața celor îngropați într-un mod unic și plin de umor.', 'images/cimitirul_vesel.jpg'),
('Cetatea Alba Carolina', 'Cetatea Alba Carolina, situată în Alba Iulia, este cea mai mare cetate din România, construită în stil Vauban în secolul XVIII. Este un simbol important al Unirii din 1918.', 'images/cetatea_alba_carolina.jpg');

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
