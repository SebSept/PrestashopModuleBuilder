
===== v 0.12 =====

* [feature] use [Gruntjs](http://gruntjs.com/) to keep css sources, concat and minify css()
* [feature] added a file cache component a speedup rendering [SimpleFileCache](http://sebsept.github.io/SimpleFileCache/)
* [feature] chrono middlewar (display time spent at page bottom in dev mode)
* [feature] use twig config in app

* [bugfix] fix displayName (not displayname) in generated code
* [bugfix] fix bad path to app in index_dev.example.php

* [improvement] removed old unused files
* [improvement] added error_reporting
* [improvement] use dedicated folder for custom templates ( template/custom/ )
* [improvement] moved classes from src/ to lib/

===== v 0.11 =====

* [feature] hook title and description in form
* [feature] Hook title and description in generated code
* [bugfix] fix bad var name in generated code
* [bugfix] link to custom css
* [bugfix] hooks rendered

===== version 0.10 =====

* Added admin form process handling structure
* Use [slim framework](http://www.slimframework.com/) instead of silex (/vendor/ is 4.6M vs 23M) and app faster.