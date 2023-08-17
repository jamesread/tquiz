-- +migrate Up
INSERT INTO users (username, password, `group`) VALUES ('admin', sha1('password'), 1);
INSERT INTO permissions (`key`) VALUES ('SUPERUSER');
INSERT INTO groups (`title`) VALUES ('admins');
INSERT INTO privileges_g (`group`, `permission`) VALUES (1, 1);
INSERT INTO site_settings (`key`, value) VALUES ("headerMessage", "header message goes here");
INSERT INTO site_settings (`key`, value) VALUES ("registrationBlockMessage", "");
INSERT INTO site_settings (`key`, value) VALUES ("activeQuiz", "");
INSERT INTO site_settings (`key`, value) VALUES ("sponsorMessage", "This quiz is sponsored by...");

-- +migrate Down
