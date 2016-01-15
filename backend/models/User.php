<?php
/**
 * Created by PhpStorm.
 * User: khem
 * Date: 12/14/15
 * Time: 9:13 PM
 */

namespace backend\models;


class User extends \dektrium\user\models\User{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'role';
        $scenarios['update'][]   = 'role';
        $scenarios['register'][] = 'role';
        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();
        // add some rules
        $rules['fieldRequired'] = ['role', 'required'];
        $rules['fieldLength']   = ['role', 'string', 'max' => 10];

        return $rules;
    }
}