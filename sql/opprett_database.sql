/*Step one*/
CREATE TABLE IF NOT EXISTS bruker(
	navn VARCHAR(254) NOT NULL,
	ansattnr INT UNIQUE NOT NULL,
	passord VARCHAR(254) NOT NULL,
	admin TINYINT(2) NOT NULL,
	PRIMARY KEY(ansattnr)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS anlegg(
	anleggsid INT NOT NULL,
	anleggsnavn VARCHAR(254),
	PRIMARY KEY(anleggsid)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS labprover(
	labproveid INT AUTO_INCREMENT NOT NULL,
	vannproveid INT NULL,
	ansattnr INT NULL,
	kimtall INT NOT NULL,
	pa INT NOT NULL,
	koliform INT NOT NULL,
	ph DECIMAL (4, 2) NOT NULL,
	temp_v_ph DECIMAL (4, 2) NOT NULL,
	fargetall INT NOT NULL,
	turbiditet DECIMAL (4, 2) NOT NULL,
	PRIMARY KEY(labproveid),
	FOREIGN KEY(ansattnr) REFERENCES bruker(ansattnr)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS vannprover(
	vannproveid INT NOT NULL AUTO_INCREMENT,
	anleggsid INT NOT NULL,
	labproveid INT,
	signatur VARCHAR(255) NOT NULL,
	ansattnr INT NULL,
	opprettet DATETIME NOT NULL,
	klor DECIMAL(4, 2) NOT NULL,
	ph DECIMAL(4, 2) NOT NULL,
	dpd1 DECIMAL(4, 2) NOT NULL,
	dpd3 DECIMAL(4, 2) NOT NULL,
	bundet_klor DECIMAL(4, 2) NOT NULL,
	phenol DECIMAL (4, 2) NOT NULL,
	addLab TINYINT(2) NOT NULL,
	PRIMARY KEY(vannproveid),
	FOREIGN KEY(ansattnr) REFERENCES bruker(ansattnr),
	FOREIGN KEY(anleggsid) REFERENCES anlegg(anleggsid),
	FOREIGN KEY(labproveid) REFERENCES labprover(labproveid) ON DELETE CASCADE
	)
	ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8;


/*Step two - Insert after making tables  */
	ALTER TABLE labprover
	ADD FOREIGN KEY vannprover(vannproveid) REFERENCES vannprover(vannproveid) ON DELETE CASCADE;



/* step three -  insert after create tables and making tables */

INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(0, 'Flowrider');
INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(1, 'Barneanlegget');
INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(2, 'Nedre Nedre');
INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(3, 'Nedre Øvre');
INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(4, 'Øvre');
INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(5, 'Bøverstranda');
INSERT INTO anlegg(anleggsid, anleggsnavn) VALUES(6, 'Splash');

/* Make admin */
INSERT INTO bruker(navn, ansattnr, passord, admin) VALUES
('Admin', 1234, '$2y$10$HaX3pPm1QqC.hY9ZfUJ/9uwAhEmpLR0BiWnwFq5El2uINckSdfQ2m', 2);
