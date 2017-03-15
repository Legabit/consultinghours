--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.1
-- Dumped by pg_dump version 9.6.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: days; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE days AS ENUM (
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday'
);


ALTER TYPE days OWNER TO postgres;

--
-- Name: hourtype; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE hourtype AS ENUM (
    'class',
    'officeHour',
    'freeHour'
);


ALTER TYPE hourtype OWNER TO postgres;

--
-- Name: periods; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE periods AS ENUM (
    'AGO-DIC',
    'VERANO',
    'ENE-MAY'
);


ALTER TYPE periods OWNER TO postgres;

--
-- Name: correctday(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION correctday() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
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
$$;


ALTER FUNCTION public.correctday() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: hours; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE hours (
    id integer NOT NULL,
    day days,
    professor integer,
    start time without time zone,
    finish time without time zone,
    type hourtype,
    period integer
);


ALTER TABLE hours OWNER TO postgres;

--
-- Name: asesoriasdan; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW asesoriasdan AS
 SELECT hours.start,
    hours.finish,
    hours.day
   FROM hours
  WHERE ((hours.professor = 1327685) AND (hours.type = 'officeHour'::hourtype));


ALTER TABLE asesoriasdan OWNER TO postgres;

--
-- Name: asesoriasoliart; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW asesoriasoliart AS
 SELECT hours.start,
    hours.finish,
    hours.day
   FROM hours
  WHERE ((hours.professor = 1326798) AND (hours.type = 'officeHour'::hourtype));


ALTER TABLE asesoriasoliart OWNER TO postgres;

--
-- Name: availabledates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE availabledates (
    id integer NOT NULL,
    officehour integer,
    availability boolean,
    date timestamp without time zone,
    student integer,
    subject integer,
    topic character varying(50)
);


ALTER TABLE availabledates OWNER TO postgres;

--
-- Name: period; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE period (
    id integer NOT NULL,
    year integer,
    period periods
);


ALTER TABLE period OWNER TO postgres;

--
-- Name: professor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE professor (
    id integer NOT NULL,
    name character varying(50),
    CONSTRAINT professor_id_check CHECK ((id > 0))
);


ALTER TABLE professor OWNER TO postgres;

--
-- Name: profesores; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW profesores AS
 SELECT professor.name
   FROM professor;


ALTER TABLE profesores OWNER TO postgres;

--
-- Name: student; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE student (
    id integer NOT NULL,
    name character varying(50),
    CONSTRAINT student_id_check CHECK ((id > 0))
);


ALTER TABLE student OWNER TO postgres;

--
-- Name: subject; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE subject (
    id integer NOT NULL,
    name character varying(50),
    professor integer
);


ALTER TABLE subject OWNER TO postgres;

--
-- Data for Name: availabledates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY availabledates (id, officehour, availability, date, student, subject, topic) FROM stdin;
1	1	f	2017-03-06 00:00:00	1325081	1	Postgres
\.


--
-- Data for Name: hours; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY hours (id, day, professor, start, finish, type, period) FROM stdin;
1	Monday	1327685	11:30:00	13:00:00	officeHour	1
2	Monday	1324318	11:30:00	13:00:00	class	1
3	Tuesday	1327685	14:30:00	16:00:00	class	1
4	Friday	1327685	14:30:00	16:00:00	class	1
5	Thursday	1327685	11:30:00	13:00:00	officeHour	1
6	Wednesday	1326798	09:00:00	10:00:00	officeHour	1
7	Monday	1326798	14:00:00	15:00:00	freeHour	1
8	Monday	1324318	14:00:00	15:00:00	freeHour	1
9	Monday	1327685	14:00:00	15:00:00	freeHour	1
\.


--
-- Data for Name: period; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY period (id, year, period) FROM stdin;
1	2017	ENE-MAY
2	2017	VERANO
\.


--
-- Data for Name: professor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY professor (id, name) FROM stdin;
1327685	Dan Perez
1326798	Alberto Oliart
1324318	David Sol
\.


--
-- Data for Name: student; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY student (id, name) FROM stdin;
1325081	Ricardo Rodiles Legaspi
1328484	Alejandro Tovar
1325050	Pedrito Sola
1321212	Tom Brady
1328787	Rob Gronkowsky
1327272	Bobby Fischer
1323232	Devin Mccourty
1326789	Juan Pablo Veracruz
\.


--
-- Data for Name: subject; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY subject (id, name, professor) FROM stdin;
1	Bases de datos Avanzadas	1327685
2	Mates Discretas	1327685
3	Progra Avanzada	1326798
4	POO	1324318
\.


--
-- Name: availabledates availabledates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_pkey PRIMARY KEY (id);


--
-- Name: hours hours_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hours
    ADD CONSTRAINT hours_pkey PRIMARY KEY (id);


--
-- Name: period period_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY period
    ADD CONSTRAINT period_pkey PRIMARY KEY (id);


--
-- Name: professor professor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY professor
    ADD CONSTRAINT professor_pkey PRIMARY KEY (id);


--
-- Name: student student_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY student
    ADD CONSTRAINT student_pkey PRIMARY KEY (id);


--
-- Name: subject subject_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subject
    ADD CONSTRAINT subject_pkey PRIMARY KEY (id);


--
-- Name: availabledates checkday; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER checkday AFTER INSERT ON availabledates FOR EACH ROW EXECUTE PROCEDURE correctday();


--
-- Name: availabledates availabledates_officehour_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_officehour_fkey FOREIGN KEY (officehour) REFERENCES hours(id);


--
-- Name: availabledates availabledates_student_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_student_fkey FOREIGN KEY (student) REFERENCES student(id);


--
-- Name: availabledates availabledates_subject_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_subject_fkey FOREIGN KEY (subject) REFERENCES subject(id);


--
-- Name: hours hours_period_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hours
    ADD CONSTRAINT hours_period_fkey FOREIGN KEY (period) REFERENCES period(id);


--
-- Name: hours hours_professor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hours
    ADD CONSTRAINT hours_professor_fkey FOREIGN KEY (professor) REFERENCES professor(id);


--
-- Name: subject subject_professor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subject
    ADD CONSTRAINT subject_professor_fkey FOREIGN KEY (professor) REFERENCES professor(id);


--
-- PostgreSQL database dump complete
--

