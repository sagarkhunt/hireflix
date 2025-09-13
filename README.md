# HireFlix - Interview Management System

A comprehensive Laravel-based interview management system that allows admins and reviewers to create interviews with questions, and candidates to record and upload video answers for review.

**GitHub Repository:** [https://github.com/sagarkhunt/hireflix.git](https://github.com/sagarkhunt/hireflix.git)

## 🎯 **Complete System Flow & Implementation**

### **1. User Registration & Authentication Flow**

```
User Registration → Role Selection → Email Verification → Login → Role-based Dashboard
```

-   **Sign up** with name, email, password, and role selection (Admin/Reviewer/Candidate)
-   **Sign in** with email and password
-   **Role-based redirect:** Admin/Reviewer → Interview Management, Candidate → Available Interviews
-   **Secure session management** with Laravel authentication

### **2. Admin/Reviewer Complete Workflow**

```
Login → Create Interview → Add Questions → Activate Interview → View Submissions → Score & Review
```

-   **Create Interviews:** Add title, description, and multiple questions with ordering
-   **Manage Questions:** Add/edit/delete questions with proper sequencing
-   **Interview Control:** Activate/deactivate interviews to control candidate visibility
-   **View All Submissions:** See all candidate video submissions across all interviews
-   **Score & Review:** Provide scores (0-100) and detailed feedback comments
-   **Track Statistics:** Monitor submission rates, completion status, and performance metrics

### **3. Candidate Complete Workflow**

```
Login → Browse Interviews → Start Interview → Upload Videos → Add Notes → Track Progress → View Feedback
```

-   **Browse Available Interviews:** View only active interviews with descriptions
-   **Start Interview Process:** Access questions one by one in sequence
-   **Upload Video Answers:** Record and upload video responses for each question
-   **Add Text Notes:** Include optional written explanations or context
-   **Track Progress:** See completion status and remaining questions
-   **View Feedback:** Read reviewer scores and comments after submission

### **4. Complete Technical Implementation**

#### **Database Architecture (MySQL)**

-   **users** table with role-based authentication (admin, reviewer, candidate)
-   **interviews** table with creator tracking and active status
-   **questions** table with ordering and interview relationships
-   **submissions** table with video paths, scores, and reviewer tracking
-   **Proper foreign key constraints** and relationships

#### **File Upload System**

-   **Video Upload:** Support for MP4, AVI, MOV, WMV formats
-   **File Size Limit:** 100MB maximum per video
-   **Storage Location:** `storage/app/public/submissions/`
-   **Public Access:** Videos accessible for reviewer playback

#### **Frontend Implementation**

-   **Bootstrap 5** responsive design
-   **Custom CSS** styling for modern UI
-   **Vite** asset compilation and management
-   **Role-based navigation** and access control

## 🚀 **Setup Instructions**

### **Prerequisites**

-   PHP 8.1 or higher
-   Composer
-   Node.js and NPM
-   MySQL database

### **Installation Steps**

1. **Clone and Setup**

    ```bash
    git clone https://github.com/sagarkhunt/hireflix.git
    cd hireflix
    composer install
    npm install
    ```

2. **Environment Configuration**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. **Database Setup (MySQL)**

    ```bash
    # Configure .env for MySQL
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hire_flix
    DB_USERNAME=root
    DB_PASSWORD=

    # Run migrations and seed data
    php artisan migrate --seed
    ```

4. **Frontend Assets**

    ```bash
    npm run build
    ```

5. **Start Application**
    ```bash
    php artisan serve
    # Access: http://127.0.0.1:8000
    ```

## 👥 **Test Account Credentials**

### **Admin Account**

-   **Email:** admin@hireflix.com
-   **Password:** password
-   **Access:** Full system control, create/edit interviews, review all submissions

### **Reviewer Account**

-   **Email:** reviewer@hireflix.com
-   **Password:** password
-   **Access:** Create interviews, review submissions, score candidates

### **Candidate Accounts**

-   **Email:** candidate@hireflix.com
-   **Password:** password
-   **Email:** john@example.com
-   **Password:** password
-   **Email:** jane@example.com
-   **Password:** password

## 📋 **Complete Usage Guide**

### **For Admins/Reviewers**

1. **Login** → Redirected to Interview Management Dashboard
2. **Create Interview:**
    - Click "Create New Interview"
    - Enter title and description
    - Add multiple questions (minimum 1 required)
    - Set interview as active for candidate visibility
3. **Review Submissions:**
    - Navigate to "Submissions" to see all candidate submissions
    - Click "Review" to watch videos and score answers
    - Provide scores (0-100) and detailed feedback comments
4. **Manage Interviews:**
    - Edit interview details or deactivate interviews
    - View submission statistics and progress tracking

### **For Candidates**

1. **Login** → Redirected to Available Interviews Dashboard
2. **Browse Interviews:**
    - See all active interviews with descriptions
    - Click "Start Interview" to begin the process
3. **Submit Answers:**
    - Record or upload video answers for each question
    - Add optional text notes for additional context
    - Submit answers one by one as you complete them
4. **Track Progress:**
    - See completion status for each question
    - View scores and feedback from reviewers
    - Monitor overall interview progress

### **Authentication Routes**

-   `GET /login` - Show login form
-   `POST /login` - Process login
-   `GET /register` - Show registration form
-   `POST /register` - Process registration
-   `POST /logout` - Logout user
-   `GET /dashboard` - Role-based dashboard redirect

### **Interview Management (Admin/Reviewer)**

-   `GET /interviews` - List all interviews
-   `GET /interviews/create` - Show create form
-   `POST /interviews` - Store new interview
-   `GET /interviews/{id}` - Show interview details
-   `GET /interviews/{id}/edit` - Show edit form
-   `PUT /interviews/{id}` - Update interview
-   `DELETE /interviews/{id}` - Delete interview
-   `GET /interviews/{id}/submissions` - View interview submissions

### **Submission Management**

-   `GET /submissions` - List all submissions (Admin/Reviewer)
-   `GET /submissions/{id}` - Show submission details
-   `PUT /submissions/{id}` - Update submission (score/comments)
-   `POST /submissions` - Store new submission (Candidate)

### **Candidate Routes**

-   `GET /candidate/interviews` - List available interviews
-   `GET /candidate/interviews/{id}` - Show interview for candidate

## ⚙️ **Technical Implementation Details**

### **Database Schema**

-   **MySQL** with proper foreign key relationships
-   **Role-based user system** with enum constraints
-   **Cascade deletes** for data integrity
-   **Indexed columns** for performance

### **File Upload System**

-   **Video file validation** (MP4, AVI, MOV, WMV)
-   **File size limits** (100MB maximum)
-   **Secure file storage** in Laravel storage
-   **Public access** for video playback

### **Security Features**

-   **CSRF protection** on all forms
-   **Role-based middleware** for route protection
-   **File upload validation** and sanitization
-   **SQL injection protection** with Eloquent ORM

### **UI/UX Features**

-   **Responsive design** with Bootstrap 5
-   **Custom CSS** styling for modern appearance
-   **Progress tracking** for candidates
-   **Statistics dashboard** for reviewers
-   **Error handling** with user-friendly messages

## 📊 **Sample Data Included**

-   **5 Test Users:** 1 Admin, 1 Reviewer, 3 Candidates
-   **2 Sample Interviews:** Software Developer & Marketing Manager
-   **16 Sample Questions:** 8 questions per interview
-   **Complete Database Structure:** All tables with proper relationships

## 🚨 **Known Limitations**

1. **File Upload Size:** Video files limited to 100MB maximum
2. **Video Formats:** Only MP4, AVI, MOV, WMV formats supported
3. **Email Verification:** Not implemented (can be added)
4. **Video Processing:** No compression or optimization
5. **Real-time Updates:** No live notifications
6. **Bulk Operations:** No bulk scoring features
7. **Mobile Recording:** Requires file upload (no built-in recorder)

## 🛠️ **Development Notes**

-   **Laravel 10** with modern PHP practices
-   **MySQL** database with proper relationships
-   **Vite** for frontend asset compilation
-   **Bootstrap 5** for responsive UI
-   **File uploads** stored in `storage/app/public/submissions/`
-   **Role-based access** enforced through middleware
-   **Custom CSS** for enhanced styling

## 🎉 **Ready to Use!**

The application is **fully functional** with:

-   ✅ Complete authentication system
-   ✅ Role-based access control
-   ✅ Interview creation and management
-   ✅ Video submission and review system
-   ✅ Scoring and feedback functionality
-   ✅ Responsive UI with modern design
-   ✅ MySQL database with sample data

**Start the application and begin using it immediately!**
