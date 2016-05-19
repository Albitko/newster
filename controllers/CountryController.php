<?php

namespace app\controllers;

use app\models\CountrySearch;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Country;

class CountryController extends Controller
{
    public function actionIndex()
    {
        /*$query = Country::find();

        $countries = $query->orderBy('name')
            ->all();
        $countries->code='RT';
        $countries->save();

        return $this->render('index', [
            'countries' => $countries
        ]);
        */
        $countries= CountrySearch::findOne('AU');
        $countries->code = 'QR';
        $countries->save();

    }


}
