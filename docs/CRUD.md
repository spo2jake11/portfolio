# CRUD Module Documentation

This document describes the CRUD (Create, Read, Update, Delete) module in the portfolio application. The module provides **user authentication** and a **discussion board** (threads, comments, replies) using CodeIgniter 3 and a separate database connection for CRUD data.

---

## Overview

| Component        | Purpose                                      |
|-----------------|----------------------------------------------|
| **Crud**        | Login, registration, logout                 |
| **Board**       | Thread list, create/open thread, comments, replies, edit/delete, close/update thread |
| **Logins**      | User auth (login, register, uniqueness checks) |
| **Boards**      | Threads, comments, replies (all CRUD via `for_crud` DB) |

- **Database:** CRUD uses the `for_crud` database group (see `application/config/database.php`). Tables include `users`, `threads`, `comments`, `replies`.
- **Sessions:** Logged-in state is stored in `is_logged_in`, `id`, `email`, `username`.

---

## Routes

| URL / Route | Controller → Method        | Description |
|-------------|----------------------------|-------------|
| `crud`      | `crud/crud/index`          | Login page (redirects to `home` if logged in) |
| `validate`  | `crud/crud/validate_login` | POST: validate login, set session, redirect to `home` |
| `register`  | `crud/crud/validate_register` | POST: validate & register user |
| `logout`    | `crud/crud/logout`         | Destroy session, redirect to `crud` |
| `home`      | `crud/board/index`        | Board index: list threads (requires login) |
| `create_thread` | `crud/board/create`    | POST: create new thread |
| `add_comment`   | `crud/board/add_comment` | POST: add comment to thread |
| `add_reply`     | `crud/board/add_reply`   | POST: add reply to comment |
| `edit_comment/(:num)`   | `crud/board/edit_comment/$1`   | POST: edit comment (owner only) |
| `delete_comment/(:num)/(:num)` | `crud/board/delete_comment/$1/$2` | Delete comment (owner only); 2nd param = thread_id |
| `edit_reply/(:num)`     | `crud/board/edit_reply/$1`     | POST: edit reply (owner only) |
| `delete_reply/(:num)/(:num)`   | `crud/board/delete_reply/$1/$2`   | Delete reply (owner only) |
| `close_thread/(:num)`   | `crud/board/close_thread/$1`   | Soft-close thread (owner only) |
| `update_thread/(:num)` | `crud/board/update_thread/$1` | POST: update title/content/slug (owner only) |
| `history/(:any)` | `crud/board/history/$1`   | List current user’s threads |
| `search`    | `crud/board/search_threads` | GET: search threads by keyword |
| `(:any)`    | `crud/board/open_thread/$1` | Open thread by slug (catch-all; keep after specific routes) |

---

## Authentication (Crud Controller + Logins Model)

### Login

- **Page:** `crud` → view `crud/login/index`.
- **POST to `validate`:** `email`, `password`.
- **Logins::check_login():** Looks up user by email + password; returns user id/email and sets session (`id`, `email`, `is_logged_in`). Username is added via `get_account()`.
- **Redirect:** Success → `home`; failure → `crud` with flash `error`.

### Registration

- **POST to `register`:** Triggers `validate_register()` which uses CodeIgniter form validation:
  - `email`: required, valid_email, unique (callback `check_email_unique`).
  - `name`: required, unique as username (callback `check_username_unique`).
  - `password`: required, min length 6.
  - `check_password`: required, must match `password`.
- **Logins::register_user():** Inserts into `users`; returns insert id.
- **Logins:** `check_email_exists()`, `check_username_exists()`, `get_account($id)` support validation and session.

### Logout

- **logout:** `sess_destroy()`, redirect to `crud`.

---

## Board (Threads, Comments, Replies)

### Threads

