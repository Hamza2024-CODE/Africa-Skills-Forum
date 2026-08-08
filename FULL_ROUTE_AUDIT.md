# WSAP V5 — Full Route Audit & Navigation Inventory

Date: 2026-08-04
Platform: WorldSkills Algeria Management Platform (WSAP)

---

## 1. Public Portal Routes

| Method | URI | Named Route | Middleware | Status |
| :--- | :--- | :--- | :--- | :--- |
| GET | `/` | `home` | web, locale | PASS (200) |
| GET | `/guide` | `guide` | web, locale | PASS (200) |
| GET | `/skills` | `skills` | web, locale | PASS (200) |
| GET | `/regulations` | `regulations` | web, locale | PASS (200) |
| GET | `/schedule` | `schedule` | web, locale | PASS (200) |
| GET | `/results` | `results` | web, locale | PASS (200) |
| GET | `/news` | `news` | web, locale | PASS (200) |
| GET | `/events` | `events` | web, locale | PASS (200) |
| GET | `/gallery` | `gallery` | web, locale | PASS (200) |
| GET | `/videos` | `videos` | web, locale | PASS (200) |
| GET | `/partners` | `partners` | web, locale | PASS (200) |
| GET | `/contact` | `contact` | web, locale | PASS (200) |
| GET | `/faq` | `faq` | web, locale | PASS (200) |
| GET | `/registration` | `registration` | web, locale | PASS (200) |
| GET | `/login` | `login` | web, guest | PASS (200) |
| GET | `/privacy` | `privacy` | web, locale | PASS (200) |
| GET | `/terms` | `terms` | web, locale | PASS (200) |
| GET | `/search` | `search` | web, locale | PASS (200) |
| GET | `/profile` | `profile` | web, auth | PASS (200) |

---

## 2. Authenticated Dashboards & Scoped Portals

| Portal Area | URI | Named Route | Auth Scope | Status |
| :--- | :--- | :--- | :--- | :--- |
| Super Admin Command Center | `/admin/dashboard` | `admin.dashboard` | SUPER_ADMIN | PASS (200) |
| Admin Logistics | `/admin/logistics` | `admin.logistics` | SUPER_ADMIN | PASS (200) |
| Admin Readiness Center | `/admin/readiness` | `admin.readiness` | SUPER_ADMIN | PASS (200) |
| Admin Events Management | `/admin/events` | `admin.events` | SUPER_ADMIN | PASS (200) |
| Admin Media Dashboard | `/admin/media/dashboard` | `admin.media.dashboard` | SUPER_ADMIN, MEDIA_MANAGER | PASS (200) |
| Admin CMS Homepage Manager | `/admin/cms/homepage` | `admin.cms.homepage` | SUPER_ADMIN | PASS (200) |
| Executive Viewer | `/executive/dashboard` | `executive.dashboard` | EXECUTIVE_VIEWER (Read-Only) | PASS (200) |
| Vocational Institution | `/organization/dashboard` | `organization.dashboard` | ORGANIZATION_ADMIN | PASS (200) |
| Judge Portal | `/judge/dashboard` | `judge.dashboard` | JUDGE / EXPERT | PASS (200) |
| Participant Portal | `/participant/dashboard` | `participant.dashboard` | PARTICIPANT | PASS (200) |
| Country Delegation Portal | `/country/dashboard` | `country.dashboard` | COUNTRY_ADMIN | PASS (200) |
