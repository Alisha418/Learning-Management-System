# 🎓 Role-Based Learning Management System (LMS)
> A centralized education portal for seamless interaction between Admin, Teachers, and Students.

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)

---

### 🔑 User Roles & Functionalities

| Feature | Admin | Teacher | Student |
| :--- | :---: | :---: | :---: |
| **User Management** | ✅ | ❌ | ❌ |
| **Course Creation** | ✅ | ✅ | ❌ |
| **Content Upload** | ❌ | ✅ | ❌ |
| **Subject Registration**| ❌ | ❌ | ✅ |
| **Attempt Quizzes** | ❌ | ❌ | ✅ |
| **Performance Tracking**| ✅ | ✅ | ✅ |

---

### 🌟 Core Modules

#### 👨‍🎓 Student Portal
* **Subject Registration:** Self-enrollment in available courses.
* **Learning Dashboard:** Access to current courses and materials.
* **Assessment Engine:** Integrated quiz functionality with instant evaluation.
* **Performance Analytics:** Track grades and learning progress.

#### 👨‍🏫 Teacher Portal
* **Course Management:** Upload and organize study materials.
* **Quiz Management:** Create and update assessments for students.
* **Student Monitoring:** Review student performances.

#### 🛠️ Admin Panel
* **Master Control:** Manage all user accounts (Students/Teachers).
* **System Logs:** Ensure smooth interaction between different roles.

---

### 🚀 Technical Setup

1. **Database Configuration:**
   -  Open **phpMyAdmin**
   -  Create a new database named `edusphere2`.
   - Import the `edusphere2.sql` file into your MySQL (XAMPP/WAMP).
   - Update `config.php` with your local DB credentials.

2. **Deployment:**
   ```bash
   # Move files to htdocs
   git clone [https://github.com/Alisha418/LMS.git](https://github.com/Alisha418/LMS.git)