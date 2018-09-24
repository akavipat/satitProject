<?php
/**
 * Created by PhpStorm.
 * User: ruj
 * Date: 13/9/2018 AD
 * Time: 21:24
 */

namespace App;


class SystemConstant
{
    // These 2 values should be set following value in Grade Status table in database
/* 0: No grade
* 1: I
* 2: S
* 3: U
* 4: 0/1
* 5: Value
* 6: I/X This type is to be displayed as I/<grade value>
* 7: Drop */
    const NO_GRADE = 0;
    const I_GRADE = 1;
    const S_GRADE = 2;
    const U_GRADE = 3;
    const REMEDIAL_GRADE = 4;
    const HAS_GRADE = 5;
    const PASS_I_GRADE = 6;
    const DROP_GRADE = 7;

    // Waiting for approval status
    const DATA_STATUS_WAIT = 0;

    const DROP_GRADE_TEXT = "DROP";

    // 2 quaters exclude final  This is total quarter for each semester.
    const TOTAL_QUARTERS = 2;

    // Quarter signifying final score
    const FINAL_Q = 3;

    // Constant for N/A grade to be used with all cumulative grade data
    const NA_GRADE = "-";

    const TOTAL_SEMESTERS = 2;

    const MIN_TO_ZERO = 0.0001;

    // Helper functions
    public static function clean_blank_spaces($str){
        return trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $str)));
    }
}

