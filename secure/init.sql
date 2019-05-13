-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- USERS TABLE
CREATE TABLE `users` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`username` TEXT NOT NULL UNIQUE,
    `password` TEXT NOT NULL
);

-- USERS TABLE SEED DATA
INSERT INTO `users` (id,username,password) VALUES (1,"jz482","$2y$10$Ud/kxikzS3PbJJxIZFVfOOgXPwVnRelJZZJyJg/baGNRnouFsLpMu"); --password: janez1299
INSERT INTO `users` (id,username,password) VALUES (2,"gs484", "$2y$10$yzLmTif2Xs59XzgeHSATQOjT3sYRmhTKuqn04H72CzrKBXPJnXhpK"); --password: ramen
INSERT INTO `users` (id,username,password) VALUES (3,"yl799", "$2y$10$oZV0PvoAaNYWzWZg22YTXeNKLsn/OVm3ZD2goktNBKrLWKhXCmnkO"); --password: gucci

-- SESSIONS TABLE
CREATE TABLE `sessions` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`user_id` INTEGER NOT NULL,
	`session_id` TEXT NOT NULL UNIQUE
);

-- IMAGES TABLE
CREATE TABLE `images` (
	`image_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`user_id` INTEGER NOT NULL,
	`image_name` TEXT,
    `image_description` TEXT,
    `file_type` TEXT,
	`source_name` TEXT,
	`source_link` TEXT
);

-- IMAGES TABLE SEED DATA
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (1,1,'thailand-1.jpg','beach in Phuket,Thailand','jpg','travelandleisure.com','https://www.travelandleisure.com/trip-ideas/island-vacations/phuket-thailand-travel-guide');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (2,2,'thailand-2.jpg','Phi Phi Island in Thailand','jpg','Similan Islands','https://similan-islands.com/thailand-islands/');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (3,1,'thailand-3.jpg','Mandarin Oriental, Bangkok','jpg','touropia.com','https://www.touropia.com/gfx/d/amazing-hotels-in-thailand/Mandarin_Oriental_Bangkok.jpg?v=1');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (4,3,'shanghai-1.jpg','Aerial view of Shanghai','jpg','fubiz.net','http://www.fubiz.net/wp-content/uploads/2018/02/fubiz-mark-siegemund-shanghai-photography-01.jpg');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (5,2,'shanghai-2.jpg','Shanghai Disney Resort','jpg','cdn1.parksmedia.wdprapps.disney.com','https://cdn1.parksmedia.wdprapps.disney.com/media/blog/wp-content/uploads/2017/06/shoyc39878581.jpg');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (6,2,'greece-1.jpg','Santorini,Greece','jpg','photographytraveltours.com','https://photographytraveltours.com/wp-content/uploads/2014/06/Oia_Santorini_Greece_Windmill_Sunset.jpg');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (7,3,'greece-2.jpg','Parga, Greece','jpg','onebigphoto.com','http://onebigphoto.com/this-is-parga-greece/');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (8,2,'mountain-1.jpg','Lago di Braies, Italy','jpg','CNN.com','https://dynaimage.cdn.cnn.com/cnn/q_auto,w_900,c_fill,g_auto,h_506,ar_16:9/http%3A%2F%2Fcdn.cnn.com%2Fcnnnext%2Fdam%2Fassets%2F180601122530-italy---lago-di-braies---johan-lolos.jpg');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (9,3,'mountain-2.jpg','Plitvice National Park, Croatia','jpg','venturists.net','https://www.venturists.net/plitvice-lakes-national-park-croatia/');
INSERT INTO `images` (image_id,user_id,image_name,image_description,file_type,source_name, source_link) VALUES (10,2,'mountain-3.jpg','Sommaroy, Tromso, Norway','jpg','scandinaviantraveler.com','https://scandinaviantraveler.com/en/places/sommaroy-where-the-arctic-meets-the-caribbean');


-- TAGS TABLE
CREATE TABLE `tags` (
	`tag_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`tag_name` TEXT
);


-- TAGS TABLE SEED DATA
INSERT INTO `tags` (tag_id,tag_name) VALUES (1,'Greece');
INSERT INTO `tags` (tag_id,tag_name) VALUES (2,'Thailand');
INSERT INTO `tags` (tag_id,tag_name) VALUES (3,'Beach');
INSERT INTO `tags` (tag_id,tag_name) VALUES (4,'Shanghai');
INSERT INTO `tags` (tag_id,tag_name) VALUES (5,'Nightview');
INSERT INTO `tags` (tag_id,tag_name) VALUES (6,'City');
INSERT INTO `tags` (tag_id,tag_name) VALUES (7,'Mountain');
INSERT INTO `tags` (tag_id,tag_name) VALUES (8,'Nature');
INSERT INTO `tags` (tag_id,tag_name) VALUES (9,'Europe');
INSERT INTO `tags` (tag_id,tag_name) VALUES (10,'Asia');
INSERT INTO `tags` (tag_id,tag_name) VALUES (11,'Island');


-- IMAGE_TAGS TABLE
CREATE TABLE `image_tags` (
	`image_tags_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`tag_id` INTEGER,
    `image_id` INTEGER
);

-- IMAGES_TAGS TABLE SEED DATA
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (1,1,6);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (2,1,7);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (3,2,1);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (4,2,2);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (5,2,3);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (6,3,1);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (7,3,2);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (8,4,4);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (9,4,5);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (10,5,4);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (11,5,6);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (12,6,3);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (13,6,4);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (14,6,6);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (15,6,7);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (16,7,8);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (17,7,9);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (18,7,10);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (19,8,1);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (20,8,2);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (21,8,8);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (22,8,9);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (23,8,10);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (24,9,6);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (25,9,7);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (26,9,8);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (27,9,9);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (28,9,10);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (29,10,1);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (30,10,2);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (31,10,3);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (32,10,4);
INSERT INTO `image_tags` (image_tags_id,tag_id,image_id) VALUES (33,10,5);

COMMIT;
