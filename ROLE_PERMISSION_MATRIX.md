# WSAP V5 — Role & Permission Access Matrix

Date: 2026-08-04
Platform: WorldSkills Algeria Management Platform (WSAP)

---

| Role | Access Scope | CMS Management | Evaluation / Scoring | User Management | Audit Logs |
| :--- | :--- | :--- | :--- | :--- | :--- |
| `SUPER_ADMIN` | Global Full Access | Full Control | Full Control | Full Control | Full View |
| `EXECUTIVE_VIEWER` | Global Strategic View | Read-Only | Read-Only | Read-Only | Read-Only |
| `MEDIA_MANAGER` | News, Gallery, Videos, CMS | Content Only | None | None | Media Logs |
| `COUNTRY_ADMIN` | Own Country Delegation | None | None | Delegation Members | Country Logs |
| `ORGANIZATION_ADMIN` | Own Vocational Institute | None | None | Institute Trainees | Org Logs |
| `JUDGE` / `EXPERT` | Assigned Skills & Approved Trainees | None | Locked Evaluation | None | Scoring Logs |
| `PARTICIPANT` | Own Profile & Document Vault | None | None | Self Profile | Self Logs |
| `SPONSOR/PARTNER` | Partner Portal & Visibility | None | None | None | Campaign Logs |
