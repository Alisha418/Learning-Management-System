-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Apr 25, 2025 at 08:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edusphere2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'admin2', 'admin2'),
(3, 'rabbia', '123'),
(4, 'rabbia', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `ArticleId` int(11) NOT NULL,
  `ArticleTitle` varchar(255) NOT NULL,
  `Content` varchar(400) NOT NULL,
  `Image` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`ArticleId`, `ArticleTitle`, `Content`, `Image`) VALUES
(1, 'teacher enhancement', 'we are making a teacher enhancement cell', 'https://res.cloudinary.com/dp9mrfhm7/image/upload/v1745065803/articles/jzdyoipua266ortzzquv.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceId` int(11) NOT NULL,
  `Enroll_Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Status` enum('present','absent','leave') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepId` int(11) NOT NULL,
  `DepName` varchar(255) NOT NULL,
  `DepCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepId`, `DepName`, `DepCode`) VALUES
(1, 'Computer Science', 'CS');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `QuizId` int(11) NOT NULL,
  `Offer_Id` int(11) NOT NULL,
  `QuizTitle` varchar(255) NOT NULL,
  `TotalMarks` int(11) NOT NULL,
  `TimeLimit` int(11) NOT NULL DEFAULT 30,
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizanswers`
--

CREATE TABLE `quizanswers` (
  `AnswerId` int(11) NOT NULL,
  `Attempt_Id` int(11) NOT NULL,
  `Ques_Id` int(11) NOT NULL,
  `SelectedOption` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizattempt`
--

CREATE TABLE `quizattempt` (
  `AttemptId` int(11) NOT NULL,
  `Stu_Id` int(11) NOT NULL,
  `Quiz_Id` int(11) NOT NULL,
  `StartTime` datetime NOT NULL DEFAULT current_timestamp(),
  `EndTime` datetime NOT NULL,
  `Score` decimal(5,2) NOT NULL,
  `TotalCorrect` int(11) NOT NULL,
  `TotalWrong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizquestions`
--

CREATE TABLE `quizquestions` (
  `QuesId` int(11) NOT NULL,
  `Quiz_Id` int(11) NOT NULL,
  `QuestionText` text NOT NULL,
  `OptionA` varchar(255) NOT NULL,
  `OptionB` varchar(255) NOT NULL,
  `OptionC` varchar(255) NOT NULL,
  `OptionD` varchar(255) NOT NULL,
  `CorrectOption` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `SectionId` int(11) NOT NULL,
  `SectionName` varchar(255) NOT NULL,
  `Dep_Id` int(11) NOT NULL,
  `Session_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`SectionId`, `SectionName`, `Dep_Id`, `Session_Id`) VALUES
(1, 'A', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `SemId` int(11) NOT NULL,
  `SemName` varchar(255) NOT NULL,
  `StartDate` varchar(10) NOT NULL,
  `EndDate` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`SemId`, `SemName`, `StartDate`, `EndDate`) VALUES
(1, '8th', '2024-02-19', '2025-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `SessionId` int(11) NOT NULL,
  `SessionName` varchar(255) NOT NULL,
  `StartDate` varchar(10) NOT NULL,
  `EndDate` varchar(10) NOT NULL,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`SessionId`, `SessionName`, `StartDate`, `EndDate`, `Status`) VALUES
(1, 'Fall 2023', '2023-06-09', '2025-04-09', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StuId` int(11) NOT NULL,
  `StuName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `StuGender` varchar(10) NOT NULL,
  `StuAddress` varchar(255) NOT NULL,
  `StuPhone` varchar(255) NOT NULL,
  `StuEmail` varchar(255) NOT NULL,
  `SectionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StuId`, `StuName`, `password`, `StuGender`, `StuAddress`, `StuPhone`, `StuEmail`, `SectionId`) VALUES
(4, 'Rabbia', '123', '', 'lahore', '03099341290', 'rabbia@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `studentenroll`
--

CREATE TABLE `studentenroll` (
  `EnrollId` int(11) NOT NULL,
  `Offer_Id` int(11) NOT NULL,
  `Stu_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubId` int(11) NOT NULL,
  `SubName` varchar(255) NOT NULL,
  `CreditHors` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubId`, `SubName`, `CreditHors`) VALUES
(1, 'data science', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subjectoffer`
--

CREATE TABLE `subjectoffer` (
  `OfferId` int(11) NOT NULL,
  `Sub_Id` int(11) NOT NULL,
  `Section_Id` int(11) NOT NULL,
  `T_Id` int(11) NOT NULL,
  `Sem_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjectoffer`
--

INSERT INTO `subjectoffer` (`OfferId`, `Sub_Id`, `Section_Id`, `T_Id`, `Sem_Id`) VALUES
(1, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `surveyanswers`
--

CREATE TABLE `surveyanswers` (
  `SurveyAnswerId` int(11) NOT NULL,
  `Submit_Id` int(11) NOT NULL,
  `Ques_Id` int(11) NOT NULL,
  `Option_Id` int(11) NOT NULL,
  `Stu_Id` int(11) NOT NULL,
  `Sub_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveyoptions`
--

CREATE TABLE `surveyoptions` (
  `OptionId` int(11) NOT NULL,
  `OptionText` varchar(255) NOT NULL,
  `Ques_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surveyoptions`
--

INSERT INTO `surveyoptions` (`OptionId`, `OptionText`, `Ques_Id`) VALUES
(1, 'maths', 1),
(2, 'computer', 1),
(3, 'statistics', 1),
(4, 'machine learning', 1),
(5, 'rotation', 2),
(6, 'shifting', 2),
(7, 'dragging', 2),
(8, 'dropping', 2),
(9, 'step', 3),
(10, 'code', 3),
(11, 'instructs', 3),
(12, 'none', 3);

-- --------------------------------------------------------

--
-- Table structure for table `surveyquestions`
--

CREATE TABLE `surveyquestions` (
  `QuesId` int(11) NOT NULL,
  `Sub_Id` int(11) NOT NULL,
  `QuesText` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surveyquestions`
--

INSERT INTO `surveyquestions` (`QuesId`, `Sub_Id`, `QuesText`) VALUES
(1, 1, 'What is data science'),
(2, 1, 'what is linear transformation'),
(3, 1, 'what is algorithm');

-- --------------------------------------------------------

--
-- Table structure for table `surveysubmit`
--

CREATE TABLE `surveysubmit` (
  `SurveySubmitId` int(11) NOT NULL,
  `Stu_Id` int(11) NOT NULL,
  `Sub_Id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Comment` text NOT NULL,
  `SubmitDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacherId` int(11) NOT NULL,
  `TName` varchar(255) NOT NULL,
  `TPass` varchar(255) NOT NULL,
  `TGender` varchar(10) NOT NULL,
  `TAddress` varchar(255) NOT NULL,
  `TQualification` varchar(255) NOT NULL,
  `TMarried` varchar(5) NOT NULL,
  `TPhone` varchar(255) NOT NULL,
  `TSalary` int(11) NOT NULL,
  `TEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacherId`, `TName`, `TPass`, `TGender`, `TAddress`, `TQualification`, `TMarried`, `TPhone`, `TSalary`, `TEmail`) VALUES
(2, 'Rabbia Batool', 'A1B2C3D4E5F6G', 'Female', 'siddique road dilkushana street no 7 naqi louge house 4/44 multan', 'Bachelor', 'Yes', '9617856789', 5005, 'rabbiabatool575@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `Id` int(11) NOT NULL,
  `Day` varchar(255) NOT NULL,
  `TimeSlot` varchar(15) NOT NULL,
  `Offer_Id` int(11) NOT NULL,
  `RoomNo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`Id`, `Day`, `TimeSlot`, `Offer_Id`, `RoomNo`) VALUES
(1, 'Wednesday', '9:00-10:00', 1, 'G-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ArticleId`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceId`),
  ADD KEY `attend1` (`Enroll_Id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepId`),
  ADD UNIQUE KEY `DepName` (`DepName`),
  ADD UNIQUE KEY `DepCode` (`DepCode`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`QuizId`),
  ADD KEY `quiz1` (`Offer_Id`);

--
-- Indexes for table `quizanswers`
--
ALTER TABLE `quizanswers`
  ADD PRIMARY KEY (`AnswerId`),
  ADD KEY `quizanswer1` (`Attempt_Id`),
  ADD KEY `quizanswer2` (`Ques_Id`);

--
-- Indexes for table `quizattempt`
--
ALTER TABLE `quizattempt`
  ADD PRIMARY KEY (`AttemptId`),
  ADD KEY `quizAttempt1` (`Stu_Id`),
  ADD KEY `quizattempt2` (`Quiz_Id`);

--
-- Indexes for table `quizquestions`
--
ALTER TABLE `quizquestions`
  ADD PRIMARY KEY (`QuesId`),
  ADD KEY `QuizQues1` (`Quiz_Id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`SectionId`),
  ADD UNIQUE KEY `SectionName` (`SectionName`),
  ADD KEY `Section1` (`Dep_Id`),
  ADD KEY `Section2` (`Session_Id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`SemId`),
  ADD UNIQUE KEY `SemName` (`SemName`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`SessionId`),
  ADD UNIQUE KEY `SessionName` (`SessionName`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StuId`),
  ADD UNIQUE KEY `password` (`password`),
  ADD KEY `Section` (`SectionId`);

--
-- Indexes for table `studentenroll`
--
ALTER TABLE `studentenroll`
  ADD PRIMARY KEY (`EnrollId`),
  ADD UNIQUE KEY `Offer_Id` (`Offer_Id`,`Stu_Id`),
  ADD KEY `Enroll1` (`Offer_Id`),
  ADD KEY `Enroll2` (`Stu_Id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubId`),
  ADD UNIQUE KEY `SubName` (`SubName`);

--
-- Indexes for table `subjectoffer`
--
ALTER TABLE `subjectoffer`
  ADD PRIMARY KEY (`OfferId`),
  ADD KEY `Offer1` (`Section_Id`),
  ADD KEY `Offer2` (`Sem_Id`),
  ADD KEY `Offer3` (`Sub_Id`),
  ADD KEY `Offer4` (`T_Id`);

--
-- Indexes for table `surveyanswers`
--
ALTER TABLE `surveyanswers`
  ADD PRIMARY KEY (`SurveyAnswerId`),
  ADD UNIQUE KEY `unique_survey` (`Stu_Id`,`Sub_Id`),
  ADD KEY `submit` (`Submit_Id`),
  ADD KEY `survay` (`Ques_Id`),
  ADD KEY `option` (`Option_Id`),
  ADD KEY `subjects` (`Sub_Id`);

--
-- Indexes for table `surveyoptions`
--
ALTER TABLE `surveyoptions`
  ADD PRIMARY KEY (`OptionId`),
  ADD KEY `Option1` (`Ques_Id`);

--
-- Indexes for table `surveyquestions`
--
ALTER TABLE `surveyquestions`
  ADD PRIMARY KEY (`QuesId`),
  ADD KEY `QuestionConstraint` (`Sub_Id`);

--
-- Indexes for table `surveysubmit`
--
ALTER TABLE `surveysubmit`
  ADD PRIMARY KEY (`SurveySubmitId`),
  ADD KEY `survey1` (`Stu_Id`),
  ADD KEY `survey2` (`Sub_Id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacherId`),
  ADD UNIQUE KEY `TPass` (`TPass`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `ArticleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DepId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizanswers`
--
ALTER TABLE `quizanswers`
  MODIFY `AnswerId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizattempt`
--
ALTER TABLE `quizattempt`
  MODIFY `AttemptId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizquestions`
--
ALTER TABLE `quizquestions`
  MODIFY `QuesId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `SectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `SemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `SessionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `studentenroll`
--
ALTER TABLE `studentenroll`
  MODIFY `EnrollId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `SubId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjectoffer`
--
ALTER TABLE `subjectoffer`
  MODIFY `OfferId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surveyanswers`
--
ALTER TABLE `surveyanswers`
  MODIFY `SurveyAnswerId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surveyoptions`
--
ALTER TABLE `surveyoptions`
  MODIFY `OptionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `surveyquestions`
--
ALTER TABLE `surveyquestions`
  MODIFY `QuesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surveysubmit`
--
ALTER TABLE `surveysubmit`
  MODIFY `SurveySubmitId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacherId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attend1` FOREIGN KEY (`Enroll_Id`) REFERENCES `studentenroll` (`EnrollId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz1` FOREIGN KEY (`Offer_Id`) REFERENCES `subjectoffer` (`OfferId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizanswers`
--
ALTER TABLE `quizanswers`
  ADD CONSTRAINT `quizanswer1` FOREIGN KEY (`Attempt_Id`) REFERENCES `quizattempt` (`AttemptId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quizanswer2` FOREIGN KEY (`Ques_Id`) REFERENCES `quizquestions` (`QuesId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizattempt`
--
ALTER TABLE `quizattempt`
  ADD CONSTRAINT `quizAttempt1` FOREIGN KEY (`Stu_Id`) REFERENCES `student` (`StuId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quizattempt2` FOREIGN KEY (`Quiz_Id`) REFERENCES `quiz` (`QuizId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizquestions`
--
ALTER TABLE `quizquestions`
  ADD CONSTRAINT `QuizQues1` FOREIGN KEY (`Quiz_Id`) REFERENCES `quiz` (`QuizId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `Section1` FOREIGN KEY (`Dep_Id`) REFERENCES `department` (`DepId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Section2` FOREIGN KEY (`Session_Id`) REFERENCES `session` (`SessionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `Section` FOREIGN KEY (`SectionId`) REFERENCES `section` (`SectionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studentenroll`
--
ALTER TABLE `studentenroll`
  ADD CONSTRAINT `Enroll1` FOREIGN KEY (`Offer_Id`) REFERENCES `subjectoffer` (`OfferId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Enroll2` FOREIGN KEY (`Stu_Id`) REFERENCES `student` (`StuId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjectoffer`
--
ALTER TABLE `subjectoffer`
  ADD CONSTRAINT `Offer1` FOREIGN KEY (`Section_Id`) REFERENCES `section` (`SectionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Offer2` FOREIGN KEY (`Sem_Id`) REFERENCES `semester` (`SemId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Offer3` FOREIGN KEY (`Sub_Id`) REFERENCES `subject` (`SubId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Offer4` FOREIGN KEY (`T_Id`) REFERENCES `teacher` (`TeacherId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surveyanswers`
--
ALTER TABLE `surveyanswers`
  ADD CONSTRAINT `option` FOREIGN KEY (`Option_Id`) REFERENCES `surveyoptions` (`OptionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studnts` FOREIGN KEY (`Stu_Id`) REFERENCES `student` (`StuId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects` FOREIGN KEY (`Sub_Id`) REFERENCES `subject` (`SubId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `submit` FOREIGN KEY (`Submit_Id`) REFERENCES `surveysubmit` (`SurveySubmitId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survay` FOREIGN KEY (`Ques_Id`) REFERENCES `surveyquestions` (`QuesId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surveyoptions`
--
ALTER TABLE `surveyoptions`
  ADD CONSTRAINT `Option1` FOREIGN KEY (`Ques_Id`) REFERENCES `surveyquestions` (`QuesId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surveyquestions`
--
ALTER TABLE `surveyquestions`
  ADD CONSTRAINT `QuestionConstraint` FOREIGN KEY (`Sub_Id`) REFERENCES `subject` (`SubId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surveysubmit`
--
ALTER TABLE `surveysubmit`
  ADD CONSTRAINT `survey1` FOREIGN KEY (`Stu_Id`) REFERENCES `student` (`StuId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey2` FOREIGN KEY (`Sub_Id`) REFERENCES `subject` (`SubId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
