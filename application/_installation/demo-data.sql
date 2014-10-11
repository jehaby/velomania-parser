INSERT INTO User(user_id, user_name, user_email, user_password) VALUES (1,'urf', 'kevin.smth.42@gmail.com','7e169b8d621f031e58ee5f5f7dca1401');

INSERT INTO "Pattern" VALUES(1,'рюкзак');
INSERT INTO "Pattern" VALUES(2,'нож');
INSERT INTO "Pattern" VALUES(3,'баобаб бля');
INSERT INTO "Pattern" VALUES(4,'ёлка И иголка');

INSERT INTO "UserPattern" VALUES(1,1);
INSERT INTO "UserPattern" VALUES(1,2);
INSERT INTO "UserPattern" VALUES(1,3);
INSERT INTO "UserPattern" VALUES(1,4);

INSERT INTO "Theme" VALUES(1,'рюкзак','Врунгель');
INSERT INTO "Theme" VALUES(2,'Куплю нож','Сява');

INSERT INTO "PatternTheme" VALUES(1,1);
INSERT INTO "PatternTheme" VALUES(1,2);