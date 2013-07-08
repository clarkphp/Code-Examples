-- SQL script for creating database tables

CREATE TABLE `students` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `first_name` varchar(30) default NULL,
  `last_name` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `instructors` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `first_name` varchar(30) default NULL,
  `last_name` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) default NULL,
  `instructor_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE `courses_students` (
  `course_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL
);