# 📊 DevTrack — MCD & MLD Analysis

## 🎯 Deep Analysis

### Business Requirements Analysis

Before designing the schema, let's analyze what DevTrack needs:

**Key Operations**:
1. Team Leads create projects
2. Team Leads invite developers (by email)
3. Team Leads assign tasks to developers
4. Developers update task status (only their own)
5. View projects with task counts (total & completed)
6. Archive/restore projects
7. Track task deadlines and urgency

**Critical Relationships**:
- Users ↔ Projects (Many-to-Many) — with role differentiation (lead/developer)
- Projects → Tasks (One-to-Many) — tasks belong to projects
- Users → Tasks (One-to-Many) — users are assigned tasks
- Users → Projects (One-to-Many) — users create projects (lead)

**Access Patterns**:
- Get all projects for a user (lead or member)
- Get all tasks for a project
- Get all tasks for a developer
- Get project with member count & task status summary

**Data Integrity Needs**:
- Can't have duplicate user-project pairs
- Deleting a project should handle tasks carefully
- Task must have a project
- Assignee is optional (unassigned tasks allowed)

---

## 📋 MCD (Conceptual Data Model)

### What is MCD?
- **Abstract representation** of data
- **No column types**, no technical details
- **Only entities and relationships**
- Used to **communicate with stakeholders**

### DevTrack MCD Structure

```
┌─────────────────────────────────────────────────────────────┐
│                         ENTITIES                             │
└─────────────────────────────────────────────────────────────┘

┌──────────────┐
│    USER      │
├──────────────┤
│ id           │
│ name         │
│ email        │
│ password     │
│ created_at   │
│ updated_at   │
└──────────────┘

┌──────────────┐
│  PROJECT     │
├──────────────┤
│ id           │
│ title        │
│ description  │
│ deadline     │
│ created_at   │
│ updated_at   │
└──────────────┘

┌──────────────┐
│    TASK      │
├──────────────┤
│ id           │
│ title        │
│ description  │
│ deadline     │
│ status       │
│ priority     │
│ created_at   │
│ updated_at   │
└──────────────┘

┌─────────────────────────────────────────────────────────────┐
│                     RELATIONSHIPS                            │
└─────────────────────────────────────────────────────────────┘

USER ──┐
       ├─── (1,N) ──→ PROJECT (creates as lead)
       │
       ├─── (M,N) ──→ PROJECT (participates as member/developer)
       │
       └─── (1,N) ──→ TASK (assigned to)

PROJECT ──┐
          ├─── (1,N) ──→ TASK (contains)
          │
          └─── (N,M) ──→ USER (has members with role)

TASK ──┐
       ├─── (N,1) ──→ PROJECT (belongs to)
       │
       └─── (N,1) ──→ USER (assigned to, optional)
```

### Key Relationships Explained

**1. USER → PROJECT (1,N)** "creates"
- One user (lead) creates many projects
- Cardinality: 1 user : N projects
- Implementation: `projects.created_by` FK

**2. USER ↔ PROJECT (M,N)** "participates"
- Many users are members of many projects
- Each pair has a role (lead or developer)
- Cardinality: M users : N projects
- Implementation: `project_user` pivot table with `role` column

**3. PROJECT → TASK (1,N)** "contains"
- One project has many tasks
- Cardinality: 1 project : N tasks
- Implementation: `tasks.project_id` FK

**4. TASK → USER (N,1)** "assigned to"
- Many tasks are assigned to one user
- But tasks can be unassigned (optional)
- Cardinality: N tasks : 1 user (nullable)
- Implementation: `tasks.assigned_to` FK, nullable

---

## 🗂️ MLD (Logical Data Model)

### What is MLD?
- **Technical representation** of data
- **Includes column types, constraints, keys**
- **Ready for database implementation**
- Maps to actual database tables

### DevTrack MLD Structure

---

## TABLE DESIGN SPECIFICATIONS

### 1️⃣ TABLE: users

**Purpose**: Store user accounts (Team Leads and Developers)

```sql
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  INDEX idx_email (email),
  INDEX idx_created_at (created_at)
);
```

**Column Explanations**:
- `id` — Unique identifier, auto-increment
- `name` — User's display name
- `email` — Unique email for login (also for inviting members)
- `email_verified_at` — Null until email verified (Breeze feature)
- `password` — Hashed password (Laravel hashes automatically)
- `remember_token` — For "remember me" functionality
- `created_at` — When user registered
- `updated_at` — Last profile update

**Indexes**:
- `email` — Users login by email, searches by email common
- `created_at` — Useful for sorting/filtering users

**No Role Column**: Role lives in `project_user` pivot table (users can be lead in one project, developer in another)

---

### 2️⃣ TABLE: projects

**Purpose**: Store projects with metadata

