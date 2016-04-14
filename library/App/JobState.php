<?php

class App_JobState
{

    protected static $job;

    public static function getState ($job)
    {

        $db = new App_User_Service_Optimus();
        $sql = $db->getStateOfJob($job);
        return $sql['tm_act'];
    }

    public static function getCleanState ($job)
    {

        $db = new App_User_Service_Optimus();
        $sql = $db->getStateOfJob($job);
        return self::_transform($sql['tm_act']);
    }

    private function _transform ($machineState)
    {

        switch ($machineState) {
            case 'TME COL FA':
                return 'Acabamentos';
                break;
            case 'TMM DESCAS':
                return 'Acabamentos';
                break;
            case '112 COL FA':
                return 'Acabamentos';
                break;
            case '112 COL FN':
                return 'Acabamentos';
                break;
            case '112 AUX MQ':
                return 'Acabamentos';
                break;
            case '112 AFI FA':
                return 'Acabamentos';
                break;
            case '112 AFI FN':
                return 'Acabamentos';
                break;
            case '119 CORT D':
                return 'Acabamentos';
                break;
            case '119 AFI CD':
                return 'Acabamentos';
                break;
            case '119 AFINAR':
                return 'Acabamentos';
                break;
            case '041 CORT I':
                return 'Acabamentos';
                break;
            case '019 AFINAR':
                return 'Acabamentos';
                break;
            case '019 CORT V':
                return 'Acabamentos';
                break;
            case '006 IMPRIM':
                return 'Impressão';
                break;
            case '109 IMPRIM':
                return 'Impressão';
                break;
            case '109 AUX MQ':
                return 'Impressão';
                break;
            case '109 AFINAR':
                return 'Impressão';
                break;
            case 'PRE PAG EM':
                return 'Prepress';
                break;
            case '007 AFINAR':
                return 'Impressão';
                break;
            case '007 IMPRIM':
                return 'Impressão';
                break;
            case '006 AUX MQ':
                return 'Impressão';
                break;
            case '006 AFINAR':
                return 'Impressão';
                break;
            case '006 IMPRIM':
                return 'Impressão';
                break;
            case '006 AUX MQ':
                return 'Impressão';
                break;
            case '120 AFINAR':
                return 'Impressão';
                break;
            case '120 IMPRIM':
                return 'Impressão';
                break;
            case '120 AUX MQ':
                return 'Impressão';
                break;
            case '007 MC DIR':
                return 'Impressão';
                break;
            case '006 MC DIR':
                return 'Impressão';
                break;
            case '109 MC DIR':
                return 'Impressão';
                break;
            case '120 MC DIR':
                return 'Impressão';
                break;
            case '007 AFINAR':
                return 'Impressão';
                break;
            case '006 AFINAR':
                return 'Impressão';
                break;
            case '109 AFINAR':
                return 'Impressão';
                break;
            case '120 AFINAR':
                return 'Impressão';
                break;
            case '119 AUX MQ':
                return 'Acabamentos';
                break;
            case '119 AFB CD':
                return 'Acabamentos';
                break;
            default:
                return $machineState;
                break;
        }
    }
}
