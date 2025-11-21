# Technical Documentation: Apexio

This document details the technical architecture and implementation logic of the Apexio application features.

## System Architecture

The project utilizes the **Laravel Livewire Component-Based** pattern.

* **View Layer:** Uses Livewire components (`app/Livewire/`) that combine PHP logic and Blade views.
* **Styling:** Uses **Modular SCSS**.
    * `_sidebar.scss`: Handles sidebar layout and navigation.
    * `_kanban.scss`: Handles board and task card styling.
    * `_forms.scss`: Handles input components and validation styling.
    * `app.scss`: The main entry point for styling imports.

---

## Database Schema

The application uses a relational database with 5 main entities:

### Table `users`
* **Function:** Stores user data.
* `avatar_path`: Stores the profile photo file location.
* **Feature:** Uses the `getAvatarUrlAttribute` *Accessor* to handle automatic photo display logic (storage URL or fallback to initials).

### Table `projects`
* **Function:** Groups tasks within a workspace.
* `owner_id`: Relation to the `users` table (Project Owner).

### Table `project_members` (Pivot)
* **Function:** Handles project membership (Many-to-Many).
* `user_id` & `project_id`: Connects users and projects.
* `role`: Stores user role (Admin/Member).

### Table `tasks`
* **Function:** The main unit of work.
* `status`: Enum (To-Do, In-Progress, Done).
* `priority`: Enum (Critical, High, Medium, Low).
* `assignee_id`: Relation to the user performing the task.

### Table `comments`
* **Function:** Discussion on specific tasks.
* `task_id`: Relation to the related task.
* `user_id`: Relation to the comment author.
* `body`: The content of the comment.

---

## Feature Implementation

### Sidebar Navigation
The sidebar uses server-side URL detection (`request()->routeIs()`) to determine the active menu.
* **Visual:** Uses CSS Pseudo-elements for the indicator line on the left side of the active menu.
* **Dynamic Project List:** Project indicator colors are generated using a color array loop in PHP.

### Profile Photo
The photo upload feature uses a combination of Native JavaScript and Laravel Controller.
1.  **Preview:** Uses JavaScript `FileReader` to display the image preview before uploading.
2.  **Storage:** Files are stored in `storage/app/public/avatars` using `Illuminate\Support\Facades\Storage`.
3.  **Cleanup:** The system automatically deletes old files when a photo is replaced or deleted.

### Kanban Board & Comments
Task cards use unique `wire:key` attributes to handle *DOM Diffing* in Livewire.
* **Reactivity:** When a new comment is added via the modal, the counter on the task card automatically increments without a full page refresh due to the `$refresh` event listener.

---

## Security

Access control is managed using **Laravel Policies**:
* **ProjectPolicy:** Restricts project access to registered members only.
* **TaskPolicy:** Manages access rights for creating and deleting tasks.