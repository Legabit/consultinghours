--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.2
-- Dumped by pg_dump version 9.6.2

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
-- Name: asesoriasdestudiante(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION asesoriasdestudiante(i integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
declare 
    horas integer;
        BEGIN
                horas = count(*) from availabledates where student =i;
    RETURN horas;
        END;
$$;


ALTER FUNCTION public.asesoriasdestudiante(i integer) OWNER TO postgres;

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
-- Name: asesorias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE asesorias (
    id integer NOT NULL,
    student integer,
    professor integer,
    topic character varying(100),
    dateh date,
    start time without time zone,
    finish time without time zone
);


ALTER TABLE asesorias OWNER TO postgres;

--
-- Name: asesorias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE asesorias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE asesorias_id_seq OWNER TO postgres;

--
-- Name: asesorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE asesorias_id_seq OWNED BY asesorias.id;


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
-- Name: availabledates_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE availabledates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE availabledates_id_seq OWNER TO postgres;

--
-- Name: availabledates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE availabledates_id_seq OWNED BY availabledates.id;


--
-- Name: hours_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hours_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE hours_id_seq OWNER TO postgres;

--
-- Name: hours_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE hours_id_seq OWNED BY hours.id;


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
-- Name: period_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE period_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE period_id_seq OWNER TO postgres;

--
-- Name: period_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE period_id_seq OWNED BY period.id;


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
-- Name: subject_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subject_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE subject_id_seq OWNER TO postgres;

--
-- Name: subject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subject_id_seq OWNED BY subject.id;


--
-- Name: usuar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE usuar (
    id integer NOT NULL,
    password character varying(100),
    email character varying(100),
    type integer,
    CONSTRAINT usuar_id_check CHECK ((id > 0))
);


ALTER TABLE usuar OWNER TO postgres;

--
-- Name: asesorias id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asesorias ALTER COLUMN id SET DEFAULT nextval('asesorias_id_seq'::regclass);


--
-- Name: availabledates id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates ALTER COLUMN id SET DEFAULT nextval('availabledates_id_seq'::regclass);


--
-- Name: hours id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hours ALTER COLUMN id SET DEFAULT nextval('hours_id_seq'::regclass);


--
-- Name: period id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY period ALTER COLUMN id SET DEFAULT nextval('period_id_seq'::regclass);


--
-- Name: subject id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subject ALTER COLUMN id SET DEFAULT nextval('subject_id_seq'::regclass);


--
-- Data for Name: asesorias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY asesorias (id, student, professor, topic, dateh, start, finish) FROM stdin;
1	1325081	1327685	aiuda	2017-03-28	10:00:00	10:15:00
\.


--
-- Name: asesorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('asesorias_id_seq', 1, true);


--
-- Data for Name: availabledates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY availabledates (id, officehour, availability, date, student, subject, topic) FROM stdin;
\.


--
-- Name: availabledates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('availabledates_id_seq', 1, false);


--
-- Data for Name: hours; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY hours (id, day, professor, start, finish, type, period) FROM stdin;
5	Monday	1327685	07:00:00	08:00:00	class	1
6	Thursday	1327685	07:00:00	08:00:00	class	1
7	Tuesday	1327685	10:00:00	13:00:00	officeHour	1
\.


--
-- Name: hours_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('hours_id_seq', 7, true);


--
-- Data for Name: period; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY period (id, year, period) FROM stdin;
1	2017	ENE-MAY
2	2017	VERANO
\.


--
-- Name: period_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('period_id_seq', 1, false);


--
-- Data for Name: professor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY professor (id, name) FROM stdin;
1327685	Dan Perez
1326798	Alberto Oliart
1326969	Juan Calleros
1325050	Dr Olmos
\.


--
-- Data for Name: student; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY student (id, name) FROM stdin;
1325081	Ricardo Rodiles Legaspi
1328484	Alejandro Tovar
\.


--
-- Data for Name: subject; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY subject (id, name, professor) FROM stdin;
1	Bases de datos Avanzadas	1327685
2	Mates Discretas	1327685
3	Progra Avanzada	1326798
\.


--
-- Name: subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('subject_id_seq', 1, false);


--
-- Data for Name: usuar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuar (id, password, email, type) FROM stdin;
1325081	6fb88c0c4156bae22639348760c151870072e1c7	a01325081@itesm.mx	2
1328484	e752529a12218ad9759044a4a2b79bda51882fe9	a01328484@itesm.mx	2
1326798	a3ddea8602dd587f3a6fd4f506b4242a7ff12f6d	a01326798@itesm.mx	1
1	d033e22ae348aeb5660fc2140aec35850c4da997	admin	0
1326969	b994f7ab6040ee49d9e59907fb063d74cc7736b4	calleros@itesm.mx	1
1325050	9662c3d777bd7e3ff36d59eb40a5c574ac0123a5	elcoach@itesm.mx	1
1327685	40bd001563085fc35165329ea1ff5c5ecbdbbeef	danperez@itesm.mx	1
\.


--
-- Name: asesorias asesorias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asesorias
    ADD CONSTRAINT asesorias_pkey PRIMARY KEY (id);


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
-- Name: usuar usuar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuar
    ADD CONSTRAINT usuar_pkey PRIMARY KEY (id);


--
-- Name: availabledates checkday; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER checkday AFTER INSERT ON availabledates FOR EACH ROW EXECUTE PROCEDURE correctday();


--
-- Name: asesorias asesorias_professor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asesorias
    ADD CONSTRAINT asesorias_professor_fkey FOREIGN KEY (professor) REFERENCES professor(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: asesorias asesorias_student_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY asesorias
    ADD CONSTRAINT asesorias_student_fkey FOREIGN KEY (student) REFERENCES student(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: availabledates availabledates_officehour_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_officehour_fkey FOREIGN KEY (officehour) REFERENCES hours(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: availabledates availabledates_student_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_student_fkey FOREIGN KEY (student) REFERENCES student(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: availabledates availabledates_subject_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY availabledates
    ADD CONSTRAINT availabledates_subject_fkey FOREIGN KEY (subject) REFERENCES subject(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: hours hours_period_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hours
    ADD CONSTRAINT hours_period_fkey FOREIGN KEY (period) REFERENCES period(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: hours hours_professor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hours
    ADD CONSTRAINT hours_professor_fkey FOREIGN KEY (professor) REFERENCES professor(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: professor professor_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY professor
    ADD CONSTRAINT professor_id_fkey FOREIGN KEY (id) REFERENCES usuar(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: student student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY student
    ADD CONSTRAINT student_id_fkey FOREIGN KEY (id) REFERENCES usuar(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: subject subject_professor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subject
    ADD CONSTRAINT subject_professor_fkey FOREIGN KEY (professor) REFERENCES professor(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

