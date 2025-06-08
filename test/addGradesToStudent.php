<?php

/*
grades:
id: int(11) primary key auto_increment
student_class_id: int(11) foreign key
grade: decimal(4,2)
*/

/*
the purpose of this file is to add grades to a student.
the student_class_id will be used to identify the student and the class they are enrolled in.
it will also be used to identify the term and school year for the grade.
the grade will be a decimal value with 2 decimal places. e.g (1.00, 2.50, 3.75, etc.)
it will be used to display the grades for a student in a specific term and school year.
*/

/*
 to add a grade to a student, the following fields are required:
 we need to get all the students from the database, and then we need to get all the student classes from the database.
 we will need to filter out selected students. so that it will only show the student that is selected.
*/
?>