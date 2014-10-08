CREATE TABLE User (
  user_id INTEGER PRIMARY KEY,
  username TEXT NOT NULL,
  password TEXT NOT NULL
);

CREATE TABLE Pattern (
  pattern_id INTEGER PRIMARY KEY,
  pattern TEXT NOT NULL
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
  theme_id INTEGER REFERENCES Theme(theme_id)
  PRIMARY KEY(pattern_id, theme_id)
);

CREATE TABLE UselessTheme (
theme_id INTEGER PRIMARY KEY
);

CREATE TABLE PatternCheckedTheme (
theme_id INTEGER NOT NULL,  -- need't be a foreign key
pattern_id INTEGER REFERENCES Pattern(pattern_id),
PRIMARY KEY(theme_id, pattern_id)
)