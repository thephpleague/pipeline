# Changelog

## 1.0.0 - ???

### Added

* Add strict typing.

### Changed

* Now requires PHP 7.1 or newer.

## 0.3.0 - 2016-10-13

* A pipeline now has a processor which is responsible for the stage invoking.

## 0.2.2 - 2016-03-23

### Fixed

* #17 - use `call_user_func` instead of invoking a variable.

## 0.2.1 - 2015-12-06

### Altered

* Cloning is used to create the new pipeline [performance]
* Stages are callable, so no need to wrap them in closures.

## 0.2.0 - 2015-12-04

### Changed

* Stages are now anything that satisfies the `callable` type-hint.

## 0.1.0 - 2015-06-25

Initial release
