# Proposition
*Lightweight property-based testing for PHP, inspired by Python's Hypothesis library.*

Currently, it just consists of my idea for an API and an implementation for simple cases. But I want to develop it into a nice package, since the other property-based libraries I found were either too fancy or abandoned.

Goals:

* Extremely lightweight and easy to use
  * only **one** class to `use`
  * dead simple API, which reads like English when you use good variable names
  * uses generators to produce randomized values which fulfill the given constraints
  * pragmatic: common use-cases already included like integers, integers within a range, strings, "garbage" data, etc.
    * but it's still easy to pass in your own generator if you know how they work
  * other than generators and callbacks, no use of "advanced" or "frameworky" features (e.g. interfaces). Functional programming features should be used with care.
* Easy to integrate with PHPUnit but there should be NO functionality specific to that.
* Compatible with PHP v.7.0 and up but also v.5.6. Probably not below that.

Lastly, pull requests welcome!
