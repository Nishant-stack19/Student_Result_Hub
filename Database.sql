CREATE Database student_result_manage_db;

CREATE TABLE `add_student_details` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each student record
  `name` VARCHAR(255) NOT NULL,  -- Student's Name
  `roll_number` VARCHAR(255) NOT NULL,  -- Student Roll Number
  `mother_name` VARCHAR(255) NOT NULL,  -- Mother's Name
  `subjects` VARCHAR(255) NOT NULL,  -- Subjects (Comma-separated list)
  `marks` INT NOT NULL,  -- Marks obtained
  `total_marks` INT NOT NULL,  -- Total Marks
  `percentage` FLOAT NOT NULL,  -- Percentage
  `student_id` INT NOT NULL,  -- References `students_result` table
  FOREIGN KEY (`student_id`) REFERENCES `students_result` (`id`) -- Links to results table
);

CREATE TABLE `admin_db` (
  `username` VARCHAR(50) PRIMARY KEY,  -- Admin Username
  `password` VARCHAR(50) NOT NULL  -- Admin Password
);

CREATE TABLE `attendance_table` (
  `attendance_id` INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID
  `student_id` INT NOT NULL,  -- Student ID
  `subject_id` INT NOT NULL,  -- Subject ID
  `attendance_date` DATE NOT NULL,  -- Date of attendance
  `status` VARCHAR(10) NOT NULL  -- Status (Present/Absent)
);

CREATE TABLE `certificate` (
  `certificate_id` INT AUTO_INCREMENT PRIMARY KEY,  -- Certificate ID
  `student_id` INT NOT NULL,  -- Student ID
  `course_id` INT NOT NULL,  -- Course ID
  `issue_date` DATE NOT NULL,  -- Date of issue
  `certificate_file_path` VARCHAR(255) NOT NULL,  -- File path of the certificate
  `certificate_number` VARCHAR(50) NOT NULL,  -- Unique certificate number
  `status` ENUM('Issued','Revoked') DEFAULT 'Issued',  -- Status (Issued or Revoked)
  `remarks` TEXT NOT NULL  -- Any additional remarks
);

CREATE TABLE `departments_table` (
  `department_id` INT AUTO_INCREMENT PRIMARY KEY,  -- Unique Department ID
  `department_name` VARCHAR(50) NOT NULL,  -- Name of the Department
  `head_of_department` VARCHAR(50) NOT NULL  -- HOD Name
);

CREATE TABLE `notices` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,  -- Notice ID
  `title` VARCHAR(255) NOT NULL,  -- Notice Title
  `content` TEXT NOT NULL,  -- Notice Content
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Date of Creation
);

CREATE TABLE `students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,  -- Unique Student ID
  `student_name` VARCHAR(100) NOT NULL,  -- Full Name
  `roll_number` VARCHAR(50) UNIQUE NOT NULL,  -- Unique Roll Number
  `course` VARCHAR(100) NOT NULL,  -- Course Name
  `semester` TINYINT NOT NULL,  -- Semester Number
  `email` VARCHAR(100) UNIQUE NOT NULL,  -- Email ID
  `phone` VARCHAR(15) NOT NULL,  -- Contact Number
  `address` TEXT NOT NULL,  -- Address
  `dob` DATE NOT NULL,  -- Date of Birth
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Registration Date
);
