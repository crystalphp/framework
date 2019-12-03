<?php

include_once libs('/Jobs/Job.php');
$jobs = glob(app_path('/jobs/*.php'));
foreach($jobs as $job){
    if(is_file($job)){
        include_once $job;
    }
}
