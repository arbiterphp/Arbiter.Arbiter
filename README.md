# Arbiter

An Action system for Action-Domain-Responder.

This package is installable and PSR-4 autoloadable via Composer as `arbiter/arbiter`.

Alternatively, download a release or clone this repository, then map the `Arbiter\` namespace to the package `src/` directory.

This package requires PHP 5.5 or later; it has been tested on PHP 5.6, PHP 7, and HHVM. You should use the latest available version of PHP as a matter of principle.

To run the tests, issue `composer install` to install the test dependencies, then issue `phpunit`.

* * *

An _Action_ value object is composed of three elements:

- an `$input` callable: this collects input from the incoming _RequestContext_ and converts it to an array of parameters suitable for `call_user_func_array()`;

- a `$domain` callable: this is invoked via `call_user_func_array()` using the array of parameters provided by the `$input` callable; and

- a `$responder` callable: this is invoked with the incoming _RequestContext_, and the result (or "payload") returned by the `$domain` callable.

Call the _ActionHandler_ `act()` method with the _Action_, and a _RequestContext_. The _ActionHandler_ then acts as a mediator to direct the interaction between the three callables, and returns a modified _ResponseRepresentation_.
