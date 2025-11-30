# Technical Documentation: Apexio

This document details the technical architecture, implementation logic, and security protocols of the **Apexio** application.

---

## 1. System Architecture

The project adopts a **Modern Monolith** architecture using **Laravel 11** and **Livewire 3**, focusing on clean code and modularity.

* **Backend Framework:** Laravel 11 (PHP 8.2+).
* **Frontend Interactivity:** Livewire 3 + Alpine.js.
* **Styling Architecture:** Modular SCSS (Bootstrap 5 based).
    * `_base.scss`: Global resets and variables.
    * `components/`: Specific styles for Kanban, Sidebar, Profile, etc.
* **JavaScript Logic:** Separated ES6 modules in `resources/js/` (No inline JS).

---

## 2. Database Schema Highlights

The application relies on a relational database (MySQL/MariaDB). Key schema design decisions include:

### Table `users`
* **`is_admin` (boolean):** Determines global access rights (Super Admin vs Regular User).
* **`avatar_path` (string|null):** Stores the file path of the uploaded profile photo.
    * *Logic:* Accessor `getAvatarUrlAttribute` handles the full URL generation. If null, the UI renders an "Initials" fallback.

### Table `tasks`
* **`due_date` (datetime):** Stores exact deadlines.
    * *Reason:* Uses `DATETIME` instead of `DATE` to support precision for the "Real-time Due Date" feature.
* **`priority` (enum):** Levels: `low`, `medium`, `high`, `critical`.
* **`status` (enum):** States: `To-Do`, `In-Progress`, `Done`.

### Table `projects` & `project_members`
* **Many-to-Many Relationship:** Users can belong to multiple projects with specific roles via the pivot table.

---

## 3. Feature Implementation Details

### A. Interactive Kanban Board (Drag & Drop)
* **Library:** Integrated **SortableJS** for smooth drag-and-drop interactions.
* **Synchronization:**
    * Frontend events trigger Livewire methods (`updateTaskStatus`) to persist changes.
    * Uses `Livewire.hook('commit')` to re-initialize JS logic after DOM updates, preventing UI flicker/glitches.
* **Visual Logic:** CSS classes (`js-draggable-task`) enforce visual limits. Users cannot drag cards they do not own or have permission to move.

### B. Real-time Due Date System
Solves the timezone discrepancy between Server (UTC) and Client (Local Time).
* **Server Side:** Sends date strings in **ISO 8601** format (e.g., `2025-11-25T15:30:00+07:00`) via HTML data attributes.
* **Client Side (JS):** A background script (`kanban.js`) runs every 10 seconds to parse these ISO strings into the user's local browser time.
* **Dynamic Badges:** Automatically updates CSS classes to `.overdue` (Red) or `.due-soon` (Orange) in real-time without page reload.

### C. Super Admin Dashboard & Online Tracker
* **Access Control:** Protected by strict checks: `if (!Auth::user()->is_admin) abort(403)`.
* **Online Status Tracker:**
    * Implemented via a custom Middleware (`TrackUserActivity`).
    * Updates a Cache key (`user-is-online-{id}`) with a 2-minute expiration on every request.
    * The UI checks this Cache key to display the Green (Online) or Grey (Offline) indicator.
* **User Management:** Admin can reset passwords to default (`password123`), toggle Admin status, and delete users via Livewire actions.

### D. "My Tasks" Aggregation
* **Purpose:** A centralized view for users to see all their responsibilities across multiple projects.
* **Query Logic:** Filters `tasks` where `assignee_id` matches the current user AND `status != Done`.
* **Sorting:** Automatically ordered by `due_date` ascending (Urgent tasks first).
* **Reusability:** Reuses the "Smart Badge" logic from Kanban for consistent real-time status indicators.

### E. User Profile & Avatar
* **Preview Logic:** Uses JavaScript `FileReader` API (`profile.js`) to show instant image previews before upload.
* **Fallback UI:** Blade logic determines whether to render an `<img>` tag (if photo exists) or a `<div>` with initials (if null).

---

## 4. Security & Authorization

Access control is enforced at multiple layers (Backend & Frontend):

1.  **Role-Based Access Control (RBAC):**
    * **Super Admin:** Has global access (`is_admin = 1`). Can access `/admin` routes and manage all users.
    * **Regular User:** Restricted to their own Projects and Tasks. The Admin menu is hidden from the Sidebar.

2.  **Task Ownership Policy:**
    * Users can only **move/edit** tasks if:
        * They are the **Assignee**.
        * OR the task is **Unassigned**.
        * OR they are the **Admin** (Project Owner/Super Admin).
    * **Frontend Enforcement:** Unauthorized tasks have `pointer-events: none` and `cursor: not-allowed`.
    * **Backend Enforcement:** The `updateTaskStatus` method verifies ownership before saving changes to prevent IDOR (Insecure Direct Object Reference) attacks.

3.  **Middleware Protection:**
    * `auth`: Ensures user is logged in.
    * `verified`: Ensures email is verified (if enabled).
    * `TrackUserActivity`: Monitors session activity for the online status feature.