```sql
CREATE TABLE projects (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  created_by BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  deadline DATETIME NOT NULL,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY fk_projects_created_by (created_by) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_created_by (created_by),
  INDEX idx_deadline (deadline),
  INDEX idx_deleted_at (deleted_at),
  INDEX idx_created_at (created_at)
);
```

**Column Explanations**:
- `id` — Unique project identifier
- `created_by` — FK to users.id (who created this project, the lead)
- `title` — Project name (e.g., "Mobile App Redesign")
- `description` — Project details/goals
- `deadline` — When project is due
- `deleted_at` — Soft delete timestamp (NULL if active, TIMESTAMP if archived)
- `created_at`, `updated_at` — Audit trail

**Foreign Keys**:
- `created_by` → `users.id` with CASCADE
  - If lead user deleted, project deleted
  - (Or set to NULL with SET NULL, depending on business logic)

**Indexes**:
- `created_by` — Find all projects created by a user (dashboard query)
- `deadline` — Filter projects by deadline
- `deleted_at` — Find archived projects (soft delete queries)
- `created_at` — Sort projects chronologically

**Soft Deletes**: `deleted_at` column enables archive feature without losing data

---

### 3️⃣ TABLE: tasks

**Purpose**: Store individual tasks assigned within projects

```sql
CREATE TABLE tasks (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  project_id BIGINT UNSIGNED NOT NULL,
  assigned_to BIGINT UNSIGNED NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  priority ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'medium',
  status ENUM('todo', 'in_progress', 'done') NOT NULL DEFAULT 'todo',
  deadline DATETIME NOT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY fk_tasks_project_id (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY fk_tasks_assigned_to (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_project_id (project_id),
  INDEX idx_assigned_to (assigned_to),
  INDEX idx_status (status),
  INDEX idx_deadline (deadline),
  INDEX idx_priority (priority),
  INDEX idx_project_status (project_id, status),
  INDEX idx_assigned_deadline (assigned_to, deadline)
);
```

**Column Explanations**:
- `id` — Unique task identifier
- `project_id` — FK to projects.id (which project owns this task)
- `assigned_to` — FK to users.id (which developer is assigned, NULL if unassigned)
- `title` — Task name (e.g., "Create login UI")
- `description` — Task details
- `priority` — ENUM: low/medium/high (fixed set of values)
- `status` — ENUM: todo/in_progress/done (task workflow state)
- `deadline` — When task must be completed
- `created_at`, `updated_at` — Audit trail

**Foreign Keys**:
- `project_id` → `projects.id` with CASCADE
  - If project deleted, all tasks deleted
- `assigned_to` → `users.id` with SET NULL (nullable)
  - If developer deleted, task becomes unassigned
  - Not CASCADE because task should survive developer deletion

**Indexes**:
- `project_id` — Find all tasks in a project (very common query)
- `assigned_to` — Find all tasks for a developer
- `status` — Filter tasks by status
- `deadline` — Sort by due date
- `priority` — Filter by urgency
- Composite `(project_id, status)` — Find "in progress" tasks in a project
- Composite `(assigned_to, deadline)` — Developer's overdue tasks

**ENUM vs String**:
- ENUM is more space-efficient
- ENUM enforces only valid values
- ENUM rejects invalid status values at DB level

---

### 4️⃣ TABLE: project_user (Pivot/Junction Table)

**Purpose**: Store many-to-many relationship between users and projects with role information

```sql
CREATE TABLE project_user (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  project_id BIGINT UNSIGNED NOT NULL,
  role ENUM('lead', 'developer') NOT NULL DEFAULT 'developer',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY fk_project_user_user_id (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY fk_project_user_project_id (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  UNIQUE KEY uk_user_project (user_id, project_id),
  INDEX idx_project_id (project_id),
  INDEX idx_user_id (user_id),
  INDEX idx_role (role)
);
```

**Column Explanations**:
- `id` — Primary key of the relationship record
- `user_id` — FK to users.id
- `project_id` — FK to projects.id
- `role` — ENUM: lead/developer (what role does this user have in this project?)
- `created_at`, `updated_at` — When member was added, last updated

**Foreign Keys**:
- Both with CASCADE — if user/project deleted, relationship deleted

**Unique Constraint**:
- `UNIQUE (user_id, project_id)` — prevent duplicate memberships
- Can't add same user twice to same project

**Indexes**:
- `user_id` — Find all projects a user is in
- `project_id` — Find all members of a project
- `role` — Find all leads, or all developers

**Why Separate Role from created_by?**
- `projects.created_by` — FK to users.id (who CREATED the project, the original lead)
- `project_user.role` — stores membership with role
- The creator must also exist in project_user with role='lead'
- This allows full audit trail and flexibility (could change role if needed)

---

## 📊 Complete MLD Diagram (Text Format)

