<?php

class CleanDatabaseCommand extends CConsoleCommand {
    private $do_clean=false;

    public function showUsage()
    {
echo <<<USAGE
\033[1;1mNAME\033[1;m
\tcleanDatabase
\033[1;1mDESCRIPTION\033[1;m
\t-d --duplicates
\t\tcheck for duplicate movies by IMDB or TMDB ID. combine with -c, --clean the movies will be removed from the database
\t-b --broken
\t\find broken relations and output the number of found items. combine with -c, --clean to remove them from the database
\t-c --clean
\t\t
\t-a --all
\t\texecute all commands

USAGE;
    }

    /// @TODO Build Argument Handler, -cdb should work too
    public function run($args)
    {
      if(in_array('-c',$args) || in_array('--clean',$args))
        $this->do_clean=true;

      if(in_array('-d',$args) || in_array('--duplicates',$args))
        $this->findDuplicates();

      if(in_array('-b',$args) || in_array('--broken',$args));
        $this->findBroken();

      if(in_array('-a',$args) || in_array('--all',$args))
      {
        $this->findDuplicates();
        $this->findBroken();
      }

      if(isset($args['help']) || isset($args['?']) || !count($args))
        $this->showUsage();
    }

    private function findDuplicates()
    {
      $q="
        SELECT
          id,tmdb_id,count(*) as cnt
        FROM movie
        GROUP BY tmdb_id
        HAVING cnt > 1";
      $cmd=Yii::app()->db->createCommand($q);
      echo count($cmd->queryAll())." Duplicates found!\n";
      if($this->do_clean)
        $this->removeDuplicates();
    }
    private function removeDuplicates()
    {
    }
    private function findBroken() { }
    private function removeBroken() { }
}
