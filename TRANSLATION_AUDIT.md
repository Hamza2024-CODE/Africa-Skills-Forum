# WSAP V5 — Multilingual Architecture & Translation Audit

Date: 2026-08-04
Platform: WorldSkills Algeria Management Platform (WSAP)

---

## 1. Multilingual Support Overview

- **Supported Languages**: Arabic (`ar`), French (`fr`), English (`en`).
- **Default Locale**: Arabic (`ar`) with `dir="rtl"`.
- **Text Direction**:
  - `ar`: `dir="rtl"` | `lang="ar"`
  - `fr`: `dir="ltr"` | `lang="fr"`
  - `en`: `dir="ltr"` | `lang="en"`

---

## 2. Fallback Chain & Database Translation Trait

All dynamic models utilize `App\Traits\HasTranslations`:

```text
Requested Language (e.g. fr)
   └──> English (en)
         └──> Arabic (ar)
               └──> First available stored value
```

---

## 3. Legal & CMS Content Multilingual Coverage

- Homepage Hero, Announcements, and Sections: AR / FR / EN.
- Privacy Policy (`/privacy`): Dynamic via `privacy_content_{locale}` settings.
- Terms of Use (`/terms`): Dynamic via `terms_content_{locale}` settings.
- Navigation Header, Footer, and Buttons: Translated via central translation files and components.
