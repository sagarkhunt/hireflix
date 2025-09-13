# MySQL Database Setup Guide for HireFlix

## Step-by-Step Instructions for MySQL Workbench

### 1. Open MySQL Workbench

-   Launch MySQL Workbench
-   Connect to your MySQL server (usually localhost:3306)

### 2. Create the Database

1. In MySQL Workbench, click on the "Query" tab or press `Ctrl+Shift+Q`
2. Copy and paste the entire content from `database_setup.sql` file
3. Click the "Execute" button (lightning bolt icon) or press `Ctrl+Shift+Enter`

### 3. Verify the Setup

After running the script, you should see:

-   Database `hire_flix` created
-   5 tables created: `users`, `interviews`, `questions`, `submissions`, `password_reset_tokens`, `failed_jobs`, `personal_access_tokens`
-   Test data inserted (5 users, 2 interviews, 16 questions)

### 4. Test the Connection

Run this query to verify everything is working:

```sql
USE hire_flix;
SELECT
    'Users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT
    'Interviews' as table_name, COUNT(*) as count FROM interviews
UNION ALL
SELECT
    'Questions' as table_name, COUNT(*) as count FROM questions;
```

Expected results:

-   Users: 5
-   Interviews: 2
-   Questions: 16

### 5. Update Laravel Configuration

The `.env` file is already configured for MySQL:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hire_flix
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Test the Laravel Application

1. Run: `php artisan migrate:status` (should show all migrations as "Ran")
2. Run: `php artisan serve`
3. Open: http://127.0.0.1:8000
4. Login with test accounts:
    - Admin: admin@hireflix.com / password
    - Reviewer: reviewer@hireflix.com / password
    - Candidate: candidate@hireflix.com / password

## Database Schema Overview

### Tables Created:

1. **users** - User accounts with roles (admin, reviewer, candidate)
2. **interviews** - Interview sessions created by admins/reviewers
3. **questions** - Questions within each interview
4. **submissions** - Candidate video submissions and reviewer scores
5. **password_reset_tokens** - Password reset functionality
6. **failed_jobs** - Queue job failures
7. **personal_access_tokens** - API authentication

### Test Data Included:

-   5 test users (1 admin, 1 reviewer, 3 candidates)
-   2 sample interviews (Software Developer, Marketing Manager)
-   16 sample questions (8 per interview)

## Troubleshooting

### If you get connection errors:

1. Check MySQL service is running
2. Verify username/password in `.env` file
3. Ensure database `hire_flix` exists
4. Run `php artisan config:clear`

### If you get permission errors:

1. Make sure your MySQL user has CREATE, INSERT, UPDATE, DELETE privileges
2. Check if the database exists and is accessible

### If you get foreign key errors:

1. Make sure to run the entire script in order
2. Check that all tables were created successfully
3. Verify the foreign key constraints are properly set

## Next Steps

Once the database is set up, you can:

1. Start using the application
2. Create new interviews as admin/reviewer
3. Submit video answers as candidate
4. Review and score submissions as reviewer
