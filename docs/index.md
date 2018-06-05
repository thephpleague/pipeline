---
layout: default
permalink: /
title: Introduction
---

# League\Pipeline

[![Maintainer](https://img.shields.io/badge/author-@shadowhand-blue.svg?style=flat-square)](https://twitter.com/shadowhand)
[![Author](https://img.shields.io/badge/author-@frankdejonge-blue.svg?style=flat-square)](https://twitter.com/frankdejonge)
[![Build Status](https://img.shields.io/travis/thephpleague/pipeline/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/pipeline)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/pipeline.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/pipeline/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/pipeline.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/pipeline)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/league/pipeline.svg?style=flat-square)](https://packagist.org/packages/league/pipeline)
[![Total Downloads](https://img.shields.io/packagist/dt/league/pipeline.svg?style=flat-square)](https://packagist.org/packages/league/pipeline)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/44ebfc4c-0e97-4b47-925e-b17de7ddce4f/mini.png)](https://insight.sensiolabs.com/projects/44ebfc4c-0e97-4b47-925e-b17de7ddce4f)

## Introduction

This package provides a  plug and play implementation of
the Pipeline Pattern. It's an architectural pattern which
encapsulates sequential processes. When used, it allows you
to mix and match operation, and pipelines, to create new
execution chains. The pipeline pattern is often compared
to a production line, where each stage performs a certain
operation on a given payload/subject. Stages can act on,
manipulate, decorate, or even replace the payload.

If you find yourself passing results from one function to
another to complete a series of tasks on a given subject,
you might want to convert it into a pipeline.

## Goals

* Provide an implementations of the Pipeline Pattern.
* Be highly composable.
* Be immutable.

## Questions?

This package was created by [@frankdejonge](https://twitter.com/frankdejonge), currently maintained by [@shadowhand](https://twitter.com/shadowhand).

