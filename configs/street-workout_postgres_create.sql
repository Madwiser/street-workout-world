
	CREATE TABLE IF NOT EXISTS public.utilisateur (

	idutilisateur integer NOT NULL,
    	nom character varying(50) NOT NULL,
    	prenom character varying(50) NOT NULL,
    	email character varying(100) NOT NULL,
    	admin boolean NOT NULL,
    	login character(30) COLLATE pg_catalog."default" NOT NULL,
    	passe character(100)[] COLLATE pg_catalog."default" NOT NULL,
    	CONSTRAINT utilisateur_pk PRIMARY KEY (idutilisateur)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.categoriearticle (
	idcategorie int NOT NULL,
	libellecategorie varchar(50) NOT NULL,
	CONSTRAINT categoriearticle_pk PRIMARY KEY (idcategorie)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.article (
	idarticle int NOT NULL,
	titre varchar(300) NOT NULL,
	datearticle DATE NOT NULL,
	contenuarticle TEXT NOT NULL,
	resumearticle TEXT NOT NULL,
	miniature varchar(100) NOT NULL,
	idcategorie int NOT NULL,
	idcreateura int NOT NULL,
	CONSTRAINT article_pk PRIMARY KEY (idarticle)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.ressource (
	idressource bigint NOT NULL,
	descriptionressource TEXT NOT NULL,
	lienressource varchar(100) NOT NULL,
	idtyperessource int NOT NULL,
	CONSTRAINT ressource_pk PRIMARY KEY (idressource)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.entrainement (
	identrainement int NOT NULL,
	contenuentrainement TEXT NOT NULL,
	duree varchar(20) NOT NULL,
	dateentrainement DATE NOT NULL,
	verifentrainement BOOLEAN NOT NULL,
	idCreateurE int NOT NULL,
	CONSTRAINT entrainement_pk PRIMARY KEY (identrainement)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.exercice (
	idexercice int NOT NULL,
	nomexercice varchar(50) NOT NULL,
	contenuexercice TEXT NOT NULL,
	iddifficulte int NOT NULL,
	idtype int NOT NULL,
	CONSTRAINT exercice_pk PRIMARY KEY (idexercice)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.compositionentrainement (
	identrainement int NOT NULL,
	idexercice int NOT NULL,
	CONSTRAINT compositionentrainement_pk PRIMARY KEY (identrainement,idexercice)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.difficulteexercice (
	iddifficulte int NOT NULL,
	libelledifficulte varchar(30) NOT NULL,
	CONSTRAINT difficulteexercice_pk PRIMARY KEY (iddifficulte)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.typeexercice (
	idtype int NOT NULL,
	libelletype varchar(30) NOT NULL,
	CONSTRAINT typeexercice_pk PRIMARY KEY (idtype)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.muscle (
	idmuscle int NOT NULL,
	nommuscle varchar(30) NOT NULL,
	idzone int NOT NULL,
	CONSTRAINT muscle_pk PRIMARY KEY (idmuscle)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.muscletravaille (
	idexercice int NOT NULL,
	idmuscle int NOT NULL,
	CONSTRAINT muscletravaille_pk PRIMARY KEY (idexercice,idmuscle)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.zoneducorps (
	idzone int NOT NULL,
	libellezone varchar(40) NOT NULL,
	CONSTRAINT zoneducorps_pk PRIMARY KEY (idzone)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.typeressource (
	idtyperessource int NOT NULL,
	libelletyperessource varchar(20) NOT NULL,
	CONSTRAINT typeressource_pk PRIMARY KEY (idtyperessource)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.ressourceexercice (
	idexercice int NOT NULL,
	idressource int NOT NULL,
	CONSTRAINT ressourceexercice_pk PRIMARY KEY (idexercice,idressource)
) WITH (
  OIDS=FALSE
);



CREATE TABLE IF NOT EXISTS  public.ressourcearticle (
	idarticle int NOT NULL,
	idressource int NOT NULL,
	CONSTRAINT ressourcearticle_pk PRIMARY KEY (idarticle,idressource)
) WITH (
  OIDS=FALSE
);





ALTER TABLE article ADD CONSTRAINT article_fk0 FOREIGN KEY (idcategorie) REFERENCES categoriearticle(idcategorie);
ALTER TABLE article ADD CONSTRAINT article_fk1 FOREIGN KEY (idCreateurA) REFERENCES utilisateur(idutilisateur);

ALTER TABLE ressource ADD CONSTRAINT ressource_fk0 FOREIGN KEY (idtyperessource) REFERENCES typeressource(idtyperessource);

ALTER TABLE entrainement ADD CONSTRAINT entrainement_fk0 FOREIGN KEY (idCreateure) REFERENCES utilisateur(idutilisateur);

ALTER TABLE exercice ADD CONSTRAINT exercice_fk0 FOREIGN KEY (iddifficulte) REFERENCES difficulteexercice(iddifficulte);
ALTER TABLE exercice ADD CONSTRAINT exercice_fk1 FOREIGN KEY (idtype) REFERENCES typeexercice(idtype);

ALTER TABLE compositionentrainement ADD CONSTRAINT compositionentrainement_fk0 FOREIGN KEY (identrainement) REFERENCES entrainement(identrainement);
ALTER TABLE compositionentrainement ADD CONSTRAINT compositionentrainement_fk1 FOREIGN KEY (idexercice) REFERENCES exercice(idexercice);



ALTER TABLE muscle ADD CONSTRAINT muscle_fk0 FOREIGN KEY (idzone) REFERENCES zoneducorps(idzone);

ALTER TABLE muscletravaille ADD CONSTRAINT muscletravaille_fk0 FOREIGN KEY (idexercice) REFERENCES exercice(idexercice);
ALTER TABLE muscletravaille ADD CONSTRAINT muscletravaille_fk1 FOREIGN KEY (idmuscle) REFERENCES muscle(idmuscle);



ALTER TABLE ressourceexercice ADD CONSTRAINT ressourceexercice_fk0 FOREIGN KEY (idexercice) REFERENCES exercice(idexercice);
ALTER TABLE ressourceexercice ADD CONSTRAINT ressourceexercice_fk1 FOREIGN KEY (idressource) REFERENCES ressource(idressource);

ALTER TABLE ressourcearticle ADD CONSTRAINT ressourcearticle_fk0 FOREIGN KEY (idarticle) REFERENCES article(idarticle);
ALTER TABLE ressourcearticle ADD CONSTRAINT ressourcearticle_fk1 FOREIGN KEY (idressource) REFERENCES ressource(idressource);


CREATE OR REPLACE FUNCTION public.delete_exos_entrainement()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    VOLATILE
    COST 100
AS $BODY$BEGIN
	DELETE FROM compositionentrainement where identrainement = old.identrainement;
END
	
$BODY$;


-- Trigger: delete_exos_entrainement

-- DROP TRIGGER delete_exos_entrainement ON entrainement;

CREATE TRIGGER delete_exos_entrainement
    BEFORE DELETE
    ON entrainement
    FOR EACH ROW
    EXECUTE PROCEDURE public.delete_exos_entrainement();

COMMENT ON TRIGGER delete_exos_entrainement ON entrainement
    IS 'lors de la suppression d''un entraînement, on doit d''abord supprimer tous les exos associés( dans compositionentrainement)';



CREATE OR REPLACE FUNCTION public.verif_nb_exercice()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    VOLATILE
    COST 100
AS $BODY$
BEGIN
        -- on vérifie que le nombre d'exercice est inférieur à 11.
        IF ((SELECT count(*) from compositionentrainement where identrainement = new.identrainement) =10) THEN
            RAISE EXCEPTION 'un entraînement ne peut pas contenir plus de 10 exercices';
        END IF;
		RETURN NULL;
      
END;
$BODY$;


-- Trigger: verif_nb_exercice

-- DROP TRIGGER verif_nb_exercice ON compositionentrainement;

CREATE TRIGGER verif_nb_exercice
    BEFORE INSERT OR UPDATE 
    ON compositionentrainement
    FOR EACH ROW
    EXECUTE PROCEDURE public.verif_nb_exercice();

COMMENT ON TRIGGER verif_nb_exercice ON compositionentrainement
    IS 'le trigger se déclenche avant l''insert ou l''update de compositionentrainement';
