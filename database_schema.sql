-- ====================================================================
-- Centralized Job Placement and Management System - Database Schema
-- ====================================================================

-- Enum Definitions
CREATE TYPE user_role AS ENUM ('student', 'employer', 'admin');
CREATE TYPE verification_status_enum AS ENUM ('pending', 'verified', 'rejected');
CREATE TYPE pipeline_enum AS ENUM ('academic', 'direct-hire');
CREATE TYPE approval_enum AS ENUM ('pending', 'approved', 'rejected');
CREATE TYPE job_status_enum AS ENUM ('open', 'closed');
CREATE TYPE tracking_status_enum AS ENUM ('pending', 'interviewing', 'offered', 'accepted', 'rejected');
CREATE TYPE doc_type_enum AS ENUM ('resume', 'offer_letter');
CREATE TYPE action_enum AS ENUM ('CREATE', 'READ', 'UPDATE', 'DELETE', 'DOWNLOAD');

-- 1. USER Table
CREATE TABLE users (
    user_id BIGSERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role user_role NOT NULL,
    is_first_login BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. STUDENT Table
CREATE TABLE students (
    student_id BIGSERIAL PRIMARY KEY,
    user_id BIGINT UNIQUE NOT NULL,
    matric_number VARCHAR(100) UNIQUE NOT NULL,
    degree_program VARCHAR(255) NOT NULL,
    CONSTRAINT fk_student_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 3. EMPLOYER Table
CREATE TABLE employers (
    employer_id BIGSERIAL PRIMARY KEY,
    user_id BIGINT UNIQUE NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    registration_number VARCHAR(100) UNIQUE NOT NULL,
    verification_status verification_status_enum NOT NULL DEFAULT 'pending',
    CONSTRAINT fk_employer_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 4. ADMINISTRATOR Table
CREATE TABLE administrators (
    admin_id BIGSERIAL PRIMARY KEY,
    user_id BIGINT UNIQUE NOT NULL,
    staff_id VARCHAR(100) UNIQUE NOT NULL,
    faculty_department VARCHAR(255) NOT NULL,
    CONSTRAINT fk_admin_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 5. JOBS Table
CREATE TABLE jobs (
    job_id BIGSERIAL PRIMARY KEY,
    employer_id BIGINT NOT NULL,
    title VARCHAR(255) NOT NULL,
    technical_requirements TEXT,
    pipeline_type pipeline_enum NOT NULL,
    admin_approval approval_enum NOT NULL DEFAULT 'pending',
    status job_status_enum NOT NULL DEFAULT 'open',
    open_date DATE,
    close_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_jobs_employer FOREIGN KEY (employer_id) REFERENCES employers(employer_id) ON DELETE CASCADE
);

-- 6. APPLICATIONS Table
CREATE TABLE applications (
    application_id BIGSERIAL PRIMARY KEY,
    job_id BIGINT NOT NULL,
    student_id BIGINT NOT NULL,
    match_score DECIMAL(5,2),
    skill_gap_report JSONB,
    tracking_status tracking_status_enum NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_app_job FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE,
    CONSTRAINT fk_app_student FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- 7. DOCUMENT Table
CREATE TABLE documents (
    document_id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    application_id BIGINT,
    document_type doc_type_enum NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    parsed_data JSONB,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_doc_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT fk_doc_app FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE SET NULL
);

-- 8. SECURITY_LOG Table
CREATE TABLE security_logs (
    log_id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    action_type action_enum NOT NULL,
    target_entity VARCHAR(255) NOT NULL,
    target_id BIGINT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 9. SYSTEM_SETTING Table
CREATE TABLE system_settings (
    setting_key VARCHAR(255) PRIMARY KEY,
    setting_value VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
