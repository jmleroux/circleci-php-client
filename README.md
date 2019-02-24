### Docker

Run docker development environment:

```bash
docker-compose up -d
```

Install the library:

```bash
docker-compose exec fpm composer install --prefer-dist
```

Run tests:

```bash
docker-compose exec fpm ./vendor/bin/php-cs-fixer  fix  --config=.php_cs.php --diff --dry-run -v
docker-compose exec fpm ./vendor/bin/phpunit
```

You can run all this command in one line with the provided `bin/setup.sh` script.

#### Usage

Run the example script:

```bash
docker-compose exec fpm ./doc/examples/last_build.php
```

```php
use Jmleroux\CircleCi\Api\BranchLastBuild;
use Jmleroux\CircleCi\Client;

require_once __DIR__.'/../../vendor/autoload.php';

$client = new Client('c900a267b73d8fbcab665fedc818c8de2b6aedf1');
$query = new BranchLastBuild($client);
$build = $query->execute('github', 'jmleroux', 'circleci-php-client', 'master');

var_dump($build);
```

Output:

```
class stdClass#34 (57) {
  public $compare =>
  NULL
  public $previous_successful_build =>
  class stdClass#32 (3) {
    public $build_num =>
    int(86)
    public $status =>
    string(7) "success"
    public $build_time_millis =>
    int(7750)
  }
  public $build_parameters =>
  class stdClass#18 (1) {
    public $CIRCLE_JOB =>
    string(5) "tests"
  }
  public $oss =>
  bool(true)
  public $all_commit_details_truncated =>
  bool(false)
  public $committer_date =>
  string(25) "2019-02-24T18:07:15+01:00"
  public $body =>
  string(0) ""
  public $usage_queued_at =>
  string(24) "2019-02-24T17:07:26.913Z"
  public $context_ids =>
  array(0) {
  }
  public $fail_reason =>
  NULL
  public $retry_of =>
  NULL
  public $reponame =>
  string(19) "circleci-php-client"
  public $ssh_users =>
  array(0) {
  }
  public $build_url =>
  string(55) "https://circleci.com/gh/jmleroux/circleci-php-client/87"
  public $parallel =>
  int(1)
  public $failed =>
  bool(false)
  public $branch =>
  string(6) "master"
  public $username =>
  string(8) "jmleroux"
  public $author_date =>
  string(25) "2019-02-24T18:07:15+01:00"
  public $why =>
  string(6) "github"
  public $user =>
  class stdClass#28 (6) {
    public $is_user =>
    bool(true)
    public $login =>
    string(8) "jmleroux"
    public $avatar_url =>
    string(52) "https://avatars1.githubusercontent.com/u/1516770?v=4"
    public $name =>
    string(17) "jean-marie leroux"
    public $vcs_type =>
    string(6) "github"
    public $id =>
    int(1516770)
  }
  public $vcs_revision =>
  string(40) "b79c5014ebe89d25871d14ef9df9256bb1797abf"
  public $workflows =>
  class stdClass#22 (7) {
    public $job_name =>
    string(5) "tests"
    public $job_id =>
    string(36) "fa1bd4bc-7281-46fd-92b2-bfcae4e9457e"
    public $workflow_id =>
    string(36) "487024d9-63fc-49dc-ab0c-dd521b0bbc2e"
    public $workspace_id =>
    string(36) "487024d9-63fc-49dc-ab0c-dd521b0bbc2e"
    public $upstream_job_ids =>
    array(1) {
      [0] =>
      string(36) "d6a86dad-4b05-4c62-b9b8-abbee757d1b2"
    }
    public $upstream_concurrency_map =>
    class stdClass#21 (0) {
    }
    public $workflow_name =>
    string(10) "build_test"
  }
  public $vcs_tag =>
  NULL
  public $build_num =>
  int(87)
  public $infrastructure_fail =>
  bool(false)
  public $committer_email =>
  string(22) "jmleroux.pro@gmail.com"
  public $has_artifacts =>
  bool(true)
  public $previous =>
  class stdClass#19 (3) {
    public $build_num =>
    int(86)
    public $status =>
    string(7) "success"
    public $build_time_millis =>
    int(7750)
  }
  public $status =>
  string(7) "success"
  public $committer_name =>
  string(17) "jean-marie leroux"
  public $retries =>
  NULL
  public $subject =>
  string(16) "Add Projects API"
  public $vcs_type =>
  string(6) "github"
  public $timedout =>
  bool(false)
  public $dont_build =>
  NULL
  public $lifecycle =>
  string(8) "finished"
  public $no_dependency_cache =>
  bool(false)
  public $stop_time =>
  string(24) "2019-02-24T17:07:56.709Z"
  public $ssh_disabled =>
  bool(true)
  public $build_time_millis =>
  int(28216)
  public $picard =>
  class stdClass#35 (3) {
    public $build_agent =>
    class stdClass#33 (2) {
      public $image =>
      string(33) "circleci/picard:1.0.7981-23afa854"
      public $properties =>
      class stdClass#26 (2) {
        ...
      }
    }
    public $resource_class =>
    class stdClass#36 (3) {
      public $cpu =>
      double(2)
      public $ram =>
      int(4096)
      public $class =>
      string(6) "medium"
    }
    public $executor =>
    string(6) "docker"
  }
  public $circle_yml =>
  class stdClass#37 (1) {
    public $string =>
    string(1030) "version: 2
jobs:
  build:
    docker:
    - image: circleci/php:7.2-browsers
    working_directory: ~/repo
    steps:
    - run:
        name: Disable XDebug
        command: sudo sed -i 's/^zend_extension/;zend_extension/g' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
    - checkout
    - run: composer install -n --prefer-dist
    - persist_to_workspace:
        root: ~/repo
        paths:
        - vendor
  tests:
    docker:
    - image: circleci/php:7.2-browsers
    working_directory: ~/repo
    "...
  }
  public $messages =>
  array(0) {
  }
  public $is_first_green_build =>
  bool(false)
  public $job_name =>
  NULL
  public $start_time =>
  string(24) "2019-02-24T17:07:28.493Z"
  public $canceler =>
  NULL
  public $all_commit_details =>
  array(2) {
    [0] =>
    class stdClass#38 (13) {
      public $committer_date =>
      string(25) "2019-02-24T18:07:15+01:00"
      public $body =>
      string(0) ""
      public $branch =>
      string(6) "master"
      public $author_date =>
      string(25) "2019-02-24T18:07:15+01:00"
      public $committer_email =>
      string(22) "jmleroux.pro@gmail.com"
      public $commit =>
      string(40) "e8e5581de62e8c9c0fc0cf588e12eaa547ba20b0"
      public $committer_login =>
      string(8) "jmleroux"
      public $committer_name =>
      string(17) "jean-marie leroux"
      public $subject =>
      string(28) "Add DotEnv for dev and tests"
      public $commit_url =>
      string(95) "https://github.com/jmleroux/circleci-php-client/commit/e8e5581de62e8c9c0fc0cf588e12eaa547ba20b0"
      public $author_login =>
      string(8) "jmleroux"
      public $author_name =>
      string(8) "jmleroux"
      public $author_email =>
      string(22) "jmleroux.pro@gmail.com"
    }
    [1] =>
    class stdClass#39 (13) {
      public $committer_date =>
      string(25) "2019-02-24T18:07:15+01:00"
      public $body =>
      string(0) ""
      public $branch =>
      string(6) "master"
      public $author_date =>
      string(25) "2019-02-24T18:07:15+01:00"
      public $committer_email =>
      string(22) "jmleroux.pro@gmail.com"
      public $commit =>
      string(40) "b79c5014ebe89d25871d14ef9df9256bb1797abf"
      public $committer_login =>
      string(8) "jmleroux"
      public $committer_name =>
      string(17) "jean-marie leroux"
      public $subject =>
      string(16) "Add Projects API"
      public $commit_url =>
      string(95) "https://github.com/jmleroux/circleci-php-client/commit/b79c5014ebe89d25871d14ef9df9256bb1797abf"
      public $author_login =>
      string(8) "jmleroux"
      public $author_name =>
      string(8) "jmleroux"
      public $author_email =>
      string(22) "jmleroux.pro@gmail.com"
    }
  }
  public $platform =>
  string(3) "2.0"
  public $outcome =>
  string(7) "success"
  public $vcs_url =>
  string(47) "https://github.com/jmleroux/circleci-php-client"
  public $author_name =>
  string(8) "jmleroux"
  public $node =>
  NULL
  public $queued_at =>
  string(24) "2019-02-24T17:07:26.935Z"
  public $canceled =>
  bool(false)
  public $author_email =>
  string(22) "jmleroux.pro@gmail.com"
}
```