- **List:** `home` → `Board::index()` → `Boards::get_threads()`. Returns threads with username and total comment+reply count; only active threads.
- **Create:** POST to `create_thread` with `title`, `content`. Slug from `url_title(title, 'dash', true)`. `user_id` from session. Redirects to `home`.
- **Open:** Any unmatched segment (e.g. `my-thread`) → `open_thread($slug)`. `Boards::get_thread($slug)`; 404 if not found. Loads comments and replies (active only).
- **Update:** POST to `update_thread/(:num)` with `title`, `content`. Allowed only for thread owner. Slug recomputed; redirect to new slug.
- **Close:** `close_thread/(:num)` — owner only. Soft-delete: `Boards::delete_thread($id)` sets `active = 0`.

### Comments

- **Add:** POST to `add_comment` with `thread_id`, `comment`. Requires login; thread must exist and be active (`active = 1`). Redirects to thread slug.
- **Edit:** POST to `edit_comment/(:num)` with `comment`, `thread_id`. Owner-only; then redirect to thread.
- **Delete:** GET `delete_comment/(:num)/(:num)` (comment_id, thread_id). Owner-only. Soft-delete: content set to "Comment has been deleted", `active = 0`. Redirect to thread.

### Replies

- **Add:** POST to `add_reply` with `thread_id`, `comment_id`, `comment`. Login and active thread required.
- **Edit:** POST to `edit_reply/(:num)` with `comment`, `thread_id`. Owner-only.
- **Delete:** `delete_reply/(:num)/(:num)` (reply_id, thread_id). Owner-only. Soft-delete: `active = 0`. Redirect to thread.

### Helpers and extras

- **time_elapsed():** Used in views for relative time (e.g. "5 minutes ago").
- **history($username):** Lists threads for current user via `get_user_threads(session id)`.
- **search_threads():** GET `keyword`; `Boards::search_threads($keyword)` searches title and content with `like`/`or_like`.

---

## Models Summary

### Logins (`application/models/Logins.php`)

- Uses `$this->load->database('for_crud', true)`.
- **check_login($data):** email + password → user row or false.
- **register_user($data):** insert `users`, return insert_id.
- **check_email_exists($email)**, **check_username_exists($username)**.
- **get_account($id):** single user row.

### Boards (`application/models/Boards.php`)

- Uses `for_crud` database.
- **Threads:** `add_thread`, `get_threads`, `get_thread($slug)`, `get_thread_by_id($id)`, `update_thread`, `delete_thread` (soft: `active = 0`).
- **Comments:** `get_comments($thread_id)`, `get_comment($id)`, `add_comment`, `update_comment`, `delete_comment` (soft: content + `active = 0`).
- **Replies:** `get_replies($comment_id)`, `get_reply($id)`, `add_reply`, `update_reply`, `delete_reply` (soft: `active = 0`).
- **Other:** `get_user_threads($user_id)`, `search_threads($keyword)`.

---

## Views (CRUD)

- **Template:** `crud/template/header`, `crud/template/footer`.
- **Auth:** `crud/login/index` (login/register forms).
- **Board:** `crud/home/index`, `crud/home/content` (thread list), `crud/home/thread` (single thread + comments/replies), `crud/home/history`, `crud/home/search`.

---

## Security Notes

- Login required for board index, create thread, add comment/reply, edit/delete (comment/reply), close/update thread, history.
- Comment/reply edit and delete check that `comment.user_id` or `reply.user_id` matches `session id`.
- Thread close and update check that `thread.user_id` matches session.
- Closed threads (`active = 0`) reject new comments and replies; thread still viewable (content remains).

---

## Quick Reference: Where is each CRUD?

| Entity   | Create        | Read              | Update           | Delete (soft)   |
|----------|---------------|-------------------|------------------|------------------|
| User     | register      | check_login, get_account | —         | —                |
| Thread   | create_thread | index, open_thread, history, search | update_thread | close_thread  |
| Comment  | add_comment   | get_comments, get_comment | edit_comment | delete_comment |
| Reply    | add_reply     | get_replies, get_reply   | edit_reply  | delete_reply  |
