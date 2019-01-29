<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;

class Team extends SparkTeam {

    public function campaigns() {
        return $this->hasMany(Campaign::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

}
