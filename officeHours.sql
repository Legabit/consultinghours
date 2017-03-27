CREATE TABLE usuar (
    id               int PRIMARY KEY CHECK(id>0),
    password varchar(100),
    email varchar(100),
    token varchar(16),
    type int,
    valid boolean
);

CREATE TABLE student (
    id int PRIMARY KEY CHECK(id>0) references usuar(id) ON DELETE CASCADE ON UPDATE CASCADE,
    name varchar(50)   
);

CREATE TABLE professor (
    id				 int PRIMARY KEY CHECK(id>0) references usuar(id) ON DELETE CASCADE ON UPDATE CASCADE,
    name			 varchar(50)
);

CREATE TYPE days AS ENUM('Monday','Tuesday','Wednesday','Thursday','Friday');

CREATE TYPE hourType AS ENUM ('class', 'officeHour', 'freeHour');

CREATE TYPE periods AS ENUM('AGO-DIC','VERANO','ENE-MAY');

CREATE TABLE subject(
	id				 serial PRIMARY KEY,
	name			 varchar(50),
	professor		 int references professor(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE period(
    id               serial PRIMARY KEY,
    year             int,
    period           periods
);
CREATE TABLE hours(
	id				 serial PRIMARY KEY,
	day 			 days,
	professor		 int references professor(id) ON DELETE CASCADE ON UPDATE CASCADE,
	start		     time,
	finish		     time,
	type 			 hourType,
    period           int references period(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE availableDates (
    id				 serial PRIMARY KEY,
    officeHour		 int references hours(id) ON DELETE CASCADE ON UPDATE CASCADE,
    availability     boolean,
    date 			 timestamp,
    student 		 int references student(id) ON DELETE CASCADE ON UPDATE CASCADE,
    subject 		 int references subject(id) ON DELETE CASCADE ON UPDATE CASCADE,
    topic			 varchar(50)
);

CREATE TABLE asesorias (
    id serial PRIMARY KEY,
    student int references student(id) ON DELETE CASCADE ON UPDATE CASCADE,
    professor int references professor(id) ON DELETE CASCADE ON UPDATE CASCADE,
    topic varchar(100),
    dateh date,
    start time,
    finish time
);

INSERT INTO usuar VALUES (01325081,'6fb88c0c4156bae22639348760c151870072e1c7', 'a01325081@itesm.mx', 'j4hf83jdmwkeiqoq', 2, TRUE);
INSERT INTO usuar VALUES (01328484,'e752529a12218ad9759044a4a2b79bda51882fe9', 'a01328484@itesm.mx', 'hdgryertwqpoerte', 2, FALSE);
INSERT INTO usuar VALUES (01327685,'5c6d9edc3a951cda763f650235cfc41a3fc23fe8', 'a01327685@itesm.mx', 'hyertyeuqieiwuej', 1, TRUE);
INSERT INTO usuar VALUES (01326798,'a3ddea8602dd587f3a6fd4f506b4242a7ff12f6d', 'a01326798@itesm.mx', 'sifjiqjwihrqwurw', 1, TRUE);

INSERT INTO student VALUES (01325081,'Ricardo Rodiles Legaspi');
INSERT INTO student VALUES (01328484,'Alejandro Tovar');

INSERT INTO professor VALUES (01327685,'Dan Perez');
INSERT INTO professor VALUES (01326798,'Alberto Oliart');

INSERT INTO subject VALUES(1,'Bases de datos Avanzadas',01327685);
INSERT INTO subject VALUES(2,'Mates Discretas',01327685);
INSERT INTO subject VALUES(3,'Progra Avanzada',01326798);

INSERT INTO period VALUES(1,2017,'ENE-MAY');


INSERT INTO hours VALUES(1,'Monday',01327685,'11:30:00','13:00:00','officeHour',1);
INSERT INTO hours VALUES(3,'Tuesday',01327685,'14:30:00','16:00:00','class',1);
INSERT INTO hours VALUES(4,'Friday',01327685,'14:30:00','16:00:00','class',1);
INSERT INTO hours VALUES(5,'Thursday',01327685,'11:30:00','13:00:00','officeHour',1);
INSERT INTO hours VALUES(6,'Wednesday',01326798,'09:00:00','10:00:00','officeHour',1);
INSERT INTO hours VALUES(7,'Monday',01326798,'14:00:00','15:00:00','freeHour',1);
INSERT INTO hours VALUES(9,'Monday',01327685,'14:00:00','15:00:00','freeHour',1);


INSERT INTO availableDates VALUES (1,1,FALSE,'2017-03-06',01325081,1,'Postgres');



CREATE VIEW asesoriasDan AS
    SELECT start, finish,day FROM hours where professor=01327685 and type='officeHour';

SELECT * FROM asesoriasDan;

CREATE VIEW asesoriasOliart AS
    SELECT start, finish,day FROM hours where professor=01326798 and type='officeHour';

CREATE VIEW profesores AS
    SELECT name FROM professor;

BEGIN;
UPDATE availableDates SET availability = TRUE WHERE id=8;
COMMIT;

BEGIN;
INSERT INTO period VALUES(2,2017,'VERANO');
COMMIT;

BEGIN;
INSERT INTO availableDates VALUES (4,8,FALSE,'2017-03-20',01325081,4,'inheritance');
COMMIT;

CREATE OR REPLACE FUNCTION correctDay ()
RETURNS TRIGGER AS $boo$
declare
   dia integer ;
   checkday integer;
   diaSem varchar(10);
BEGIN
   dia = EXTRACT(ISODOW FROM new.date);
   diaSem=(SELECT day FROM hours WHERE id=new.officeHour);
   IF ('Monday'= diaSem ) THEN
        checkday=1;
    END IF;
   IF ('Tuesday'= diaSem) THEN
        checkday=2;
    END IF;
   IF ('Wednesday'= diaSem) THEN
        checkday=3;
    END IF;
    IF ('Thursday'= diaSem) THEN
        checkday=4;
    END IF;
    IF ('Friday'= diaSem) THEN
        checkday=5;
    END IF;
    IF ('Saturday'= diaSem) THEN
        checkday=6;
    END IF;
    IF ('Sunday'= diaSem) THEN
        checkday=7;
    END IF;
    IF(dia!=checkday) THEN
        DELETE FROM availabledates where id=new.id;
    END IF;
    RETURN NEW;
END;
$boo$ LANGUAGE 'plpgsql';

CREATE TRIGGER checkDay
    AFTER INSERT ON availableDates
    FOR EACH ROW
    EXECUTE PROCEDURE correctDay();

CREATE OR REPLACE FUNCTION asesoriasDestudiante(i integer) RETURNS integer AS $$
declare 
    horas integer;
        BEGIN
                horas = count(*) from availabledates where student =i;
    RETURN horas;
        END;
$$ LANGUAGE plpgsql;