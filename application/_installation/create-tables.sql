CREATE TABLE User (
  user_id INTEGER PRIMARY KEY,
  user_name TEXT NOT NULL,
  user_email TEXT NOT NULL,
  user_password TEXT NOT NULL,
  user_rememberme_token TEXT,
  user_creation_timestamp INT,
  user_last_login_timestamp INT,
  user_failed_logins INT,
  user_last_failed_login INT,
  user_password_reset_hash TEXT,
  user_password_reset_timestamp INT
);

CREATE TABLE Pattern (
  pattern_id INTEGER PRIMARY KEY,
  pattern TEXT NOT NULL,
  sections TEXT NOT NULL
);

CREATE TABLE UserPattern (
  user_id INTEGER REFERENCES User(user_id),
  pattern_id INTEGER REFERENCES Pattern(pattern_id),
PRIMARY KEY(user_id, pattern_id)
);

CREATE TABLE Theme (
  theme_id INTEGER PRIMARY KEY,
  title TEXT NOT NULL,
  author TEXT NOT NULL
);

CREATE TABLE PatternTheme (
  pattern_id INTEGER REFERENCES Pattern(pattern_id),
  theme_id INTEGER REFERENCES Theme(theme_id),
  PRIMARY KEY(pattern_id, theme_id)
);

CREATE TABLE UselessTheme (
theme_id INTEGER NOT NULL,
pattern_id INTEGER NOT NULL,
PRIMARY KEY(theme_id, pattern_id)
);

CREATE TABLE PatternCheckedTheme (
theme_id INTEGER NOT NULL,  -- need't be a foreign key
pattern_id INTEGER REFERENCES Pattern(pattern_id),
PRIMARY KEY(theme_id, pattern_id)
);