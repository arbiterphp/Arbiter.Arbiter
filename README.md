# Arbiter

A PSR-7 Action system for Action-Domain-Responder.

This package is installable and PSR-4 autoloadable via Composer as `elemental/elemental`.

Alternatively, download a release or clone this repository, then map the `Arbiter\` namespace to the package `src/` directory.

This package requires PHP 5.5 or later; it has been tested on PHP 5.6, PHP 7, and HHVM. You should use the latest available version of PHP as a matter of principle.

To run the tests, issue `composer install` to install the test dependencies, then issue `phpunit`.

* * *

An _Action_ is composed of three elements:

- an `$input` callable: this collects input from the incoming _ServerRequestInterface_ and converts it to an array of parameters suitable for `call_user_func_array()`;

- a `$domain` callable: this is invoked via `call_user_func_array()` using the array of parameters provided by the `$input` callable; and

- a `$responder` callable: this is invoked with the incoming _ServerRequestInterface_, the outgoing _ResponseInterface_, and the result (or "payload") returned by the `$domain` callable.

You can then call the _ActionHandler_ `handle()` method with the _Action_, _ServerRequestInterface_, and _ResponseInterface_. The handler coordinates the execution of the callables, and returns the modified _ResponseInterface_.

