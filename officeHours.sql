CREATE TABLE student (
    id int PRIMARY KEY CHECK(id>0),
    name varchar(50)
);

CREATE TABLE professor (
    id				 int PRIMARY KEY CHECK(id>0),
    name			 varchar(50)
);

CREATE TYPE days AS ENUM('Monday','Tuesday','Wednesday','Thursday','Friday');

CREATE TYPE hourType AS ENUM ('class', 'officeHour', 'freeHour');

CREATE TYPE periods AS ENUM('AGO-DIC','VERANO','ENE-MAY');

CREATE TABLE subject(
	id				 serial PRIMARY KEY,
	name			 varchar(50),
	professor		 int references professor(id)
);
CREATE TABLE period(
    id               serial PRIMARY KEY,
    year             int,
    period           periods
);
CREATE TABLE hours(
	id				 serial PRIMARY KEY,
	day 			 days,
	professor		 int references professor(id),
	start		     time,
	finish		     time,
	type 			 hourType,
    period           int references period(id)
);

CREATE TABLE availableDates (
    id				 serial PRIMARY KEY,
    officeHour		 int references hours(id),
    availability     boolean,
    date 			 timestamp,
    student 		 int references student(id),
    subject 		 int references subject(id),
    topic			 varchar(50)
);

CREATE TABLE asesorias (
    id serial PRIMARY KEY,
    student int references student(id),
    professor int references professor(id),
    topic varchar(100),
    dateh date,
    start time,
    finish time
);



INSERT INTO student VALUES (01325081,'Ricardo Rodiles Legaspi');
INSERT INTO student VALUES (01328484,'Alejandro Tovar');
INSERT INTO student VALUES (01325050,'Pedrito Sola');
INSERT INTO student VALUES (01321212,'Tom Brady');
INSERT INTO student VALUES (01328787,'Rob Gronkowsky');
INSERT INTO student VALUES (01327272,'Bobby Fischer');
INSERT INTO student VALUES (01323232,'Devin Mccourty');
INSERT INTO student VALUES (01326789,'Juan Pablo Veracruz');

INSERT INTO professor VALUES (01327685,'Dan Perez');
INSERT INTO professor VALUES (01326798,'Alberto Oliart');
INSERT INTO professor VALUES (01324318,'David Sol');

INSERT INTO subject VALUES(1,'Bases de datos Avanzadas',01327685);
INSERT INTO subject VALUES(2,'Mates Discretas',01327685);
INSERT INTO subject VALUES(3,'Progra Avanzada',01326798);
INSERT INTO subject VALUES(4,'POO',01324318);

INSERT INTO period VALUES(1,2017,'ENE-MAY');


INSERT INTO hours VALUES(1,'Monday',01327685,'11:30:00','13:00:00','officeHour',1);
INSERT INTO hours VALUES(2,'Monday',01324318,'11:30:00','13:00:00','class',1);
INSERT INTO hours VALUES(3,'Tuesday',01327685,'14:30:00','16:00:00','class',1);
INSERT INTO hours VALUES(4,'Friday',01327685,'14:30:00','16:00:00','class',1);
INSERT INTO hours VALUES(5,'Thursday',01327685,'11:30:00','13:00:00','officeHour',1);
INSERT INTO hours VALUES(6,'Wednesday',01326798,'09:00:00','10:00:00','officeHour',1);
INSERT INTO hours VALUES(7,'Monday',01326798,'14:00:00','15:00:00','freeHour',1);
INSERT INTO hours VALUES(8,'Monday',01324318,'14:00:00','15:00:00','freeHour',1);
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
INSERT INTO availableDates VALUES (4,8,FALSE,'2017-03-20',01321212,4,'inheritance');
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



