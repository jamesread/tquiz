This is a _really basic_ quickstart. More to come later.

You'll need php, mysql, etc installed. 

1) Register a user using the standard registration form.
2) Open up a mysql client, run

SQL: select * from users

should show your new user row. Look at the `group` field. Normally this is "2"

SQL: insert into groups (id, title) values (2, "Staff");

Where "2" is the id number of the group associated with your user.

Now insert the super user permission

SQL: insert into permissions (`key`) values ("SUPERUSER");

Now give that permission to a group:

SQL: insert into privileges_g (`group`, `permission`) values (2,2);

You'll want some site settings, add the following

SQL: insert into site_settings (`key`, value) values ("headerMessage", "header message goes here");
SQL: insert into site_settings (`key`, value) values ("registrationBlockMessage", "");
SQL: insert into site_settings (`key`, value) values ("activeQuiz", "");
SQL: insert into site_settings (`key`, value) values ("sponsorMessage", "This quiz is sponsored by...");

3) Now try to login...! you should see an "admin" link if all went well...