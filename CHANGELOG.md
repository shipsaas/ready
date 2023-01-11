# Changelog of ShipSaaS Ready

## v1.1.0
- Entity & Service: Dynamic Setting ([documentation](https://phattranminh96.gitbook.io/shipsaas-ready/entities/dynamic-setting))
- Fixed some small issues
- Minor changes

## v1.0.4
- Removed unused code

## v1.0.3
- Fixed issue when SaaS Ready overwrote all Factory classes

## v1.0.2
- Fixed issue when exporting the config file went wrong.

## v1.0.1
- Added 2 commands:
  - `saas-ready:activate-entity {entity} {code}`: To activate an Entity
  - `saas-ready:deactivate-entity {entity} {code}`: To deactivate an Entity
- Added `activated_at` for `currencies` table.

### Upgrade notes
- `php artisan migrate`

## v1.0.0 (Initial Release)

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
