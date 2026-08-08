# WSAP V5 — Database Architecture & Integrity Audit

Date: 2026-08-04
Platform: WorldSkills Algeria Management Platform (WSAP)

---

## 1. Schema & Migration Summary

- **Total Migrations**: 40 Migration files.
- **Total Database Tables**: 23 System & Feature Tables.
- **Key Relationships & Integrity**:
  - `users`: Foreign keys to `countries`, `organizations`, UUID generation.
  - `events`: Active event flag (`is_active`), registration windows, start/end timestamps.
  - `skills`: Skills categories, active status, competition phase.
  - `participant_profiles`: UUID identification, country & organization association.
  - `partners`: Category, display order, logo URL, active status.
  - `albums`, `news_articles`, `videos`: Multilingual fields (`_ar`, `_fr`, `_en`), status (`PUBLISHED`, `DRAFT`).

---

## 2. Dynamic Source of Truth Strategy

Zero hardcoded business numbers or titles. Statistics and events are dynamically queried and cached via `HomepageStatisticsService` and `ActiveEventService`.
