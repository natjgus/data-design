-- The statement below sets the collation of the database to utf8
ALTER DATABASE ngustafson CHARACTER SET utf8 COLLATE utf8_unicode_ci;


-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- not null means the attribute is required!
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAtHandle VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	-- to make something optional, exclude the not null
	profileHash	CHAR(128) NOT NULL,
	profilePhone VARCHAR(32),
	profileSalt CHAR(64) NOT NULL,
	-- to make sure duplicate data cannot exist, create a unique index
	UNIQUE(profileAtHandle),
	UNIQUE(profileEmail),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);

-- create the article entity
CREATE TABLE article (
	-- this is for yet another primary key...
	articleId BINARY(16) NOT NULL,
	-- this is for a foreign key
	articleProfileId BINARY(16) NOT NULL,
	articleTitle VARCHAR(100),
	articleContent VARCHAR(5000) NOT NULL,
	articlePublishDate DATETIME(6) NOT NULL,
	-- this creates an index before making a foreign key
	INDEX(articleProfileId),
	-- this creates the actual foreign key relation
	FOREIGN KEY(articleProfileId) REFERENCES profile(profileId),
	-- and finally create the primary key
	PRIMARY KEY(articleId)
);

-- create the like entity (a weak entity from an m-to-n for profile --> tweet)
CREATE TABLE clap (
	clapId BINARY(16) NOT NULL,
	clapArticleId BINARY(16) NOT NULL,
	clapProfileId BINARY(16) NOT NULL ,

	likeDate DATETIME(6) NOT NULL,
	-- index the foreign keys
	INDEX(clapArticleId),
	INDEX(clapProfileId),
	-- create the foreign key relations
	FOREIGN KEY(clapArticleId) REFERENCES profile(profileId),
	FOREIGN KEY(clapProfileId) REFERENCES article(articleId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(clapArticleId, clapProfileId)
);