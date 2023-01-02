# Changelog of ShipSaaS Ready

## 1.0.1
- Added 2 commands:
  - `saas-ready:activate-entity {entity} {code}`: To activate an Entity
  - `saas-ready:deactivate-entity {entity} {code}`: To deactivate an Entity
- Added `activated_at` for `currencies` table.

## 1.0.0 (Initial Release)

🚀 ShipSaaS Ready initial release ships:

- Entities:
    - Country
    - Currency
    - Language
    - Translation
    - Event
- Services/Helpers:
    - Event Sourcing
    - Dynamic Translation
    - Money class
- Traits
    - HasUuid
    - EloquentBuilderMixin
