CREATE TABLE :Club
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    ShortName VARCHAR(20) NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Player
(
    player_id SMALLINT NOT NULL AUTO_INCREMENT,
    pdga varchar(10),
    sex ENUM('male', 'female'),
    lastname VARCHAR(100),
    firstname VARCHAR(100),
    birthdate DATE,
    email VARCHAR(150),
    PRIMARY KEY(player_id),
    INDEX(pdga)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :User
(
    id INT NOT NULL AUTO_INCREMENT,
    Username VARCHAR(40) NOT NULL,
    UserEmail VARCHAR(100) NOT NULL,
    Password VARCHAR(60) NOT NULL,
    Salt VARCHAR(40) DEFAULT NULL,
    Hash VARCHAR(40) DEFAULT NULL,
    Role ENUM('admin', 'player') NOT NULL DEFAULT 'player',
    UserFirstName VARCHAR(40) NOT NULL,
    UserLastName VARCHAR(40) NOT NULL,
    Player SMALLINT,
    LastLogin DATETIME,
    PasswordChanged DATETIME,
    SflId INT,
    Club INT,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    FOREIGN KEY(Club) REFERENCES :Club(id),
    UNIQUE(Username),
    INDEX(Username, Password)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Venue
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(40) NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Level
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(40) NOT NULL,
    ScoreCalculationMethod VARCHAR(40) NOT NULL,
    Available TINYINT NOT NULL,
    PRIMARY KEY(id),
    INDEX(Available)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Tournament
(
    id INT NOT NULL AUTO_INCREMENT,
    Level INT NOT NULL,
    Name VARCHAR(40) NOT NULL,
    Year INT NOT NULL,
    Description TEXT NOT NULL,
    ScoreCalculationMethod VARCHAR(40) NOT NULL,
    Available TINYINT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Level) REFERENCES :Level(id),
    INDEX(Year),
    INDEX(Available)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :File
(
    id INT NOT NULL AUTO_INCREMENT,
    Filename VARCHAR(60) NOT NULL,
    Type VARCHAR(10) NOT NULL,
    DisplayName VARCHAR(60) NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Event
(
    id INT NOT NULL AUTO_INCREMENT,
    Venue INT,
    Tournament INT,
    Level INT,
    Name VARCHAR(80) NOT NULL,
    Date DATETIME NOT NULL,
    Duration TINYINT NOT NULL,
    ActivationDate DATETIME,
    SignupStart DATETIME,
    SignupEnd DATETIME,
    ResultsLocked DATETIME NULL,
    ContactInfo VARCHAR(250) NOT NULL,
    FeesRequired TINYINT NOT NULL,
    AdBanner INT NULL,
    PdgaEventId INT,
    PlayerLimit INT NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(Venue) REFERENCES :Venue(id),
    FOREIGN KEY(Level) REFERENCES :Level(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :AdBanner
(
    id INT(11) NOT NULL AUTO_INCREMENT,
    URL VARCHAR(200) NULL,
    ImageURL VARCHAR(200)  NULL,
    LongData TEXT,
    ImageReference INT(11) DEFAULT NULL,
    Type VARCHAR(20) NOT NULL,
    Event INT(11) DEFAULT NULL,
    ContentId VARCHAR(30)  NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(ImageReference) REFERENCES :File(id),
    FOREIGN KEY(Event) REFERENCES :Event(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :EventManagement
(
    id INT NOT NULL AUTO_INCREMENT,
    User INT NOT NULL,
    Event INT NOT NULL,
    Role VARCHAR(10) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (User) REFERENCES :User(id),
    FOREIGN KEY (Event) REFERENCES :Event(id),
    INDEX(User, Event, Role)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :TextContent
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NULL,
    Title VARCHAR(40) NOT NULL,
    Content TEXT NOT NULL,
    Date DATETIME NOT NULL,
    Type VARCHAR(14) NOT NULL,
    `Order` SMALLINT,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    INDEX(Event, Title),
    INDEX(Event, Type)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Classification
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(40) NOT NULL,
    MinimumAge INT,
    MaximumAge INT,
    GenderRequirement CHAR(1),
    Available TINYINT NOT NULL,
    PRIMARY KEY(id),
    INDEX(Available)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Course
(
    id INT NOT NULL AUTO_INCREMENT,
    Venue INT NULL,
    Name VARCHAR(40) NOT NULL,
    Description TEXT NOT NULL,
    Link VARCHAR(120) NOT NULL,
    Map VARCHAR(60) NOT NULL,
    Event INT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Venue) REFERENCES :Venue(id),
    FOREIGN KEY(Event) REFERENCES :Event(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Round
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Course INT NULL,
    StartType VARCHAR(12) NOT NULL,
    StartTime DATETIME NOT NULL,
    `Interval` TINYINT,
    ValidResults TINYINT(1) NOT NULL,
    GroupsFinished DATETIME NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Course) REFERENCES :Course(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Section
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(40) NOT NULL,
    Classification INT NULL,
    Round INT NOT NULL,
    Priority SMALLINT NULL,
    StartTime DATETIME NULL,
    Present TINYINT NOT NULL DEFAULT '1',
    PRIMARY KEY(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    FOREIGN KEY(Round) REFERENCES `:Round`(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Hole
(
    id INT NOT NULL AUTO_INCREMENT,
    Course INT NOT NULL,
    HoleNumber TINYINT NOT NULL,
    HoleText VARCHAR(4),
    Par TINYINT NOT NULL,
    Length SMALLINT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Course) REFERENCES :Course(id),
    INDEX(Course, HoleNumber)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :Participation
(
    id INT NOT NULL AUTO_INCREMENT,
    Player SMALLINT NOT NULL,
    Event INT NOT NULL,
    Classification INT NOT NULL,
    Approved TINYINT NOT NULL,
    EventFeePaid DATETIME,
    OverallResult SMALLINT,
    Standing SMALLINT,
    DidNotFinish TINYINT NOT NULL,
    SignupTimestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    TournamentPoints INT NULL,
    Club INT,
    Rating INT,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    FOREIGN KEY(Club) REFERENCES :Club(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :RoundResult
(
    id INT NOT NULL AUTO_INCREMENT,
    Round INT NOT NULL,
    Player SMALLINT NOT NULL,
    Result SMALLINT NOT NULL,
    Penalty TINYINT NOT NULL,
    SuddenDeath TINYINT,
    Completed TINYINT DEFAULT '99',
    DidNotFinish TINYINT DEFAULT '0',
    PlusMinus MEDIUMINT NOT NULL,
    LastUpdated DATETIME NOT NULL,
    CumulativePlusminus INT DEFAULT '0',
    CumulativeTotal INT DEFAULT '0',
    PRIMARY KEY(id),
    FOREIGN KEY(Round) REFERENCES :Round(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    INDEX(Round, LastUpdated)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :HoleResult
(
    id INT NOT NULL AUTO_INCREMENT,
    Hole INT NOT NULL,
    RoundResult INT NOT NULL,
    Player SMALLINT NOT NULL,
    Result TINYINT NOT NULL,
    DidNotShow TINYINT(1) NOT NULL,
    LastUpdated DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Hole) REFERENCES :Hole(id),
    FOREIGN KEY(RoundResult) REFERENCES :RoundResult(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    INDEX(RoundResult, LastUpdated)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :StartingOrder
(
    id INT NOT NULL AUTO_INCREMENT,
    Player SMALLINT NOT NULL,
    Section INT NOT NULL,
    StartingTime DATETIME NOT NULL,
    StartingHole TINYINT,
    GroupNumber SMALLINT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    FOREIGN KEY(Section) REFERENCES :Section(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :SectionMembership
(
    id INT NOT NULL AUTO_INCREMENT,
    Participation INT NOT NULL,
    Section INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Participation) REFERENCES :Participation(id),
    FOREIGN KEY(Section) REFERENCES :Section(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :TournamentStanding
(
    id INT NOT NULL AUTO_INCREMENT,
    Player SMALLINT NOT NULL,
    Tournament INT NOT NULL,
    OverallScore SMALLINT NOT NULL,
    Standing SMALLINT,
    TieBreaker SMALLINT NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    FOREIGN KEY(Tournament) REFERENCES :Tournament(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :ClassInEvent
(
    id INT NOT NULL AUTO_INCREMENT,
    Classification INT NOT NULL,
    Event INT NOT NULL,
    MinQuota INT NOT NULL DEFAULT 0,
    MaxQuota INT NOT NULL DEFAULT 999,
    PRIMARY KEY(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    FOREIGN KEY(Event) REFERENCES :Event(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :LicensePayment
(
    id INT NOT NULL AUTO_INCREMENT,
    Player SMALLINT NOT NULL,
    Year INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :MembershipPayment
(
    id INT NOT NULL AUTO_INCREMENT,
    Player SMALLINT NOT NULL,
    Year INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :EventQueue
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Player SMALLINT NOT NULL,
    Classification INT NOT NULL,
    Club INT,
    Rating INT,
    SignupTimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    INDEX(Event)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :RegistrationRules
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Classification INT NOT NULL,
    Type ENUM('rating', 'country', 'player', 'status', 'co'),
    Op ENUM('>', '>=', '<', '<=', '!=', '=='),
    Value VARCHAR(20) NOT NULL,
    Action ENUM('accept', 'queue', 'reject'),
    ValidUntil DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :PDGAPlayers
(
    pdga_number INT NOT NULL,
    last_updated DATETIME,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    birth_year INT(4) NOT NULL,
    gender ENUM('M', 'F') NOT NULL,
    membership_status ENUM('expired', 'current') NOT NULL,
    membership_expiration_date DATE,
    classification ENUM('P', 'A') NOT NULL,
    city VARCHAR(255) NOT NULL,
    state_prov VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    rating INT NOT NULL DEFAULT 0,
    rating_effective_date DATE,
    official_status ENUM('yes', 'no') NOT NULL,
    official_expiration_date DATE,
    PRIMARY KEY(pdga_number)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :PDGAStats
(
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    pdga_number INT NOT NULL,
    rating INT NOT NULL DEFAULT 0,
    year INT NOT NULL,
    class ENUM('P', 'A') NOT NULL,
    gender ENUM('M', 'F') NOT NULL,
    bracket VARCHAR(30) NOT NULL,
    country VARCHAR(2) NOT NULL,
    state_prov VARCHAR(30),
    tournaments INT NOT NULL DEFAULT 0,
    rating_rounds_used INT NOT NULL DEFAULT 0,
    points INT NOT NULL DEFAULT 0,
    prize FLOAT(12,2) DEFAULT 0.00,
    last_updated DATETIME,
    UNIQUE KEY(pdganum, year, class)
) ENGINE=InnoDB;
SHOW WARNINGS;