```
┌─────────────────────────────────────────────────────────────────┐
│                           USERS                                 │
├─────────────────────────────────────────────────────────────────┤
│ PK │ id                    BIGINT UNSIGNED AUTO_INCREMENT        │
│    │ name                  VARCHAR(255) NOT NULL                 │
│    │ email                 VARCHAR(255) UNIQUE NOT NULL          │
│    │ email_verified_at     TIMESTAMP NULL                        │
│    │ password              VARCHAR(255) NOT NULL                 │
│    │ remember_token        VARCHAR(100) NULL                     │
│    │ created_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP   │
│    │ updated_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP   │
│    └────────────────────────────────────────────────────────────│
│ Indexes: email, created_at                                       │
└─────────────────────────────────────────────────────────────────┘
                               △ (1)
                               │ (created_by)
                               │ (M)
                               │
┌─────────────────────────────────────────────────────────────────┐
│                         PROJECTS                                │
├─────────────────────────────────────────────────────────────────┤
│ PK │ id                    BIGINT UNSIGNED AUTO_INCREMENT        │
│ FK │ created_by            BIGINT UNSIGNED NOT NULL → users.id   │
│    │ title                 VARCHAR(255) NOT NULL                 │
│    │ description           TEXT NULL                             │
│    │ deadline              DATETIME NOT NULL                     │
│    │ deleted_at            TIMESTAMP NULL (Soft Delete)          │
│    │ created_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP   │
│    │ updated_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP   │
│    └────────────────────────────────────────────────────────────│
│ Indexes: created_by, deadline, deleted_at, created_at           │
│ Constraint: CASCADE DELETE on created_by                         │
└─────────────────────────────────────────────────────────────────┘
                △ (1)              △ (N)
                │ (1)              │ (N)
                │ (N)              │ (1)
                │                  │
     ┌──────────┘                  └──────────┐
     │                                        │
     │         ┌─────────────────────────────────────────────┐
     │         │       PROJECT_USER (Pivot)                  │
     │         ├─────────────────────────────────────────────┤
     │         │ PK │ id          BIGINT AUTO_INCREMENT      │
     │         │ FK │ user_id     BIGINT → users.id (CASCADE)│
     │         │ FK │ project_id  BIGINT → projects.id (CASC)│
     │         │    │ role        ENUM('lead','developer')   │
     │         │    │ created_at  TIMESTAMP                  │
     │         │    │ updated_at  TIMESTAMP                  │
     │         │    └─────────────────────────────────────────│
     │         │ UNIQUE: (user_id, project_id)               │
     │         │ Indexes: user_id, project_id, role          │
     │         └─────────────────────────────────────────────┘
     │                                        │
     └────────────────────────┬───────────────┘
                              │ (M)
                              │ (N)
                              │
                         USERS (repeat)
                              △
                              │ (1)
                              │ (assigned_to)
                              │ (N)
                              │
┌─────────────────────────────────────────────────────────────────┐
│                         TASKS                                   │
├─────────────────────────────────────────────────────────────────┤
│ PK │ id                    BIGINT UNSIGNED AUTO_INCREMENT        │
│ FK │ project_id            BIGINT UNSIGNED NOT NULL → projects   │
│ FK │ assigned_to           BIGINT UNSIGNED NULL → users (opt)    │
│    │ title                 VARCHAR(255) NOT NULL                 │
│    │ description           TEXT NULL                             │
│    │ priority              ENUM('low','medium','high') DEFAULT   │
│    │ status                ENUM('todo','in_progress','done')     │
│    │ deadline              DATETIME NOT NULL                     │
│    │ created_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP   │
│    │ updated_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP   │
│    └────────────────────────────────────────────────────────────│
│ Indexes: project_id, assigned_to, status, deadline, priority    │
│ Composite: (project_id, status), (assigned_to, deadline)        │
│ Constraints: CASCADE on project_id, SET NULL on assigned_to     │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔍 Design Decisions & Rationale

### 1. Why Pivot Table `project_user` and NOT Role in Projects?

**Option A (WRONG)**: Add `role` directly to `projects` table
```sql
-- BAD - only stores one role per project (lead)
projects:
  id, title, created_by, deadline
  // Where do we store developers?
