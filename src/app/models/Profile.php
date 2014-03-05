<?php

/**
 * Description of Profile
 *
 * @author joe
 */
class Profile extends Eloquent {

    public function user() {
        return $this->belongsTo('User');
    }

}
