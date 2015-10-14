STAMP
=====

[![Build Status](https://travis-ci.org/gajdaw/stamp.svg?branch=master)](https://travis-ci.org/gajdaw/stamp)

Application that makes versioning a little easier.

## 1. Example

Suppose your application contains a file name `metadata.json` with
the following contents:

    {
      "name": "gajdaw-php_phars",
      "version": "0.1.4",
      "author": "gajdaw"
    }

To release a new version you would probably:

* increase the version in `metadata.json` from `0.1.4` to `0.1.5`
* commit the change setting the commit's message to `Version 0.1.5`
* create an annotated tag `v0.1.5` with message `Release 0.1.5`

To perform the above operations with `stamp` application
start with the configuration file named `stamp.yml`
(in your project's root directory):

    filename:    'metadata.json'
    regex:       '/"version": "(?P<version>[\d\.]+)",/'
    replacement: '"version": "{{ version }}",'

The `filename` parameter sets the file to be searched for version.

The `regex` parameter sets the regular expression used to parse
the file for version number. Please note that `?P<version>`
sets the name of the variable to `version`.

The `replacement` parameter is a Twig template for the
string that represents the new version. This string
will be stored in the file defined by `filename`.

## 2. How to install?

### 2.1. Manual download

Download the latest release available at:

    https://github.com/gajdaw/stamp/releases/download/v0.2.0/stamp.phar

You can do this with:

    wget -O stamp.phar http://github.com/gajdaw/stamp/releases/download/v0.2.0/stamp.phar

## 2. Running `stamp`

Since `stamp` is not yet stable, I suggest using
`--dry-run` and `--verbose` options for start.

Here is the list of available commands:

    $ stamp patch:up --dry-run --verbose
    $ stamp minor:up --dry-run --verbose
    $ stamp major:up --dry-run --verbose

The command `patch:up` performs the following transformation:

    1.2.3        =>  1.2.4
    77.234.654   =>  77.234.655

The command `minor:up` increases the number in the middle
and sets the patch number to 0:

    1.2.3        =>  1.3.0
    77.234.654   =>  77.235.0

The last command, `major:up` increases the first number
and sets the other numbers to 0:

    1.2.3        =>  2.0.0
    77.234.654   =>  78.0.0

## 3. Reading list

* https://github.com/vojtajina/grunt-bump
* https://github.com/maestrodev/puppet-blacksmith
* http://opensource.apple.com/source/libarchive/libarchive-30/libarchive/build/bump-version.sh
* http://stackoverflow.com/questions/4181185/what-does-bump-version-stands-for
* https://gist.github.com/pete-otaqui/4188238
* https://github.com/nvie/gitflow/blob/develop/bump-version
* https://docs.npmjs.com/cli/version

## 4. How to run the tests?

    $ vagrant up
    $ composer update
    $ bin/phpspec run
    $ bin/behat

## 5. How to build dev version?

    git checkout master
    git checkout -b build
    vagrant ssh
    bin/stamp version:dev
    ./build.bash

    git checkout master
    git branch -D build

## 6. Credits

Many concepts in this application, especially when it comes to
testing, came from: https://github.com/phpspec/phpspec

Great many thanks to [all contributors](https://github.com/phpspec/phpspec/graphs/contributors)!

I used some of the files, like for example matchers in
`features/bootstrap/Matcher/` folder, directly
(i.e. without any modifications).

In case of other fragments (e.g. `parseConfigurationFile`
method in `Stamp\Console\Application`) I changed the
code that I found in phpspec.

