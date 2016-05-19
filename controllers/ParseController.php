<?php

namespace app\controllers;

use keltstr\simplehtmldom\SimpleHTMLDom;
use yii\web\Controller;
use app\models\News;

class ParseController extends Controller
{
    //переменная для функции Parse
    public $news;
    public $sel_from_title='h2.post__title';
    public $sel_as_title='a.post__title_link';
    public $url='https://habrahabr.ru/hub/infosecurity/all/';
    public $number='1';
    public $for_example='5';//нужна для парсинга старой новости
    public $sel_from_text='.post__body_crop';
    public $sel_as_text='.html_format';

    //функция парсинга универсальная
    public function Parse($sel_from,$sel_as,$url,$how_many_news)
    {
        $html = SimpleHTMLDom::file_get_html($url);
        $i='0';
        foreach ($html->find($sel_from) as $article)
        {
            $this->news=$article->find($sel_as,0)->innertext;
            $i++;
            if ($i == $how_many_news) break; // прерывание цикла
        }
        return $this->news;

    }

    //итоговая функция сравнения и парсинга
    public function Fullparse($sel_from_title,
                              $sel_from_text,
                              $sel_as_title,
                              $sel_as_text,
                              $url,$number,
                              $old_news,
                              $new_news)
    {

        if ($old_news != $new_news)
        {
            while ($old_news != $new_news)
            {
                $text_news = $this->Parse($sel_from_text, $sel_as_text, $url, $number);

                $query = new News();
                $query->title = $new_news;
                $query->text = $text_news;
                $query->save();

                $number++;
                $new_news = $this->Parse($sel_from_title, $sel_as_title, $url, $number);
            }

            return true;
        }
        else
        {
            echo "Нет новых новостей.";
        }

    }

    //получение последнего заголовка
    public  function  LastOne()
    {
        $query = News::find()->orderBy('id')
            ->one();
        return $query->title;
    }

    //получение массива [id,title,text] $how_many последних новостей
    public function LastMore($how_many)
    {
        $newses = (new \yii\db\Query())
            ->select(['id','title','text'])
            ->orderBy('id DESC')
            ->from('news')
            ->limit($how_many)
            ->all();
        return $newses;
    }

    //добавление строки в таблицу
    //$query=new News();
    //$query->title = 'title';
    //$query->save();



    public function actionIndex()
    {
        $old_news=$this->LastOne(); //Последний заголвок БД
       //$old_news=$this->Parse($this->sel_from_title,$this->sel_as_title,$this->url,$this->for_example);
        $new_news=$this->Parse($this->sel_from_title,$this->sel_as_title,$this->url,$this->number);
        if (
            $this->Fullparse($this->sel_from_title,
                $this->sel_from_text,
                $this->sel_as_title,
                $this->sel_as_text,
                $this->url,$this->number,$old_news,$new_news)=="true") {
            echo "Свежие новости уже в БД";
        } else {
            echo "Упссс....";
        }
    }


    public $n;

    public function actionShow()
    {
        $n=$this->LastMore(4);
        var_dump($n);
    }
}