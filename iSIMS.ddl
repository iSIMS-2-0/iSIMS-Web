CREATE TABLE students (id int(10) NOT NULL AUTO_INCREMENT, student_number varchar(20) NOT NULL UNIQUE, name varchar(100) NOT NULL, program_id int(10) NOT NULL, sex varchar(10) NOT NULL, gender_disclosure bit(1) NOT NULL, pronouns varchar(20), mobile varchar(20) NOT NULL, landline varchar(20) NOT NULL, email varchar(100) NOT NULL, lot_blk varchar(50) NOT NULL, street varchar(50) NOT NULL, zip_code int(10) NOT NULL, city_municipality varchar(50) NOT NULL, country varchar(20), created_at timestamp NOT NULL, password_hash varchar(255) NOT NULL, family_info_id int(10) NOT NULL, medical_historyid int(10) NOT NULL, PRIMARY KEY (id));
CREATE TABLE subjects (
    id int(10) NOT NULL AUTO_INCREMENT,
    code varchar(20) NOT NULL UNIQUE,
    name varchar(100) NOT NULL,
    units int(10) NOT NULL,
    is_laboratory TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);

CREATE TABLE payment_proofs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    payment_description VARCHAR(255) NOT NULL,
    school_year VARCHAR(20) NOT NULL,
    term VARCHAR(20) NOT NULL,
    upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    file_name VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT NOT NULL,
    file_blob LONGBLOB NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    amount decimal(10,2) DEFAULT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
);
CREATE TABLE grades (id int(10) NOT NULL AUTO_INCREMENT, students_class_id int(10) NOT NULL, grade decimal(4, 2) NOT NULL, PRIMARY KEY (id));
CREATE TABLE sections (id int(10) NOT NULL AUTO_INCREMENT, name varchar(50) NOT NULL, PRIMARY KEY (id));
CREATE TABLE schedules (id int(10) NOT NULL AUTO_INCREMENT, subject_id int(10) NOT NULL, section_id int(10) NOT NULL, day_of_week varchar(10), start_time time DEFAULT '6', end_time time DEFAULT '6', room varchar(50), PRIMARY KEY (id));
CREATE TABLE announcements (id int(10) NOT NULL AUTO_INCREMENT, title varchar(255), content varchar(255) NOT NULL, posted_at timestamp NULL, PRIMARY KEY (id));
CREATE TABLE calendar_events (id int(10) NOT NULL AUTO_INCREMENT, title varchar(255), description varchar(255), event_date date, PRIMARY KEY (id));
CREATE TABLE family_info (id int(10) NOT NULL AUTO_INCREMENT, mother_name varchar(50), father_name varchar(50), mother_mobile_number varchar(50), father_mobile_number varchar(50), mother_email varchar(50), father_email varchar(100), other_contact_name varchar(100), other_contact_mobilenum varchar(50), other_contact_email varchar(100), PRIMARY KEY (id));
CREATE TABLE medical_history (id int(10) NOT NULL AUTO_INCREMENT, comorb varchar(255), allergies varchar(255), PRIMARY KEY (id));
CREATE TABLE students_class (id int(10) NOT NULL AUTO_INCREMENT, student_id int(10) NOT NULL, subject_id int(10) NOT NULL, section_id int(10) NOT NULL, term int(10) NOT NULL, school_year varchar(20) NOT NULL, PRIMARY KEY (id));
CREATE TABLE student_schedule (id int(10) NOT NULL AUTO_INCREMENT, scheduleid int(10) NOT NULL, studentid int(10) NOT NULL, PRIMARY KEY (id));
CREATE TABLE program (id int(10) NOT NULL AUTO_INCREMENT, program_name varchar(100) NOT NULL, course_code varchar(50) NOT NULL, PRIMARY KEY (id));
CREATE TABLE curriculum (programid int(10) NOT NULL, subjectid int(10) NOT NULL, year_level int(10) DEFAULT 1, term_number int(10) DEFAULT 1, PRIMARY KEY (programid, subjectid));
ALTER TABLE schedules ADD CONSTRAINT FKschedules755966 FOREIGN KEY (subject_id) REFERENCES subjects (id);
ALTER TABLE schedules ADD CONSTRAINT FKschedules426559 FOREIGN KEY (section_id) REFERENCES sections (id);
ALTER TABLE students ADD CONSTRAINT FKstudents848833 FOREIGN KEY (family_info_id) REFERENCES family_info (id);
ALTER TABLE students ADD CONSTRAINT FKstudents807765 FOREIGN KEY (medical_historyid) REFERENCES medical_history (id);
ALTER TABLE students_class ADD CONSTRAINT FKstudents_c543496 FOREIGN KEY (student_id) REFERENCES students (id);
ALTER TABLE students_class ADD CONSTRAINT FKstudents_c321277 FOREIGN KEY (subject_id) REFERENCES subjects (id);
ALTER TABLE students_class ADD CONSTRAINT FKstudents_c991869 FOREIGN KEY (section_id) REFERENCES sections (id);
ALTER TABLE grades ADD CONSTRAINT FKgrades55145 FOREIGN KEY (students_class_id) REFERENCES students_class (id);
ALTER TABLE student_schedule ADD CONSTRAINT FKstudent_sc483723 FOREIGN KEY (scheduleid) REFERENCES schedules (id);
ALTER TABLE student_schedule ADD CONSTRAINT FKstudent_sc662748 FOREIGN KEY (studentid) REFERENCES students (id);
ALTER TABLE students ADD CONSTRAINT FKstudents245356 FOREIGN KEY (program_id) REFERENCES program (id);
ALTER TABLE curriculum ADD CONSTRAINT FKcurriculum233065 FOREIGN KEY (programid) REFERENCES program (id);
ALTER TABLE curriculum ADD CONSTRAINT FKcurriculum121471 FOREIGN KEY (subjectid) REFERENCES subjects (id);
