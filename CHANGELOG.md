# [2.3.0](https://github.com/phpsa/filament-authentication/compare/v2.2.1...v2.3.0) (2022-11-23)


### Features

* Attach user to role ([62d7c19](https://github.com/phpsa/filament-authentication/commit/62d7c19c394a06ad5341c327952e3468a6eb7798))

## [2.2.1](https://github.com/phpsa/filament-authentication/compare/v2.2.0...v2.2.1) (2022-09-11)


### Bug Fixes

* Clear permissions cache on attach/detach ([#22](https://github.com/phpsa/filament-authentication/issues/22)) ([50952ca](https://github.com/phpsa/filament-authentication/commit/50952ca04144e85f175f167211e29f48dc7df454))
* Make Role and Permission Name and Guard Name required for form ([#23](https://github.com/phpsa/filament-authentication/issues/23)) ([0f948e9](https://github.com/phpsa/filament-authentication/commit/0f948e93cd7b939221a6b0fd1e76cdd021129207))

# [2.2.0](https://github.com/phpsa/filament-authentication/compare/v2.1.2...v2.2.0) (2022-08-11)


### Features

* Vietnamese translations ([#19](https://github.com/phpsa/filament-authentication/issues/19)) ([616bb75](https://github.com/phpsa/filament-authentication/commit/616bb754e6bf8ba99df6b04df941e2ee26294d5b))

## [2.2.0] (to be released)

### Features

* [2.2.0] introduce ability to override User, Role and Permission Model (instead of just RoleResource and PermissionResource)

## [2.1.2](https://github.com/phpsa/filament-authentication/compare/v2.1.1...v2.1.2) (2022-06-16)


### Bug Fixes

* tableActions removed ([91b1526](https://github.com/phpsa/filament-authentication/commit/91b152674ef6f7a0b1d658d5efc40bd08546cd61))

## [2.1.1](https://github.com/phpsa/filament-authentication/compare/v2.1.0...v2.1.1) (2022-06-06)


### Bug Fixes

* added ability to set sort order of the LatestUsers widget ([7198cff](https://github.com/phpsa/filament-authentication/commit/7198cfffbc37e788f46cde363709cf2d91332bc1))

# [2.1.0](https://github.com/phpsa/filament-authentication/compare/v2.0.0...v2.1.0) (2022-06-02)


### Bug Fixes

* mount not static ([3b9e4cc](https://github.com/phpsa/filament-authentication/commit/3b9e4cc0fe9ca259135b5eee15ebfdccbe05d22e))
* use Terniary Filter ([9d9a07a](https://github.com/phpsa/filament-authentication/commit/9d9a07ad9672739c96b3128bc80649614536e824))
* use user name by default on edit ([b3d4a90](https://github.com/phpsa/filament-authentication/commit/b3d4a90356622901ff71bf3c95381fe9df07fc8b))


### Features

* added event triggers for create and update ([59dd8ef](https://github.com/phpsa/filament-authentication/commit/59dd8ef6f62591b2e6a8f89e425e5f54e340df71))

# [2.1.0-beta.2](https://github.com/phpsa/filament-authentication/compare/v2.1.0-beta.1...v2.1.0-beta.2) (2022-05-31)


### Bug Fixes

* use Terniary Filter ([9d9a07a](https://github.com/phpsa/filament-authentication/commit/9d9a07ad9672739c96b3128bc80649614536e824))
* use user name by default on edit ([b3d4a90](https://github.com/phpsa/filament-authentication/commit/b3d4a90356622901ff71bf3c95381fe9df07fc8b))

# [2.1.0-beta.1](https://github.com/phpsa/filament-authentication/compare/v2.0.0...v2.1.0-beta.1) (2022-05-30)


### Bug Fixes

* mount not static ([3b9e4cc](https://github.com/phpsa/filament-authentication/commit/3b9e4cc0fe9ca259135b5eee15ebfdccbe05d22e))


### Features

* added event triggers for create and update ([59dd8ef](https://github.com/phpsa/filament-authentication/commit/59dd8ef6f62591b2e6a8f89e425e5f54e340df71))

# [2.0.0](https://github.com/phpsa/filament-authentication/compare/v1.1.2...v2.0.0) (2022-05-27)


### Bug Fixes

* use Filament::makeTableAction for table action ([864610a](https://github.com/phpsa/filament-authentication/commit/864610acaf9d05498d4c430c51deb50027bc1fc1))


### Features

* Timezone display set to use Filament Core system ([f5d5507](https://github.com/phpsa/filament-authentication/commit/f5d550710ff63b018c660a6b5be3262de469318b))


### BREAKING CHANGES

* Visual display of dates will need to be updated

## [1.1.2](https://github.com/phpsa/filament-authentication/compare/v1.1.1...v1.1.2) (2022-05-06)


### Bug Fixes

* spelling issue in config file ([4160da9](https://github.com/phpsa/filament-authentication/commit/4160da954fa0163653560abd3824904a8a426d06))

## [1.1.1](https://github.com/phpsa/filament-authentication/compare/v1.1.0...v1.1.1) (2022-05-03)


### Bug Fixes

* code quality updates ([ce9c8d1](https://github.com/phpsa/filament-authentication/commit/ce9c8d113ab1c3769d63b59b544813bb107c2f1c))
* user Widget laravel 8 compatability ([f9dd25f](https://github.com/phpsa/filament-authentication/commit/f9dd25f5eff7d110367cf61c666752b49ba60c20))

# [1.1.0](https://github.com/phpsa/filament-authentication/compare/v1.0.1...v1.1.0) (2022-04-23)


### Features

* allow enable / disable / config of user widget ([74329cb](https://github.com/phpsa/filament-authentication/commit/74329cb4ff4db269796a9bb8750f8d39a9452dfa))
* User Impersonation ([fb30d9e](https://github.com/phpsa/filament-authentication/commit/fb30d9e2b47d5a8f04a5ac12fa22782b51c0556e))

## [1.0.1](https://github.com/phpsa/filament-authentication/compare/v1.0.0...v1.0.1) (2022-04-22)


### Bug Fixes

* set page resources to use config value for resource ([f239ca9](https://github.com/phpsa/filament-authentication/commit/f239ca9ab732895147e1cc606780870ce8bf58df))

# 1.0.0 (2022-04-20)


### Bug Fixes

* remove pagination on widget ([b8a5e99](https://github.com/phpsa/filament-authentication/commit/b8a5e9947d666715c8f82637d6b363bdbfacfca4))


### Features

* Initial Commit ([a5b7299](https://github.com/phpsa/filament-authentication/commit/a5b72991624e1049369c3ff453c14449aa391885))