```

**Option B (CORRECT)**: Use pivot table with role
```sql
-- GOOD - stores multiple users with different roles
projects: id, created_by, title, deadline
project_user: user_id, project_id, role
// Lead and developers all recorded
```

**Why Option B**:
- Lead creates project → added to project_user with role='lead'
- Lead invites developer → added to project_user with role='developer'
- Supports multiple users per project
- Allows querying "all developers on this project"
- Allows changing roles (if needed in future)

---

### 2. Soft Delete (deleted_at) vs Hard Delete

**Option A**: Hard delete projects
```sql
DELETE FROM projects WHERE id = 1;
-- Data is GONE forever
```

**Option B (CHOSEN)**: Soft delete with `deleted_at`
```sql
UPDATE projects SET deleted_at = NOW() WHERE id = 1;
-- Data still exists, just marked as deleted
SELECT * FROM projects WHERE deleted_at IS NULL; -- Active only
SELECT * FROM projects WHERE deleted_at IS NOT NULL; -- Archived only
```

**Why Soft Delete**:
- Archive feature (US5, US6) requires data recovery
- Safer — can restore if user clicks "undo"
- Maintains referential integrity
- Keeps historical data for auditing
- Laravel has built-in SoftDeletes trait

---

### 3. CASCADE vs SET NULL for Foreign Keys

**For `projects.created_by`**:
```sql
ON DELETE CASCADE
-- If lead user deleted, project is deleted too
-- Makes sense: project can't exist without creator
```

**For `tasks.assigned_to`**:
```sql
ON DELETE SET NULL
-- If developer deleted, task becomes unassigned
-- Makes sense: task shouldn't be deleted just because developer left
```

**For `project_user` FKs**:
```sql
ON DELETE CASCADE
-- If user/project deleted, membership deleted
-- Cleans up automatically
```

---

### 4. Why Separate Indexes for Composite Queries?

**Index 1**: `(project_id, status)`
```sql
SELECT * FROM tasks 
WHERE project_id = 5 AND status = 'in_progress';
-- Fast: uses index covering both columns
```

**Index 2**: `(assigned_to, deadline)`
```sql
SELECT * FROM tasks 
WHERE assigned_to = 3 AND deadline < NOW();
-- Fast: for finding overdue tasks for a developer
```

---

## 🚀 Implementation Notes for Ilyas

### What to Create in Migrations

1. **users table** — Breeze provides default, customize as shown
2. **projects table** — Add `created_by` FK, `deleted_at` for soft deletes
3. **tasks table** — Add both FKs, ENUM columns
4. **project_user table** — Pivot with unique constraint
5. **Later**: Add `deleted_at` column to projects via separate migration (for soft deletes)

### Laravel Relationship Code (Preview)

```php
// User model
public function projects() {
    return $this->belongsToMany(Project::class, 'project_user')
        ->withPivot('role')
        ->withTimestamps();
}

// Project model
public function members() {
    return $this->belongsToMany(User::class, 'project_user')
        ->withPivot('role')
        ->withTimestamps();
}

public function tasks() {
    return $this->hasMany(Task::class);
}

// Task model
public function project() {
    return $this->belongsTo(Project::class);
}

public function assignee() {
    return $this->belongsTo(User::class, 'assigned_to');
}
```

---

## ✅ Validation Checklist

**Does this MLD support all User Stories?**

- ✅ **US2** (Dashboard): Query `user->projects()` + count tasks per project
- ✅ **US3** (Create Project): Insert to projects, add user to project_user
- ✅ **US4** (Update Project): Update projects table
- ✅ **US5** (Archive): Set `deleted_at` timestamp
- ✅ **US6** (Restore): Clear `deleted_at` (set to NULL)
- ✅ **US7** (Add/Remove Member): Insert/delete from project_user
- ✅ **US8** (List Tasks): Query `project->tasks()`
- ✅ **US9** (Create Task): Insert to tasks table
- ✅ **US10** (Update Task): Update tasks table
- ✅ **US11** (Update Status): Update `tasks.status` column
- ✅ **US12** (Delete Task): Delete from tasks table
- ✅ **US13** (API Endpoint): Return tasks with role-based authorization

**Does it handle performance?**

- ✅ Indexes on foreign keys (fast joins)
- ✅ Indexes on frequently searched columns (created_by, status, deadline)
- ✅ Composite indexes for complex queries
- ✅ Unique constraint prevents duplicates (no N+1 on members)

**Does it maintain data integrity?**

- ✅ Foreign key constraints prevent orphaned records
- ✅ Cascade deletes clean up related data
- ✅ Soft deletes preserve history
- ✅ Unique constraint on (user_id, project_id) prevents duplicates

---

## 📐 Summary Table

| Aspect | Decision | Why |
|--------|----------|-----|
| Many-to-Many | Pivot table `project_user` | Support multiple roles, query flexibility |
| Role Storage | In pivot table, not projects | Users have different roles across projects |
| Soft Delete | `deleted_at` column | Archive feature, data recovery, history |
| Cascade Delete | On project_id in tasks | Delete project → delete related tasks |
| Set Null | On assigned_to in tasks | Delete user → unassign tasks |
| ENUM | For status & priority | Enforce valid values at DB level |
| Indexes | Composite & single | Balance between speed & storage |
| Audit Trail | created_at, updated_at | Track changes for debugging |

---

This MCD/MLD is **production-ready**, **normalized** to 3NF, and **supports all requirements** while maintaining performance and data integrity. ✅