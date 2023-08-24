# Example access control mechanism for CreditOne
## Description of implementation
Works as web application - basically a simple form.

I've tried to make it simple while giving an idea of code separation as it would have been managed by large team.

Adding dropdown to form instead of just two inputs might be considered unnecessary, but it's just a small effort for the
UX gained - no need to check db for usernames and/or function names.

Core logic is implemented in ModuleFunctionAccessResolver class and repos it uses. Having the dropdown selection would
enable me to have object ids (or record ids respectively) available directly in POST input saving two queries, but you
wanted function w/ two strings as params thus resolver respects that.

Comments... well, they tend to get obsoleted. I do find some use for them in regards to ease of understanding or to provide
some knowledge useful to the subject of implementation (e.g. link to doc or some explanation of possible limitations).
But in general, it is up to the code itself to be easy to understand and that is what've always tried to achieve.

## Set up
- Mysql/MariaDB dump located in database folder
- configuration is located in Config class
- needs PHP 8.1, a web server and a MySQL-like database to run