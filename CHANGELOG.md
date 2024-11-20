# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.2] - 2024-11-20
### Fixed
- Another improvement for parsing invalid JSON with unescaped double quote characters inside string values.

## [1.1.1] - 2024-11-20
### Fixed
- Improve parsing invalid JSON by detecting and fixing unescaped double quote characters inside string values.

## [1.1.0] - 2023-07-20
- The `Microseconds` value object class that wraps timestamp float values to make it easier and less error-prone to work with.

## [1.0.0] - 2023-05-17
### Added
- The `Json` class that converts JSON strings to array and also tries to deal with "relaxed" JSON, where keys can be unquoted.
