<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 2/12/18
 * Time: 2:47 PM
 */

namespace App\Modules\Misc;

class DefaultValue
{


    public function emailMsgToSpeaker(){
        return "we are happy to inform you that your contribution through this platform has been approved.
We have communicated relavant participants to join your event through Distance Learning Theater established in respective universities following are the event details :";
    }

    public function emailMsgToRepresentative(){
        return "We are pleased to inform you that following event will take place and interested participants may join from you university Distance Learning Theater established by BdREN.";
    }
}