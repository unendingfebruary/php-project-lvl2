# Gendiff

[![Actions Status](https://github.com/absque96/php-project-lvl2/workflows/hexlet-check/badge.svg)](https://github.com/absque96/php-project-lvl2/actions)
[![linter](https://github.com/absque96/php-project-lvl2/actions/workflows/check.yml/badge.svg)](https://github.com/absque96/php-project-lvl2/actions/workflows/check.yml)
<a href="https://codeclimate.com/github/absque96/php-project-lvl2/maintainability"><img src="https://api.codeclimate.com/v1/badges/1a2df6c33ac55fefd38d/maintainability" /></a>
<a href="https://codeclimate.com/github/absque96/php-project-lvl2/test_coverage"><img src="https://api.codeclimate.com/v1/badges/1a2df6c33ac55fefd38d/test_coverage" /></a>


## About:

Gendiff is a program that determines the difference between two data structures.

Utility features:

- Support for different input formats: yaml and json.
- Report generation as plain text, stylish and json.

## Setup:

```
git clone git@github.com:unendingfebruary/php-project-lvl2.git
make install
```

## Info:

```
./bin/gendiff -h
```

## Example:

```
# format plain
./bin/gendiff --format plain filepath1.json filepath2.json

Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]

# format stylish
./bin/gendiff filepath1.json filepath2.json

{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}
```
